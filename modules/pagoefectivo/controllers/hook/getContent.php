<?php

class PagoEfectivoGetContentController
{
	public function __construct($module, $file, $path)
	{
		$this->file = $file;
		$this->module = $module;
		$this->context = Context::getContext();
		$this->_path = $path;
	}

	public function processConfiguration()
	{

		if (Tools::isSubmit('pagoefectivo_form'))
		{
			$shop = new Shop(Configuration::get('PS_SHOP_DEFAULT'));
			$home_url = Tools::getShopProtocol().$shop->domain.$shop->getBaseURI();

			$ds = DIRECTORY_SEPARATOR;
        	$path = _PS_ROOT_DIR_.'/upload/pagoefectivo/key';
			if (!file_exists($path)) {
	            if (!mkdir($path, 0777, true)) {
	                die('Failed to create folders...');
	            }
	        }

			$key_publica = $path.$ds.$_FILES['PE_CONFIG_KEYPUBLICA']['name'];
        	move_uploaded_file($_FILES['PE_CONFIG_KEYPUBLICA']['tmp_name'], $key_publica);

        	$key_privada = $path.$ds.$_FILES['PE_CONFIG_KEYPRIVADA']['name'];
        	move_uploaded_file($_FILES['PE_CONFIG_KEYPRIVADA']['tmp_name'], $key_privada);

        	if ($_FILES['PE_CONFIG_KEYPUBLICA']['name']){
        		$key_publica_nombre = $_FILES['PE_CONFIG_KEYPUBLICA']['name'];
        	} else {
        		$key_publica_nombre = Tools::getValue('PE_CONFIG_KEYPUBLICA_NOMBRE', Configuration::get('PE_CONFIG_KEYPUBLICA_NOMBRE'));
        	}

        	if ($_FILES['PE_CONFIG_KEYPRIVADA']['name']){
        		$key_privada_nombre = $_FILES['PE_CONFIG_KEYPRIVADA']['name'];
        	} else {
        		$key_privada_nombre = Tools::getValue('PE_CONFIG_KEYPRIVADA_NOMBRE', Configuration::get('PE_CONFIG_KEYPRIVADA_NOMBRE'));
        	}

			Configuration::updateValue('PE_COMERCIO_NOMBRE', Tools::getValue('PE_COMERCIO_NOMBRE'));
			Configuration::updateValue('PE_COMERCIO_EMAIL', Tools::getValue('PE_COMERCIO_EMAIL'));
			Configuration::updateValue('PE_COMERCIO_IP', $_SERVER['SERVER_ADDR']);
			Configuration::updateValue('PE_TITULO', Tools::getValue('PE_TITULO'));
			Configuration::updateValue('PE_INTERNET', Tools::getValue('PE_INTERNET'));
			Configuration::updateValue('PE_AGENCIAS', Tools::getValue('PE_AGENCIAS'));
			Configuration::updateValue('PE_PREGUNTA', Tools::getValue('PE_PREGUNTA'));
			Configuration::updateValue('PE_URL', Tools::getValue('PE_URL'));
			Configuration::updateValue('PE_CONFIG_ID', Tools::getValue('PE_CONFIG_ID'));
			Configuration::updateValue('PE_CONFIG_SERVIDOR', Tools::getValue('PE_CONFIG_SERVIDOR'));
			Configuration::updateValue('PE_TEST', Tools::getValue('PE_TEST'));
			Configuration::updateValue('PE_TEST_URL', $home_url.'modules/pagoefectivo/pages/test.php');
			Configuration::updateValue('PE_CONFIG_KEYPUBLICA_NOMBRE', $key_publica_nombre);
			Configuration::updateValue('PE_CONFIG_KEYPRIVADA_NOMBRE', $key_privada_nombre);
			Configuration::updateValue('PE_CONFIG_DIA', Tools::getValue('PE_CONFIG_DIA'));
			Configuration::updateValue('PE_CONFIG_HORA', Tools::getValue('PE_CONFIG_HORA'));
			Configuration::updateValue('PE_CONFIG_MINUTO', Tools::getValue('PE_CONFIG_MINUTO'));
			Configuration::updateValue('PE_CONFIG_MODO', Tools::getValue('PE_CONFIG_MODO'));
			$this->context->smarty->assign('confirmation', 'ok');
		}
	}

