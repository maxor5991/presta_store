<?php

require_once( _PS_ROOT_DIR_ . '/modules/pagoefectivo/controllers/front/lib_pagoefectivo/PagoEfectivo.php');

class PagoEfectivoCIP extends PaymentModule
{
    public function __construct()
    {
        $this->name = 'pagoefectivocip';
        $this->tab = 'payments_gateways';
        $this->version = '1.0.0';
        $this->author = 'PagoEfectivo';
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('PagoEfectivo - Operaciones con CIP');
        $this->description = $this->l('Transacciones seguras en internet en el Perú.');

        $this->confirmUninstall = $this->l('¿Esta seguro de querer desintalar el módulo de PagoEfectivo - Operaciones con CIP?');

    }

    public function getContent()
    {

        if (isset($_POST) && isset($_POST['submitCIP']))
        {
            $this->_displayResult();
        }
        return $this->_displayAdminTpl();
    }

    private function _displayAdminTpl()
    {
        $this->context->smarty->assign(array(
            'formCIP' => './index.php?tab=AdminModules&configure=pagoefectivocip&token='.Tools::getAdminTokenLite('AdminModules').
            '&tab_module='.$this->tab.'&module_name=pagoefectivocip',
            'tab' => array(
                'EstadoCip' => array(
                    'title' => $this->l('Actualizar estado del CIP'),
                    'content' => $this->_actualizarEstadoCIP(),
                    'tab' => 'estado',
                    'selected' => (Tools::isSubmit('submitCIP') ? true : false),
                    'style' => 'credentials_pe',
                ),
                'EliminarCip' => array(
                    'title' => $this->l('Eliminar número de CIP'),
                    'content' => $this->_eliminarCIP(),
                    'tab' => 'eliminar',
                    'selected' => (Tools::isSubmit('submitCIP') ? true : false),
                    'style' => 'credentials_pe',
                ),
                'FechaCip' => array(
                    'title' => $this->l('Actualizar fecha de expiración del CIP'),
                    'content' => $this->_fechaCIP(),
                    'tab' => 'fecha',
                    'selected' => (Tools::isSubmit('submitCIP') ? true : false),
                    'style' => 'credentials_pe',
                ),
            ),
            'css' => '../modules/pagoefectivocip/css/',
        ));

        return $this->display(__FILE__, 'views/templates/admin/admin.tpl');
    }

    private function _actualizarEstadoCIP()
    {
        $this->context->smarty->assign(array(
            'estadoTitle' => $this->l('Actualizar estado del CIP'),
            'estadoInputVar' => array(
                'EstadoCip' => array(
                    'name' => 'EstadoCip',
                    'required' => true,
                    'type' => 'text',
                    'label' => $this->l('Número de CIP'),
                    'desc' => $this->l('Se puede Ingresar el valor de un CIP o más separados por comas (máximo 10 CIPs). Ej: 1724393, 1723897 o 1724393.')
                )
            )
        ));
        return $this->display(__FILE__, 'views/templates/admin/actualizarEstado.tpl');
    }

    private function _eliminarCIP()
    {
        $this->context->smarty->assign(array(
            'eliminarTitle' => $this->l('Eliminar número de CIP'),
            'eliminarInputVar' => array(
                'EliminarCip' => array(
                    'name' => 'EliminarCip',
                    'required' => true,
                    'type' => 'text',
                    'label' => $this->l('Número de CIP'),
                    'desc' => $this->l('Se puede Ingresar el valor de un CIP o más separados por comas (máximo 10 CIPs). Ej: 1724393, 1723897 o 1724393.')
                )
            )
        ));
        return $this->display(__FILE__, 'views/templates/admin/eliminar.tpl');
    }

    private function _fechaCIP()
    {
        $this->context->smarty->assign(array(
            'fechaTitle' => $this->l('Actualizar fecha de expiración del CIP'),
            'fechaInputVar' => array(
                'fechaCip' => array(
                    'name' => 'fechaCip',
                    'required' => true,
                    'type' => 'text',
                    'label' => $this->l('Número de CIP')
                )
            )
        ));
        return $this->display(__FILE__, 'views/templates/admin/actualizarFecha.tpl');
    }

