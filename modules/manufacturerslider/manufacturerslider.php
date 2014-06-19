<?php

if (!defined('_CAN_LOAD_FILES_'))
	exit;

class manufacturerslider extends Module
{
    function __construct()
    {
        $this->name = 'manufacturerslider';
        $this->tab = 'slideshows';
        $this->author = 'BOSS Themes';
        $this->version = 1.0;

        parent::__construct();

		$this->displayName = $this->l('Carousel of manufacturer/brand images');
        $this->description = $this->l('For Prestashop version 1.5. Displays a carousel of manufacturers/brands images in homepage. www.bossthemes.co.uk');
    }

    function install()
    {
        return (parent::install() AND $this->registerHook('Home'));
    }
   
    function hookHome($params)
    {
		global $smarty, $link;
		
		$smarty->assign(array(
			'manufacturers' => Manufacturer::getManufacturers(),
			'link' => $link,
			'text_list' => Configuration::get('MANUFACTURER_DISPLAY_TEXT'),
			'text_list_nb' => Configuration::get('MANUFACTURER_DISPLAY_TEXT_NB'),
			'form_list' => Configuration::get('MANUFACTURER_DISPLAY_FORM'),
		));
		return $this->display(__FILE__, 'manufacturerslider.tpl');                   
	}
}

?>
