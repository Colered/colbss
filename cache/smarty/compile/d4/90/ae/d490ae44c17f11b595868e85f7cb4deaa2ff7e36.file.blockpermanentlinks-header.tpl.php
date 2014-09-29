<?php /* Smarty version Smarty-3.1.14, created on 2014-08-20 15:53:11
         compiled from "D:\xampp\htdocs\bookstore\themes\thgr00027o\modules\blockpermanentlinks\blockpermanentlinks-header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:276753f4770f5700c2-62871402%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd490ae44c17f11b595868e85f7cb4deaa2ff7e36' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\themes\\thgr00027o\\modules\\blockpermanentlinks\\blockpermanentlinks-header.tpl',
      1 => 1407408749,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '276753f4770f5700c2-62871402',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'come_from' => 0,
    'meta_title' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53f4771060c4c8_91951128',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53f4771060c4c8_91951128')) {function content_53f4771060c4c8_91951128($_smarty_tpl) {?>

<!-- Block permanent links module HEADER -->
<ul id="header_links">
	<li id="header_link_contact"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('contact',true);?>
" title="<?php echo smartyTranslate(array('s'=>'Contact','mod'=>'blockpermanentlinks'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Contact','mod'=>'blockpermanentlinks'),$_smarty_tpl);?>
</a></li>
	<li id="header_link_sitemap"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('sitemap');?>
" title="<?php echo smartyTranslate(array('s'=>'Sitemap','mod'=>'blockpermanentlinks'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Sitemap','mod'=>'blockpermanentlinks'),$_smarty_tpl);?>
</a></li>
	<li id="header_link_bookmark">
		<script type="text/javascript">writeBookmarkLink('<?php echo $_smarty_tpl->tpl_vars['come_from']->value;?>
', '<?php echo addslashes(addslashes($_smarty_tpl->tpl_vars['meta_title']->value));?>
', '<?php echo smartyTranslate(array('s'=>'Bookmark','mod'=>'blockpermanentlinks'),$_smarty_tpl);?>
');</script>
	<li class="header_link_myaccount"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true);?>
" title="<?php echo smartyTranslate(array('s'=>'My account','mod'=>'blockpermanentlinks'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'My account','mod'=>'blockpermanentlinks'),$_smarty_tpl);?>
</a></li>
	<li class="header_link_createanaccount"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true);?>
" title="<?php echo smartyTranslate(array('s'=>'Create an account','mod'=>'blockpermanentlinks'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Create an account','mod'=>'blockpermanentlinks'),$_smarty_tpl);?>
</a></li>
</ul>
<!-- /Block permanent links module HEADER -->
<?php }} ?>