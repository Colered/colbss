<?php /* Smarty version Smarty-3.1.14, created on 2014-06-24 16:43:00
         compiled from "D:\xampp\htdocs\bookstore\modules\cheque\views\templates\hook\infos.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2141853a95d3c159cc3-20568151%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3e1131b228d027964bc720da96642bb7b1091492' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\modules\\cheque\\views\\templates\\hook\\infos.tpl',
      1 => 1403253996,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2141853a95d3c159cc3-20568151',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53a95d3c243fc7_42008718',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53a95d3c243fc7_42008718')) {function content_53a95d3c243fc7_42008718($_smarty_tpl) {?>

<div class="alert alert-info">
<img src="../modules/cheque/cheque.jpg" style="float:left; margin-right:15px;" width="86" height="49">
<p><strong><?php echo smartyTranslate(array('s'=>"This module allows you to accept payments by check.",'mod'=>'cheque'),$_smarty_tpl);?>
</strong></p>
<p><?php echo smartyTranslate(array('s'=>"If the client chooses this payment method, the order status will change to 'Waiting for payment.'",'mod'=>'cheque'),$_smarty_tpl);?>
</p>
<p><?php echo smartyTranslate(array('s'=>"You will need to manually confirm the order as soon as you receive a check.",'mod'=>'cheque'),$_smarty_tpl);?>
</p>
</div>
<?php }} ?>