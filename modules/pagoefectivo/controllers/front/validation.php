<?php

require_once(dirname(__FILE__) . '/lib_pagoefectivo/PagoEfectivo.php');
require_once(dirname(__FILE__) . '/lib_pagoefectivo/be/be_solicitud.php');

class PagoEfectivoValidationModuleFrontController extends ModuleFrontController
{
    public function postProcess()
    {
        // Check if cart exists and all fields are set
        $cart = Context::getContext()->cart;
        if ($cart->id_customer == 0 || $cart->id_address_delivery == 0 ||
            $cart->id_address_invoice == 0 || !$this->module->active)
            Tools::redirect('index.php?controller=order&step=1');

        // Check if module is enabled
        $authorized = false;
        foreach (Module::getPaymentModules() as $module)
            if ($module['name'] == $this->module->name)
                $authorized = true;
        if (!$authorized)
            die('This payment method is not available.');

        // Check if customer exists
        $customer = new Customer((int)$cart->id_customer);
        if (!Validate::isLoadedObject($customer))
            Tools::redirect('index.php?controller=order&step=1');

        $currency = new Currency((int)$cart->id_currency);
        $currencyCode = $currency->iso_code;
        $total = (float)$cart->getOrderTotal(true, Cart::BOTH);
        $extra_vars = array('transaction_id' => Tools::getValue('transaction_id'));

        // Validate order
        $this->module->validateOrder($cart->id,Configuration::get('PAGOEFECTIVO_OS_PENDING'),$total,$this->module->displayName,NULL,$extra_vars,(int)$currency->id,false,$customer->secure_key);

        // Obtener la moneda
        if($currencyCode == 'USD'){
            $moneda = 2;
            $metodosPago = '1';
        } elseif($currencyCode == 'PEN') {
            $moneda = 1;
            $metodosPago = '1,2';
        } else {
            echo '<center><h3>ERROR<br/>La moneda en que se realiza esta venta no ha sido autorizada por PagoEfectivo.</h3></center>';
            exit();
        }

        $billing_address = new Address(Context::getContext()->cart->id_address_invoice);
        $billing_address->country = new Country($billing_address->id_country);
        $delivery_address = new Address(Context::getContext()->cart->id_address_delivery);
        $delivery_address->country = new Country($delivery_address->id_country);

        $value_hrs = Configuration::get('PE_CONFIG_HORA');
        $value_min = Configuration::get('PE_CONFIG_MINUTO');

        // DATOS PARA GENERAR CIP
        date_default_timezone_set('America/Lima');
        $paymentRequest = new BEGenRequest();
        $paymentRequest->_moneda            = $moneda;// 1 soles - 2 dolares;
        $paymentRequest->_monto             = number_format($total, 2, '.', '');
        $paymentRequest->_medio_pago        = $metodosPago;
        $paymentRequest->_cod_servicio      = PE_MERCHAND_ID;
        $paymentRequest->_numero_orden      = $this->module->currentOrder;
        $paymentRequest->_concepto_pago     = substr(PE_COMERCIO_CONCEPTO_PAGO,0,16); // Debe ser menos de 16 dígitos.
        $paymentRequest->_email_comercio    = PE_EMAIL_PORTAL;
        $paymentRequest->_fecha_expirar     = date('d/m/Y H:i:s', time() + ( ((int)EXPIRACION_DIA * 24 * 60 * 60) + ((int)$value_hrs * 60 * 60) + ((int)$value_min * 60) ));//Este valor debe ser dinamico
        $paymentRequest->_usuario_id        = (int)$cart->id_customer;
        $paymentRequest->_usuario_nombre    = substr(especiales($customer->firstname),0,10);
        $paymentRequest->_usuario_apellidos = substr(especiales($customer->lastname),0,10);
        $paymentRequest->_usuario_pais      = $billing_address->country->iso_code;
        $paymentRequest->_usuario_email     = utf8_encode($customer->email);
        $paymentRequest->_usuario_domicilio = substr(especiales($billing_address->address1),0,16);

        // GENERAR CIP DE PAGOEFECTIVO
        $pagoefectivo = new App_Service_PagoEfectivo();
        $paymentResponse = $pagoefectivo->GenerarCip($paymentRequest);

        $token = $paymentResponse->Token;
        $numCip = $paymentResponse->CIP->NumeroOrdenPago;
        $numOrden = $paymentResponse->CodTrans;
        //$codBarras = $pagoefectivo->getCodigoBarra($numCip);

        $redirect = PE_WSGENPAGO . '?token=' . $token;

        if(PE_MOD_INTEGRACION == 1){
            // Redirect on order confirmation page
            Tools::redirect('index.php?controller=order-confirmation&id_cart='.$cart->id.'&id_module='.$this->module->id.'&id_order='.$this->module->currentOrder.'&key='.$customer->secure_key.'&token='.$token);
        } else{
            Tools::redirectLink($redirect);
        }
   
    }
}

function especiales($s)
{  
    $s = preg_replace("/á|à|â|ã|ª/","a",$s);
    $s = preg_replace("/Á|À|Â|Ã/","A",$s);
    $s = preg_replace("/é|è|ê/","e",$s);
    $s = preg_replace("/É|È|Ê/","E",$s);
    $s = preg_replace("/í|ì|î/","i",$s);
    $s = preg_replace("/Í|Ì|Î/","I",$s);
    $s = preg_replace("/ó|ò|ô|õ|º/","o",$s);
    $s = preg_replace("/Ó|Ò|Ô|Õ/","O",$s);
    $s = preg_replace("/ú|ù|û/","u",$s);
    $s = preg_replace("/Ú|Ù|Û/","U",$s);
    $s = str_replace("ñ","n",$s);
    $s = str_replace("Ñ","N",$s);
    $s = trim(preg_replace('/[^a-zA-Z0-9., ]/','',$s));
    return $s;     
}