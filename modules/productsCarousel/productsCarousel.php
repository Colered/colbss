<?php
class productsCarousel extends Module
{
	private $_html = '';
	private $_postErrors = array();

	function __construct()
	{
		$this->name = 'productsCarousel';
		$this->tab = 'others';
		$this->version = '1.1';
		$this->author = 'Promokit Co.';
		$this->need_instance = 0;

		parent::__construct();

		$this->page = basename(__FILE__, '.php');
		$this->displayName = $this->l('Products Carousel on the homepage');
		$this->description = $this->l('Displays Products Carousel in Your Homepage');
	}

	function install()
	{
		if (!Configuration::updateValue('CAROUSEL_PRODUCTS_NUMBER', 8) OR 
			!Configuration::updateValue('PRODUCTS_TYPE', 1) OR 
			!Configuration::updateValue('PRODUCTS_VISIBLE', 6) OR 
			!Configuration::updateValue('PRODUCTS_TO_SCROLL', 2) OR
			!Configuration::updateValue('SHOW_PRICE', 0) OR
			!Configuration::updateValue('SHOW_FUNCBUTTONS', 1) OR 
			!Configuration::updateValue('CELL_WIDTH', 200) OR 
			!parent::install() OR 
			!$this->registerHook('header') OR
			!$this->registerHook('displayHome')
			) return false;
		return true;
	}


	public function uninstall()
	{
		return (parent::uninstall());
	}

	public function getContent()
	{
		$output = '<div style="width:800px; margin:0 auto"><h2>'.$this->displayName.'</h2>';
		if (Tools::isSubmit('submitHomeFeatured'))
		{
			Configuration::updateValue('PRODUCTS_TYPE', intval(Tools::getValue('products_type')));
			Configuration::updateValue('SHOW_PRICE', intval(Tools::getValue('show_price')));
			Configuration::updateValue('SHOW_FUNCBUTTONS', intval(Tools::getValue('show_funcbuttons')));
			$nbr = intval(Tools::getValue('nbr'));
			$products_visible = intval(Tools::getValue('products_visible'));
			$products_to_scroll = intval(Tools::getValue('products_to_scroll'));
			$cell_width = intval(Tools::getValue('cell_width'));
			if (!$nbr OR $nbr <= 0 OR !Validate::isInt($nbr))
				$errors[] = $this->l('Invalid number of products');
			else
				Configuration::updateValue('CAROUSEL_PRODUCTS_NUMBER', $nbr);  /*---------------------*/
			if (!$products_visible OR $products_visible <= 0 OR !Validate::isInt($products_visible))
				$errors[] = $this->l('Invalid number of visible products');
			else
				Configuration::updateValue('PRODUCTS_VISIBLE', $products_visible); /*---------------------*/
			if (!$products_to_scroll OR $products_to_scroll <= 0 OR !Validate::isInt($products_to_scroll))
				$errors[] = $this->l('Invalid number of visible products');
			else
				Configuration::updateValue('PRODUCTS_TO_SCROLL', $products_to_scroll);/*---------------------*/
			if (!$cell_width OR $cell_width <= 0 OR !Validate::isInt($cell_width))
				$errors[] = $this->l('Invalid number of visible products');
			else
				Configuration::updateValue('CELL_WIDTH', $cell_width);
			if (isset($errors) AND sizeof($errors))
				$output .= $this->displayError(implode('<br />', $errors));
			else
				$output .= $this->displayConfirmation($this->l('Settings updated'));
		}
		$output .= "</div>";
		return $output.$this->displayForm();
	}

