<?php

class PagoEfectivoPaymentReturnController
{
	public function __construct($module, $file, $path)
	{
		$this->file = $file;
		$this->module = $module;
		$this->context = Context::getContext();
		$this->_path = $path;
	}

	public function run($params)
	{
		if ($params['objOrder']->payment != $this->module->displayName)
			return '';

		$reference = $params['objOrder']->id;
		if (isset($params['objOrder']->reference) && !empty($params['objOrder']->reference))
			$reference = $params['objOrder']->reference;
		$total_to_pay = Tools::displayPrice($params['total_to_pay'], $params['currencyObj'], false);
		$token = $_GET['token'];

		$this->context->smarty->assign(array(
			'reference' => $reference,
			'total_to_pay' => $total_to_pay,
			'server' => Configuration::get('PE_CONFIG_SERVIDOR'),
			'token' => $token,
		));

		return $this->module->display($this->file, 'paymentReturn.tpl');
	}
}
