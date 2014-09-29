<?php /* Smarty version Smarty-3.1.14, created on 2014-09-29 19:21:04
         compiled from "D:\xampp\htdocs\bookstore\modules\blockadvertising\blockadvertising.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16510542963c8ed31a0-82026238%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cbd9ee2ee1e0926e0ab91d221940d9d45bafdcfc' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\modules\\blockadvertising\\blockadvertising.tpl',
      1 => 1411996837,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16510542963c8ed31a0-82026238',
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
  'unifunc' => 'content_542963c8efa307_48431872',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_542963c8efa307_48431872')) {function content_542963c8efa307_48431872($_smarty_tpl) {?>

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