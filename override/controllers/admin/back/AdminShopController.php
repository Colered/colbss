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
					'label' => $this->l('Phone:'),
					'name' => 'phone',
					'size' => 15,
					'maxlength' => 16,
					'desc' => $this->l('Phone number for this shop')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Address:'),
					'name' => 'address1',
					'size' => 100,
					'maxlength' => 128,
					'required' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Address:').' (2)',
					'name' => 'address2',
					'size' => 100,
					'maxlength' => 128,
				),
				array(
					'type' => 'text',
					'label' => $this->l('Postal Code/Zip Code:'),
					'name' => 'postcode',
					'size' => 10,
					'maxlength' => 12,
					'required' => true,
				),
				array(
					'type' => 'text',
					'label' => $this->l('City:'),
					'name' => 'city',
					'size' => 20,
					'maxlength' => 32,
					'required' => true,
				),
				array(
					'type' => 'select',
					'label' => $this->l('Country:'),
					'name' => 'id_country',
					'required' => true,
					'default_value' => (int)$this->context->country->id,
					'options' => array(
						'query' => Country::getCountries($this->context->language->id, false),
						'id' => 'id_country',
						'name' => 'name',
					),
				),
				array(
					'type' => 'select',
					'label' => $this->l('State'),
					'name' => 'id_state',
					'options' => array(
						'id' => 'id_state',
						'query' => array(),
						'name' => 'name'
					)
				  )
				)
			);
			/*$countries_list = $this->assignCountries();
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
				);*/

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
				'id_shop_group' => (Tools::getValue('id_shop_group') ? Tools::getValue('id_shop_group') : (isset($obj->id_shop_group)) ? $obj->id_shop_group : Shop::getContextShopGroupID()),
				'id_category' => (Tools::getValue('id_category') ? Tools::getValue('id_category') : (isset($obj->id_category)) ? $obj->id_category : (int)Configuration::get('PS_HOME_CATEGORY')),
				'id_theme_checked' => (isset($obj->id_theme) ? $obj->id_theme : $id_theme),
				'phone' => (Tools::getValue('phone') ? Tools::getValue('phone') : (isset($shopaddress['0']['phone']) ? $shopaddress['0']['phone'] : '')),
				'address1' => (Tools::getValue('address1') ? Tools::getValue('address1') : (isset($shopaddress['0']['address1']) ? $shopaddress['0']['address1'] : '')),
				'address2' => (Tools::getValue('address2') ? Tools::getValue('address2') : (isset($shopaddress['0']['address2']) ? $shopaddress['0']['address2'] : '')),
				'postcode' => (Tools::getValue('postcode') ? Tools::getValue('postcode') : (isset($shopaddress['0']['postcode']) ? $shopaddress['0']['postcode'] : '')),
				'city'     => (Tools::getValue('city') ? Tools::getValue('city') : (isset($shopaddress['0']['city']) ? $shopaddress['0']['city'] : '')),
				'id_country' => (Tools::getValue('id_country') ? Tools::getValue('id_country') : (isset($shopaddress['0']['id_country']) ? $shopaddress['0']['id_country'] : '')),
				'id_state' => (Tools::getValue('id_state') ? Tools::getValue('id_state') : (isset($shopaddress['0']['id_state']) ? $shopaddress['0']['id_state'] : ''))
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

	/**
	 * Object creation
	 */
	public function processAdd()
	{
		if (!Tools::getValue('categoryBox') || !in_array(Tools::getValue('id_category'), Tools::getValue('categoryBox')))
			$this->errors[] = $this->l('You need to select at least the root category.');


		if (Tools::isSubmit('id_category_default'))
			$_POST['id_category'] = (int)Tools::getValue('id_category_default');

		/* Checking fields validity */
		$this->validateRules();


		if (!Tools::getValue('address1'))
			$this->errors[] = $this->l('Address1 must not be empty.');

		if (!Tools::getValue('postcode'))
			$this->errors[] = $this->l('Postal Code must not be empty.');

		if (!Tools::getValue('city'))
			$this->errors[] = $this->l('City must not be empty.');

		if (!count($this->errors))
		{
			$object = new $this->className();
			$this->copyFromPost($object, $this->table);
			$this->beforeAdd($object);
			if (!$object->add())
			{
				$this->errors[] = Tools::displayError('An error occurred while creating an object.').
					' <b>'.$this->table.' ('.Db::getInstance()->getMsgError().')</b>';
			}
			/* voluntary do affectation here */
			else if (($_POST[$this->identifier] = $object->id) && $this->postImage($object->id) && !count($this->errors) && $this->_redirect)
			{
				$parent_id = (int)Tools::getValue('id_parent', 1);
				$this->afterAdd($object);
				$this->updateAssoShop($object->id);
				// Save and stay on same form
				if (Tools::isSubmit('submitAdd'.$this->table.'AndStay'))
					$this->redirect_after = self::$currentIndex.'&'.$this->identifier.'='.$object->id.'&conf=3&update'.$this->table.'&token='.$this->token;
				// Save and back to parent
				if (Tools::isSubmit('submitAdd'.$this->table.'AndBackToParent'))
					$this->redirect_after = self::$currentIndex.'&'.$this->identifier.'='.$parent_id.'&conf=3&token='.$this->token;
				// Default behavior (save and back)
				if (empty($this->redirect_after))
					$this->redirect_after = self::$currentIndex.($parent_id ? '&'.$this->identifier.'='.$object->id : '').'&conf=3&token='.$this->token;
			}
		}

		$this->errors = array_unique($this->errors);
		if (count($this->errors) > 0)
		{
			$this->display = 'add';
			return;
		}

		// specific import for stock
		if (isset($import_data['stock_available']) && isset($import_data['product']) && Tools::isSubmit('useImportData'))
		{
			$id_src_shop = (int)Tools::getValue('importFromShop');
			if ($object->getGroup()->share_stock == false)
				StockAvailable::copyStockAvailableFromShopToShop($id_src_shop, $object->id);
		}

		$categories = Tools::getValue('categoryBox');
		array_unshift($categories, Configuration::get('PS_ROOT_CATEGORY'));
		Category::updateFromShop($categories, $object->id);
		Search::indexation(true);
		return $object;
	}
	/**
	 * Copy datas from $_POST to object
	 *
	 * @param object &$object Object
	 * @param string $table Object table
	 */
	protected function copyFromPost(&$object, $table)
	{
		$_POST['id_shop'] = $this->context->cookie->id_shop;
		/* Classical fields */
		foreach ($_POST as $key => $value)
			if (key_exists($key, $object) && $key != 'id_'.$table)
			{
				/* Do not take care of password field if empty */
				if ($key == 'passwd' && Tools::getValue('id_'.$table) && empty($value))
					continue;
				/* Automatically encrypt password in MD5 */
				if ($key == 'passwd' && !empty($value))
					$value = Tools::encrypt($value);
				$object->{$key} = $value;
			}

		/* Multilingual fields */
		$rules = call_user_func(array(get_class($object), 'getValidationRules'), get_class($object));
		if (count($rules['validateLang']))
		{
			$languages = Language::getLanguages(false);
			foreach ($languages as $language)
				foreach (array_keys($rules['validateLang']) as $field)
					if (isset($_POST[$field.'_'.(int)$language['id_lang']]))
						$object->{$field}[(int)$language['id_lang']] = $_POST[$field.'_'.(int)$language['id_lang']];
		}
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
		//PRINT"<PRE>";print_r($_POST);die;
		$this->context->cookie->id_shop = $new_shop->id;
		$object = new ShopAddress();
		$this->copyFromPost($object, "shop_address");
		$this->beforeAdd($object);
		if (!$object->add())
		{
			$this->errors[] = Tools::displayError('An error occurred while creating an object.').
				' <b>shop_address ('.Db::getInstance()->getMsgError().')</b>';
		}
		return parent::afterAdd($new_shop);

	}

	/**
	 * Object update
	 */
	public function processUpdate()
	{

		/* Checking fields validity */
		$this->validateRules();

		if (!Tools::getValue('address1'))
			$this->errors[] = $this->l('Address1 must not be empty.');

		if (!Tools::getValue('postcode'))
					$this->errors[] = $this->l('Postal Code must not be empty.');


		if (!Tools::getValue('city'))
					$this->errors[] = $this->l('City must not be empty.');

		if (empty($this->errors))
		{
			$id = (int)Tools::getValue($this->identifier);

			/* Object update */
			if (isset($id) && !empty($id))
			{
				$object = new $this->className($id);
				if (Validate::isLoadedObject($object))
				{
					/* Specific to objects which must not be deleted */
					if ($this->deleted && $this->beforeDelete($object))
					{
						// Create new one with old objet values
						$object_new = $object->duplicateObject();
						if (Validate::isLoadedObject($object_new))
						{
							// Update old object to deleted
							$object->deleted = 1;
							$object->update();

							// Update new object with post values
							$this->copyFromPost($object_new, $this->table);
							$result = $object_new->update();
							if (Validate::isLoadedObject($object_new))
								$this->afterDelete($object_new, $object->id);
						}
					}
					else
					{
						$this->copyFromPost($object, $this->table);
						$result = $object->update();
						$this->afterUpdate($object);
					}

					if ($object->id)
						$this->updateAssoShop($object->id);

					if (!$result)
					{
						$this->errors[] = Tools::displayError('An error occurred while updating an object.').
							' <b>'.$this->table.'</b> ('.Db::getInstance()->getMsgError().')';
					}
					elseif ($this->postImage($object->id) && !count($this->errors) && $this->_redirect)
					{
						$parent_id = (int)Tools::getValue('id_parent', 1);
						// Specific back redirect
						if ($back = Tools::getValue('back'))
							$this->redirect_after = urldecode($back).'&conf=4';
						// Specific scene feature
						// @todo change stay_here submit name (not clear for redirect to scene ... )
						if (Tools::getValue('stay_here') == 'on' || Tools::getValue('stay_here') == 'true' || Tools::getValue('stay_here') == '1')
							$this->redirect_after = self::$currentIndex.'&'.$this->identifier.'='.$object->id.'&conf=4&updatescene&token='.$this->token;
						// Save and stay on same form
						// @todo on the to following if, we may prefer to avoid override redirect_after previous value
						if (Tools::isSubmit('submitAdd'.$this->table.'AndStay'))
							$this->redirect_after = self::$currentIndex.'&'.$this->identifier.'='.$object->id.'&conf=4&update'.$this->table.'&token='.$this->token;
						// Save and back to parent
						if (Tools::isSubmit('submitAdd'.$this->table.'AndBackToParent'))
							$this->redirect_after = self::$currentIndex.'&'.$this->identifier.'='.$parent_id.'&conf=4&token='.$this->token;

						// Default behavior (save and back)
						if (empty($this->redirect_after) && $this->redirect_after !== false)
							$this->redirect_after = self::$currentIndex.($parent_id ? '&'.$this->identifier.'='.$object->id : '').'&conf=4&token='.$this->token;
					}
					Logger::addLog(sprintf($this->l('%s edition', 'AdminTab', false, false), $this->className), 1, null, $this->className, (int)$object->id, true, (int)$this->context->employee->id);
				}
				else
					$this->errors[] = Tools::displayError('An error occurred while updating an object.').
						' <b>'.$this->table.'</b> '.Tools::displayError('(cannot load object)');
			}
		}
		$this->errors = array_unique($this->errors);
		if (!empty($this->errors))
		{
			// if we have errors, we stay on the form instead of going back to the list
			$this->display = 'edit';
			return false;
		}

		if (isset($object))
			return $object;
		return;
	}

	protected function afterUpdate($new_shop)
	{
		$categories = Tools::getValue('categoryBox');
		array_unshift($categories, Configuration::get('PS_ROOT_CATEGORY'));

		if (!Category::updateFromShop($categories, $new_shop->id))
			$this->errors[] = $this->l('You need to select at least the root category.');
		if (Tools::getValue('useImportData') && ($import_data = Tools::getValue('importData')) && is_array($import_data))
			$new_shop->copyShopData((int)Tools::getValue('importFromShop'), $import_data);

		if(Tools::getValue('address1'))
			$address1 = Tools::getValue('address1');
		if(Tools::getValue('address2'))
			$address2 = Tools::getValue('address2');
		if(Tools::getValue('postcode'))
			$postcode = Tools::getValue('postcode');
		if(Tools::getValue('city'))
			$city = Tools::getValue('city');
		if(Tools::getValue('id_country'))
			$id_country = Tools::getValue('id_country');
		if(Tools::getValue('id_state'))
			$id_state = Tools::getValue('id_state');
		if(Tools::getValue('phone'))
			$phone = Tools::getValue('phone');

		$sql = "UPDATE "._DB_PREFIX_."shop_address  SET `address1` = '".$address1."',
														`address2` = '".$address2."',
														`postcode` = '".$postcode."',
														`city`     = '".$city."',
														`id_country` = '".$id_country."',
														`id_state`   = '".$id_state."',
														`phone`   = '".$phone."',
														`date_upd`   = '".date("Y-m-d H:i:s")."'
														where `id_shop` = '".$new_shop->id."'";
		Db::getInstance()->execute($sql);
		return parent::afterUpdate($new_shop);
	}


}
?>