<?php /* Smarty version Smarty-3.1.14, created on 2014-06-19 14:34:38
         compiled from "D:\xampp\htdocs\bookstore\themes\PRS020046\footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1186053a2a7a637eae0-91321948%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ae944fc3742d7f999517449eeb5ecd43be4aad2a' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\themes\\PRS020046\\footer.tpl',
      1 => 1395903526,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1186053a2a7a637eae0-91321948',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content_only' => 0,
    'HOOK_LEFT_COLUMN' => 0,
    'HOOK_RIGHT_COLUMN' => 0,
    'HOOK_FOOTER' => 0,
    'page_name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_53a2a7a63ad8e7_40828250',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53a2a7a63ad8e7_40828250')) {function content_53a2a7a63ad8e7_40828250($_smarty_tpl) {?>

			<?php if (!$_smarty_tpl->tpl_vars['content_only']->value){?>
			</div>
				
				
				<!-- Left -->
				<div id="left_column" class="column grid_2 alpha">
					<aside id="left_column_inner" role="complementary">
						<?php echo $_smarty_tpl->tpl_vars['HOOK_LEFT_COLUMN']->value;?>

					</aside>	
				</div>
				
</section>
			 <!-- ===== End Center Column ==== -->
			
				<!-- Right -->
				<div id="right_column" class="column grid_2 omega">
					<aside id="right_column_inner" role="complementary">
						<?php echo $_smarty_tpl->tpl_vars['HOOK_RIGHT_COLUMN']->value;?>

					</aside>	
				</div>

			</div><!-- End columns_inner Div -->	
			</div><!-- ===== end columns ==== -->
						
		</div>
		<!-- Footer -->
			<footer id="footer" class="">
				<div class="footer_inner">
					<?php echo $_smarty_tpl->tpl_vars['HOOK_FOOTER']->value;?>

					
					<?php if ($_smarty_tpl->tpl_vars['page_name']->value=='index'){?> 
						<div class="tm_footerlink" style="display:none;">
							Theme By <a href="http://www.templatemela.com/" title="TemplateMela" target="_blank">TemplateMela</a>
						</div>
					<?php }?>
				</div>	
			
			</footer>
	<?php }?>
	<span class="grid_default_width" style="display:none; visibility:hidden"></span>
	</body>
</html>
<?php }} ?>