    private function _displayResult()
    {

        $OPCION = $_POST['submit'];
        $mensaje = '';

        try {
            $arr_estado = array('21'=>'Expirado', '22'=> 'Pendiente', '23'=>'Pagado', '25'=>'Eliminado');

            if ($OPCION == "Estado") {

                $CIP = $_POST['EstadoCip'];
                //Lamada al método de consultar CIP
                $pagoefectivo = new App_Service_PagoEfectivo();
                $paymentResponse = $pagoefectivo->consultarCip(trim($CIP));

                //Mostrar respuesta
                if($paymentResponse->Estado){

                    $CIPResult = $paymentResponse->CIPs->ConfirSolPago;     

                    foreach($CIPResult as $CIPs){

                        $orderId = $CIPs->CIP->OrderIdComercio;
                        //$cart = new Cart((int)$orderId);

                        switch ($CIPs->CIP->IdEstado) {
                            case 21:
                                $state = 'PAGOEFECTIVO_OS_EXPIRED';
                                break;

                            case 22:
                                $state = 'PAGOEFECTIVO_OS_PENDING';
                                break;

                            case 23:
                                $state = 'PS_OS_PAYMENT';
                                break;

                            case 25:
                                $state = 'PS_OS_CANCELED';
                                break;

                            default:
                                $state = 'PS_OS_ERROR';
                                return;
                        }

                        //if ($cart->orderExists()) {
                            //$order = new Order((int)Order::getOrderByCartId($cart->id));
                            $order = new Order((int)$orderId);

                            if (_PS_VERSION_ < '1.5') {
                                $current_state = $order->getCurrentState();

                                $mensaje .= 'Número de CIP: '.$CIPs->CIP->IdOrdenPago.'<br />';
                                $mensaje .= 'Número de pedido: '.$CIPs->CIP->OrderIdComercio.'<br />';
                                $mensaje .= 'Estado actual del pedido: <b>'.$current_state.'</b><br />';
                                $mensaje .= 'Estado del CIP: <b>'.$arr_estado[(string)($CIPs->CIP->IdEstado)].'</b><br />';
                                $mensaje .= 'Fecha de Emision: '.$CIPs->CIP->FechaEmision.'<br />';

                                $history = new OrderHistory();
                                $history->id_order = (int)$order->id;
                                $history->changeIdOrderState((int)Configuration::get($state), $order->id);
                                $history->addWithemail(true);

                                $current_state_new = $order->getCurrentState();
                                $mensaje .= 'Nuevo estado del pedido: <b>'.$current_state_new.'</b><br />';
                                $mensaje .= '<br /><hr><br />';

                            }
                            else {
                                $current_state = $order->current_state;

                                $mensaje .= 'Número de CIP: '.$CIPs->CIP->IdOrdenPago.'<br />';
                                $mensaje .= 'Número de pedido: '.$CIPs->CIP->OrderIdComercio.'<br />';
                                $mensaje .= 'Estado actual del pedido: <b>'.$current_state.'</b><br />';
                                $mensaje .= 'Estado del CIP: <b>'.$arr_estado[(string)($CIPs->CIP->IdEstado)].'</b><br />';
                                $mensaje .= 'Fecha de Emision: '.$CIPs->CIP->FechaEmision.'<br />';

                                $history = new OrderHistory();
                                $history->id_order = (int)$order->id;
                                $history->changeIdOrderState((int)Configuration::get($state), $order, true);
                                $history->addWithemail(true);

                                $current_state_new = $order->current_state;
                                $mensaje .= 'Nuevo estado del pedido: <b>'.$current_state_new.'</b><br />';
                                $mensaje .= '<br /><hr><br />';

                            }
                       // }
                    }
                }else{
                    $mensaje = $paymentResponse->ConsultarCIPResult->Mensaje;
                }
                $this->context->smarty->assign(array(
                    'mensaje_actualizarestado' => $mensaje,
                ));
            }

            if ($OPCION == "Eliminar") {

                $CIP = trim($_POST['EliminarCip']);
                $CIPLista = explode(',', $CIP);

                $pagoefectivo = new App_Service_PagoEfectivo();

                foreach($CIPLista as $CIPs){

                    //Lamada al método de Eliminar de CIP
                    $paymentRequest = $pagoefectivo->eliminarCip($CIPs);
                    $mensaje .= $paymentRequest->Mensaje;
                    $estado = $paymentRequest->Estado; // 1 = el CIP se elimina // 0 = CIP eliminado anteriormente o expirado

                    if ($estado == 1) {
                        //Lamada a la consulta del CIP
                        $paymentResponse =$pagoefectivo->consultarCIP($CIPs);
                        $CIPResult = $paymentResponse->CIPs->ConfirSolPago;
                        $CIPResult = $CIPResult->CIP;

                        $orderId = $CIPResult->OrderIdComercio;
                        //$cart = new Cart((int)$orderId);

                        //if ($cart->orderExists()) {
                            //$order = new Order((int)Order::getOrderByCartId($cart->id));
                            $order = new Order((int)$orderId);

                            if (_PS_VERSION_ < '1.5') {
                                $current_state = $order->getCurrentState();

                                $mensaje .= '<br /><br />';
                                $mensaje .= 'Número de pedido: '.$CIPResult->OrderIdComercio.'<br />';
                                $mensaje .= 'Estado actual del pedido: <b>'.$current_state.'</b><br />';
                                $mensaje .= 'Nuevo estado del CIP: <b>'.$arr_estado[(string)$CIPResult->IdEstado].'</b><br />';
                                $mensaje .= 'Fecha de Emision: '.$CIPResult->FechaEmision.'<br />';

                                $state = 'PS_OS_CANCELED';

                                $history = new OrderHistory();
                                $history->id_order = (int)$order->id;
                                $history->changeIdOrderState((int)Configuration::get($state), $order->id);
                                $history->addWithemail(true);

                                $current_state_new = $order->getCurrentState();
                                $mensaje .= 'Nuevo estado del pedido: <b>'.$current_state_new.'</b><br />';

                            }
                            else {
                                $current_state = $order->current_state;

                                $mensaje .= '<br /><br />';
                                $mensaje .= 'Número de pedido: '.$CIPResult->OrderIdComercio.'<br />';
                                $mensaje .= 'Estado actual del pedido: <b>'.$current_state.'</b><br />';
                                $mensaje .= 'Nuevo estado del CIP: <b>'.$arr_estado[(string)$CIPResult->IdEstado].'</b><br />';
                                $mensaje .= 'Fecha de Emision: '.$CIPResult->FechaEmision.'<br />';

                                $state = 'PS_OS_CANCELED';

                                $history = new OrderHistory();
                                $history->id_order = (int)$order->id;
                                $history->changeIdOrderState((int)Configuration::get($state), $order, true);
                                $history->addWithemail(true);

                                $current_state_new = $order->current_state;
                                $mensaje .= 'Nuevo estado del pedido: <b>'.$current_state_new.'</b><br />';

                            }
                        //}
                    }
                    else {
                        $mensaje .= '<br />';
                    }

                    $mensaje .= '<br /><hr><br />';
                }

                $this->context->smarty->assign(array(
                    'mensaje_eliminar' => $mensaje,
                ));
            }

            if ($OPCION == "Fecha") {

                $CIP = trim($_POST['fechaCip']);
                $CIPLista = explode(',', $CIP);

                $fecha = $_POST['CfechaCIP'];

                $pagoefectivo = new App_Service_PagoEfectivo();

                foreach($CIPLista as $CIPs){
                    $paymentResponse = $pagoefectivo->actualizarCip($CIPs,trim($fecha));
                    $mensaje .= $paymentResponse->Mensaje;
                    $mensaje .= '<br /><br /><hr><br />';
                }

                $this->context->smarty->assign(array(
                    'mensaje_actualizarfecha' => $mensaje,
                ));

            }
        }
        catch (Exception $e){
            echo 'Mensaje: ',  $e->getMessage(), "\n";
        }
    }
}


