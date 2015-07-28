<?php
/*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class StoreAddress extends ObjectModel
{

    public  function addStoreAddress()
	      {     
				$sql =Db::getInstance()->getRow('SELECT * FROM '._DB_PREFIX_.'shop_address WHERE id_shop='.$this->context->shop->id.'');
				$id_country=$sql['id_country'];
				$id_state=$sql['id_state'];
				$id_customer=$this->context->cookie->id_customer;
				$address1=$sql['address1'];
				$address2=$sql['address2'];
				$postcode=$sql['postcode'];
				$city=$sql['city'];
				$date_upd=strtotime($sql['date_upd']);
				$phone=$sql['phone'];
				$school_address="School address";
				$sql_alias =Db::getInstance()->ExecuteS('SELECT alias,date_upd FROM '._DB_PREFIX_.'address WHERE id_customer="'.$this->context->cookie->id_customer.'" and alias="'.$school_address.'"');
				if (Db::getInstance()->NumRows()){
				    if($date_upd >= strtotime($sql_alias[0]['date_upd'])){
					Db::getInstance()->execute("UPDATE "._DB_PREFIX_."address SET id_country = '".$id_country."',id_state = '".$id_state."',id_customer='".$id_customer."',address1='".$address1."',address2='".$address2."',postcode='".$postcode."',city='".$city."',phone='".$phone."',date_upd = '".date("Y-m-d H:i:s")."' WHERE id_customer='".$this->context->cookie->id_customer."'");
					 } 
				}else{
					$insertData = array(
									'id_country'  => $id_country,
                             		'id_state'  => $id_state, 
         							'id_customer'  => $id_customer, 
        							'address1'   => $address1, 
         							'address2'  => $address2,
		 							'postcode'  => $postcode,
		 							'city'  => $city,
									'phone'=>$phone,
		 							'alias'  => $school_address,
									'date_add' =>date("Y-m-d H:i:s")
									
		        				);
			
                   $inserted=Db::getInstance()->insert("address", $insertData);
				  
				}
				
	}

}