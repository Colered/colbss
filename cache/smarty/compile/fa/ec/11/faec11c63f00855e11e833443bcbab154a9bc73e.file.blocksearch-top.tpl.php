<?php /* Smarty version Smarty-3.1.14, created on 2014-07-10 12:45:58
         compiled from "D:\xampp\htdocs\bookstore\themes\PRS020046\modules\blocksearch\blocksearch-top.tpl" */ ?>
<?php /*%%SmartyHeaderCode:224753be3dae6b6042-57475927%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'faec11c63f00855e11e833443bcbab154a9bc73e' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\themes\\PRS020046\\modules\\blocksearch\\blocksearch-top.tpl',
      1 => 1385358750,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '224753be3dae6b6042-57475927',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'hook_mobile' => 0,
    'link' => 0,
    'ENT_QUOTES' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53be3dae779531_09822873',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53be3dae779531_09822873')) {function content_53be3dae779531_09822873($_smarty_tpl) {?>
<!-- block seach mobile -->
<?php if (isset($_smarty_tpl->tpl_vars['hook_mobile']->value)){?>
<div class="input_search" data-role="fieldcontain">
	<form method="get" action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('search'), ENT_QUOTES, 'UTF-8', true);?>
" id="searchbox">
		<input type="hidden" name="controller" value="search" />
		<input type="hidden" name="orderby" value="position" />
		<input type="hidden" name="orderway" value="desc" />
		<input class="search_query" type="search" id="search_query_top" name="search_query" placeholder="<?php echo smartyTranslate(array('s'=>'Search','mod'=>'blocksearch'),$_smarty_tpl);?>
" value="<?php if (isset($_GET['search_query'])){?><?php echo stripslashes(htmlentities($_GET['search_query'],$_smarty_tpl->tpl_vars['ENT_QUOTES']->value,'utf-8'));?>
<?php }?>" />
	</form>
</div>
<?php }else{ ?>
<!-- Block search module TOP -->
<div id="search_block_top">
	<form method="get" action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('search'), ENT_QUOTES, 'UTF-8', true);?>
" id="searchbox">
	<div class="left_img"></div>
		<p>
			<label for="search_query_top"><!-- image on background --></label>
			<input type="hidden" name="controller" value="search" />
			<input type="hidden" name="orderby" value="position" />
			<input type="hidden" name="orderway" value="desc" />
			<input class="search_query" type="text" id="search_query_top" name="search_query" value="<?php if (isset($_GET['search_query'])){?><?php echo stripslashes(htmlentities($_GET['search_query'],$_smarty_tpl->tpl_vars['ENT_QUOTES']->value,'utf-8'));?>
<?php }?>" />
			<input type="submit" name="submit_search" value="<?php echo smartyTranslate(array('s'=>'Search','mod'=>'blocksearch'),$_smarty_tpl);?>
" class="button" />
		</p>
		<div class="right_img"></div>
	</form>
</div>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['self']->value)."/blocksearch-instantsearch.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?>
<!-- /Block search module TOP -->
<?php }} ?>