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

    public function preProcess() {

        parent::preProcess();

    }

    public function postProcess() {
        parent::postProcess();

        $index = count($this->_conf);

        $isbn_from_csv = false;
        $isbn_by_form = false;
        $isbn_values = trim(Tools::getValue('isb_no'));
        if($isbn_values<>""){
           $isbn_by_form = true;
        }


        $categories = Tools::getValue('categoryChk') ? Tools::getValue('categoryChk') : array();

        if(Tools::isSubmit('isbn_data') && $_FILES['csvUpload']['name'] != ""){
        	$csvfileData = $this->readCSVFile();
			if(empty($csvfileData)){
				  $this->errors[] = Tools::displayError('Error: Category and ISBN not exist in CSV file.');
			}
        	$isbn_from_csv = true;
        }

		$this->context->smarty->assign(array(
			'categoriesArr' => array()
		));

		$this->context->smarty->assign(array(
			'isbn_values' => ''
		));

		if(Tools::isSubmit('isbn_data') && $isbn_from_csv && $isbn_by_form) {

		  $this->errors[] = Tools::displayError('Error: At a time you can choose either form or CSV file.');

		}else if(Tools::isSubmit('isbn_data') && $isbn_from_csv) {

			foreach($csvfileData as $csvRow)
			{
				$pre_insert_error = false;
				$dataRowCategories = '';
				$dataRowArr = explode("#",$csvRow);
				if(trim($dataRowArr[0])<>""){
					$dataRowCategories = $dataRowArr[0];
				}
				if(trim($dataRowArr[1])<>""){
					$dataRowIsbn = str_replace("-","",$dataRowArr[1]);
				}


				$dataRowCategoriesArr = explode(",",$dataRowCategories);

				$z = 0;
				$cat_not_exist = false;
				$cat_NotExistArr = array();
				foreach($dataRowCategoriesArr as $catarr){
					$dataRowCategoriesArr[$z] = $catarr;

					if(!$this->categoryExists($catarr)){
					   $cat_not_exist = true;
					   $cat_NotExistArr[] = $catarr;
					}

					$z++;
				}

				if($cat_not_exist){
                  $pre_insert_error = true;
				  $this->errors[] = Tools::displayError('Error: '.implode(',',$cat_NotExistArr).' Category not exist against the ISBN '.$dataRowIsbn.'.');

				}

				//print"<pre>";print_r($dataRowIsbn);die;

				if (Tools::isSubmit('isbn_data') && (!is_array($dataRowCategoriesArr) || !count($dataRowCategoriesArr))) {
					$this->errors[] = Tools::displayError('Error: There is no category associated to ISBN '.$dataRowIsbn.' in CSV file.');
                    $pre_insert_error = true;
				}
				if (Tools::isSubmit('isbn_data') && !$dataRowIsbn) {
					$this->errors[] = Tools::displayError('Error: There is no ISBN associated to category '.implode(',',$dataRowCategoriesArr).' in CSV file.');
					$pre_insert_error = true;
				}else if (Tools::isSubmit('isbn_data') && (strlen(trim($dataRowIsbn)) < 10 || !is_numeric(trim($dataRowIsbn)))) {
					$this->errors[] = Tools::displayError('Error: ISBN " '.$dataRowIsbn.' " is not valid.');
					$pre_insert_error = true;
				}

				if(!$pre_insert_error){
					$this->addProdByCSV($dataRowIsbn,$dataRowCategoriesArr);
				}
			}
			//if(empty($this->errors))
				//Tools::redirectAdmin(self::$currentIndex.'&conf='.$index.'&token='.$this->token);



        }else if(Tools::isSubmit('isbn_data') && $isbn_by_form){

			if (Tools::isSubmit('isbn_data') && (!is_array($categories) || !count($categories))) {
			   $this->errors[] = Tools::displayError('Error: You must choose at least one category.');
			}else{
			  $this->context->smarty->assign(array(
					'categoriesArr' => $categories
			  ));
			}
			if (Tools::isSubmit('isbn_data') && !$isbn_values) {
			   $this->errors[] = Tools::displayError('Error: Fill the comma separated ISBN values.');
			}else {
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
          //check isbn number in database
		   $result = $this->getReference($isbn_val);
		   if($result){
			   $this->errors[] = Tools::displayError('A Product with ISBN ' . $isbn_val . ' already exists in database');
		   }else{
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

				  $item_height = $metadata->Items->Item->ItemAttributes->ItemDimensions->Height/100;
				  $item_length = $metadata->Items->Item->ItemAttributes->ItemDimensions->Length/100;
				  $item_weight = $metadata->Items->Item->ItemAttributes->ItemDimensions->Weight/100;
				  $item_width = $metadata->Items->Item->ItemAttributes->ItemDimensions->Width/100;

				  $item_desc = '';
				  $item_desc_short = '';
				  if(isset($metadata->Items->Item->EditorialReviews->EditorialReview->Content)){
					$item_desc_short = substr(html_entity_decode($metadata->Items->Item->EditorialReviews->EditorialReview->Content),0,390).'...';
					$item_desc = html_entity_decode($metadata->Items->Item->EditorialReviews->EditorialReview->Content);
				  }

				  $meta_keywords = '';
				  $link_rewrite = "testprod";


				   $dataArr = array(
					 'isbn_val' => $isbn_val,
					 'final_price' =>$final_price,
					 'product_name' => $product_name,
					 'item_height' => $item_height,
					 'item_length' => $item_length,
					 'item_weight' => $item_weight,
					 'item_width' => $item_width,
					 'meta_keywords' => $meta_keywords,
					 'description_short' => $item_desc_short,
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
		  $prodObj->width = $dataArr['item_width'];
		  $prodObj->height = $dataArr['item_height'];
		  $prodObj->depth = $dataArr['item_length'];
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

          $prod_id = $prodObj->id;

		  // to do the search indesing
		  Search::indexation(false, $prod_id);


          $prodObj = null;
          unset($prodObj);


         return $prod_id;
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

	 /**
	 * Specify if a category already in base
	 *
	 * @param $id_category Category id
	 * @return boolean
	 */
	 public function categoryExists($id_category)
	 {
		 $row = Db::getInstance()->getRow('
		 SELECT `id_category`
		 FROM '._DB_PREFIX_.'category c
		 WHERE c.`id_category` = '.(int)$id_category);

		 return isset($row['id_category']);
    }

	public function getReference($reference)
	{
		$sql = "SELECT p.reference from ps_product p where p.reference ='".$reference."'";
		$res = Db::getInstance()->getValue($sql);
		return $res;
	}

}
