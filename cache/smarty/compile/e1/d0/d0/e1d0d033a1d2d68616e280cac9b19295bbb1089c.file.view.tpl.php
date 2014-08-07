<?php /* Smarty version Smarty-3.1.14, created on 2014-08-05 17:07:03
         compiled from "D:\xampp\htdocs\bookstore\modules\isbn\views\templates\admin\isbn\helpers\view\view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3054753e0c1df28afe2-42078822%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e1d0d033a1d2d68616e280cac9b19295bbb1089c' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\modules\\isbn\\views\\templates\\admin\\isbn\\helpers\\view\\view.tpl',
      1 => 1395653072,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3054753e0c1df28afe2-42078822',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'toolbar_btn' => 0,
    'toolbar_scroll' => 0,
    'title' => 0,
    'catData' => 0,
    'row' => 0,
    'categoriesArr' => 0,
    'isbn_values' => 0,
    'base_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53e0c1df421493_25476058',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53e0c1df421493_25476058')) {function content_53e0c1df421493_25476058($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("toolbar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('toolbar_btn'=>$_smarty_tpl->tpl_vars['toolbar_btn']->value,'toolbar_scroll'=>$_smarty_tpl->tpl_vars['toolbar_scroll']->value,'title'=>$_smarty_tpl->tpl_vars['title']->value), 0);?>

<form id="isbn_data" method="post" action="index.php?controller=AdminIsbn&amp;token=<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getAdminToken'][0][0]->getAdminTokenLiteSmarty(array('tab'=>'AdminIsbn'),$_smarty_tpl);?>
" enctype="multipart/form-data">
  <fieldset id="fieldset_main_conf">
    <legend>
      <img alt="Edit carrier" src="../img/t/AdminPreferences.gif">  <?php echo smartyTranslate(array('s'=>'Add ISBN'),$_smarty_tpl);?>
</legend>
     <div class="margin-form">
		<div style="float:left;"><label for="category_block">Associated categories:</label></div>
		<div style="float:left;">
			  <?php if (isset($_smarty_tpl->tpl_vars['catData']->value)){?>
				  <ul>
				  <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['catData']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
					<li id="<?php echo $_smarty_tpl->tpl_vars['row']->value['id_category'];?>
"><input type="checkbox" name="categoryChk[]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['id_category'];?>
"  <?php if (in_array($_smarty_tpl->tpl_vars['row']->value['id_category'],$_smarty_tpl->tpl_vars['categoriesArr']->value)){?>CHECKED<?php }?>> <span class="category_label"><?php echo $_smarty_tpl->tpl_vars['row']->value['catName'];?>
</span> </li>
				  <?php } ?>
				  </ul> 
			  <?php }?>
		</div>	
		<div class="clear"></div>
    </div> 
      <div class="clear"></div>
    <div class="margin-form">
     <div style="float:left;"><p class="text"><label for="category_block">ISBN:</label></p></div>
		<div style="float:left;">
		<textarea id="isb_no" name="isb_no" style="width:500px;height:100px; resize: none;"><?php echo $_smarty_tpl->tpl_vars['isbn_values']->value;?>
</textarea>
		<br>
		<p style="display:block; position:relative; display:inline-block;" class="hint">
			<span>Fill the comma separated ISBN values(i.e. xxx44, xxx55).</span>
		</p>
		<p class="text"><b> OR </b></p>
		<p class="text">Browse the CSV file with ISBN and associated categories.
		    <br>
			<input type="file" name="csvUpload" id="csvUpload" />
			<br>
			<span style="color: #268CCD;"><a href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
isbnsample.csv" style="color: #268CCD;">Download the sample CSV file.</a></span>
		</p>
	 </div>	 
    </div>
    <div class="clear"></div>
    <div class="margin-form">
      <div style="float:left;"><label for="category_block">&nbsp;</label></div>
		<div style="float:left;"><br>
      		<input type="submit" class="button" name="isbn_data" value="<?php echo smartyTranslate(array('s'=>'Proceed'),$_smarty_tpl);?>
" id="isbn_data_btn">
      	</div>	 	
    </div>
  </fieldset>
</form>
<?php }} ?>