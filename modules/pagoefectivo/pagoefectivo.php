<?php

class PagoEfectivo extends PaymentModule
{
    public function __construct()
    {
        $this->name = 'pagoefectivo';
        $this->tab = 'payments_gateways';
        $this->version = '1.0.0';
        $this->author = 'PagoEfectivo';
        $this->bootstrap = true;
        $this->currencies = true;
        $this->currencies_mode = 'checkbox';

        parent::__construct();

        $this->displayName = $this->l('PagoEfectivo');
        $this->description = $this->l('Transacciones seguras en internet en el Perú.');

        $this->confirmUninstall = $this->l('¿Esta seguro de querer desintalar el módulo de PagoEfectivo?');

        if (!extension_loaded('openssl')) {
            $this->warning = $this->l("Debe habilitar la extensión openssl en su archivo php.ini.");
        }
        if (!extension_loaded('soap')) {
            $this->warning = $this->l("Debe habilitar la extensión soap en su archivo php.ini.");
        }
    }

    public function install()
    {
        $this->installOrderState();

        if (!parent::install()
            || !$this->registerHook('Payment')
            || !$this->registerHook('PaymentReturn'))
            return false;
        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall()
            || !Configuration::deleteByName('PAGOEFECTIVO_OS_PENDING')
            || !Configuration::deleteByName('PAGOEFECTIVO_OS_EXPIRED')
            || !Configuration::deleteByName('PAGOEFECTIVO_OS_REJECTED'))
            return false;
        return true;
    }

    public function installOrderState()
    {   
        if (!Configuration::get('PAGOEFECTIVO_OS_PENDING'))
        {
            $order_state = new OrderState();
            $order_state->name = array();
            foreach (Language::getLanguages() as $language)
                $order_state->name[$language['id_lang']] = 'Pago pendiente';

            $order_state->send_email = false;
            $order_state->color = '#FFD942';
            $order_state->hidden = false;
            $order_state->delivery = false;
            $order_state->logable = false;
            $order_state->invoice = false;

            if ($order_state->add())
            {
                $source = dirname(__FILE__).'/img/logo.jpg';
                $destination = dirname(__FILE__).'/../../img/os/'.(int)$order_state->id.'.gif';
                copy($source, $destination);
            }
            Configuration::updateValue('PAGOEFECTIVO_OS_PENDING', (int)$order_state->id);
        }

        if (!Configuration::get('PAGOEFECTIVO_OS_EXPIRED'))
        {
            $order_state = new OrderState();
            $order_state->name = array();
            foreach (Language::getLanguages() as $language)
                $order_state->name[$language['id_lang']] = 'Pago expirado';

            $order_state->send_email = false;
            $order_state->color = '#ec2e15';
            $order_state->hidden = false;
            $order_state->delivery = false;
            $order_state->logable = false;
            $order_state->invoice = false;

            if ($order_state->add())
            {
                $source = dirname(__FILE__).'/img/logo.jpg';
                $destination = dirname(__FILE__).'/../../img/os/'.(int)$order_state->id.'.gif';
                copy($source, $destination);
            }
            Configuration::updateValue('PAGOEFECTIVO_OS_EXPIRED', (int)$order_state->id);
        }

        if (!Configuration::get('PAGOEFECTIVO_OS_REJECTED'))
        {
            $order_state = new OrderState();
            $order_state->name = array();
            foreach (Language::getLanguages() as $language)
                $order_state->name[$language['id_lang']] = 'Pago extornado';

            $order_state->send_email = false;
            $order_state->color = '#FFD942';
            $order_state->hidden = false;
            $order_state->delivery = false;
            $order_state->logable = false;
            $order_state->invoice = false;

            if ($order_state->add())
            {
                $source = dirname(__FILE__).'/img/logo.jpg';
                $destination = dirname(__FILE__).'/../../img/os/'.(int)$order_state->id.'.gif';
                copy($source, $destination);
            }
            Configuration::updateValue('PAGOEFECTIVO_OS_REJECTED', (int)$order_state->id);
        }

    }

    public function getHookController($hook_name)
    {
        // Include the controller file
        require_once(dirname(__FILE__).'/controllers/hook/'. $hook_name.'.php');

        // Build dynamically the controller name
        $controller_name = $this->name.$hook_name.'Controller';

        // Instantiate controller
        $controller = new $controller_name($this, __FILE__, $this->_path);

        // Return the controller
        return $controller;
    }

    public function hookPayment($params)
    {
        $controller = $this->getHookController('payment');
        return $controller->run($params);
    }

    public function hookPaymentReturn($params)
    {
        $controller = $this->getHookController('paymentReturn');
        return $controller->run($params);
    }

    public function getContent()
    {
        $controller = $this->getHookController('getContent');
        return $controller->run();
    }

}


