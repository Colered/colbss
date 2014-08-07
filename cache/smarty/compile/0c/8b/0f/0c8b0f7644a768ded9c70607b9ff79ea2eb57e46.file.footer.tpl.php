<?php /* Smarty version Smarty-3.1.14, created on 2014-08-04 15:50:26
         compiled from "D:\xampp\htdocs\bookstore\themes\thgr00027o\footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1135353df5e6a43bce0-08103920%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0c8b0f7644a768ded9c70607b9ff79ea2eb57e46' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\themes\\thgr00027o\\footer.tpl',
      1 => 1358667788,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1135353df5e6a43bce0-08103920',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content_only' => 0,
    'HOOK_RIGHT_COLUMN' => 0,
    'HOOK_FOOTER' => 0,
    'PS_ALLOW_MOBILE_DEVICE' => 0,
    'link' => 0,
    'img_dir' => 0,
    'base_dir' => 0,
    'shop_name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53df5e6a4a1612_02750774',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53df5e6a4a1612_02750774')) {function content_53df5e6a4a1612_02750774($_smarty_tpl) {?>

<?php if (!$_smarty_tpl->tpl_vars['content_only']->value){?>
				</div>

<!-- Right -->
				<div id="right_column" class="column grid_2 omega">
					<?php echo $_smarty_tpl->tpl_vars['HOOK_RIGHT_COLUMN']->value;?>

				</div>
			</div>
</div>
<!-- Footer -->

			<div id="footer" class="grid_9 alpha omega clearfix"><div class="footer_container">
			<?php echo $_smarty_tpl->tpl_vars['HOOK_FOOTER']->value;?>

				<?php if ($_smarty_tpl->tpl_vars['PS_ALLOW_MOBILE_DEVICE']->value){?>
				<div class="mobile_switch">
					<p class="center clearBoth">
						<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('index',true);?>
?mobile_theme_ok">
						<img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
mobile_switch.png" alt="<?php echo smartyTranslate(array('s'=>'Browse the mobile site'),$_smarty_tpl);?>
"/>
						</a>
					</p>
				</div>			
				<?php }?>
<!-- Footer copyright -->
			<div class="footer_copyright">
				<p><?php echo smartyTranslate(array('s'=>'Copyright 2013'),$_smarty_tpl);?>
 <a href="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
" title=""><?php echo $_smarty_tpl->tpl_vars['shop_name']->value;?>
</a>  |  <?php echo smartyTranslate(array('s'=>'all rights reserved'),$_smarty_tpl);?>
  |  <?php echo smartyTranslate(array('s'=>'Information society'),$_smarty_tpl);?>
  |  <?php echo smartyTranslate(array('s'=>'Design by:'),$_smarty_tpl);?>
 <a href="http://www.graphileom.fr">Graphileom</a></p>			
			</div></div>
<!-- /Footer copyright -->
			
	<?php }?>
</div>
	</body>
</html>
<?php }} ?>