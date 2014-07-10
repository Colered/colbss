<?php /* Smarty version Smarty-3.1.14, created on 2014-07-10 12:35:58
         compiled from "D:\xampp\htdocs\bookstore\modules\bankpopular\views\templates\hook\payment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3177853be3b5619ad84-89199735%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a4a9c9a5df31d4f12d1066dbb96df9d480b4a7a0' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\modules\\bankpopular\\views\\templates\\hook\\payment.tpl',
      1 => 1403605233,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3177853be3b5619ad84-89199735',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'this_path_bankpopular' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53be3b561cda09_55679747',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53be3b561cda09_55679747')) {function content_53be3b561cda09_55679747($_smarty_tpl) {?>

<p class="payment_module">
	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getModuleLink('bankpopular','payment',array(),true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Pay by bank popular.','mod'=>'bankpopular'),$_smarty_tpl);?>
">
		<img src="<?php echo $_smarty_tpl->tpl_vars['this_path_bankpopular']->value;?>
bankpopular.jpg" alt="<?php echo smartyTranslate(array('s'=>'Pay by bank popular.','mod'=>'bankpopular'),$_smarty_tpl);?>
" width="100" height="50" />
		<?php echo smartyTranslate(array('s'=>'Pay by bank popular','mod'=>'bankpopular'),$_smarty_tpl);?>

	</a>
</p>
<?php }} ?>