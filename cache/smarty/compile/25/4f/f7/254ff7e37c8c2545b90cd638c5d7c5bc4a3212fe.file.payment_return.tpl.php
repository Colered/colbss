<?php /* Smarty version Smarty-3.1.14, created on 2014-07-10 12:46:00
         compiled from "D:\xampp\htdocs\bookstore\modules\bankpopular\views\templates\hook\payment_return.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1286653be3db0d6c935-43540350%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '254ff7e37c8c2545b90cd638c5d7c5bc4a3212fe' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\modules\\bankpopular\\views\\templates\\hook\\payment_return.tpl',
      1 => 1403690538,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1286653be3db0d6c935-43540350',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'status' => 0,
    'shop_name' => 0,
    'reference' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53be3db0de1c23_78371888',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53be3db0de1c23_78371888')) {function content_53be3db0de1c23_78371888($_smarty_tpl) {?>

<?php if ($_smarty_tpl->tpl_vars['status']->value=='ok'){?>
	<p><?php echo smartyTranslate(array('s'=>'Your order on %s is complete.','sprintf'=>$_smarty_tpl->tpl_vars['shop_name']->value,'mod'=>'bankpopular'),$_smarty_tpl);?>

		<br /><br /><?php echo smartyTranslate(array('s'=>'Your order reference is <b>%s</b>.','sprintf'=>$_smarty_tpl->tpl_vars['reference']->value,'mod'=>'bankpopular'),$_smarty_tpl);?>

		<br /><br /><?php echo smartyTranslate(array('s'=>'An email has been sent to you with this information.','mod'=>'bankpopular'),$_smarty_tpl);?>

		<br /><br /><strong><?php echo smartyTranslate(array('s'=>'Your order will be sent as soon as we receive your payment.','mod'=>'bankpopular'),$_smarty_tpl);?>
</strong>
		<br /><br /><?php echo smartyTranslate(array('s'=>'For any questions or for further information, please contact our','mod'=>'bankpopular'),$_smarty_tpl);?>
 <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('contact',true), ENT_QUOTES, 'UTF-8', true);?>
"><?php echo smartyTranslate(array('s'=>'customer service department.','mod'=>'bankpopular'),$_smarty_tpl);?>
</a>.
	</p>
<?php }else{ ?>
	<p class="warning">
		<?php echo smartyTranslate(array('s'=>'We have noticed that there is a problem with your order. If you think this is an error, you can contact our','mod'=>'bankpopular'),$_smarty_tpl);?>
 
		<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('contact',true), ENT_QUOTES, 'UTF-8', true);?>
"><?php echo smartyTranslate(array('s'=>'customer service department.','mod'=>'bankpopular'),$_smarty_tpl);?>
</a>.
	</p>
<?php }?>
<?php }} ?>