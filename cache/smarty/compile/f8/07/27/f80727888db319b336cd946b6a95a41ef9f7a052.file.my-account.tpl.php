<?php /* Smarty version Smarty-3.1.14, created on 2014-06-25 15:21:24
         compiled from "D:\xampp\htdocs\bookstore\modules\blockwishlist\my-account.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2861653aa9b9c13f614-24615066%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f80727888db319b336cd946b6a95a41ef9f7a052' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\modules\\blockwishlist\\my-account.tpl',
      1 => 1390191860,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2861653aa9b9c13f614-24615066',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'wishlist_link' => 0,
    'module_template_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53aa9b9c166710_14862242',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53aa9b9c166710_14862242')) {function content_53aa9b9c166710_14862242($_smarty_tpl) {?>

<!-- MODULE WishList -->
<li class="lnk_wishlist">
	<a href="<?php echo $_smarty_tpl->tpl_vars['wishlist_link']->value;?>
" title="<?php echo smartyTranslate(array('s'=>'My wishlists','mod'=>'blockwishlist'),$_smarty_tpl);?>
">
		<img src="<?php echo $_smarty_tpl->tpl_vars['module_template_dir']->value;?>
img/gift.gif" alt="<?php echo smartyTranslate(array('s'=>'My wishlists','mod'=>'blockwishlist'),$_smarty_tpl);?>
" class="icon" />
		<?php echo smartyTranslate(array('s'=>'My wishlists','mod'=>'blockwishlist'),$_smarty_tpl);?>

	</a>
</li>
<!-- END : MODULE WishList --><?php }} ?>