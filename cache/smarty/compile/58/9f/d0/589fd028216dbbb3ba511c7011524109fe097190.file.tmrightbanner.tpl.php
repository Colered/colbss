<?php /* Smarty version Smarty-3.1.14, created on 2014-08-07 16:21:18
         compiled from "D:\xampp\htdocs\bookstore\modules\tmrightbanner\tmrightbanner.tpl" */ ?>
<?php /*%%SmartyHeaderCode:318553e35a2604c785-56208738%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '589fd028216dbbb3ba511c7011524109fe097190' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\modules\\tmrightbanner\\tmrightbanner.tpl',
      1 => 1407408592,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '318553e35a2604c785-56208738',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tmrightbanner_slides' => 0,
    'slide' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53e35a260b2081_16888871',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53e35a260b2081_16888871')) {function content_53e35a260b2081_16888871($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['tmrightbanner_slides']->value)){?>
<div id="tm_rightbanner">
	<ul>
	<?php $_smarty_tpl->tpl_vars['ItemsPerLine'] = new Smarty_variable(1, null, 0);?>
	<?php  $_smarty_tpl->tpl_vars['slide'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['slide']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tmrightbanner_slides']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['slide']->key => $_smarty_tpl->tpl_vars['slide']->value){
$_smarty_tpl->tpl_vars['slide']->_loop = true;
?>
	<?php if ($_smarty_tpl->tpl_vars['slide']->value['active']){?>
		<li>
			<a href="<?php echo $_smarty_tpl->tpl_vars['slide']->value['url'];?>
" target="_blank">
				<img src="<?php echo @constant('_MODULE_DIR_');?>
/tmrightbanner/images/<?php echo $_smarty_tpl->tpl_vars['slide']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['slide']->value['title'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['slide']->value['title'];?>
" />
			</a>
		</li>
	<?php }?>
	<?php } ?>
	</ul>
</div>
<?php }?>
<?php }} ?>