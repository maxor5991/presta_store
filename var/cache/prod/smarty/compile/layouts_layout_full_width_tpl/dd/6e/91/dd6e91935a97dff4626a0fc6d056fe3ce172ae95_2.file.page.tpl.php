<?php
/* Smarty version 3.1.33, created on 2019-01-04 19:54:21
  from 'C:\xampp\htdocs\presta\themes\classic\templates\page.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c30003dac0e94_68158637',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dd6e91935a97dff4626a0fc6d056fe3ce172ae95' => 
    array (
      0 => 'C:\\xampp\\htdocs\\presta\\themes\\classic\\templates\\page.tpl',
      1 => 1546642544,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c30003dac0e94_68158637 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_12450928715c30003da8f093_80919971', 'content');
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, $_smarty_tpl->tpl_vars['layout']->value);
}
/* {block 'page_title'} */
class Block_4680277135c30003da90117_59292926 extends Smarty_Internal_Block
{
public $callsChild = 'true';
public $hide = 'true';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <header class="page-header">
          <h1><?php 
$_smarty_tpl->inheritance->callChild($_smarty_tpl, $this);
?>
</h1>
        </header>
      <?php
}
}
/* {/block 'page_title'} */
/* {block 'page_header_container'} */
class Block_6006674015c30003da8f7d2_16457029 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_4680277135c30003da90117_59292926', 'page_title', $this->tplIndex);
?>

    <?php
}
}
/* {/block 'page_header_container'} */
/* {block 'page_content_top'} */
class Block_5924324935c30003dabe2a9_27465478 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'page_content_top'} */
/* {block 'page_content'} */
class Block_1293470435c30003dabeb86_95891049 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <!-- Page content -->
        <?php
}
}
/* {/block 'page_content'} */
/* {block 'page_content_container'} */
class Block_9916930265c30003dabdb65_85034225 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <section id="content" class="page-content card card-block">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_5924324935c30003dabe2a9_27465478', 'page_content_top', $this->tplIndex);
?>

        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1293470435c30003dabeb86_95891049', 'page_content', $this->tplIndex);
?>

      </section>
    <?php
}
}
/* {/block 'page_content_container'} */
/* {block 'page_footer'} */
class Block_11321652095c30003dabfed4_14046397 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <!-- Footer content -->
        <?php
}
}
/* {/block 'page_footer'} */
/* {block 'page_footer_container'} */
class Block_18213040675c30003dabf8a6_38746344 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <footer class="page-footer">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_11321652095c30003dabfed4_14046397', 'page_footer', $this->tplIndex);
?>

      </footer>
    <?php
}
}
/* {/block 'page_footer_container'} */
/* {block 'content'} */
class Block_12450928715c30003da8f093_80919971 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_12450928715c30003da8f093_80919971',
  ),
  'page_header_container' => 
  array (
    0 => 'Block_6006674015c30003da8f7d2_16457029',
  ),
  'page_title' => 
  array (
    0 => 'Block_4680277135c30003da90117_59292926',
  ),
  'page_content_container' => 
  array (
    0 => 'Block_9916930265c30003dabdb65_85034225',
  ),
  'page_content_top' => 
  array (
    0 => 'Block_5924324935c30003dabe2a9_27465478',
  ),
  'page_content' => 
  array (
    0 => 'Block_1293470435c30003dabeb86_95891049',
  ),
  'page_footer_container' => 
  array (
    0 => 'Block_18213040675c30003dabf8a6_38746344',
  ),
  'page_footer' => 
  array (
    0 => 'Block_11321652095c30003dabfed4_14046397',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


  <section id="main">

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_6006674015c30003da8f7d2_16457029', 'page_header_container', $this->tplIndex);
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_9916930265c30003dabdb65_85034225', 'page_content_container', $this->tplIndex);
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_18213040675c30003dabf8a6_38746344', 'page_footer_container', $this->tplIndex);
?>


  </section>

<?php
}
}
/* {/block 'content'} */
}
