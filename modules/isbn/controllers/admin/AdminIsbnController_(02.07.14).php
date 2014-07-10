<?php

class AdminIsbnController extends ModuleAdminController {

    public function __construct() {
        $this->bootstrap = true;
        $this->display = 'view';
        $this->meta_title = $this->l('ISBN');
        $this->context = Context::getContext();
        parent::__construct();
    }

    public function setMedia() {
        return parent::setMedia();
    }

    public function initToolBarTitle() {
        $this->toolbar_title[] = $this->l('Catalog');
        $this->toolbar_title[] = $this->l('ISBN');
    }

    public function initPageHeaderToolbar() {
        parent::initPageHeaderToolbar();
        unset($this->page_header_toolbar_btn['back']);
    }

    public function initToolbar() {
        /* $this->toolbar_btn['save'] = array(
          'href' => '#',
          'desc' => $this->l('Save')
          ); */

        return $this->toolbar_btn;
    }

    public function renderView() {
        /* if (version_compare(_PS_VERSION_, '1.5.6.0', '>'))
          $this->base_tpl_view = 'view_bt.tpl'; */

        $db = Db::getInstance();
        $result = $db->query('SELECT c.id_category, cl.name
							FROM ps_category c
							INNER JOIN ps_category_lang cl ON ( c.id_category = cl.id_category )
							WHERE c.level_depth <>0
							AND c.active = "1"
							GROUP BY c.id_category
							ORDER BY c.id_category,cl.name');
        $catArr = array();
        $z = 0;
        while ($row = $db->nextRow($result)) {
            $catTr = array();
            $catTr['id_category'] = $row['id_category'];
            $catTr['catName'] = $row['name'];

            $catArr[$z] = $catTr;
            $z++;
        }

        //print_r($dataTable);

        $this->context->smarty->assign(array(
            'catData' => $catArr
        ));

        return parent::renderView();
    }

    function preProcess() {

        parent::preProcess();

    }

    public function postProcess() {
        parent::postProcess();

        $index = count($this->_conf);

        $isbn_from_csv = false;
        $isbn_values = trim(Tools::getValue('isb_no'));
        $categories = Tools::getValue('categoryChk') ? Tools::getValue('categoryChk') : array();

        if(Tools::isSubmit('isbn_data') && $_FILES['csvUpload']['name'] != ""){
        	$csvfileData = $this->readCSVFile();
        	$isbn_from_csv = true;
        }

		$this->context->smarty->assign(array(
			'categoriesArr' => array()
		));

		$this->context->smarty->assign(array(
			'isbn_values' => ''
		));

        if(Tools::isSubmit('isbn_data') && $isbn_from_csv) {

			foreach($csvfileData as $csvRow)
			{
				$pre_insert_error = false;
				$dataRowArr = explode("#",$csvRow);
				if(trim($dataRowArr[0])<>""){
					$dataRowCategories = $dataRowArr[0];
				}
				if(trim($dataRowArr[1])<>""){
					$dataRowIsbn = str_replace("-","",$dataRowArr[1]);
				}
				$dataRowCategoriesArr = explode(",",$dataRowCategories);
				
				$z = 0;
				foreach($dataRowCategoriesArr as $catarr){
					$dataRowCategoriesArr[$z] = $catarr + 3;
				$z++;
				}
				//print"<pre>";print_r($dataRowIsbn);die;

				if (Tools::isSubmit('isbn_data') && (!is_array($dataRowCategoriesArr) || !count($dataRowCategoriesArr))) {
					$this->errors[] = Tools::displayError('Error: There is no category associated to ISBN '.$dataRowIsbn.' in CSV file.');
                    $pre_insert_error = true;
				}
				if (Tools::isSubmit('isbn_data') && !$dataRowIsbn) {
					$this->errors[] = Tools::displayError('Error: There is no ISBN associated to category "'.implode(',',$dataRowCategoriesArr).'" in CSV file.');
					$pre_insert_error = true;
				}

				if(!$pre_insert_error){
					$this->addProdByCSV($dataRowIsbn,$dataRowCategoriesArr);
				}
			}
			//if(empty($this->errors))
				//Tools::redirectAdmin(self::$currentIndex.'&conf='.$index.'&token='.$this->token);



        }else if(Tools::isSubmit('isbn_data') && !$isbn_from_csv){

			if (Tools::isSubmit('isbn_data') && (!is_array($categories) || !count($categories))) {
			   $this->errors[] = Tools::displayError('Error: You must choose at least one category.');
			}else{
			  $this->context->smarty->assign(array(
					'categoriesArr' => $categories
			  ));
			}
			if (Tools::isSubmit('isbn_data') && !$isbn_values) {
			   $this->errors[] = Tools::displayError('Error: Fill the comma separated ISBN values.');
			}else{
				 $this->context->smarty->assign(array(
						'isbn_values' => $isbn_values
				 ));
			}

			if(empty($this->errors)){

				$this->addProdByForm($isbn_values,$categories);

				$this->context->smarty->assign(array(
					'categoriesArr' => array()
				));

				$this->context->smarty->assign(array(
					'isbn_values' => ''
				));


               $_POST['categoryChk'] = array();
               $_POST['isb_no'] = '';

				//Tools::redirectAdmin(self::$currentIndex.'&conf='.$index.'&token='.$this->token);
			}
       }
    }

	protected function addProdByCSV($isbn_value,$categories)
	{
		  // get isbn
		  $isbn_val = trim($isbn_value);
		  if ($isbn_val <> "") {
              $this->addProdDataInDB($isbn_val, $categories);
		  }
	}


    protected function addProdByForm($isbn_values,$categories)
    {
		  $isbnArray = explode(",", $isbn_values);
		  if (count($isbnArray)) {
			  foreach ($isbnArray as $i => $k) {
				  // get isbn
				  $isbn_val = trim($k);
				  if ($isbn_val <> "") {
                     $this->addProdDataInDB($isbn_val, $categories);
				  }
			  }
		  }
    }

   protected function addProdDataInDB($isbn_val, $categories)
   {
          $id_lang = (int)(Configuration::get('PS_LANG_DEFAULT'));
		  //check if product already exist in selected category
		  foreach ($categories as $catid) {
			  //$sql = 'SELECT reference FROM ' . _DB_PREFIX_ . 'product WHERE reference="' . $isbn_val . '" AND id_category_default="' . $catid . '"';
			  $sql = 'SELECT COUNT(cp.`id_product`) AS total
						FROM `'._DB_PREFIX_.'product` p
						'.Shop::addSqlAssociation('product', 'p').'
						LEFT JOIN `'._DB_PREFIX_.'category_product` cp ON p.`id_product` = cp.`id_product`
						WHERE p.reference = "' . $isbn_val . '" AND cp.`id_category` = '.(int)$catid;
			  $isbn_exist = Db::getInstance()->getValue($sql);
			  if ($isbn_exist > 0) {
				  $catIDMatched[] = $catid;
			  } else {
				  $catIdArr[] = $catid;
			  }
		  }

		  if (!empty($catIDMatched)) {
			  $this->errors[] = Tools::displayError('Product with ISBN ' . $isbn_val . ' already exists in Category ID ' . implode(',', $catIDMatched));
		  }
		  if (!empty($catIdArr)) {

			  // Get your own accesskey at http://aws.amazon.com/
			  $metadata = $this->getDataFromAmazon($isbn_val);
			  //echo '<pre>';
			//  print_r($metadata);die;

			  if (isset($metadata->Items->Request->Errors)) {
				  $this->errors[] = Tools::displayError($metadata->Items->Request->Errors->Error->Message);
			  } else {
                  $large_image = '';
				  if(isset($metadata->Items->Item->ImageSets->ImageSet)){
				    $large_image = $metadata->Items->Item->ImageSets->ImageSet->LargeImage->URL;
				  }
				  $product_name = html_entity_decode($metadata->Items->Item->ItemAttributes->Title);
				  $final_price = substr($metadata->Items->Item->ItemAttributes->ListPrice->FormattedPrice, 1);
				  $item_weight = $metadata->Items->Item->ItemAttributes->ItemDimensions->Weight;

				  $item_desc = '';
				  if(isset($metadata->Items->Item->EditorialReviews->EditorialReview->Content)){
					$item_desc = substr(html_entity_decode($metadata->Items->Item->EditorialReviews->EditorialReview->Content),0,100).'...';
				  }

				  $meta_keywords = '';
				  $description_short = $item_desc;
				  $link_rewrite = "testprod";


				   $dataArr = array(
					 'isbn_val' => $isbn_val,
					 'final_price' =>$final_price,
					 'product_name' => $product_name,
					 'item_weight' => $item_weight,
					 'meta_keywords' => $meta_keywords,
					 'description_short' => $item_desc,
					 'link_rewrite' => $link_rewrite,
					 'description' => $item_desc
				   );

				   $prod_id = $this->addProducts($dataArr,$catIdArr);
				   if($prod_id<>""){
				      $this->informations[] = $this->l('ISBN '.$isbn_val.' added successfully.');
				   }

				   if(!empty($large_image) && $prod_id<>""){
				        $product_has_images = (bool)Image::getImages($id_lang, (int)$prod_id);
						$url = trim($large_image);
						$url = str_replace(' ', '%20', $url);
						$image = new Image();
						$image->id_product = (int)$prod_id;
						$image->position = Image::getHighestPosition($prod_id) + 1;
						$image->cover = (!$product_has_images) ? true : false;
						$image->add();

						if (!$this->copyImg($prod_id, $image->id, $url, 'products', !Tools::getValue('regenerate'))) {
						   $this->warnings[] = sprintf(Tools::displayError('Error copying image: %s'), $url);
						}
				   }

			  }
		  }

   }


    protected function getDataFromAmazon($isbn_val)
    {
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
			  'Version' => '2009-01-06'
		  );
		  ksort($args);
		  $parts = array();
		  foreach (array_keys($args) as $key) {
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

		  return $metadata;
    }

    protected function addProducts($dataArr, $catIdArr)
    {
          $index = count($this->_conf);

		  $shopID = (int) $this->context->shop->id;
		  $id_lang = (int)(Configuration::get('PS_LANG_DEFAULT'));

		  $prodObj = new Product();
		  $prodObj->price = $dataArr['final_price'];
		  //$prodObj->id_supplier = $SKU;
		  $prodObj->id_tax_rules_group = 1;
		  $prodObj->name = array($id_lang => $dataArr['product_name']);
		  //$prodObj->id_manufacturer = $SKU;
		  $prodObj->quantity = 0;
		  $prodObj->reference = $dataArr['isbn_val'];
		  $prodObj->minimal_quantity = 1;
		  $prodObj->additional_shipping_cost = 0;
		  $prodObj->wholesale_price = 0;
		  $prodObj->ecotax = 0;
		  $prodObj->width = 0;
		  $prodObj->height = 0;
		  $prodObj->depth = 0;
		  $prodObj->weight = $dataArr['item_weight'];
		  $prodObj->out_of_stock = 0;
		  $prodObj->active = 0;
		  //$prodObj->id_category_default = 3;
		  //$prodObj->category[] = array(4,5,6);
		  $prodObj->category = $catIdArr;
		  $prodObj->available_for_order = 1;
		  $prodObj->show_price = 1;
		  $prodObj->on_sale = 0;
		  $prodObj->meta_keywords = array($id_lang => $dataArr['meta_keywords']);
		  $prodObj->description_short = array($id_lang => $dataArr['description_short']);
		  $prodObj->link_rewrite = array($id_lang => $dataArr['link_rewrite']);
		  $prodObj->description = array($id_lang => $dataArr['description']);
		  //save the product
		  $prodObj->save();

		  $prodObj->updateCategories($prodObj->category, true);

		  //StockAvailable::setQuantity($prodObj->id, 0, 10);

          $this->_conf[$index]=$this->l('test');


         return $prodObj->id;
    }

	protected function readCSVFile()
	{
		$csvISBN = array();
		$categoryIsbnArr = array();
		// check there are no errors
		if($_FILES['csvUpload']['error'] == 0){
			$name = $_FILES['csvUpload']['name'];
			$fileext = explode('.', $name);
			$ext = strtolower(end($fileext));
			$type = $_FILES['csvUpload']['type'];
			$tmpName = $_FILES['csvUpload']['tmp_name'];

			// check the file is a csv
			if($ext === 'csv'){
				if(($handle = fopen($tmpName, 'r')) !== FALSE) {

					while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
						for ($i = 0; $i < count($data); $i++) {
							$csvISBN[] = $data[$i];
						}
  				    }
  				    for($j=2; $j < count($csvISBN); $j += 2){
                        $csvCategories = $csvISBN[$j];
                        $csvIsbn = $csvISBN[$j+1];
                        $categoryIsbnArr[] = $csvCategories.'#'.$csvIsbn;
  				    }
					fclose($handle);
				}

			} else {
			    $this->errors[] = Tools::displayError('Error: The file extention "'.$ext.'" not allowed.');
			}
	    }

	    return $categoryIsbnArr;
	}

