<?php
/* Smarty version 3.1.33, created on 2019-01-04 19:59:56
  from 'C:\xampp\htdocs\presta\modules\mercadopago\views\templates\admin\paymentConfiguration.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c30018c7c9739_10909614',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '93128bb037b83d1b22d89d9eb7a5f56591a5e887' => 
    array (
      0 => 'C:\\xampp\\htdocs\\presta\\modules\\mercadopago\\views\\templates\\admin\\paymentConfiguration.tpl',
      1 => 1546647709,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c30018c7c9739_10909614 (Smarty_Internal_Template $_smarty_tpl) {
?><form id="module_form" class="defaultForm form-horizontal" action="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['currentIndex']->value,'htmlall','UTF-8' ));?>
" method="post" enctype="multipart/form-data">
<div class="panel">
	<?php if ($_smarty_tpl->tpl_vars['show']->value) {?>
	<div class="form-group border-none">
		<div class="col-lg-2 logo-wrapper">
			<img src="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['thisPath']->value,'htmlall','UTF-8' ));?>
views/img/mercadopago_125X125.jpg" class="payment-config-logo">
		</div>
		<label class="payment-label col-lg-3">
			Checkout Standard
		</label>
		<div class="col-lg-3">
			<div class="col-lg-6 switch prestashop-switch fixed-width-lg">
				<input type="radio" name="MERCADOPAGO_STARDAND_ACTIVE" id="MERCADOPAGO_STARDAND_ACTIVE_on" value="1"  <?php if (($_smarty_tpl->tpl_vars['mercadoPagoActive']->value == 1)) {?>checked="checked"<?php }?>>
				<label for="MERCADOPAGO_STARDAND_ACTIVE_on"><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['button']->value['yes'],'htmlall','UTF-8' ));?>
</label>

				<input type="radio" name="MERCADOPAGO_STARDAND_ACTIVE" id="MERCADOPAGO_STARDAND_ACTIVE_off" value="0" <?php if (empty($_smarty_tpl->tpl_vars['mercadoPagoActive']->value)) {?>checked="checked"<?php }?>>
				<label for="MERCADOPAGO_STARDAND_ACTIVE_off"><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['button']->value['no'],'htmlall','UTF-8' ));?>
</label>
				<a class="slide-button btn"></a>
			</div>
		</div>
		<div class="col-lg-4">
			<label class="general-tooltip">
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'When enabled, all single payment methods will be disabled.','d'=>'Modules.MercadoPago.Admin'),$_smarty_tpl ) );?>

			</label>
		</div>
		<div style="clear: both"></div>
	</div>
	<div style="clear: both"></div>
	<?php } else { ?>
		<div class="alert alert-danger">
	  		<strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Danger!','d'=>'Modules.MercadoPago.Admin'),$_smarty_tpl ) );?>
</strong> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Please, fill your credentials to enable the module.','d'=>'Modules.MercadoPago.Admin'),$_smarty_tpl ) );?>

		</div>
	<?php }?>
</div>
<?php if ($_smarty_tpl->tpl_vars['show']->value) {?>
<div class="panel panel-default">
	<div class="panel-heading"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Payment Methods','d'=>'Modules.MercadoPago.Admin'),$_smarty_tpl ) );?>
</div>
	<div class="alert alert-info">
	  <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Enable and disable your payment methods.','d'=>'Modules.MercadoPago.Admin'),$_smarty_tpl ) );?>

	</div>
	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['payments']->value, 'payment', false, 'sort');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['sort']->value => $_smarty_tpl->tpl_vars['payment']->value) {
?>
		<div class="form-group">
			<div class="col-lg-2 logo-wrapper">
				<img src="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['payment']->value['brand'],'htmlall','UTF-8' ));?>
" alt="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['payment']->value['title'],'htmlall','UTF-8' ));?>
">
			</div>
<!-- 				<label class="payment-label col-lg-3">
				<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['payment']->value['title'],'htmlall','UTF-8' ));?>

				<?php if (!empty($_smarty_tpl->tpl_vars['payment']->value['thumbnail'])) {?>
					<img src="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['thisPath']->value,'htmlall','UTF-8' ));?>
views/img/questionmark.png" alt="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['payment']->value['type'],'htmlall','UTF-8' ));?>
" data-toggle="tooltip" title="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['payment']->value['tooltips'],'htmlall','UTF-8' ));?>
" class="payment-config-tooltip">
				<?php }?>
			</label> -->
			<div class="col-lg-3">
				<!--<div class="col-lg-4 control-label switch-label">
					<?php if (($_smarty_tpl->tpl_vars['payment']->value['active'] == 1)) {?>
						<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['label']->value['active'],'htmlall','UTF-8' ));?>

					<?php } else { ?>
						<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['label']->value['disable'],'htmlall','UTF-8' ));?>

					<?php }?>
				</div>-->
				<div class="col-lg-6 switch prestashop-switch fixed-width-lg">
					<input type="radio" name="MERCADOPAGO_<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['payment']->value['id'],'htmlall','UTF-8' ));?>
_ACTIVE" id="MERCADOPAGO_<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['payment']->value['id'],'htmlall','UTF-8' ));?>
_ACTIVE_on" value="1" <?php if (($_smarty_tpl->tpl_vars['payment']->value['active'] == 1)) {?>checked="checked"<?php }?>>
					<label for="MERCADOPAGO_<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['payment']->value['id'],'htmlall','UTF-8' ));?>
_ACTIVE_on"><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['button']->value['yes'],'htmlall','UTF-8' ));?>
</label>

					<input type="radio" name="MERCADOPAGO_<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['payment']->value['id'],'htmlall','UTF-8' ));?>
_ACTIVE" id="MERCADOPAGO_<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['payment']->value['id'],'htmlall','UTF-8' ));?>
_ACTIVE_off" value="0" <?php if (empty($_smarty_tpl->tpl_vars['payment']->value['active'])) {?>checked="checked"<?php }?>>
					<label for="MERCADOPAGO_<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['payment']->value['id'],'htmlall','UTF-8' ));?>
_ACTIVE_off"><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['button']->value['no'],'htmlall','UTF-8' ));?>
</label>
					<a class="slide-button btn"></a>
				</div>
			</div>
			<div style="clear: both"></div>
		</div>
		<div style="clear: both"></div>
	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
</div>

<div class="row">
	<div class="col-md-12 text-center"> 
		<button type="submit" value="1" name="btnSubmitPaymentConfig" class="btn btn-primary btn-lg">
			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Save','mod'=>'mercadopago'),$_smarty_tpl ) );?>

		</button>
	</div>
</div>

<?php }?>
</form>

<?php echo '<script'; ?>
 type="text/javascript">
	<?php if ($_smarty_tpl->tpl_vars['mercadoPagoActive']->value) {?>
		$("#MERCADOPAGO_STARDAND_ACTIVE_on").attr("checked", true);
	<?php }
echo '</script'; ?>
>
<?php }
}
