<?php /* Smarty version Smarty-3.1.14, created on 2014-08-04 15:44:50
         compiled from "D:\xampp\htdocs\bookstore\themes\default\category-count.tpl" */ ?>
<?php /*%%SmartyHeaderCode:362153df5d1a8b21f7-53642877%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cb1a26150bf4412404a2b511cdb9db0fb41bc7eb' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\themes\\default\\category-count.tpl',
      1 => 1390191862,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '362153df5d1a8b21f7-53642877',
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
  'unifunc' => 'content_53df5d1a8d9309_00185310',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53df5d1a8d9309_00185310')) {function content_53df5d1a8d9309_00185310($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['category']->value->id==1||$_smarty_tpl->tpl_vars['nb_products']->value==0){?>
	<?php echo smartyTranslate(array('s'=>'There are no products in  this category'),$_smarty_tpl);?>

<?php }else{ ?>
	<?php if ($_smarty_tpl->tpl_vars['nb_products']->value==1){?>
		<?php echo smartyTranslate(array('s'=>'There is %d product.','sprintf'=>$_smarty_tpl->tpl_vars['nb_products']->value),$_smarty_tpl);?>

	<?php }else{ ?>
		<?php echo smartyTranslate(array('s'=>'There are %d products.','sprintf'=>$_smarty_tpl->tpl_vars['nb_products']->value),$_smarty_tpl);?>

	<?php }?>
<?php }?><?php }} ?>