<?php
if (!defined('_PS_VERSION_'))
exit;
class FeaturedBrands extends Module
{
	public function __construct()
    {
		$this->name = 'featuredbrands';
		$this->tab = 'front_office_features';
		$this->version = '1.0';
		$this->author = 'Deepali Kakkar';
		$this->need_instance = 0;
		$this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.5.6.2');
		
		parent::__construct();
	 
		$this->displayName = $this->l('Featured Brands');
		$this->description = $this->l('Description of my module.');
	 
		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
	 
		if (!Configuration::get('MYMODULE_NAME'))      
		  $this->warning = $this->l('No name provided');
    }
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
		$tab->class_name='AdminFeaturedBrands';
		$tab->module='featuredbrands';
		$tab->position = 3;
		$tab->name[(int)(Configuration::get('PS_LANG_DEFAULT'))] = $this->l('Featured Brands');
		$tab->active=1;
		if(!$tab->save()) return false;
		return true;
	}

	public function uninstall()
	{
		$tabMain = new Tab((int)Tab::getIdFromClassName('AdminFeaturedBrands'));
		$tabMain->delete();
		if (!parent::uninstall() ||
		  !Configuration::deleteByName('Featured Brands'))
		  return false;
		return true;
	}


}
?>