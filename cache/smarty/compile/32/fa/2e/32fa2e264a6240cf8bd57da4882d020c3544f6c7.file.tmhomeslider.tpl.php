<?php /* Smarty version Smarty-3.1.14, created on 2014-07-28 11:20:33
         compiled from "D:\xampp\htdocs\bookstore\modules\tmhomeslider\tmhomeslider.tpl" */ ?>
<?php /*%%SmartyHeaderCode:363953d5e4a9a92ee6-56188869%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '32fa2e264a6240cf8bd57da4882d020c3544f6c7' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\modules\\tmhomeslider\\tmhomeslider.tpl',
      1 => 1385402012,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '363953d5e4a9a92ee6-56188869',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'page_name' => 0,
    'tmhomeslider_slides' => 0,
    'slide' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53d5e4a9ad93e4_06290212',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53d5e4a9ad93e4_06290212')) {function content_53d5e4a9ad93e4_06290212($_smarty_tpl) {?><!-- ===================== Homepage Slider Module ============ -->
<?php if ($_smarty_tpl->tpl_vars['page_name']->value=='index'){?> 
<?php if (isset($_smarty_tpl->tpl_vars['tmhomeslider_slides']->value)){?>
<div class="flexslider">
	<ul class="slides">
	<?php  $_smarty_tpl->tpl_vars['slide'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['slide']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tmhomeslider_slides']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['slide']->key => $_smarty_tpl->tpl_vars['slide']->value){
$_smarty_tpl->tpl_vars['slide']->_loop = true;
?>
	<?php if ($_smarty_tpl->tpl_vars['slide']->value['active']){?>
		<li>
			<a href="<?php echo $_smarty_tpl->tpl_vars['slide']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['slide']->value['title'];?>
">
				<img src="<?php echo @constant('_MODULE_DIR_');?>
/tmhomeslider/images/<?php echo $_smarty_tpl->tpl_vars['slide']->value['image'];?>
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
<?php }?><?php }} ?>