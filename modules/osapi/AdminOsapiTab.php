<?php
/*
  AdminOsapiTab.php v 1.0

  OneSaas Connect API 1.0.6 for PrestaShop 1.5.0
  http://www.onesaas.com

  Copyright (c) 2012 oneSaas

*/

include(_PS_MODULE_DIR_.'osapi/osapi.php');

class AdminOsapiTab extends AdminTab
{
  public function __construct()
  {
    $this->osapi = new Osapi();
    return parent::__construct();
  }

  public function display()
  {
    $this->osapi->token = $this->token;
    $this->osapi->displayMain(); //in displayMain() you have to place html form and all html elements you want to display on your tab
  }

}
?>