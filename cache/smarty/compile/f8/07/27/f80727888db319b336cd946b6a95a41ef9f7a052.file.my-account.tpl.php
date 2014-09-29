<?php /* Smarty version Smarty-3.1.14, created on 2014-09-29 14:56:31
         compiled from "D:\xampp\htdocs\bookstore\modules\blockwishlist\my-account.tpl" */ ?>
<?php /*%%SmartyHeaderCode:30504542925c71af990-40315647%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f80727888db319b336cd946b6a95a41ef9f7a052' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\modules\\blockwishlist\\my-account.tpl',
      1 => 1407407939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '30504542925c71af990-40315647',
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
  'unifunc' => 'content_542925c71d6a94_33999568',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_542925c71d6a94_33999568')) {function content_542925c71d6a94_33999568($_smarty_tpl) {?>

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