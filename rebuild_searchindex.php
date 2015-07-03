<?php
@ini_set('display_errors', 'on');
require_once(dirname(__FILE__).'/config/config.inc.php');
require_once(dirname(__FILE__).'/init.php');
ini_set('max_execution_time', 7200);
Search::indexation('true');
echo 'success -- search index has been rebuilt';
?>