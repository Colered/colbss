<?php /* Smarty version Smarty-3.1.14, created on 2014-08-04 15:50:24
         compiled from "D:\xampp\htdocs\bookstore\themes\thgr00027o\category-count.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13653df5e68c883c6-23774403%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b461cfa922e83a73c62387ecc5c01015b28ede99' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\themes\\thgr00027o\\category-count.tpl',
      1 => 1355224136,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13653df5e68c883c6-23774403',
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
  'unifunc' => 'content_53df5e68ccaa61_27431946',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53df5e68ccaa61_27431946')) {function content_53df5e68ccaa61_27431946($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['category']->value->id==1||$_smarty_tpl->tpl_vars['nb_products']->value==0){?>
	<?php echo smartyTranslate(array('s'=>'There are no products.'),$_smarty_tpl);?>

<?php }else{ ?>
	<?php if ($_smarty_tpl->tpl_vars['nb_products']->value==1){?>
		<?php echo smartyTranslate(array('s'=>'There is %d product.','sprintf'=>$_smarty_tpl->tpl_vars['nb_products']->value),$_smarty_tpl);?>

	<?php }else{ ?>
		<?php echo smartyTranslate(array('s'=>'There are %d products.','sprintf'=>$_smarty_tpl->tpl_vars['nb_products']->value),$_smarty_tpl);?>

	<?php }?>
<?php }?><?php }} ?>