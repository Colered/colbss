<?php /* Smarty version Smarty-3.1.14, created on 2014-06-25 16:17:09
         compiled from "D:\xampp\htdocs\bookstore\modules\blockadvertising\blockadvertising.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2277853aaa8ad4cd976-06809474%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cbd9ee2ee1e0926e0ab91d221940d9d45bafdcfc' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\modules\\blockadvertising\\blockadvertising.tpl',
      1 => 1390191860,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2277853aaa8ad4cd976-06809474',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'adv_link' => 0,
    'adv_title' => 0,
    'image' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53aaa8ad4f4ac7_54140697',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53aaa8ad4f4ac7_54140697')) {function content_53aaa8ad4f4ac7_54140697($_smarty_tpl) {?>

<!-- MODULE Block advertising -->
<div class="advertising_block">
	<a href="<?php echo $_smarty_tpl->tpl_vars['adv_link']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['adv_title']->value;?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['image']->value;?>
" alt="<?php echo $_smarty_tpl->tpl_vars['adv_title']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['adv_title']->value;?>
" width="155"  height="163" /></a>
</div>
<!-- /MODULE Block advertising -->
<?php }} ?>