<?php
class AdminProductPermissionsController extends ModuleAdminController {

	 public function __construct() {
		$this->bootstrap = true;
		$this->display = 'view';
		$this->meta_title = $this->l('Product Permissions');
		$this->context = Context::getContext();
		parent::__construct();
	}
	public function setMedia() {
		return parent::setMedia();
	}

	public function initToolBarTitle() {
		$this->toolbar_title[] = $this->l('Catalog');
		$this->toolbar_title[] = $this->l('Product Permissions');
	}

	public function initPageHeaderToolbar() {
		parent::initPageHeaderToolbar();
		unset($this->page_header_toolbar_btn['back']);
	}

	public function initToolbar() {
		return $this->toolbar_btn;
	}

	public function renderView() {
		
		  if(!empty($_POST['profiles'])) {
			  //print_r($_POST);die;
			  $profile_name = trim(Tools::getValue('profiles'));
			  $sql = 'SELECT product_tabs from ps_profile_product_tabs where id_profile ='.$profile_name;
			  $res = Db::getInstance()->getValue($sql);
			  if($res){
				  $res = unserialize($res);
				   $this->context->smarty->assign(array(
					'profilename' => $profile_name
			  ));
			  $this->context->smarty->assign(array(
					'profilesArr' => $res
			  ));

			  }else{
					$res = unserialize($res);
				   $this->context->smarty->assign(array(
					'profilename' => $profile_name
			  ));

			  }
			  
				
			 // print"<pre>";print_r($res);die;

		 }
	    $db = Db::getInstance();
        $result = $db->query('SELECT p.id_profile,pl.name
							FROM ps_profile p
							INNER JOIN ps_profile_lang pl ON ( p.id_profile = pl.id_profile )
							GROUP BY p.id_profile
							ORDER BY p.id_profile');
		$profileArr = array();
		$z=0;
        while ($row = $db->nextRow($result)) {
            $profileArr[$z]['id_profile'] = $row['id_profile'];
            $profileArr[$z]['name'] = $row['name'];
			$z++;
        }

        $this->context->smarty->assign(array(
            'profileData' => $profileArr
        ));
       return parent::renderView();
    }
	function preProcess() {

        parent::preProcess();

    }

	public function postProcess() {
		$this->context->smarty->assign(array(
				'profilesArr' => array()
		   ));

		   $this->context->smarty->assign(array(
				'profilename' => ''
		   ));
		if (Tools::isSubmit('product_permissions_data'))
		{
			 $profile_name = trim(Tools::getValue('profiles'));
			 $profiles = Tools::getValue('profileChk') ? Tools::getValue('profileChk') : array();
			// print"<pre>";print_r($profile_name); echo "<br/>";print_r(serialize($profiles));die;
			$profilesArr = array();
			 if(!$profile_name){
				  $this->errors[] = Tools::displayError('Error: Please select the role from dropdown for which you want to add the permissions.');
				   $this->context->smarty->assign(array(
					'profilename' => ''
			  ));
			 }else{
				 $this->context->smarty->assign(array(
					'profilename' => $profile_name
			  ));
			 }

			if (Tools::isSubmit('product_permissions_data') && (!is_array($profiles) || !count($profiles))){
				$this->errors[] = Tools::displayError('Error: Please choose atleast 1 product tab.');
				$this->context->smarty->assign(array(
					'profilesArr' => array()
			  ));
			}
			else{
			  $this->context->smarty->assign(array(
					'profilesArr' => $profiles
			  ));
			}

			if(empty($this->errors)){
				$sql = 'SELECT product_tabs from ps_profile_product_tabs where id_profile ='.$profile_name;
				$res = Db::getInstance()->getValue($sql);
				if(!$res){
					$result = Db::getInstance()->insert('profile_product_tabs', array(
					'id_profile'      => $profile_name,
					'product_tabs'   => serialize($profiles),
					));
					$this->context->smarty->assign( 'success',  'Permissions are successfully added to selected users' );
				}
				else{
					Db::getInstance()->delete('profile_product_tabs', 'id_profile ='.$profile_name);
					$result = Db::getInstance()->insert('profile_product_tabs', array(
					'id_profile'      => $profile_name,
					'product_tabs'   => serialize($profiles),
					));
					$this->context->smarty->assign( 'success',  'Permissions are successfully edited to selected users' );

				}
			}		 
			 
		}
	}


  
}