	protected static function copyImg($id_entity, $id_image = null, $url, $entity = 'products', $regenerate = true)
	{
		  $tmpfile = tempnam(_PS_TMP_IMG_DIR_, 'ps_import');
		  $watermark_types = explode(',', Configuration::get('WATERMARK_TYPES'));

		  switch ($entity) {

			   case 'products':
					$image_obj = new Image($id_image);
					$path = $image_obj->getPathForCreation();
			   break;
		  }
		  $url = str_replace(' ', '%20', trim($url));
		  // Evaluate the memory required to resize the image: if it's too much, you can't resize it.
		  if (!ImageManager::checkImageMemoryLimit($url))
		   return false;

		  // 'file_exists' doesn't work on distant file, and getimagesize make the import slower.
		  // Just hide the warning, the traitment will be the same.
		  if (Tools::copy($url, $tmpfile)) {
			   ImageManager::resize($tmpfile, $path.'.jpg');
			   $images_types = ImageType::getImagesTypes($entity);

			   if ($regenerate)
					foreach ($images_types as $image_type) {
						 ImageManager::resize($tmpfile, $path.'-'.stripslashes($image_type['name']).'.jpg', $image_type['width'], $image_type['height']);
						 if (in_array($image_type['id_image_type'], $watermark_types))
						  Hook::exec('actionWatermark', array('id_image' => $id_image, 'id_product' => $id_entity));
					}
		  } else {
			   unlink($tmpfile);
			   return false;
		  }
		  unlink($tmpfile);
		  return true;
	 }
}
