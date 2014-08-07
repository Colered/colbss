<?php /* Smarty version Smarty-3.1.14, created on 2014-08-07 17:07:27
         compiled from "D:\xampp\htdocs\bookstore\themes\PRS020046\modules\blockcurrencies\blockcurrencies.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1256353e364f7106cc7-12321012%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ebd6bb5fdd4e4853941adbda29e33dea6e536328' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\themes\\PRS020046\\modules\\blockcurrencies\\blockcurrencies.tpl',
      1 => 1407408811,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1256353e364f7106cc7-12321012',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'request_uri' => 0,
    'blockcurrencies_sign' => 0,
    'currencies' => 0,
    'cookie' => 0,
    'f_currency' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53e364f7170525_27374069',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53e364f7170525_27374069')) {function content_53e364f7170525_27374069($_smarty_tpl) {?>

<!-- Block currencies module -->
<div id="currencies_block_top">
	<form id="setCurrency" action="<?php echo $_smarty_tpl->tpl_vars['request_uri']->value;?>
" method="post">
		<p>
			<input type="hidden" name="id_currency" id="id_currency" value=""/>
			<input type="hidden" name="SubmitCurrency" value="" />
			<!--<?php echo smartyTranslate(array('s'=>'Currency','mod'=>'blockcurrencies'),$_smarty_tpl);?>
 : <?php echo $_smarty_tpl->tpl_vars['blockcurrencies_sign']->value;?>
-->
			<?php echo $_smarty_tpl->tpl_vars['blockcurrencies_sign']->value;?>

			<span class="top_downarrow">&nbsp;</span>
		</p>
		<ul id="first-currencies" class="currencies_ul">
			<?php  $_smarty_tpl->tpl_vars['f_currency'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['f_currency']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['currencies']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['f_currency']->key => $_smarty_tpl->tpl_vars['f_currency']->value){
$_smarty_tpl->tpl_vars['f_currency']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['f_currency']->key;
?>
				<li <?php if ($_smarty_tpl->tpl_vars['cookie']->value->id_currency==$_smarty_tpl->tpl_vars['f_currency']->value['id_currency']){?>class="selected"<?php }?>>
					<a href="javascript:setCurrency(<?php echo $_smarty_tpl->tpl_vars['f_currency']->value['id_currency'];?>
);" title="<?php echo $_smarty_tpl->tpl_vars['f_currency']->value['name'];?>
" rel="nofollow"><?php echo $_smarty_tpl->tpl_vars['f_currency']->value['name'];?>
-<?php echo $_smarty_tpl->tpl_vars['f_currency']->value['sign'];?>
</a>
				</li>
			<?php } ?>
		</ul>
	</form>
</div>
<script type="text/javascript">
// Megnor Start
	var cur_block = new HoverWatcher('#currencies_block_top');
	var currencies_ul = new HoverWatcher('.currencies_ul');
	$("#currencies_block_top").click(function() {
		$("#currencies_block_top").addClass('active');
		$(".currencies_ul").slideToggle('slow');
		setTimeout(function() {
			if (!cur_block.isHoveringOver() && !currencies_ul.isHoveringOver())
				$(".currencies_ul").stop(true, true).slideUp(450);
				$("#currencies_block_top").removeClass('active');
		}, 4000);
	});
	
	$(".currencies_ul").hover(function() {
		setTimeout(function() {
			if (!cur_block.isHoveringOver() && !currencies_ul.isHoveringOver())
				$(".currencies_ul").stop(true, true).slideUp(450);
		}, 4000);
	});
// Megnor End	
</script>
<!-- /Block currencies module -->
<?php }} ?>