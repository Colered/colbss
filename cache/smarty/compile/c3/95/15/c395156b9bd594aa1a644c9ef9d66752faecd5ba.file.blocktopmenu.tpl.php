<?php /* Smarty version Smarty-3.1.14, created on 2014-09-11 11:03:55
         compiled from "C:\xampp\htdocs\bookstore\themes\PRS020046\modules\blocktopmenu\blocktopmenu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:28430541134439efe24-68792537%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c395156b9bd594aa1a644c9ef9d66752faecd5ba' => 
    array (
      0 => 'C:\\xampp\\htdocs\\bookstore\\themes\\PRS020046\\modules\\blocktopmenu\\blocktopmenu.tpl',
      1 => 1385189848,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '28430541134439efe24-68792537',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MENU' => 0,
    'MENU_SEARCH' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_54113443a84591_19941429',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54113443a84591_19941429')) {function content_54113443a84591_19941429($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'C:\\xampp\\htdocs\\bookstore\\tools\\smarty\\plugins\\modifier.escape.php';
?></div>
<?php if ($_smarty_tpl->tpl_vars['MENU']->value!=''){?>
	
	<!-- Menu -->
	<div class="sf-contener nav-container clearfix">
		<ul id="main_menu" class="sf-menu clearfix">
			<?php echo $_smarty_tpl->tpl_vars['MENU']->value;?>

			<?php if ($_smarty_tpl->tpl_vars['MENU_SEARCH']->value){?>
				<li class="sf-search noBack" style="float:right">
					<form id="searchbox" action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('search'), ENT_QUOTES, 'UTF-8', true);?>
" method="get">
						<p>
							<input type="hidden" name="controller" value="search" />
							<input type="hidden" value="position" name="orderby"/>
							<input type="hidden" value="desc" name="orderway"/>
							<input type="text" name="search_query" value="<?php if (isset($_GET['search_query'])){?><?php echo smarty_modifier_escape($_GET['search_query'], 'htmlall', 'UTF-8');?>
<?php }?>" />
						</p>
					</form>
				</li>
			<?php }?>
		</ul>
	</div>
	<div class="sf-right">&nbsp;</div>


	<script type="text/javascript">		
		$(document).ready(function(){
			$(".nav-button").click(function () {
			$(".primary-nav").toggleClass("open");
			$(this).parent().toggleClass('active').parent().find('.nav-button');
			});    
		});
	</script>

	<!-- Mobile Menu -->
	<div class="nav-container-mobile">
		<div class="nav-button main-but">
		<div class="tm_mobilemenu_text"><?php echo smartyTranslate(array('s'=>'Menu'),$_smarty_tpl);?>
</div>
		<div class="tm_mobilemenu_img">&nbsp;</div>
	</div>	
		<ul id="main_menu_mobile" class="primary-nav tree dhtml">
			<?php echo $_smarty_tpl->tpl_vars['MENU']->value;?>

		</ul>	
	</div>	
	<!--/ Menu -->
	<div class="header_bottom"></div>
<?php }?><?php }} ?>