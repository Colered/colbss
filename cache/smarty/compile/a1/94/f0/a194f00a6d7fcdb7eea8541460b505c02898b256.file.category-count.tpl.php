<?php /* Smarty version Smarty-3.1.14, created on 2014-06-19 12:35:27
         compiled from "D:\xampp\htdocs\bookstore\themes\PRS020046\category-count.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3075053a28bb75cec04-02520138%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a194f00a6d7fcdb7eea8541460b505c02898b256' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\themes\\PRS020046\\category-count.tpl',
      1 => 1380718408,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3075053a28bb75cec04-02520138',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'category' => 0,
    'nb_products' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53a28bb7643f10_88828383',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53a28bb7643f10_88828383')) {function content_53a28bb7643f10_88828383($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['category']->value->id==1||$_smarty_tpl->tpl_vars['nb_products']->value==0){?>
	<div class="resumecat category-product-count">
		<?php echo smartyTranslate(array('s'=>'There are no products in  this category'),$_smarty_tpl);?>

	</div>
<?php }else{ ?>
	<p class="item_count">
	<?php if ($_smarty_tpl->tpl_vars['nb_products']->value==1){?>
		<?php echo smartyTranslate(array('s'=>'There is %d product.','sprintf'=>$_smarty_tpl->tpl_vars['nb_products']->value),$_smarty_tpl);?>

	<?php }else{ ?>
		<?php echo smartyTranslate(array('s'=>'There are %d products.','sprintf'=>$_smarty_tpl->tpl_vars['nb_products']->value),$_smarty_tpl);?>

	<?php }?>
	</p>
<?php }?><?php }} ?>