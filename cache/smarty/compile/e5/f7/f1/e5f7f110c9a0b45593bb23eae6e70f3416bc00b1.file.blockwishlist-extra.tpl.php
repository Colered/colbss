<?php /* Smarty version Smarty-3.1.14, created on 2014-09-29 14:56:19
         compiled from "D:\xampp\htdocs\bookstore\modules\blockwishlist\blockwishlist-extra.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1878542925bb2d11f9-55437921%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e5f7f110c9a0b45593bb23eae6e70f3416bc00b1' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\modules\\blockwishlist\\blockwishlist-extra.tpl',
      1 => 1407407939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1878542925bb2d11f9-55437921',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'id_product' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_542925bb2f82e8_02399636',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_542925bb2f82e8_02399636')) {function content_542925bb2f82e8_02399636($_smarty_tpl) {?>

<p class="buttons_bottom_block">
	<a href="#" id="wishlist_button" onclick="WishlistCart('wishlist_block_list', 'add', '<?php echo intval($_smarty_tpl->tpl_vars['id_product']->value);?>
', $('#idCombination').val(), document.getElementById('quantity_wanted').value); return false;"  title="<?php echo smartyTranslate(array('s'=>'Add to my wishlist','mod'=>'blockwishlist'),$_smarty_tpl);?>
" rel="nofollow">&raquo; <?php echo smartyTranslate(array('s'=>'Add to my wishlist','mod'=>'blockwishlist'),$_smarty_tpl);?>
</a>
</p>
<?php }} ?>