<?php /* Smarty version Smarty-3.1.14, created on 2014-07-10 12:46:01
         compiled from "D:\xampp\htdocs\bookstore\themes\PRS020046\breadcrumb.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2783653be3db16b5c85-49161959%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2942c887ecc9aac619a0419eb657a1966a26fdb3' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\themes\\PRS020046\\breadcrumb.tpl',
      1 => 1379760744,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2783653be3db16b5c85-49161959',
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
  'unifunc' => 'content_53be3db1752077_15824560',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53be3db1752077_15824560')) {function content_53be3db1752077_15824560($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'D:\\xampp\\htdocs\\bookstore\\tools\\smarty\\plugins\\modifier.escape.php';
?>

<!-- Breadcrumb -->
<?php if (isset(Smarty::$_smarty_vars['capture']['path'])){?><?php $_smarty_tpl->tpl_vars['path'] = new Smarty_variable(Smarty::$_smarty_vars['capture']['path'], null, 0);?><?php }?>
<div class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#" id="brd-crumbs">
	<a property="v:title" rel="v:url" href="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
" title="<?php echo smartyTranslate(array('s'=>'Return to Home'),$_smarty_tpl);?>
">
		<!--<img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
icon/home.gif" height="26" width="26" alt="<?php echo smartyTranslate(array('s'=>'Home'),$_smarty_tpl);?>
" />-->
		<?php echo smartyTranslate(array('s'=>'Home'),$_smarty_tpl);?>

	</a>
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