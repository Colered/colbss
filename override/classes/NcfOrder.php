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

class NcfOrder extends ObjectModel
{
	public $id;
	public $id_cart;
	public $order_id;
	public $school_id;
	public $rnc_id;
	public $rnc_name;
	public $rnc_phone;
	public $rnc_address;
	public $rnc_type;
	public $date_add;
	public $date_upd;
	public $id_customer;
	public $id_employee;
	public $fiscal_receipt_num_p1;
	public $fiscal_receipt_num_p2;
	public static $definition = array(
		'table' => 'fed_order_nfc_details',
		'primary' => 'id',
		'fields' => array(
			'order_id' => 		array('type' => self::TYPE_STRING),
			'id_cart' => 		array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'school_id' => 		array('type' => self::TYPE_STRING),
			'rnc_id' => 		array('type' => self::TYPE_STRING),
			'rnc_name' => 	array('type' => self::TYPE_STRING),
			'rnc_phone' => 	array('type' => self::TYPE_STRING),
			'rnc_type' => 	array('type' => self::TYPE_STRING),
			'rnc_address' => 		array('type' => self::TYPE_STRING),
			'id_customer' => 	array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'id_employee' => 	array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'fiscal_receipt_num_p1' => 		array('type' => self::TYPE_STRING),
			'fiscal_receipt_num_p2' => 		array('type' => self::TYPE_STRING),
			'date_add' => 		array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
			'date_upd' => 		array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
		),
	);

	/**
	  * Return the last message from cart
	  *
	  * @param integer $id_cart Cart ID
	  * @return array Message
	  */
	public static function getNcfdataByCartId($id_cart)
	{
		return Db::getInstance()->getRow('
			SELECT *
			FROM `'._DB_PREFIX_.'fed_order_nfc_details`
			WHERE `id_cart` = '.(int)$id_cart
		);
	}
}


