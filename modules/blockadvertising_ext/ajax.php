<?php
require_once(realpath(dirname(__FILE__).'/../../').'/config/config.inc.php');
require_once(dirname(__FILE__).'/blockadvertising_ext.php');

if (!$id = Tools::getValue('id'))
	die();

$module = new blockadvertising_ext();
echo $module->_getFormItem(intval($id), true);

?>