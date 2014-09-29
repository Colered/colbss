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


class AdminShopController extends AdminShopControllerCore
{
	public function renderForm()
		{
			if (!($obj = $this->loadObject(true)))
				return;

			$this->fields_form = array(
				'legend' => array(
					'title' => $this->l('Shop')
				),
				'input' => array(
					array(
						'type' => 'text',
						'label' => $this->l('Shop name:'),
						'desc' => $this->l('This field does not refer to the shop name visible in the front office.').' '.
							sprintf($this->l('Follow %sthis link%s to edit the shop name used on the Front Office.'), '<a href="'.$this->context->link->getAdminLink('AdminStores').'">', '</a>'),
						'name' => 'name',
						'required' => true,
					),
				   array(
						'type' => 'text',
						'label' => $this->l('Address'),
						'name' => 'address1',
						'required' => true,
					),
				  array(
						'type' => 'text',
						'label' => $this->l('Address(Line 2)'),
						'name' => 'address2',
						'required' => true,
					),
				  array(
						'type' => 'text',
						'label' => $this->l('Zip / Postal Code'),
						'name' => 'postcode',
						'required' => true,
					),
				  array(
						'type' => 'text',
						'label' => $this->l('City'),
						'name' => 'city',
						'required' => true,
					)
				)
			);
			$countries_list = $this->assignCountries();
			$options[] = array(
				'id_country' =>	$countries_list['id'],
				'name' =>			$countries_list['name'],
			);
			$this->fields_form['input'][] = array(
					'type' => 'select',
					'label' => $this->l('Country'),
					'name' => 'id_country',
					'options' => array(
						'query' => $options,
						'id' => 'id_country',
						'name' => 'name',
					),
				);
			$states = $this->getStates($countries_list['id']);
			foreach($states as $state){
				$options[] = array(
						'id_state' =>	$state['id_state'],
						'name' =>		$state['name'],
					);
			}
			$this->fields_form['input'][] = array(
					'type' => 'select',
					'label' => $this->l('State'),
					'name' => 'id_state',
					'options' => array(
						'query' => $options,
						'id' => 'id_state',
						'name' => 'name',
					),
				);
			
			$display_group_list = true;
			if ($this->display == 'edit')
			{
				$group = new ShopGroup($obj->id_shop_group);
				//print_r($group);die;
				if ($group->share_customer || $group->share_order || $group->share_stock)
					$display_group_list = false;
			}

			if ($display_group_list)
			{
				$options = array();
				foreach (ShopGroup::getShopGroups() as $group)
				{
					if ($this->display == 'edit' && ($group->share_customer || $group->share_order || $group->share_stock) && ShopGroup::hasDependency($group->id))
						continue;

					$options[] = array(
						'id_shop_group' =>	$group->id,
						'name' =>			$group->name,
					);
				}

				if ($this->display == 'add')
					$group_desc = $this->l('Warning: You won\'t be able to change the group of this shop if this shop belongs to a group with one of these options activated: Share Customers, Share Quantities or Share Orders.');
				else
					$group_desc = $this->l('You can only move your shop to a shop group with all "share" options disabled -- or to a shop group with no customers/orders.');

				$this->fields_form['input'][] = array(
					'type' => 'select',
					'label' => $this->l('Group Shop:'),
					'desc' => $group_desc,
					'name' => 'id_shop_group',
					'options' => array(
						'query' => $options,
						'id' => 'id_shop_group',
						'name' => 'name',
					),
				);
			}
			else
			{
				$this->fields_form['input'][] = array(
					'type' => 'hidden',
					'name' => 'id_shop_group',
					'default' => $group->name
				);
				$this->fields_form['input'][] = array(
					'type' => 'textShopGroup',
					'label' => $this->l('Shop group:'),
					'desc' => $this->l('You can\'t edit the shop group because the current shop belongs to a group with the "share" option enabled.'),
					'name' => 'id_shop_group',
					'value' => $group->name
				);
			}

			$categories = Category::getRootCategories($this->context->language->id);
			$this->fields_form['input'][] = array(
				'type' => 'select',
				'label' => $this->l('Category root:'),
				'desc' => $this->l('This is the root category of the store that you\'ve created. To define a new root category for your store,').'&nbsp;<a href="'.$this->context->link->getAdminLink('AdminCategories').'&addcategoryroot" target="_blank">'.$this->l('Please click here').'</a>',
				'name' => 'id_category',
				'options' => array(
					'query' => $categories,
					'id' => 'id_category',
					'name' => 'name'
				)
			);

			if (Tools::isSubmit('id_shop'))
			{
				$shop = new Shop((int)Tools::getValue('id_shop'));
				$parent = $shop->id_category;
			}
			else
				$parent = $categories[0]['id_category'];
			$this->fields_form['input'][] = array(
				'type' => 'categories_select',
				'name' => 'categoryBox',
				'label' => $this->l('Associated categories:'),
				'category_tree' => $this->initCategoriesAssociation($parent),
				'desc' => $this->l('By selecting associated categories, you are choosing to share the categories between shops. Once associated between shops, any alteration of this category will impact every shop.')
			);
			/*$this->fields_form['input'][] = array(
				'type' => 'radio',
				'label' => $this->l('Status:'),
				'name' => 'active',
				'required' => true,
				'class' => 't',
				'is_bool' => true,
				'values' => array(
					array(
						'id' => 'active_on',
						'value' => 1,
						'label' => $this->l('Enabled')
					),
					array(
						'id' => 'active_off',
						'value' => 0,
						'label' => $this->l('Disabled')
					)
				),
				'desc' => $this->l('Enable or disable your store?')
			);*/

			$themes = Theme::getThemes();
			if (!isset($obj->id_theme))
				foreach ($themes as $theme)
					if (isset($theme->id))
					{
						$id_theme = $theme->id;
						break;
					}

			$this->fields_form['input'][] = array(
				'type' => 'theme',
				'label' => $this->l('Theme:'),
				'name' => 'theme',
				'values' => $themes
			);

			$this->fields_form['submit'] = array(
				'title' => $this->l('Save'),
				'class' => 'button'
			);

			if (Shop::getTotalShops() > 1 && $obj->id)
				$disabled = array('active' => false);
			else
				$disabled = false;

			$import_data = array(
				'carrier' => $this->l('Carriers:'),
				'cms' => $this->l('CMS page'),
				'contact' => $this->l('Contact'),
				'country' => $this->l('Countries'),
				'currency' => $this->l('Currencies:'),
				'discount' => $this->l('Discounts'),
				'employee' => $this->l('Employees'),
				'image' => $this->l('Images'),
				'lang' => $this->l('Langs'),
				'manufacturer' => $this->l('Manufacturers:'),
				'module' => $this->l('modules'),
				'hook_module' => $this->l('Module hooks'),
				'meta_lang' => $this->l('Meta'),
				'product' => $this->l('Products:'),
				'product_attribute' => $this->l('Combinations'),
				'scene' => $this->l('Scenes'),
				'stock_available' => $this->l('Available quantities for sale'),
				'store' => $this->l('Stores'),
				'warehouse' => $this->l('Warehouse'),
				'webservice_account' => $this->l('Webservice accounts'),
				'attribute_group' => $this->l('Attribute groups'),
				'feature' => $this->l('Features'),
				'group' => $this->l('Customer groups'),
				'tax_rules_group' => $this->l('Tax rules groups'),
				'supplier' => $this->l('Suppliers'),
				'referrer' => $this->l('Referrers'),
				'zone' => $this->l('Zones'),
				'cart_rule' => $this->l('Cart rules'),
			);
			
			// Hook for duplication of shop data
			$modules_list = Hook::getHookModuleExecList('actionShopDataDuplication');
			if (is_array($modules_list) && count($modules_list) > 0)
				foreach ($modules_list as $m)
					$import_data['Module'.ucfirst($m['module'])] = Module::getModuleName($m['module']);

			asort($import_data);
					
			if (!$this->object->id)
				$this->fields_import_form = array(
					'radio' => array(
						'type' => 'radio',
						'label' => $this->l('Import data'),
						'name' => 'useImportData',
						'value' => 1
					),
					'select' => array(
						'type' => 'select',
						'name' => 'importFromShop',
						'label' => $this->l('Choose the shop (source)'),
						'options' => array(
							'query' => Shop::getShops(false),
							'name' => 'name'
						)
					),
					'allcheckbox' => array(
						'type' => 'checkbox',
						'label' => $this->l('Choose data to import'),
						'values' => $import_data
					),
					'desc' => $this->l('Use this option to associate data (products, modules, etc.) the same way for each selected shop.')
				);
			
			if ($this->display == 'edit'){
				$shopaddress = ShopAddress::getAddressIdByShopId($obj->id);
			}

			$this->fields_value = array(
				'id_shop_group' => (Tools::getValue('id_shop_group') ? Tools::getValue('id_shop_group') :
					(isset($obj->id_shop_group)) ? $obj->id_shop_group : Shop::getContextShopGroupID()),
				'id_category' => (Tools::getValue('id_category') ? Tools::getValue('id_category') :
					(isset($obj->id_category)) ? $obj->id_category : (int)Configuration::get('PS_HOME_CATEGORY')),
				'id_theme_checked' => (isset($obj->id_theme) ? $obj->id_theme : $id_theme),
				'address1' => (isset($shopaddress['0']['address1']) ? $shopaddress['0']['address1'] : ''),
				'address2' => (isset($shopaddress['0']['address2']) ? $shopaddress['0']['address2'] : ''),
				'postcode' => (isset($shopaddress['0']['postcode']) ? $shopaddress['0']['postcode'] : ''),
				'city'     => (isset($shopaddress['0']['city']) ? $shopaddress['0']['city'] : ''),
				'id_state' => (isset($shopaddress['0']['id_state']) ? $shopaddress['0']['id_state'] : '')				
			);	

			$ids_category = array();
			$shops = Shop::getShops(false);
			foreach ($shops as $shop)
				$ids_category[$shop['id_shop']] = $shop['id_category'];

			$this->tpl_form_vars = array(
				'disabled' => $disabled,
				'checked' => (Tools::getValue('addshop') !== false) ? true : false,
				'defaultShop' => (int)Configuration::get('PS_SHOP_DEFAULT'),
				'ids_category' => $ids_category,
			);
			if (isset($this->fields_import_form))
				$this->tpl_form_vars = array_merge($this->tpl_form_vars, array('form_import' => $this->fields_import_form));

			return AdminController::renderForm();
		}
	protected function assignCountries()
	{
		// Get selected country
		if (Tools::isSubmit('id_country') && !is_null(Tools::getValue('id_country')) && is_numeric(Tools::getValue('id_country')))
			$selected_country = (int)Tools::getValue('id_country');
		else if (isset($this->_address) && isset($this->_address->id_country) && !empty($this->_address->id_country) && is_numeric($this->_address->id_country))
			$selected_country = (int)$this->_address->id_country;
		else if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
		{
			// get all countries as language (xy) or language-country (wz-XY)
			$array = array();
			preg_match("#(?<=-)\w\w|\w\w(?!-)#",$_SERVER['HTTP_ACCEPT_LANGUAGE'],$array);
			if (!Validate::isLanguageIsoCode($array[0]) || !($selected_country = Country::getByIso($array[0])))
				$selected_country = (int)Configuration::get('PS_COUNTRY_DEFAULT');
		}
		else
			$selected_country = (int)Configuration::get('PS_COUNTRY_DEFAULT');

		// Generate countries list
		if (Configuration::get('PS_RESTRICT_DELIVERED_COUNTRIES'))
			$countries = Carrier::getDeliveredCountries($this->context->language->id, true, true);
		else
			$countries = Country::getCountries($this->context->language->id, true);

		// @todo use helper
		$list = '';		
		foreach ($countries as $country)
		{
			$selected = ($country['id_country'] == $selected_country) ? 'selected="selected"' : '';
			$list = array('id' => (int)$country['id_country'], 'name' => $country['name']);
			//$list .= '<option value="'.(int)$country['id_country'].'" '.$selected.'>'.htmlentities($country['name'], ENT_COMPAT, 'UTF-8').'</option>';
		}

		// Assign vars
		$this->context->smarty->assign(array(
			'countries_list' => $list,
			'countries' => $countries,
		));
		return $list;
	}
	protected function getStates($id_country){
		$db = Db::getInstance();
        $result = $db->query('SELECT id_state,name from ps_state where id_country ='.$id_country);
		
		$states = array();
		$z = 0;
		while ($row = $db->nextRow($result)) {
            $states[$z]['id_state'] = $row['id_state'];
            $states[$z]['name'] = $row['name'];
			$z++;
        }
		return $states;
		


	}
	protected function afterAdd($new_shop)
	{
		
		$import_data = Tools::getValue('importData', array());

		// The root category should be at least imported
		$new_shop->copyShopData((int)Tools::getValue('importFromShop'), $import_data);

		// copy default data
		if (!Tools::getValue('useImportData') || (is_array($import_data) && !isset($import_data['group'])))
		{
			$sql = 'INSERT INTO `'._DB_PREFIX_.'group_shop` (`id_shop`, `id_group`)
					VALUES
					('.(int)$new_shop->id.', '.(int)Configuration::get('PS_UNIDENTIFIED_GROUP').'),
					('.(int)$new_shop->id.', '.(int)Configuration::get('PS_GUEST_GROUP').'),
					('.(int)$new_shop->id.', '.(int)Configuration::get('PS_CUSTOMER_GROUP').')
				';
			Db::getInstance()->execute($sql);
		}
		if(empty(Tools::getValue('address1')))
			$this->errors[] = Tools::displayError('Address cannot be empty.');
		else
			$address1 = Tools::getValue('address1');

		if(!empty(Tools::getValue('address2')))
			$address2 = Tools::getValue('address2');
		
		if(empty(Tools::getValue('postcode')))
			$this->errors[] = Tools::displayError('Zipcode cannot be empty.');
		else
			$postcode = Tools::getValue('postcode');

		if(empty(Tools::getValue('city')))
			$this->errors[] = Tools::displayError('City cannot be empty.');
		else
			$city = Tools::getValue('city');

		if(!empty(Tools::getValue('id_country')))
			$id_country = Tools::getValue('id_country');

		if(!empty(Tools::getValue('id_state')))
			$id_state = Tools::getValue('id_state');

		//echo self::$currentIndex;die;
		//print_r($this->errors);die;
		if(empty($this->errors)){
		$sql = "INSERT INTO "._DB_PREFIX_."shop_address (`id_shop`, `address1`, `address2`, `postcode`, `city`, `id_country`, `id_state`)
					VALUES
					('".$new_shop->id."', '".$address1."', '".$address2."', '".$postcode."', '".$city."', '".$id_country."', '".$id_state."')";
		Db::getInstance()->execute($sql);
		
		}
		
		return parent::afterAdd($new_shop);
		
	}

	protected function afterUpdate($new_shop)
	{
		$categories = Tools::getValue('categoryBox');
		array_unshift($categories, Configuration::get('PS_ROOT_CATEGORY'));

		if (!Category::updateFromShop($categories, $new_shop->id))
			$this->errors[] = $this->l('You need to select at least the root category.');
		if (Tools::getValue('useImportData') && ($import_data = Tools::getValue('importData')) && is_array($import_data))
			$new_shop->copyShopData((int)Tools::getValue('importFromShop'), $import_data);

		$address1 = Tools::getValue('address1');
		$address2 = Tools::getValue('address2');
		$postcode = Tools::getValue('postcode');
		$city = Tools::getValue('city');
		$id_country = Tools::getValue('id_country');
		$id_state = Tools::getValue('id_state');

		$sql = "UPDATE "._DB_PREFIX_."shop_address  SET `address1` = '".$address1."',
														`address2` = '".$address2."',
														`postcode` = '".$postcode."',
														`city`     = '".$city."', 
														`id_country` = '".$id_country."',
														`id_state`   = '".$id_state."'
														where `id_shop` = '".$new_shop->id."'";
		Db::getInstance()->execute($sql);
		return parent::afterUpdate($new_shop);
	}
	
	
}
?>