<?php
class AdminFeaturedBrandsController extends ModuleAdminController
{
	public function __construct() {
		$this->table = 'brands';

		$this->addRowAction('view');
		$this->addRowAction('edit');
		$this->addRowAction('delete');

		$this->bulk_actions = array('delete' => array('text' => $this->l('Delete selected'), 'confirm' => $this->l('Delete selected items?')));


        $this->bootstrap = true;
        $this->display = 'view';
        $this->meta_title = $this->l('Featured Brands');
        $this->context = Context::getContext();

		$this->fields_list = array(
			'id_brand' => array('title' => $this->l('ID'), 'align' => 'center', 'width' => 25),
			'name' => array('title' => $this->l('Name'), 'width' => 'auto'),
			'active' => array('title' => $this->l('Enabled'), 'width' => 70, 'align' => 'center', 'active' => 'status', 'type' => 'bool', 'orderby' => false)
		);

        parent::__construct();
    }
	 public function setMedia() {
        return parent::setMedia();
    }
	public function initToolBarTitle() {
        $this->toolbar_title[] = $this->l('Catalog');
        $this->toolbar_title[] = $this->l('Featured Brands');
    }
	 public function initPageHeaderToolbar() {
        parent::initPageHeaderToolbar();
        unset($this->page_header_toolbar_btn['back']);
    }

    public function initToolbar() {
        return $this->toolbar_btn;
    }
	public function renderView() {
       
        return parent::renderView();
    }
	public function postProcess() {
		if (Tools::isSubmit('featured_brands'))
		{
			 $brand_name = trim(Tools::getValue('brand_name'));
			 $brand_desc = trim(Tools::getValue('brand_desc'));
			 $active = trim(Tools::getValue('active'));
			
			
			 if(!$brand_name)
				  $this->errors[] = Tools::displayError('Error: Please fill the brand name.');
			 if(!$brand_desc)
				$this->errors[] = Tools::displayError('Error: Please fill the brand description.');
			 if($brand_name && $brand_desc){
			 $result = Db::getInstance()->insert('brands', array(
				'name'      => pSQL($brand_name),
				 'date_add'  => date("Y-m-d H:i:s"),
				 'date_upd'  => date("Y-m-d H:i:s"),
				 'active'   => $active,
			));
			$this->context->smarty->assign( 'success',  'Brands are successfully added' );
			 }
			 
			 
		}
	}
	
}