<?php /* Smarty version Smarty-3.1.14, created on 2014-09-29 14:56:19
         compiled from "D:\xampp\htdocs\bookstore\modules\blocksharefb\blocksharefb.tpl" */ ?>
<?php /*%%SmartyHeaderCode:24344542925bb1bfaf3-83584140%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2e44581a0e8abc24a08448b8dfa070691687a5d8' => 
    array (
      0 => 'D:\\xampp\\htdocs\\bookstore\\modules\\blocksharefb\\blocksharefb.tpl',
      1 => 1407408630,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '24344542925bb1bfaf3-83584140',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'product_link' => 0,
    'product_title' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_542925bb1bfaf8_10244140',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_542925bb1bfaf8_10244140')) {function content_542925bb1bfaf8_10244140($_smarty_tpl) {?>

<li id="left_share_fb">
	<a href="http://www.facebook.com/sharer.php?u=<?php echo $_smarty_tpl->tpl_vars['product_link']->value;?>
&amp;t=<?php echo $_smarty_tpl->tpl_vars['product_title']->value;?>
" class="js-new-window"><?php echo smartyTranslate(array('s'=>'Share on Facebook!','mod'=>'blocksharefb'),$_smarty_tpl);?>
</a>
</li><?php }} ?>