<?php /* Smarty version Smarty-3.1.14, created on 2014-06-24 16:35:52
         compiled from "D:\xampp\htdocs\bookstore\backend\themes\default\template\helpers\list\list_action_view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1692953a95b90ab2f90-09451644%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8de96dc77886032d6aa41ce28651e7f64bbec0ef' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\backend\\themes\\default\\template\\helpers\\list\\list_action_view.tpl',
      1 => 1390191860,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1692953a95b90ab2f90-09451644',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53a95b90ad9f41_90922481',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53a95b90ad9f41_90922481')) {function content_53a95b90ad9f41_90922481($_smarty_tpl) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" >
	<img src="../img/admin/details.gif" alt="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" />
</a><?php }} ?>