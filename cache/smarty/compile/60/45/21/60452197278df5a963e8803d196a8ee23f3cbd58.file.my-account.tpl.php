<?php /* Smarty version Smarty-3.1.14, created on 2014-09-29 14:56:31
         compiled from "D:\xampp\htdocs\bookstore\modules\referralprogram\views\templates\hook\my-account.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7233542925c724bd86-46139752%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '60452197278df5a963e8803d196a8ee23f3cbd58' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\modules\\referralprogram\\views\\templates\\hook\\my-account.tpl',
      1 => 1407408178,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7233542925c724bd86-46139752',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'module_template_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_542925c7272e80_08896110',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_542925c7272e80_08896110')) {function content_542925c7272e80_08896110($_smarty_tpl) {?>

<!-- MODULE ReferralProgram -->
<li class="referralprogram">
	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getModuleLink('referralprogram','program',array(),true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Referral program','mod'=>'referralprogram'),$_smarty_tpl);?>
" rel="nofollow">
		<img src="<?php echo $_smarty_tpl->tpl_vars['module_template_dir']->value;?>
referralprogram.gif" alt="<?php echo smartyTranslate(array('s'=>'Referral program','mod'=>'referralprogram'),$_smarty_tpl);?>
" class="icon" /> 
			<?php echo smartyTranslate(array('s'=>'Referral program','mod'=>'referralprogram'),$_smarty_tpl);?>

	</a>
</li>
<!-- END : MODULE ReferralProgram --><?php }} ?>