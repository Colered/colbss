<?php /* Smarty version Smarty-3.1.14, created on 2014-08-20 15:53:15
         compiled from "D:\xampp\htdocs\bookstore\themes\thgr00027o\breadcrumb.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1144653f477130cc8c5-79247784%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b5903fd6172c030f59fc0558452d1fd2110db6cd' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\themes\\thgr00027o\\breadcrumb.tpl',
      1 => 1407408712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1144653f477130cc8c5-79247784',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'base_dir' => 0,
    'img_dir' => 0,
    'path' => 0,
    'category' => 0,
    'navigationPipe' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53f477131803c0_03384370',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53f477131803c0_03384370')) {function content_53f477131803c0_03384370($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'D:\\xampp\\htdocs\\bookstore\\tools\\smarty\\plugins\\modifier.escape.php';
?>

<!-- Breadcrumb -->
<?php if (isset(Smarty::$_smarty_vars['capture']['path'])){?><?php $_smarty_tpl->tpl_vars['path'] = new Smarty_variable(Smarty::$_smarty_vars['capture']['path'], null, 0);?><?php }?>
<div class="breadcrumb">
	<a href="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
" title="<?php echo smartyTranslate(array('s'=>'return to Home'),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
icon/home.gif" height="26" width="26" alt="<?php echo smartyTranslate(array('s'=>'Home'),$_smarty_tpl);?>
" /></a>
	<?php if (isset($_smarty_tpl->tpl_vars['path']->value)&&$_smarty_tpl->tpl_vars['path']->value){?>
		<span class="navigation-pipe" <?php if (isset($_smarty_tpl->tpl_vars['category']->value)&&isset($_smarty_tpl->tpl_vars['category']->value->id_category)&&$_smarty_tpl->tpl_vars['category']->value->id_category==1){?>style="display:none;"<?php }?>><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['navigationPipe']->value, 'html', 'UTF-8');?>
</span>
		<?php if (!strpos($_smarty_tpl->tpl_vars['path']->value,'span')){?>
			<span class="navigation_page"><?php echo $_smarty_tpl->tpl_vars['path']->value;?>
</span>
		<?php }else{ ?>
			<?php echo $_smarty_tpl->tpl_vars['path']->value;?>

		<?php }?>
	<?php }?>
</div>
<!-- /Breadcrumb --><?php }} ?>