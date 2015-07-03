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

            if(count($isbnArray))
            {
			   // CSV first line for products
			   //$csv = "id;Active (0/1);Name*;Categories (x,y,z,...);Price tax excluded;Tax rules id;Wholesale price;On sale (0/1);Discount amount;Discount percent;Discount from (yyy-mm-dd);Discount to (yyy-mm-dd);Reference #;Supplier reference #;Supplier;Manufacturer;EAN13;UPC;Ecotax;Weight;Quantity;Short description;Description;Tags (x,y,z,...);Meta-title;Meta-keywords;Meta-description;URL rewritten;Text when in-stock;Text if back-order allowed;Available for order (0 = No, 1 = Yes);Product creation date;Show price (0 = No, 1 = Yes);Image URLs (x,y,z,...);Delete existing images (0 = No, 1 = Yes);Feature (Name:Value:Position);Available online only (0 = No, 1 = Yes);Condition (new,used,refurbished);ID / Name of shop".PHP_EOL;

			   //$csv = "id;Active (0/1);Name*;Categories (x,y,z,...);Price tax excluded;Wholesale price;EAN13;Weight;Quantity;Short description;Description;Available for order (0 = No, 1 = Yes);Product creation date;Show price (0 = No, 1 = Yes);Image URLs (x,y,z,...);ID / Name of shop".PHP_EOL;
			   //$csv = "ID;Photo;Name;Reference;Default shop;Base price;Final price;Quantity;Status;".PHP_EOL;

              foreach($isbnArray as $i=>$k)
              {
				// get isbn
				$isbn_val = trim($k);
				if($isbn_val<>"")
				{
					// Get your own accesskey at http://aws.amazon.com/
					//$awsAccessKeyID = 'AKIAIH7TISU3BP2FSLOA';
					//$awsSecretKey = '8h3Dw68q9lxwIGSqBzh0Ksc01NGQr4v2Ra9ax0Zz';
					//$awsAssociateTag = 'books';

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

					} else {
                       //echo '<pre>';
					   //print_r($metadata);
					   //print_r($metadata->Items->Item->ItemAttributes);


					   $shopID = (int)$this->context->shop->id;
					   $large_image = $metadata->Items->Item->ImageSets->ImageSet->LargeImage->URL;
					   $product_name = html_entity_decode($metadata->Items->Item->ItemAttributes->Title);
					   $final_price = substr($metadata->Items->Item->ItemAttributes->ListPrice->FormattedPrice,1);
					   $item_weight = $metadata->Items->Item->ItemAttributes->ItemDimensions->Weight;
					   //$item_desc = substr(html_entity_decode($metadata->Items->Item->EditorialReviews->EditorialReview->Content),0,100).'...';


					   $categoryID = 3;
                       $supplierID = 0;
                       $manufacturerID = 0;
                       $ean13 = 0;
                       $quantity = 10;
                       $cost = 150;
                       $wholesale = 100;
                       $weight = 10;
                       $active = 1;
                       $unique_key = '';


                       $id_lang = new Language((int)(Configuration::get('PS_LANG_DEFAULT')));


						$cat = new Category();
						$cat->name = array($id_lang => '1st Grade');
						$cat->id_parent = Configuration::get('PS_HOME_CATEGORY');
                        $cat->link_rewrite = array($id_lang =>  'cool-url');

					   /* Add a new product */
					   $object = new Product();
					   $object->link_rewrite = $cat->link_rewrite;
					   $object->price = 22;
					   $object->id_tax_rules_group = 0;
					   $object->name = 'test';
					   $object->id_manufacturer = 0;
					   $object->id_supplier = 0;
					   $object->quantity = 1;
					   $object->minimal_quantity = 1;
					   $object->additional_shipping_cost = 0;
					   $object->wholesale_price = 0;
					   $object->ecotax = 0;
					   $object->width = 0;
					   $object->height = 0;
					   $object->depth = 0;
					   $object->weight = 0;
					   $object->out_of_stock = 0;
					   $object->active = 0;
					   $object->id_category_default = 18;
					   //$object->category = 18;
					   $object->available_for_order = 0;
					   $object->show_price = 1;
					   $object->on_sale = 0;
					   $object->online_only = 1;
					   $object->meta_keywords = 'test';
					   if($object->save())
					       $object->add();
					   echo "produit ajouté";


					   //$csv = "ID;Photo;Name;Reference;Default shop;Base price;Final price;Quantity;Status;".PHP_EOL;
					   //$csv .= ";1;".$large_image.";".html_entity_decode($product_name).";;;".$final_price.";10;1;".PHP_EOL;
					   //$csv .=";1;".$product_name.";;".$final_price.";".$final_price.";".$isbn_val.";".$item_weight.";10;".$item_desc.";".$item_desc.";1;;1;".$large_image.";Fedena School".PHP_EOL;
                       //($db, $categoryID, $supplierID, $manufacturerID, $ean13, $quantity, $cost, $wholesale, $weight, $active, $unique_key)
					   //$prod_id[] = $this->add_product($categoryID, $supplierID, $manufacturerID, $ean13, $quantity, $cost, $wholesale, $weight, $active, $unique_key);

					}

                   //die;

			  }
			}
			//echo '<pre>';
			//print_r($prod_id);die;

           }

           // die;

        } else if (Tools::isSubmit('isbn_data') && !Tools::getValue('isb_no')){

           $this->errors[] = Tools::displayError('Error: Please fill the comma separated ISBN values.');
        }

    }

    // Adds a new product and returns its ID
	//$db, $categoryID, $manufacturerID, $ean13, $quantity, $cost, $weight, $active,
	public function add_product($categoryID, $supplierID, $manufacturerID, $ean13, $quantity, $cost, $wholesale, $weight, $active, $unique_key)
	{
        $db = Db::getInstance();

		$id = 0;
		$sql = "INSERT INTO ps_product(id_category_default, id_supplier, id_manufacturer, ean13, quantity, price, wholesale_price, weight, active) ";
		$sql = $sql . "VALUES($categoryID, $supplierID, $manufacturerID, '$ean13', $quantity, $cost, $wholesale, $weight, $active)";
		$result = $db->query($sql);
		$id =  $db->Insert_ID();
		//$db->freeResult($result);
		unset($result);
		unset($sql);
		return $id;
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
