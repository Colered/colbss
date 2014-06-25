<?php /* Smarty version Smarty-3.1.14, created on 2014-06-24 16:42:25
         compiled from "D:\xampp\htdocs\bookstore\modules\bankpopular\views\templates\hook\infos.tpl" */ ?>
<?php /*%%SmartyHeaderCode:992053a93dcf39dfb6-29425785%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5fe000d504f2a739f656270e82f93627ee946027' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\modules\\bankpopular\\views\\templates\\hook\\infos.tpl',
      1 => 1403608121,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '992053a93dcf39dfb6-29425785',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53a93dcf43a3b8_71098570',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53a93dcf43a3b8_71098570')) {function content_53a93dcf43a3b8_71098570($_smarty_tpl) {?>

<div class="alert alert-info">
<img src="../modules/bankpopular/bankpopular.jpg" style="float:left; margin-right:15px;" width="86" height="49">
<p><strong><?php echo smartyTranslate(array('s'=>"This module allows you to accept payments by bank popular.",'mod'=>'bankpopular'),$_smarty_tpl);?>
</strong></p>
<p><?php echo smartyTranslate(array('s'=>"If the client chooses this payment method, the order status will change to 'Waiting for payment.'",'mod'=>'bankpopular'),$_smarty_tpl);?>
</p>
<p><?php echo smartyTranslate(array('s'=>"You will need to manually confirm the order as soon as you receive payment.",'mod'=>'bankpopular'),$_smarty_tpl);?>
</p>
</div>
<?php }} ?>