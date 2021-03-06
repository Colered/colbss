<?php
/*
* Isbn - a module template for Prestashop v1.5+
* Copyright (C) 2013 S.C. Minic Studio S.R.L.
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

if (!defined('_PS_VERSION_'))
  exit;

class Isbn extends Module
{

		private $_postErrors = array();
		private $_html = '';
		private $_postSucess;
		public function __construct()
		{
		   $this->name = 'isbn';
		   $this->tab = 'ISBN';
		   $this->version = '1.5';
		   $this->author = 'IB technology solutions Ltd.';
		   $this->need_instance = 0;
		   $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.6');


		   parent::__construct();

		   $this->displayName = $this->l('ISBN module');
		   $this->description = $this->l('To fetch data from amazone.');

		   $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

		   if (!Configuration::get('isbn'))
			 $this->warning = $this->l('No name provided');
		}

		// this also works, and is more future-proof
		public function install()
		{
			if( (parent::install() == false)||(!$this->_createTab()))
			     return false;
   			return true;
		}

		private function _createTab()
		{
			   $tab = new Tab();
			   $tab->id_parent = 9; // Modules tab
			   $tab->class_name='AdminIsbn';
			   $tab->module='isbn';
			   $tab->name[(int)(Configuration::get('PS_LANG_DEFAULT'))] = $this->l('ISBN');
			   $tab->active=1;
			   if(!$tab->save()) return false;
			   return true;
		}

		public function uninstall()
		{
			   $tabMain = new Tab((int)Tab::getIdFromClassName('AdminIsbn'));
			   $tabMain->delete();
			   if (!parent::uninstall() ||
				 !Configuration::deleteByName('ISBN'))
				 return false;
			   return true;
		}

        public function getContent()
	    {
	      	$output = null;
	  		if (Tools::isSubmit('submit'.$this->name))
	        {
	  			$amazon_aceess_key = trim(strval(Tools::getValue('AMAZON_ACCESS_KEY')));
	  			$amazon_secret_key = trim(strval(Tools::getValue('AMAZON_SECRET_KEY')));
	  			$amzon_associate_tag = trim(strval(Tools::getValue('AMAZON_ASSOCIATE_TAG')));

	  			if (!$amazon_aceess_key  || empty($amazon_aceess_key) || !Validate::isGenericName($amazon_aceess_key))
	  				$errors[] = $this->l('Invalid access key value');
	  			else
	  				Configuration::updateValue('AMAZON_ACCESS_KEY', $amazon_aceess_key);

	  			if ( !$amazon_secret_key  || empty($amazon_secret_key) || !Validate::isGenericName($amazon_secret_key))
	  				$errors[] = $this->l('Invalid secret key value');
	  			else
	  				Configuration::updateValue('AMAZON_SECRET_KEY', $amazon_secret_key);
	  			if ( !$amzon_associate_tag  || empty($amzon_associate_tag) || !Validate::isGenericName($amzon_associate_tag))
	  				$errors[] = $this->l('Invalid associate tag');
	  			else
	  				Configuration::updateValue('AMAZON_ASSOCIATE_TAG', $amzon_associate_tag);

	  			if (isset($errors) && count($errors))
					$output .= $this->displayError(implode('<br />', $errors));
				else
					$output .= $this->displayConfirmation($this->l('Settings updated'));

	        }

	      	 return $output.$this->displayForm();
	    }


		/**
		 * Form display for the configure link
		 */
		public function displayForm()
		{
			// Get default Language
			$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

			// Init Fields form array
			$fields_form[0]['form'] = array(
					'legend' => array(
							'title' => $this->l('Settings'),
					),
					'input' => array(
							array(
									'type' => 'text',
									'label' => $this->l('Acess Key ID'),
									'name' => 'AMAZON_ACCESS_KEY',
									'size' => 40,
									'required' => true
							),
							array(
									'type' => 'text',
									'label' => $this->l('Secret Key'),
									'name' => 'AMAZON_SECRET_KEY',
									'size' => 40,
									'required' => true
							),
							array(
									'type' => 'text',
									'label' => $this->l('Associate Tag'),
									'name' => 'AMAZON_ASSOCIATE_TAG',
									'size' => 20,
									'required' => true
							)
					),
					'submit' => array(
							'title' => $this->l('Update Settings'),
							'class' => 'button'
					)
			);

			$helper = new HelperForm();

			// Module, token and currentIndex
			$helper->module = $this;
			$helper->name_controller = $this->name;
			$helper->token = Tools::getAdminTokenLite('AdminModules');
			$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;

			// Language
			$helper->default_form_language = $default_lang;
			$helper->allow_employee_form_lang = $default_lang;

			// Title and toolbar
			$helper->title = $this->displayName;
			$helper->show_toolbar = true;        // false -> remove toolbar
			$helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
			$helper->submit_action = 'submit'.$this->name;
			$helper->toolbar_btn = array(

					'back' => array(
							'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
							'desc' => $this->l('Back to list')
					)
			);
		  // Add Empty fields in the form
			$helper->fields_value['AMAZON_ACCESS_KEY'] = Configuration::get('AMAZON_ACCESS_KEY');
			$helper->fields_value['AMAZON_SECRET_KEY'] = Configuration::get('AMAZON_SECRET_KEY');
			$helper->fields_value['AMAZON_ASSOCIATE_TAG'] = Configuration::get('AMAZON_ASSOCIATE_TAG');
		    return $helper->generateForm($fields_form);
	 }




}

?>