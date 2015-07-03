<?php

class AdminIsbnController extends ModuleAdminController
{
	public function __construct()
	{
		$this->bootstrap = true;
		$this->display = 'view';
		$this->meta_title = $this->l('ISBN');
		$this->context = Context::getContext();
		parent::__construct();
	}

	public function setMedia()
	{
		return parent::setMedia();
	}

	public function initToolBarTitle()
	{
		$this->toolbar_title[] = $this->l('Catalog');
		$this->toolbar_title[] = $this->l('ISBN');
	}

	public function initPageHeaderToolbar()
	{
		parent::initPageHeaderToolbar();
		unset($this->page_header_toolbar_btn['back']);

	}
	public function initToolbar()
	{
		/*$this->toolbar_btn['save'] = array(
			'href' => '#',
			'desc' => $this->l('Save')
		);*/

		return $this->toolbar_btn;
	}


	public function renderView()
	{
       	/*if (version_compare(_PS_VERSION_, '1.5.6.0', '>'))
			$this->base_tpl_view = 'view_bt.tpl';
        */
		return parent::renderView();
	}

    function preProcess()
    {

       parent::preProcess();

    }

    public function postProcess()
    {
        parent::postProcess();

        if (Tools::isSubmit('isbn_data') && Tools::getValue('isb_no'))
        {
            $isbn_values = Tools::getValue('isb_no');
            $isbnArray = explode(",", $isbn_values);
			$index = count($this->_conf);
			$catID = array(3, 4);
			$catIds = implode(",", $catID);
            if(count($isbnArray))
            {
              foreach($isbnArray as $i=>$k)
              {
				// get isbn
				$isbn_val = trim($k);
				if($isbn_val<>"")
				{
				//check if product already exist in selected category
				if($isbn_val != Db::getInstance()->getValue('SELECT reference FROM '._DB_PREFIX_.'product WHERE reference="'.$isbn_val.'" and id_category_default IN ("'.$catIds.'")'))
				{
					// Get your own accesskey at http://aws.amazon.com/
					$awsAccessKeyID = Configuration::get('AMAZON_ACCESS_KEY');
					$awsSecretKey = Configuration::get('AMAZON_SECRET_KEY');
					$awsAssociateTag = Configuration::get('AMAZON_ASSOCIATE_TAG');
					$host = 'ecs.amazonaws.com';
					$path = '/onca/xml';
					$args = array(
						'AssociateTag' => $awsAssociateTag,
						'AWSAccessKeyId' => $awsAccessKeyID,
						'IdType' => 'ISBN',
						'ItemId' => $isbn_val,
						'Operation' => 'ItemLookup',
						'ResponseGroup' => 'Medium',
						'SearchIndex' => 'Books',
						'Service' => 'AWSECommerceService',
						'Timestamp' => gmdate('Y-m-d\TH:i:s\Z'),
						'Version'=> '2009-01-06'
					);
					ksort($args);
					$parts = array();
					foreach(array_keys($args) as $key) {
						$parts[] = $key . "=" . $args[$key];
					}
					// Construct the string to sign
					$stringToSign = "GET\n" . $host . "\n" . $path . "\n" . implode("&", $parts);
					$stringToSign = str_replace('+', '%20', $stringToSign);
					$stringToSign = str_replace(':', '%3A', $stringToSign);
					$stringToSign = str_replace(';', urlencode(';'), $stringToSign);
					// Sign the request
					$signature = hash_hmac("sha256", $stringToSign, $awsSecretKey, TRUE);
					// Base64 encode the signature and make it URL safe
					$signature = base64_encode($signature);
					$signature = str_replace('+', '%2B', $signature);
					$signature = str_replace('=', '%3D', $signature);
					// Construct the URL
					$url = 'http://' . $host . $path . '?' . implode("&", $parts) . "&Signature=" . $signature;
					$rawData = @file_get_contents($url);
					$metadata = simplexml_load_string($rawData);
					if(isset($metadata->Items->Request->Errors)){
                       $this->errors[] = Tools::displayError($metadata->Items->Request->Errors->Error->Message);
					}else {
					   $shopID = (int)$this->context->shop->id;
					   $large_image = $metadata->Items->Item->ImageSets->ImageSet->LargeImage->URL;
					   $product_name = html_entity_decode($metadata->Items->Item->ItemAttributes->Title);
					   $final_price = substr($metadata->Items->Item->ItemAttributes->ListPrice->FormattedPrice,1);
					   $item_weight = $metadata->Items->Item->ItemAttributes->ItemDimensions->Weight;
					   //$item_desc = substr(html_entity_decode($metadata->Items->Item->EditorialReviews->EditorialReview->Content),0,100).'...';

						  $object = new Product();
						  $object->price = 100;
						  //$object->id_supplier = $SKU;
						  $object->id_tax_rules_group = 0;
						  $object->name = array(1=> $product_name);
						  //$object->id_manufacturer = $SKU;
						  $object->quantity = 1;
						  $object->reference =$isbn_val;
						  $object->minimal_quantity = 1;
						  $object->additional_shipping_cost = 0;
						  $object->wholesale_price =50;
						  $object->ecotax = 0;
						  $object->width = 0;
						  $object->height = 0;
						  $object->depth = 0;
						  $object->weight = 1;
						  $object->out_of_stock = 0;
						  $object->active = 1;
						  $object->id_category_default = 3;
						  $object->category=array(3);
						  $object->available_for_order = 1;
						  $object->show_price = 1;
						  $object->on_sale = 0;
						  $object->meta_keywords = "TEST META KEYWORDS";
						  $object->description_short = array(1 => "test product");
						  $object->link_rewrite = array(1 => "testprod");
						  $object->description = array(1 => "yes do it");
						  //save the product
						  $object->save();
						  $object->updateCategories($object->category, true);
						  $this->_conf[$index]=$this->l('test');
						  Tools::redirectAdmin(self::$currentIndex.'&conf='.$index.'&token='.$this->token);
						  //$this->context->smarty->assign( 'success', 'Products are successfully added' );
					}
			  }else{
			  			$catIDMatched = Db::getInstance()->getValue('SELECT id_category_default FROM '._DB_PREFIX_.'product WHERE reference="'.$isbn_val.'" and id_category_default IN ("'.$catIds.'")');
						$this->errors[] = Tools::displayError('Product with ISBN no '.$isbn_val.' already exists in Category ID '.$catIDMatched);
			  }}
			}
           }
        } else if (Tools::isSubmit('isbn_data') && !Tools::getValue('isb_no')){
           $this->errors[] = Tools::displayError('Error: Please fill the comma separated ISBN values.');
        }
    }

	protected static function createMultiLangField($field)
	{
		$languages = Language::getLanguages(false);
		$res = array();
		foreach ($languages as $lang)
			$res[$lang['id_lang']] = $field;
		return $res;
	}
}
