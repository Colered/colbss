<?php /* Smarty version Smarty-3.1.14, created on 2014-06-30 11:46:54
         compiled from "D:\xampp\htdocs\bookstore\backend\themes\default\template\helpers\list\list_action_duplicate.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2511053b100d6ee2ba7-82679532%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2ab64f6c08083da4c540c3872e9828c35b9fe792' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\backend\\themes\\default\\template\\helpers\\list\\list_action_duplicate.tpl',
      1 => 1390191860,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2511053b100d6ee2ba7-82679532',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'action' => 0,
    'confirm' => 0,
    'location_ok' => 0,
    'location_ko' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53b100d6f30da2_91622181',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53b100d6f30da2_91622181')) {function content_53b100d6f30da2_91622181($_smarty_tpl) {?>
<a class="pointer" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" onclick="if (confirm('<?php echo $_smarty_tpl->tpl_vars['confirm']->value;?>
')) document.location = '<?php echo $_smarty_tpl->tpl_vars['location_ok']->value;?>
'; else document.location = '<?php echo $_smarty_tpl->tpl_vars['location_ko']->value;?>
';">
	<img src="../img/admin/duplicate.png" alt="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" />
</a><?php }} ?>