<?php /* Smarty version Smarty-3.1.14, created on 2014-07-18 18:18:37
         compiled from "D:\xampp\htdocs\bookstore\modules\referralprogram\views\templates\hook\authentication.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1651353c917a5131f10-33877903%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3f040dcc80ebe2b7f961dbae3de04d253c6c4e52' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\modules\\referralprogram\\views\\templates\\hook\\authentication.tpl',
      1 => 1390191862,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1651353c917a5131f10-33877903',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53c917a5160cf2_61815007',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53c917a5160cf2_61815007')) {function content_53c917a5160cf2_61815007($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'D:\\xampp\\htdocs\\bookstore\\tools\\smarty\\plugins\\modifier.escape.php';
?>

<!-- MODULE ReferralProgram -->
<fieldset class="account_creation">
	<h3><?php echo smartyTranslate(array('s'=>'Referral program','mod'=>'referralprogram'),$_smarty_tpl);?>
</h3>
	<p class="text">
		<label for="referralprogram"><?php echo smartyTranslate(array('s'=>'E-mail address of your sponsor','mod'=>'referralprogram'),$_smarty_tpl);?>
</label>
		<input type="text" size="52" maxlength="128" id="referralprogram" name="referralprogram" value="<?php if (isset($_POST['referralprogram'])){?><?php echo smarty_modifier_escape($_POST['referralprogram'], 'htmlall', 'UTF-8');?>
<?php }?>" />
	</p>
</fieldset>
<!-- END : MODULE ReferralProgram --><?php }} ?>