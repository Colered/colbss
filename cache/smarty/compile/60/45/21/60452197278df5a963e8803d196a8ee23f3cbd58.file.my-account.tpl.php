<?php /* Smarty version Smarty-3.1.14, created on 2014-07-08 17:52:30
         compiled from "D:\xampp\htdocs\bookstore\modules\referralprogram\views\templates\hook\my-account.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3064853bbe286ad8b01-88703269%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '60452197278df5a963e8803d196a8ee23f3cbd58' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\modules\\referralprogram\\views\\templates\\hook\\my-account.tpl',
      1 => 1390191862,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3064853bbe286ad8b01-88703269',
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
  'unifunc' => 'content_53bbe286b49f84_61506783',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53bbe286b49f84_61506783')) {function content_53bbe286b49f84_61506783($_smarty_tpl) {?>

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