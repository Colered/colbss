<?php
/*
  osapi.php

  OneSaas Connect API 1.0.6.23 for PrestaShop 1.5.0
  http://www.onesaas.com

  Copyright (c) 2012 OneSaas

  Version changes:
  1.0.6.2	- Standardized plugin version to 1.0.6.x
  			- Plugin version stored in db (table configuration with name='OSAPI_VERSION')
  			- Added plugin version to Iframe url (parameter 'c_ApiVersion')
  			- Show version in admin UI
  			- iframe url stored in db (table configuration with name='OSAPI_IFRAME_URL') - default production env.
*/


if (!defined('_PS_VERSION_'))
  exit;

class Osapi extends Module
{
  public function __construct()
  {
    $this->name = 'osapi';
    $this->tab = 'Osapi';
    $this->version = '1.0.6.12';
    $this->author = 'OneSaas';
    $this->need_instance = 0;
    $this->tabClassName = 'AdminOsapiTab';
	$this->tabParentName = 'AdminAdmin';
	$this->module_key = 'a066ee4945e849e23d343c7d75d4824d';

    parent::__construct();

    $this->displayName = $this->l('OneSaas Connect');
    $this->description = $this->l('OneSaas Connect Plugin for Prestashop.');

    $this->os_prod_url = "https://secure.onesaas.com/signin/start";
  }

  public function install() {
    if (parent::install() == false) {
	    return false;
    } else {
		if (!$id_tab) {
		  $tab = new Tab();
		  $tab->class_name = $this->tabClassName;
		  $tab->id_parent = Tab::getIdFromClassName($this->tabParentName);
		  $tab->module = $this->name;
		  $languages = Language::getLanguages();
		  foreach ($languages as $language)
			$tab->name[$language['id_lang']] = $this->displayName;
		  $tab->add();
    	}
	
		$db = Db::getInstance();
    	$db->ExecuteS("select name from " . _DB_PREFIX_ . "configuration where name = 'OSAPI_ACCESS_KEY'");
		if ($db->NumRows()==0) {
			// Inizialise AccessKey
			$db->Execute("INSERT INTO " . _DB_PREFIX_ . "configuration VALUES(NULL, NULL, NULL, 'OSAPI_ACCESS_KEY', CONCAT(MD5(NOW()), MD5(CURTIME())), NOW(),NOW())");
			// Initialise Iframe Url
			$db->Execute("INSERT INTO " . _DB_PREFIX_ . "configuration VALUES(NULL, NULL, NULL, 'OSAPI_IFRAME_URL', '" . $this->os_prod_url . "', NOW(),NOW())");
			// Initialise Version
			$db->Execute("INSERT INTO " . _DB_PREFIX_ . "configuration VALUES(NULL, NULL, NULL, 'OSAPI_VERSION', '" . $this->version . "', NOW(),NOW())");
		}
    	return true;
  	}
  }

  //Allow view access to anybody
	public function viewAccess($disable = false){
			$result = true;
			return $result;
	}

  public function uninstall() {
    $id_tab = Tab::getIdFromClassName($this->tabClassName);
    if ($id_tab) {
      $tab = new Tab($id_tab);
      $tab->delete();
    }
    Db::getInstance()->Execute("delete from " . _DB_PREFIX_ . "configuration where name='OSAPI_ACCESS_KEY'");
    Db::getInstance()->Execute("delete from " . _DB_PREFIX_ . "configuration where name='OSAPI_IFRAME_URL'");
    Db::getInstance()->Execute("delete from " . _DB_PREFIX_ . "configuration where name='OSAPI_VERSION'");
    parent::uninstall();
  }

  public function displayMain() {
	$result = Db::getInstance()->ExecuteS("select value from " . _DB_PREFIX_ . "configuration where name = 'OSAPI_ACCESS_KEY'");
	foreach ($result as $ak_result) {
		$ak = $ak_result['value'];
	}
	$result = Db::getInstance()->ExecuteS("select value from " . _DB_PREFIX_ . "configuration where name = 'OSAPI_IFRAME_URL'");
	foreach ($result as $os_url_result) {
		$os_url = $os_url_result['value'];
	}
	$admins = Employee::getEmployeesByProfile(_PS_ADMIN_PROFILE_, true);
  	$ContactName = '';
  	$ContactEmail = '';
  	$ContactPhone = '';
	if (sizeof($admins)>0) {
		$ContactName = $admins[0]['firstname'] . " " . $admins[0]['lastname'];
		$ContactEmail = $admins[0]['email'];
	}
	$CompanyName = Configuration::get('PS_SHOP_NAME');
	if ($_SERVER['HTTPS']=='' || $_SERVER['HTTPS']=='off') {
		$base = 'http://' . $_SERVER['HTTP_HOST'] . _MODULE_DIR_;
	} else {
		$base = 'https://' . $_SERVER['HTTP_HOST'] ._MODULE_DIR_;
	}
	$os_link = $os_url . "?servicetype=prestashop&c_ApiUrl=" . urlencode($base . 'osapi/osapi-xml.php') . "&c_ApiVersion=" . urlencode($this->version) . "&c_ApiToken=" . urlencode($ak) . "&CompanyName=" . urlencode($CompanyName) . "&ContactName=" . urlencode($ContactName) . "&ContactEmail=" . urlencode($ContactEmail) . "&ContactPhone=" . urlencode($ContactPhone);
	echo '<div class="toolbar-placeholder">';
	echo '<div class="toolbarBox toolbarHead">';
	echo '<div class="pageTitle">';
	echo '<h3>';
	echo '<span id="current_obj" style="font-weight: normal;">';
	echo '<span class="breadcrumb item-0 ">Administration<img alt="&gt;" style="margin-right:5px" src="../img/admin/separator_breadcrumb.png" /></span>';
	echo '<span class="breadcrumb item-1 ">OneSaas Connect (v. ' . $this->version . ')</span>';
	echo '</span>';
	echo '</h3>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
  	echo '<div style="width: 990px; margin: 0 auto; height: 1600px">';
  	echo '<iframe src="' . $os_link . '" name="onesaas_frame" frameborder="0" height="1600" width="990"></iframe>';
	echo '</div>';
  }
}
?>