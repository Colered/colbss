<?php /* Smarty version Smarty-3.1.14, created on 2014-08-01 17:43:48
         compiled from "D:\xampp\htdocs\bookstore\backend\themes\default\template\helpers\list\list_action_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1009553db847c735909-62170983%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c7b2570c8ee102aded8c891f4e8b2f85234ac242' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\backend\\themes\\default\\template\\helpers\\list\\list_action_edit.tpl',
      1 => 1390191860,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1009553db847c735909-62170983',
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
  'unifunc' => 'content_53db847c75ca00_41314849',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53db847c75ca00_41314849')) {function content_53db847c75ca00_41314849($_smarty_tpl) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" class="edit" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
">
	<img src="../img/admin/edit.gif" alt="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" />
</a><?php }} ?>