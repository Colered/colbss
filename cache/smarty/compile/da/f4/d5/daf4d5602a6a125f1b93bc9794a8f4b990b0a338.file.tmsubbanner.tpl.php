<?php /* Smarty version Smarty-3.1.14, created on 2014-09-29 19:15:59
         compiled from "D:\xampp\htdocs\bookstore\modules\tmsubbanner\tmsubbanner.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1369854296297df0da5-42963699%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'daf4d5602a6a125f1b93bc9794a8f4b990b0a338' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\modules\\tmsubbanner\\tmsubbanner.tpl',
      1 => 1411996790,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1369854296297df0da5-42963699',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'page_name' => 0,
    'tmsubbanner_slides' => 0,
    'slide' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_54296297e46ed7_97679944',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54296297e46ed7_97679944')) {function content_54296297e46ed7_97679944($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['page_name']->value=='index'){?>  
<?php if (isset($_smarty_tpl->tpl_vars['tmsubbanner_slides']->value)){?>
<div id="tm_subbanner">
	<div class="tm_subbennerinner">
	<ul>
	<?php  $_smarty_tpl->tpl_vars['slide'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['slide']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tmsubbanner_slides']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['slide']->key => $_smarty_tpl->tpl_vars['slide']->value){
$_smarty_tpl->tpl_vars['slide']->_loop = true;
?>
	<?php if ($_smarty_tpl->tpl_vars['slide']->value['active']){?>
		<li>
			<a href="<?php echo $_smarty_tpl->tpl_vars['slide']->value['url'];?>
" target="_blank">
				<img src="<?php echo @constant('_MODULE_DIR_');?>
/tmsubbanner/images/<?php echo $_smarty_tpl->tpl_vars['slide']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['slide']->value['title'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['slide']->value['title'];?>
" />
			</a>
		</li>
	<?php }?>
	<?php } ?>
	</ul>
	</div>
</div>
<?php }?>
<?php }?><?php }} ?>