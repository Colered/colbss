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

/**
 * @since 1.5.0
 */
class ShopAddress extends ObjectModel
{
	public $address1;
	public $address2;
	public $postcode;
	public $city;
	public $id_country;
	public $id_state;
	public $id_shop;

	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'shop_address',
		'primary' => 'id_shop_address',
		'fields' => array(
			'id_shop' => 		array('type' => self::TYPE_INT, 'required' => true),
			'address1' => 			array('type' => self::TYPE_STRING, 'validate' => 'isAddress', 'required' => true, 'size' => 128),
			'address2' => 			array('type' => self::TYPE_STRING, 'validate' => 'isAddress', 'size' => 128),
			'postcode' => 			array('type' => self::TYPE_STRING, 'validate' => 'isPostCode', 'size' => 12),
			'city' => 				array('type' => self::TYPE_STRING, 'validate' => 'isCityName', 'required' => true, 'size' => 64),
			'id_country' => 		array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
			'id_state' => 			array('type' => self::TYPE_INT, 'validate' => 'isNullOrUnsignedId'),
		),
	);

	
	public static function getAddressIdByShopId($id_shop)
	{
		$sql = 'SELECT address1,address2,postcode,city,id_state
		FROM '._DB_PREFIX_.'shop_address
		WHERE id_shop = '.(int)$id_shop;
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
		return $result;;
	}
}
?>