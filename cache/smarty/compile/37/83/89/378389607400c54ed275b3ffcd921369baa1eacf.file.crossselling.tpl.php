<?php /* Smarty version Smarty-3.1.14, created on 2014-06-25 16:17:10
         compiled from "D:\xampp\htdocs\bookstore\themes\PRS020046\modules\crossselling\crossselling.tpl" */ ?>
<?php /*%%SmartyHeaderCode:341053aaa8ae20ff81-09188370%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '378389607400c54ed275b3ffcd921369baa1eacf' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\themes\\PRS020046\\modules\\crossselling\\crossselling.tpl',
      1 => 1383502252,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '341053aaa8ae20ff81-09188370',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'orderProducts' => 0,
    'middlePosition_crossselling' => 0,
    'productCount' => 0,
    'sliderFor' => 0,
    'orderProduct' => 0,
    'link' => 0,
    'crossDisplayPrice' => 0,
    'restricted_country_mode' => 0,
    'PS_CATALOG_MODE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53aaa8ae321890_44264895',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53aaa8ae321890_44264895')) {function content_53aaa8ae321890_44264895($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'D:\\xampp\\htdocs\\bookstore\\tools\\smarty\\plugins\\modifier.escape.php';
?>

<?php if (isset($_smarty_tpl->tpl_vars['orderProducts']->value)&&count($_smarty_tpl->tpl_vars['orderProducts']->value)){?>
<div id="crossselling" class="clearfix block products_block">
	<script type="text/javascript">var cs_middle = <?php echo $_smarty_tpl->tpl_vars['middlePosition_crossselling']->value;?>
;</script>
	<p class="productscategory_h2 title_block"><?php echo smartyTranslate(array('s'=>'Customers who bought this product also bought:','mod'=>'crossselling'),$_smarty_tpl);?>
</p>
	<div id="crossselling_productblock">
		<div id="crossselling_productlist">
		
			<!-- Megnor start -->
			<?php $_smarty_tpl->tpl_vars['sliderFor'] = new Smarty_variable(6, null, 0);?> <!-- Define Number of product for SLIDER -->
			<?php $_smarty_tpl->tpl_vars['productCount'] = new Smarty_variable(count($_smarty_tpl->tpl_vars['orderProducts']->value), null, 0);?>
			<?php if ($_smarty_tpl->tpl_vars['productCount']->value>=$_smarty_tpl->tpl_vars['sliderFor']->value){?>
			<div class="customNavigation">
				<a class="btn prev">&nbsp;</a>
				<a class="btn next">&nbsp;</a>
			</div>
			<?php }?>
			<!-- Megnor End -->
		
			<ul id="<?php if ($_smarty_tpl->tpl_vars['productCount']->value>=$_smarty_tpl->tpl_vars['sliderFor']->value){?>crossselling-carousel<?php }else{ ?>crossselling-grid<?php }?>" class="<?php if ($_smarty_tpl->tpl_vars['productCount']->value>=$_smarty_tpl->tpl_vars['sliderFor']->value){?>product-carousel<?php }else{ ?>product_list<?php }?> clearfix">
				<?php  $_smarty_tpl->tpl_vars['orderProduct'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['orderProduct']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['orderProducts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['orderProduct']->key => $_smarty_tpl->tpl_vars['orderProduct']->value){
$_smarty_tpl->tpl_vars['orderProduct']->_loop = true;
?>
				<li  class="<?php if ($_smarty_tpl->tpl_vars['productCount']->value>=$_smarty_tpl->tpl_vars['sliderFor']->value){?>slider-item<?php }?>">
<!-- Megnor Start -->
	<div class="product-block">
		<div class="product-inner">
<!-- Megnor End -->					
					<a href="<?php echo $_smarty_tpl->tpl_vars['orderProduct']->value['link'];?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['orderProduct']->value['name']);?>
" class="lnk_img"><img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['orderProduct']->value['link_rewrite'],$_smarty_tpl->tpl_vars['orderProduct']->value['id_image'],'home_default'), ENT_QUOTES, 'UTF-8', true);?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['orderProduct']->value['name']);?>
" /></a>
					<p class="product_name"><a href="<?php echo $_smarty_tpl->tpl_vars['orderProduct']->value['link'];?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['orderProduct']->value['name']);?>
"><?php echo smarty_modifier_escape($_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate($_smarty_tpl->tpl_vars['orderProduct']->value['name'],15,'...'), 'htmlall', 'UTF-8');?>
</a></p>
					<?php if ($_smarty_tpl->tpl_vars['crossDisplayPrice']->value&&$_smarty_tpl->tpl_vars['orderProduct']->value['show_price']==1&&!isset($_smarty_tpl->tpl_vars['restricted_country_mode']->value)&&!$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value){?>
						<span class="price_display">
							<span class="price"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['orderProduct']->value['displayed_price']),$_smarty_tpl);?>
</span>
						</span>
					<?php }else{ ?>
						
					<?php }?>
					<!-- <a title="<?php echo smartyTranslate(array('s'=>'View','mod'=>'crossselling'),$_smarty_tpl);?>
" href="<?php echo $_smarty_tpl->tpl_vars['orderProduct']->value['link'];?>
" class="button_small"><?php echo smartyTranslate(array('s'=>'View','mod'=>'crossselling'),$_smarty_tpl);?>
</a><br /> -->
<!-- Megnor Start -->
</div>
</div>
<!-- Megnor End -->						
				</li>
				<?php } ?>
			</ul>
		</div>

	</div>
</div>
<span class="cross_default_width" style="display:none; visibility:hidden"></span>
<?php }?>
<?php }} ?>