	public function displayForm()
	{
		
		$output = '
	   	<form action="'.$_SERVER['REQUEST_URI'].'" method="post" style="width:800px; margin:0 auto">
			<fieldset><legend><img src="'.$this->_path.'logo.png" width="16" height="16" alt="" title="" />'.$this->l('Carousel settings').'</legend>
			<h4>Products type</h4>
				<div style="overflow:hidden">
				<label style="text-align:right; width:200px;">'.$this->l('Featured products').'</label><input type="radio" name="products_type" value="1" '.((Configuration::get('PRODUCTS_TYPE') == 1) ? 'checked="checked" ' : '').'/>
				</div>
				<div style="overflow:hidden">
				<label style="text-align:right; width:200px;">'.$this->l('New products').'</label>
						<input type="radio" name="products_type" value="0" '.((Configuration::get('PRODUCTS_TYPE') == 0) ? 'checked="checked" ' : '').'/>
				</div>
				<h4>Quantity Products</h4>
				<div style="overflow:hidden">
				<label style="text-align:right; width:200px;">'.$this->l('The number of all products').'</label>
					<input type="text" size="1" name="nbr" value="'.(Configuration::get('CAROUSEL_PRODUCTS_NUMBER')).'" />	
				</div>
				<br/>
				<div style="overflow:hidden">
				<label style="text-align:right; width:200px;">'.$this->l('The number of visible products').'</label>
					<input type="text" size="1" name="products_visible" value="'.(Configuration::get('PRODUCTS_VISIBLE')).'" />	
				</div>
				<br/>
				<div style="overflow:hidden">
				<label style="text-align:right; width:200px;">'.$this->l('The number of items to scroll').'</label>
					<input type="text" size="1" name="products_to_scroll" value="'.(Configuration::get('PRODUCTS_TO_SCROLL')).'" />	
				</div>	
				<br/>
				<h4>Show Product Prices</h4>
				<div style="overflow:hidden">
				<label style="text-align:right; width:200px;">'.$this->l('Show').'</label><input type="radio" name="show_price" value="1" '.((Configuration::get('SHOW_PRICE') == 1) ? 'checked="checked" ' : '').'/>
				</div>
				<div style="overflow:hidden">
				<label style="text-align:right; width:200px;">'.$this->l('Hide').'</label>
						<input type="radio" name="show_price" value="0" '.((Configuration::get('SHOW_PRICE') == 0) ? 'checked="checked" ' : '').'/>
				</div>
				<br><br>
				<h4>Show Functional Buttons</h4>
				<div style="overflow:hidden">
				<label style="text-align:right; width:200px;">'.$this->l('Show').'</label><input type="radio" name="show_funcbuttons" value="1" '.((Configuration::get('SHOW_FUNCBUTTONS') == 1) ? 'checked="checked" ' : '').'/>
				</div>
				<div style="overflow:hidden">
				<label style="text-align:right; width:200px;">'.$this->l('Hide').'</label>
						<input type="radio" name="show_funcbuttons" value="0" '.((Configuration::get('SHOW_FUNCBUTTONS') == 0) ? 'checked="checked" ' : '').'/>
				</div>
				<br><br>
				<div style="overflow:hidden">
				<label style="text-align:right; width:200px;">'.$this->l('Width of product\'s cell, px').'</label>
					<input type="text" size="1" name="cell_width" value="'.(Configuration::get('CELL_WIDTH')).'" />	
				</div>				
				<br/><br/>
				<input type="submit" name="submitHomeFeatured" value="'.$this->l('Save').'" class="button" />
			</fieldset>
      	</form>';
		return $output;
	}

	public function getAverageGrade($pid) {		
		//$comments = ProductComment_mod::getAverageGrade($pid);
		//return $comments;


		$validate = Configuration::get('PRODUCT_COMMENTS_MODERATE');

		return Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
		SELECT (SUM(pc.`grade`) / COUNT(pc.`grade`)) AS grade
		FROM `'._DB_PREFIX_.'product_comment` pc
		WHERE pc.`id_product` = '.(int)$pid.'
		AND pc.`deleted` = 0'.
		($validate == '1' ? ' AND pc.`validate` = 1' : ''));

	}

	public static function getCommentNumber($pid)
	{
		if (!Validate::isUnsignedId($pid))
			die(Tools::displayError());
		$validate = (int)Configuration::get('PRODUCT_COMMENTS_MODERATE');
		if (($result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
		SELECT COUNT(`id_product_comment`) AS "nbr"
		FROM `'._DB_PREFIX_.'product_comment` pc
		WHERE `id_product` = '.(int)($pid).($validate == '1' ? ' AND `validate` = 1' : ''))) === false)
			return false;
		return (int)($result['nbr']);
	}

	public static function isCustomerFavoriteProduct($id_customer, $id_product, Shop $shop = null)
	{
		if (!$id_customer)
			return false;

		if (!$shop)
			$shop = Context::getContext()->shop;

		return (bool)Db::getInstance()->getValue('
			SELECT COUNT(*)
			FROM `'._DB_PREFIX_.'favorite_product`
			WHERE `id_customer` = '.(int)$id_customer.'
			AND `id_product` = '.(int)$id_product.'
			AND `id_shop` = '.(int)$shop->id);
	}

	public function hookDisplayHome($params)
	{
			
		$err = "";
		$newProducts = Product::getNewProducts((int)($params['cookie']->id_lang), 0, (int)(Configuration::get('CAROUSEL_PRODUCTS_NUMBER')));

		$category = new Category(Context::getContext()->shop->getCategory(), Configuration::get('PS_LANG_DEFAULT'));
		$nb = (int)(Configuration::get('CAROUSEL_PRODUCTS_NUMBER'));
		$products = $category->getProducts($params['cookie']->id_lang, 1, ($nb ? $nb : 10));
		$products_visible = (int)(Configuration::get('PRODUCTS_VISIBLE'));
		$this->smarty->assign(array(
			'pth' => $this->_path,
			'featuredProducts' => $products,
			'new_products' => $newProducts,
			'products_type' => Configuration::get('PRODUCTS_TYPE'),
			'visible_products' => Configuration::get('PRODUCTS_VISIBLE'),
			'products_to_scroll' => Configuration::get('PRODUCTS_TO_SCROLL'),
			'show_price' => Configuration::get('SHOW_PRICE'),
			'show_funcbuttons' => Configuration::get('SHOW_FUNCBUTTONS'),
			'cell_width' => Configuration::get('CELL_WIDTH')			
		));

		if (Configuration::get('SHOW_FUNCBUTTONS') == 1) { // if buttons enabled

			if (Module::isInstalled("favoriteproducts")) { // check if module Favorite Products installed
				foreach ($products as $product => $value) {
					$id_p = $value["id_product"];
					$featuredFavorite[$id_p] = ($this->isCustomerFavoriteProduct($this->context->customer->id, $id_p) ? 1 : 0);
					$this->smarty->assign(array('featuredIsCustomerFavoriteProduct' => $featuredFavorite));	
				}
				foreach ($newProducts as $product => $value) {
					$id_p = $value["id_product"];
					$newFavorite[$id_p] = ($this->isCustomerFavoriteProduct($this->context->customer->id, $id_p) ? 1 : 0);
					$this->smarty->assign(array('newIsCustomerFavoriteProduct' => $newFavorite));
				}
			} else {
				$err .= "<div>Please install \"Favorite Products\" module</div>";
			}

			if (Module::isInstalled("productcomments")) { // check if module Product Comments installed
			    // Exists		  

				if (Configuration::get('PRODUCTS_TYPE') == 1) $pType = $products; else $pType = $newProducts;

			    foreach ($pType as $product => $value) {
			    
					$id_p = $value["id_product"];
					$p_comments_grade[$id_p] = $this->getAverageGrade($id_p);
					$p_comments_number[$id_p] = $this->getCommentNumber($id_p);

					if (empty($p_comments_grade[$id_p]['grade'])) $p_comments_grade[$id_p]['grade'] = 0; // if no rating, rating = 0

					$this->smarty->assign(array(
						'p_comments_grade' => $p_comments_grade,
						'p_comments_number' => $p_comments_number
					));
				}

			} else {
				$err .= "<div>Please install \"Product comments\" module</div>";
			}
		}

		$this->smarty->assign('errors', $err);

		return $this->display(__FILE__, 'productsCarousel.tpl');
	}

	public function hookDisplayHeader($params)
	{
		$this->context->controller->addCSS($this->_path.'css/productsCarousel.css', 'all');
		$category = new Category(Context::getContext()->shop->getCategory(), Configuration::get('PS_LANG_DEFAULT'));
		$nb = (int)(Configuration::get('CAROUSEL_PRODUCTS_NUMBER'));
		$products = $category->getProducts($params['cookie']->id_lang, 1, ($nb ? $nb : 10));
		$this->smarty->assign(array(
			'featuredProducts' => $products
		));
		return $this->display(__FILE__, 'header.tpl');
	}

	public function hookTop($params)
	{
		return $this->hookDisplayHome($params);
	}

}