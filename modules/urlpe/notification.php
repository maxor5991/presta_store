<?php

include(dirname(__FILE__) . '/../config/config.inc.php');
include(dirname(__FILE__) . '/../init.php');
include(dirname(__FILE__) . '/../modules/pagoefectivo/pagoefectivo.php');

require_once( _PS_ROOT_DIR_ . '/modules/pagoefectivo/controllers/front/lib_pagoefectivo/PagoEfectivo.php');
require_once( _PS_ROOT_DIR_ . '/modules/pagoefectivo/controllers/front/lib_pagoefectivo/be/be_notificacion.php');

$shop = new Shop(Configuration::get('PS_SHOP_DEFAULT'));
$home_url = Tools::getShopProtocol().$shop->domain.$shop->getBaseURI();

$flag = true;
if(!isset($_POST['data'])) $flag = false;

if ($flag) {
    ini_set('display_errors',1);

    $pagoefectivo_module = new PagoEfectivo();
    $pagoefectivo = new App_Service_PagoEfectivo();
    $estado = new BE_Notificacion();

    $data = $_POST['data'];

    $solData = simplexml_load_string($pagoefectivo->desencriptarData($data));

    if($solData != null){

        $orderId = $solData->CodTrans;
        
        // $cartId = $solData->Campo1;
        // $cart = new Cart((int)$cartId);

        switch ($solData->Estado) {
            case $estado->Extornado:
                $state = 'PAGOEFECTIVO_OS_REJECTED';
                break;

            case $estado->Expirado:
                $state = 'PAGOEFECTIVO_OS_EXPIRED';
                break;

            case $estado->Pagado:
                $state = 'PS_OS_PAYMENT';
                break;

            default:
                $state = 'PS_OS_ERROR';
                return;
        }

        $moneda = (int)$solData->CIP->IdMoneda;

        if ($moneda == 1) {
            $currency = 'PEN';
        }
        if ($moneda == 2) {
            $currency = 'USD';
        }

        // if (!Validate::isLoadedObject($cart))
        //     $errors[] = $pagoefectivo_module->l('Invalid Cart ID');
        // else {
        //     $currency_cart = new Currency((int)$cart->id_currency);

        //     if ($currency != $currency_cart->iso_code)
        //         $errors[] = $pagoefectivo_module->l('Invalid Currency ID').' '.($currency.'|'.$currency_cart->iso_code);
        //     else {
        //         if ($cart->orderExists()) {
        //          $order = new Order((int)Order::getOrderByCartId($cart->id));
                    $order = new Order((int)$orderId);

                    if (_PS_VERSION_ < '1.5') {
                        $history = new OrderHistory();
                        $history->id_order = (int)$order->id;
                        $history->changeIdOrderState((int)Configuration::get($state), $order->id);
                        $history->addWithemail(true);
                    }
                    else {
                        $history = new OrderHistory();
                        $history->id_order = (int)$order->id;
                        $history->changeIdOrderState((int)Configuration::get($state), $order, true);
                        $history->addWithemail(true);
                    }
                // }
                // else {
                //     $customer = new Customer((int)$cart->id_customer);
                //     Context::getContext()->customer = $customer;
                //     Context::getContext()->currency = $currency_cart;

                //     $pagoefectivo_module->validateOrder((int)$cart->id, (int)Configuration::get($state), (float)$cart->getordertotal(true), 'PagoEfectivo', null, array(), (int)$currency_cart->id, false, $customer->secure_key);
                //     $order = new Order((int)Order::getOrderByCartId($cart->id));
                // }
                if ($state == 'PAGOEFECTIVO_OS_EXPIRED') {
                    foreach ($order->getProductsDetail() as $product)
                        StockAvailable::updateQuantity($product['product_id'], $product['product_attribute_id'], + (int)$product['product_quantity'], $order->id_shop);
                }
            //}
        //}
    }
    exit();
}
else
    Tools::redirectLink($home_url);