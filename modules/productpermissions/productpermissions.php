<?php
/*
* Product Permissions - a module template for Prestashop v1.5+
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

class ProductPermissions extends Module
{

		private $_postErrors = array();
		private $_html = '';
		private $_postSucess;
		public function __construct()
		{
		   $this->name = 'productpermissions';
		   $this->tab = 'Product Permissions';
		   $this->version = '1.5';
		   $this->author = 'IB technology solutions Ltd.';
		   $this->need_instance = 0;
		   $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.6');


		   parent::__construct();

		   $this->displayName = $this->l('Product Permissions');
		   $this->description = $this->l('To assign product tab permissions to various users.');

		   $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

		   if (!Configuration::get('productpermissions'))
			 $this->warning = $this->l('No name provided');
		}

		// this also works, and is more future-proof
		public function install()
		{
			if( (parent::install() == false)||(!$this->_createTab())  )
			  return false;
			return true;
		}
		private function _createTab()
		{
			$tab = new Tab();
			$tab->id_parent = 9; // Modules tab
			$tab->class_name='AdminProductPermissions';
			$tab->module='productpermissions';
			$tab->position = 3;
			$tab->name[(int)(Configuration::get('PS_LANG_DEFAULT'))] = $this->l('Product Permissions');
			$tab->active=1;
			if(!$tab->save()) return false;
			return true;
		}

		public function uninstall()
		{
			$tabMain = new Tab((int)Tab::getIdFromClassName('AdminProductPermissions'));
			$tabMain->delete();
			if (!parent::uninstall() ||
			  !Configuration::deleteByName('productpermissions'))
			  return false;
			return true;
		}
}

?>