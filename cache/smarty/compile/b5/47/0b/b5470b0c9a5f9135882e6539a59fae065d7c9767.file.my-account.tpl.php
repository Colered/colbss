<?php /* Smarty version Smarty-3.1.14, created on 2014-06-25 15:21:24
         compiled from "D:\xampp\htdocs\bookstore\modules\mailalerts\views\templates\hook\my-account.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2263553aa9b9c0a3236-29278694%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b5470b0c9a5f9135882e6539a59fae065d7c9767' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\modules\\mailalerts\\views\\templates\\hook\\my-account.tpl',
      1 => 1390191862,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2263553aa9b9c0a3236-29278694',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'module_template_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53aa9b9c0ca327_82545467',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53aa9b9c0ca327_82545467')) {function content_53aa9b9c0ca327_82545467($_smarty_tpl) {?>

<li class="mailalerts">
	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getModuleLink('mailalerts','account'), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'My alerts','mod'=>'mailalerts'),$_smarty_tpl);?>
" rel="nofollow">
		<img src="<?php echo $_smarty_tpl->tpl_vars['module_template_dir']->value;?>
img/icon-alert.png" class="icon" />
		<?php echo smartyTranslate(array('s'=>'My alerts','mod'=>'mailalerts'),$_smarty_tpl);?>

	</a>
</li>
<?php }} ?>