<?php
require(dirname(__FILE__).'/config/config.inc.php');
require_once(dirname(__FILE__).'/init.php');

/*$send_url = $_POST['school_url'];
$id_category = $_POST['s1g1'];*/

$send_url = isset($_POST['school_url']) ? $_POST['school_url']: "";
$id_category = isset($_POST['s1g1']) ? $_POST['s1g1']: "";


// Get data

/*$number = ((int)(Tools::getValue('n')) ? (int)(Tools::getValue('n')) : 10);
$orderBy = Tools::getProductsOrder('by', Tools::getValue('orderby'));
$orderWay = Tools::getProductsOrder('way', Tools::getValue('orderway'));
$id_category = ((int)(Tools::getValue('id_category')) ? (int)(Tools::getValue('id_category')) : Configuration::get('PS_HOME_CATEGORY'));
$products = Product::getProducts((int)Context::getContext()->language->id, 0, ($number > 10 ? 10 : $number), $orderBy, $orderWay, $id_category, true);

*/

$context = Context::getContext();

// Replace existing shop if necessary
$shop_id = 2;
/*
if (!$shop_id)
	$shop = new Shop(Configuration::get('PS_SHOP_DEFAULT'));
else if ($context->shop->id != $shop_id)
	$shop = new Shop($shop_id);*/

$category = new Category((int)$id_category);
$categoryProducts = $category->getAvailableProducts($context->language->id, 1, 100); /* 100 products max. */

$context->cart = new Cart($context->cookie->id_cart);
$context->shop->id = $shop_id;
//$context->shop = new Shop($shop_id);

/*echo '<pre>';
print_r($context->shop);
die;
*/
//echo $context->shop->id;

foreach($categoryProducts as $prow){
  if($prow['id_product']<>''){
	  $context->cart->updateQty(1, $prow['id_product'], null, 'false', 'up', 0, $context->shop, true);
  }
}


//die;


header("location:".$send_url."/index.php?controller=order");

?>