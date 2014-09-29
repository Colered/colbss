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

class AdminProductsController extends AdminProductsControllerCore
{
	public function renderList()
	{
		$this->addRowAction('edit');
		//$this->addRowAction('duplicate');
		$this->addRowAction('delete');
		return AdminController::renderList();
	}
	public function initToolbar()
	{
		parent::initToolbar();
		if ($this->display == 'edit' || $this->display == 'add')
		{
			if ($product = $this->loadObject(true))
			{
				if ($this->tabAccess['edit'])
				{
					$this->toolbar_btn['save'] = array(
						'short' => 'Save',
						'href' => '#',
						'desc' => $this->l('Save'),
					);

					$this->toolbar_btn['save-and-stay'] = array(
						'short' => 'SaveAndStay',
						'href' => '#',
						'desc' => $this->l('Save and stay'),
					);
				}

				if ((bool)$product->id)
				{
					// adding button for duplicate this product
					if ($this->tabAccess['add'] && $this->display != 'add')
						/*$this->toolbar_btn['duplicate'] = array(
							'short' => 'Duplicate',
							'desc' => $this->l('Duplicate'),
							'confirm' => 1,
							'js' => 'if (confirm(\''.$this->l('Also copy images').' ?\')) document.location = \''.$this->context->link->getAdminLink('AdminProducts').'&amp;id_product='.(int)$product->id.'&amp;duplicateproduct\'; else document.location = \''.$this->context->link->getAdminLink('AdminProducts').'&amp;id_product='.(int)$product->id.'&amp;duplicateproduct&amp;noimage=1\';'
						);
						*/

					// adding button for preview this product
					if ($url_preview = $this->getPreviewUrl($product))
						$this->toolbar_btn['preview'] = array(
							'short' => 'Preview',
							'href' => $url_preview,
							'desc' => $this->l('Preview'),
							'target' => true,
							'class' => 'previewUrl'
						);

					// adding button for preview this product statistics
					if (file_exists(_PS_MODULE_DIR_.'statsproduct/statsproduct.php') && $this->display != 'add')
						$this->toolbar_btn['stats'] = array(
						'short' => 'Statistics',
						'href' => $this->context->link->getAdminLink('AdminStats').'&amp;module=statsproduct&amp;id_product='.(int)$product->id,
						'desc' => $this->l('Product sales'),
					);

					// adding button for adding a new combination in Combination tab
					$this->toolbar_btn['newCombination'] = array(
						'short' => 'New combination',
						'desc' => $this->l('New combination'),
						'class' => 'toolbar-new'
					);
				
					// adding button for delete this product
					if ($this->tabAccess['delete'] && $this->display != 'add')
						$this->toolbar_btn['delete'] = array(
							'short' => 'Delete',
							'href' => $this->context->link->getAdminLink('AdminProducts').'&amp;id_product='.(int)$product->id.'&amp;deleteproduct',
							'desc' => $this->l('Delete this product.'),
							'confirm' => 1,
							'js' => 'if (confirm(\''.$this->l('Delete product?').'\')){return true;}else{event.preventDefault();}'
						);
				}				
			}
		}
		else
			$this->toolbar_btn['import'] = array(
					'href' => $this->context->link->getAdminLink('AdminImport', true).'&import_type=products',
					'desc' => $this->l('Import')
				);
		
		$this->context->smarty->assign('toolbar_scroll', 1);
		$this->context->smarty->assign('show_toolbar', 1);
		$this->context->smarty->assign('toolbar_btn', $this->toolbar_btn);
	}
	/**
	 * Check that a saved product is valid
	 */
	public function checkProduct()
	{
		$className = 'Product';
		// @todo : the call_user_func seems to contains only statics values (className = 'Product')
		$rules = call_user_func(array($this->className, 'getValidationRules'), $this->className);
		$default_language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$languages = Language::getLanguages(false);

		// Check required fields
		foreach ($rules['required'] as $field)
		{
			if (!$this->isProductFieldUpdated($field))
				continue;

			if (($value = Tools::getValue($field)) == false && $value != '0')
			{
				if (Tools::getValue('id_'.$this->table) && $field == 'passwd')
					continue;
				$this->errors[] = sprintf(
					Tools::displayError('The %s field is required.'),
					call_user_func(array($className, 'displayFieldName'), $field, $className)
				);
			}
		}

		// Check multilingual required fields
		foreach ($rules['requiredLang'] as $fieldLang){
			
			if ($this->isProductFieldUpdated($fieldLang, $default_language->id) && !Tools::getValue($fieldLang.'_'.$default_language->id))
				$this->errors[] = sprintf(
					Tools::displayError('This %1$s field is required at least in %2$s'),
					call_user_func(array($className, 'displayFieldName'), $fieldLang, $className),
					$default_language->name
				);
		}
		

		// Check fields sizes
		foreach ($rules['size'] as $field => $maxLength)
			if ($this->isProductFieldUpdated($field) && ($value = Tools::getValue($field)) && Tools::strlen($value) > $maxLength)
				$this->errors[] = sprintf(
					Tools::displayError('The %1$s field is too long (%2$d chars max).'),
					call_user_func(array($className, 'displayFieldName'), $field, $className),
					$maxLength
				);

		if (Tools::getIsset('description_short') && $this->isProductFieldUpdated('description_short'))
		{
			$saveShort = Tools::getValue('description_short');
			$_POST['description_short'] = strip_tags(Tools::getValue('description_short'));
		}

		// Check description short size without html
		$limit = (int)Configuration::get('PS_PRODUCT_SHORT_DESC_LIMIT');
		if ($limit <= 0) $limit = 400;
		foreach ($languages as $language)
			if ($this->isProductFieldUpdated('description_short', $language['id_lang']) && ($value = Tools::getValue('description_short_'.$language['id_lang'])))
				if (Tools::strlen(strip_tags($value)) > $limit)
					$this->errors[] = sprintf(
						Tools::displayError('This %1$s field (%2$s) is too long: %3$d chars max (current count %4$d).'),
						call_user_func(array($className, 'displayFieldName'), 'description_short'),
						$language['name'],
						$limit,
						Tools::strlen(strip_tags($value))
					);

		// Check multilingual fields sizes
		foreach ($rules['sizeLang'] as $fieldLang => $maxLength)
			foreach ($languages as $language)
		  {
				$value = Tools::getValue($fieldLang.'_'.$language['id_lang']);
				if ($value && Tools::strlen($value) > $maxLength)
					$this->errors[] = sprintf(
						Tools::displayError('The %1$s field is too long (%2$d chars max).'),
						call_user_func(array($className, 'displayFieldName'), $fieldLang, $className),
						$maxLength
					);
			}

		if ($this->isProductFieldUpdated('description_short') && isset($_POST['description_short']))
			$_POST['description_short'] = $saveShort;

		// Check fields validity
		foreach ($rules['validate'] as $field => $function)
			if ($this->isProductFieldUpdated($field) && ($value = Tools::getValue($field)))
			{
				$res = true;
				if (Tools::strtolower($function) == 'iscleanhtml')
				{
					if (!Validate::$function($value, (int)Configuration::get('PS_ALLOW_HTML_IFRAME')))
						$res = false;
				}
				else
					if (!Validate::$function($value))
						$res = false;

				if (!$res)
					$this->errors[] = sprintf(
						Tools::displayError('The %s field is invalid.'),
						call_user_func(array($className, 'displayFieldName'), $field, $className)
					);
			}
		// Check multilingual fields validity
		foreach ($rules['validateLang'] as $fieldLang => $function)
			foreach ($languages as $language)
				if ($this->isProductFieldUpdated($fieldLang, $language['id_lang']) && ($value = Tools::getValue($fieldLang.'_'.$language['id_lang'])))
					if (!Validate::$function($value, (int)Configuration::get('PS_ALLOW_HTML_IFRAME')))
						$this->errors[] = sprintf(
							Tools::displayError('The %1$s field (%2$s) is invalid.'),
							call_user_func(array($className, 'displayFieldName'), $fieldLang, $className),
							$language['name']
						);

		// Categories
		if ($this->isProductFieldUpdated('id_category_default') && (!Tools::isSubmit('categoryBox') || !count(Tools::getValue('categoryBox'))))
			$this->errors[] = $this->l('Products must be in at least one category.');

		if ($this->isProductFieldUpdated('id_category_default') && (!is_array(Tools::getValue('categoryBox')) || !in_array(Tools::getValue('id_category_default'), Tools::getValue('categoryBox'))))
			$this->errors[] = $this->l('This product must be in the default category.');

		if (Tools::getValue('reference'))
		{
			if(Tools::getValue('id_product')){
				$reference = Product::getReferenceById(Tools::getValue('reference'), Tools::getValue('id_product'));
			}else{
				$reference = Product::getReference(Tools::getValue('reference'));
			}
			
			if($reference){
			$this->errors[] = $this->l('This reference already exists in database. Please use other reference.');
			}
		}

		// Tags
		foreach ($languages as $language)
			if ($value = Tools::getValue('tags_'.$language['id_lang']))
				if (!Validate::isTagsList($value))
					$this->errors[] = sprintf(
						Tools::displayError('The tags list (%s) is invalid.'),
						$language['name']
					);
	}
}
