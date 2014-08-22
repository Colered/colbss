<?php /* Smarty version Smarty-3.1.14, created on 2014-08-20 18:42:33
         compiled from "D:\xampp\htdocs\bookstore\modules\tmsubbanner\tmsubbanner.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2549453f49ec112d565-44245843%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'daf4d5602a6a125f1b93bc9794a8f4b990b0a338' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\modules\\tmsubbanner\\tmsubbanner.tpl',
      1 => 1407408342,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2549453f49ec112d565-44245843',
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
  'unifunc' => 'content_53f49ec1154668_39165188',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53f49ec1154668_39165188')) {function content_53f49ec1154668_39165188($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['page_name']->value=='index'){?>  
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