	public function renderForm()
	{
		$horas = array();

		for($i = 0; $i <= 23; $i++) {
			$horas[$i]['key'] = $i;
			$horas[$i]['name'] = $i;
		}

		$minutos = array();

		for($i = 0; $i <= 59; $i++) {
			$minutos[$i]['key'] = $i;
			$minutos[$i]['name'] = $i;
		}

		$inputs = array(
			array(
				'name' => 'PE_COMERCIO_NOMBRE',
				'label' => $this->module->l('Nombre de su comercio'),
				'type' => 'text',
			),
			array(
				'name' => 'PE_COMERCIO_EMAIL',
				'label' => $this->module->l('Email de contacto'),
				'type' => 'text',
			),
			array(
				'name' => 'PE_COMERCIO_IP',
				'label' => $this->module->l('IP de su tienda'),
				'type' => 'text',
				'readonly' => 'readonly',
			),
			array(
				'name' => 'PE_TITULO',
				'label' => $this->module->l('Título del método de pago'),
				'type' => 'text',
			),
			array(
				'name' => 'PE_INTERNET',
				'label' => $this->module->l('Título descriptivo - Banca por Internet'),
				'type' => 'textarea',
			),
			array(
				'name' => 'PE_AGENCIAS',
				'label' => $this->module->l('Título descriptivo - Agente y agencias'),
				'type' => 'textarea',
			),
			array(
				'name' => 'PE_PREGUNTA',
				'label' => $this->module->l('Texto de pregunta'),
				'type' => 'text',
			),
			array(
				'name' => 'PE_URL',
				'label' => $this->module->l('Url de la pregunta'),
				'type' => 'text',
			),
			array(
				'name' => 'PE_CONFIG_ID',
				'label' => $this->module->l('Identificador de su comercio (Merchant ID)'),
				'type' => 'text',
			),
			array(
				'name' => 'PE_CONFIG_SERVIDOR',
				'label' => $this->module->l('Servidor PagoEfectivo'),
				'type' => 'text',
			),
			array(
				'name' => 'PE_TEST',
				'label' => $this->module->l('Test de conectividad'),
				'type' => 'switch',
				'values' => array(
					array('label' => $this->module->l('Yes'), 'value' => 1, 'id' => 'test_si'),
					array('label' => $this->module->l('No'), 'value' => 0, 'id' => 'test_no'),
				),
				'is_bool' => true,
				'class' => 't',
			),
			array(
				'name' => 'PE_TEST_URL',
				'label' => $this->module->l('URL de test'),
				'type' => 'text',
				'readonly' => 'readonly',
			),
			array(
				'name' => 'PE_CONFIG_KEYPUBLICA',
				'label' => $this->module->l('Llave Pública'),
				'type' => 'file',
			),
			array(
				'name' => 'PE_CONFIG_KEYPUBLICA_NOMBRE',
				'label' => $this->module->l(''),
				'type' => 'text',
				'readonly' => 'readonly',
			),
			array(
				'name' => 'PE_CONFIG_KEYPRIVADA',
				'label' => $this->module->l('Llave Privada'),
				'type' => 'file',
			),
			array(
				'name' => 'PE_CONFIG_KEYPRIVADA_NOMBRE',
				'label' => $this->module->l(''),
				'type' => 'text',
				'readonly' => 'readonly',
			),
			array(
				'name' => 'PE_CONFIG_DIA',
				'label' => $this->module->l('Tiempo de expiración (Días)'),
				'type' => 'text',
			),
			array(
				'name' => 'PE_CONFIG_HORA',
				'label' => $this->module->l('Tiempo de expiración (Horas)'),
				'type' => 'select',
				'options' => array(
					'query' => $horas,
					'name' => 'name',
					'id' => 'key'
				)
			),
			array(
				'name' => 'PE_CONFIG_MINUTO',
				'label' => $this->module->l('Tiempo de expiración (Minutos)'),
				'type' => 'select',
				'options' => array(
					'query' => $minutos,
					'name' => 'name',
					'id' => 'key'
				)
			),
			array(
				'name' => 'PE_CONFIG_MODO',
				'label' => $this->module->l('Modo de Integración'),
				'type' => 'select',
				'options' => array(
					'query' => array(
						array('key' => 1, 'name' => 'Iframe (Embebido en el portal del comercio)'),
						array('key' => 2, 'name' => 'Redirección (Abre una nueva ventana)')
					),
					'name' => 'name',
					'id' => 'key'
				)
			),
		);

		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->module->l('Configuración de PagoEfectivo'),
					'icon' => 'icon-wrench'
				),
				'input' => $inputs,
				'submit' => array('title' => $this->module->l('Save'))
			)
		);

		$helper = new HelperForm();
		$helper->table = 'pagoefectivo';
		$helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
		$helper->allow_employee_form_lang = (int)Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG');
		$helper->submit_action = 'pagoefectivo_form';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->module->name.'&tab_module='.$this->module->tab.'&module_name='.$this->module->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');

		$shop = new Shop(Configuration::get('PS_SHOP_DEFAULT'));
		$home_url = Tools::getShopProtocol().$shop->domain.$shop->getBaseURI();

		$pe_titulo = Configuration::get('PE_TITULO');
	    if( $pe_titulo == "" ){ $pe_titulo = 'PagoEfectivo'; }

	    $pe_internet = Configuration::get('PE_INTERNET');
	    if( $pe_internet == "" ){ $pe_internet = 'Paga a través de tu banca por internet en BBVA, BCP, INTERBANK, SCOTIABANK y BANBIF. Debítalo de tu cuenta o cárgalo a tu tarjeta de crédito asociada.'; }

	    $pe_agencias = Configuration::get('PE_AGENCIAS');
	    if( $pe_agencias == "" ){ $pe_agencias = 'Acércate a cualquier punto del BBVA, BCP, INTER- BANK, SCOTIABANK y BANBIF. Agentes corresponsales KASNET, WESTER UNION - Pago de Servicios y FULLCARGA.'; }

	    $pe_pregunta = Configuration::get('PE_PREGUNTA');
	    if( $pe_pregunta == "" ){ $pe_pregunta = '¿Cómo funciona PagoEfectivo?'; }

		$pe_url = Configuration::get('PE_URL');
	    if( $pe_url == "" ){ $pe_url = 'https://cip.pagoefectivo.pe/CNT/QueEsPagoEfectivo.aspx'; }

	    $pe_config_servidor = Configuration::get('PE_CONFIG_SERVIDOR');
	    if( $pe_config_servidor == "" ){ $pe_config_servidor = 'https://cip.pre.2b.pagoefectivo.pe/'; }

	    $pe_config_dia = Configuration::get('PE_CONFIG_DIA');
	    if( $pe_config_dia == "" ){ $pe_config_dia = 0; }

		$helper->tpl_vars = array(
			'fields_value' => array(
				'PE_COMERCIO_NOMBRE' => Tools::getValue('PE_COMERCIO_NOMBRE', Configuration::get('PE_COMERCIO_NOMBRE')),
				'PE_COMERCIO_EMAIL' => Tools::getValue('PE_COMERCIO_EMAIL', Configuration::get('PE_COMERCIO_EMAIL')),
				'PE_COMERCIO_IP' => Tools::getValue('PE_COMERCIO_IP', $_SERVER['SERVER_ADDR']),
				'PE_TITULO' => Tools::getValue('PE_TITULO', $pe_titulo),
				'PE_INTERNET' => Tools::getValue('PE_INTERNET', $pe_internet),
				'PE_AGENCIAS' => Tools::getValue('PE_AGENCIAS', $pe_agencias),
				'PE_PREGUNTA' => Tools::getValue('PE_PREGUNTA', $pe_pregunta),
				'PE_URL' => Tools::getValue('PE_URL', $pe_url),
				'PE_CONFIG_ID' => Tools::getValue('PE_CONFIG_ID', Configuration::get('PE_CONFIG_ID')),
				'PE_CONFIG_SERVIDOR' => Tools::getValue('PE_CONFIG_SERVIDOR', $pe_config_servidor),
				'PE_TEST' => Tools::getValue('PE_TEST', Configuration::get('PE_TEST')),
				'PE_TEST_URL' => Tools::getValue('PE_TEST_URL', $home_url.'modules/pagoefectivo/pages/test.php'),
				'PE_CONFIG_KEYPUBLICA' => Tools::getValue('PE_CONFIG_KEYPUBLICA', Configuration::get('PE_CONFIG_KEYPUBLICA')),
				'PE_CONFIG_KEYPUBLICA_NOMBRE' => Tools::getValue('PE_CONFIG_KEYPUBLICA_NOMBRE', Configuration::get('PE_CONFIG_KEYPUBLICA_NOMBRE')),
				'PE_CONFIG_KEYPRIVADA_NOMBRE' => Tools::getValue('PE_CONFIG_KEYPRIVADA_NOMBRE', Configuration::get('PE_CONFIG_KEYPRIVADA_NOMBRE')),
				'PE_CONFIG_KEYPRIVADA' => Tools::getValue('PE_CONFIG_KEYPRIVADA', Configuration::get('PE_CONFIG_KEYPRIVADA')),
				'PE_CONFIG_DIA' => Tools::getValue('PE_CONFIG_DIA', $pe_config_dia),
				'PE_CONFIG_HORA' => Tools::getValue('PE_CONFIG_HORA', Configuration::get('PE_CONFIG_HORA')),
				'PE_CONFIG_MINUTO' => Tools::getValue('PE_CONFIG_MINUTO', Configuration::get('PE_CONFIG_MINUTO')),
				'PE_CONFIG_MODO' => Tools::getValue('PE_CONFIG_MODO', Configuration::get('PE_CONFIG_MODO')),
			),
			'languages' => $this->context->controller->getLanguages()
		);

		return $helper->generateForm(array($fields_form));
	}

	public function run()
	{
		$this->processConfiguration();
		$html_confirmation_message = $this->module->display($this->file, 'getContent.tpl');
		$html_form = $this->renderForm();
		return $html_confirmation_message.$html_form;
	}
}
