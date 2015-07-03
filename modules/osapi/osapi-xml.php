<?php
/*
  osapi-xml.php

  OneSaas Connect API 1.0.6.4 for PrestaShop 1.5.0
  http://www.onesaas.com

  Copyright (c) 2012 oneSaas
  Version changes:
  1.0.6.1	- Attribute Id in Product generated like Code (e.g. <product_id>-<attribute_id>) if the product has attributes
	  		- Added StoreName:<store-name> in Tags element for Contacts request
  			- Added StoreName:<store-name> in Tags element for Orders request

  1.0.6.2	- Added XML encoding for text fields
			- Version attribute in Xml response is loaded dinamically from db

  1.0.6.3	- Updated support for pushing Shipping Tracking and Product Stock (both in batch mode and single mode) via xml requests
			- Added parsing LastUpdatedTime as UCT

  1.0.6.4	- Fixed update stock bug.  Remove check for stock to be positive as stock level can be also 0!!!
  
  1.0.6.5	- Changed Code from Proiduct-Id to Product Reference is not null otherwise Product Id
			- Added MAster Product in product.xml response
			- Added Product Variations support (Options)
  1.0.6.6	- Added total discount inc tax for orders
			- Added order shipping address
  1.0.6.7	- Added Address type "Billing" for all as Prestashop does not have a address type
  1.0.6.8	- Change plugin to manage stock update internally instead of relying on StockAvailable class
  1.0.6.9	- Mapped <ProductCode> to Reference field if not null otherwise Product_id
  1.0.6.10	- Mapped phone and phone_mobile to <WorkPhone> and <MobilePhone> respectively.
  1.0.6.11	- Fixed error in country iso code
  1.0.6.12	- Added Payments
*/

  // Functions
        function setStockQuantity($id_product, $id_product_attribute, $quantity, $id_shop = null)
	{
		if (!Validate::isUnsignedId($id_product))
			return false;

		$context = Context::getContext();

		// if there is no $id_shop, gets the context one
		if ($id_shop === null && Shop::getContext() != Shop::CONTEXT_GROUP)
			$id_shop = (int)$context->shop->id;

		$depends_on_stock = StockAvailable::dependsOnStock($id_product);

		//Try to set available quantity if product does not depend on physical stock
		if (!$depends_on_stock) {
			$id_stock_available = (int)StockAvailable::getStockAvailableIdByProductId($id_product, $id_product_attribute, $id_shop);
			if ($id_stock_available) {
				DB::getInstance()->Execute("update " . _DB_PREFIX_ . "stock_available set quantity='". $quantity ."' where id_stock_available = '" . $id_stock_available ."'");
			}
			else
			{
				$out_of_stock = StockAvailable::outOfStock($id_product, $id_shop);

				if ($id_shop === null)
					$shop_group = Shop::getContextShopGroup();
				else
					$shop_group = new ShopGroup((int)Shop::getGroupFromShop((int)$id_shop));
		
				// if quantities are shared between shops of the group
				if ($shop_group->share_stock)
				{
					$id_shop = 0;
					$id_shop_group = (int)$shop_group->id;
				}
				else
				{
					$id_shop_group = 0;
				}
				DB::getInstance()->Execute("insert into " . _DB_PREFIX_ . "stock_available (id_product, id_product_attribute, id_shop, id_shop_group, quantity, out_of_stock) values ('" . (int)$id_product . "', '" . (int)$id_product_attribute . "', '" . (int)$id_shop . "', '" . (int)$id_shop_group . "', '" . (int)$quantity . "', '" . (int)$out_of_stock . "')");
			}
			if ($id_product_attribute != 0) {
				// Update total quantity
				$total_quantity = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
					SELECT SUM(quantity) as quantity
					FROM '._DB_PREFIX_.'stock_available
					WHERE id_product = '.$id_product.'
					AND id_product_attribute <> 0 '.
					StockAvailable::addSqlShopRestriction(null, $id_shop)
				);
				setStockQuantity($id_product, 0, $total_quantity);
			}
		}
	}

	function parseSingleStockUpdateRequest (SimpleXmlElement $aRequest) {
		$stockUpdateRequest = array();
		if (!is_null($aRequest) && $aRequest->getName()==='ProductStockUpdate') {
			foreach ($aRequest->attributes() as $attr) {
				if ($attr->getName() === 'Id') {
					$stockUpdateRequest['ProductCode'] = $attr;
				}
			}
			foreach ($aRequest->children() as $child) {
				switch ($child->getName()) {
					case 'StockAtHand':
						$stockUpdateRequest['StockAtHand'] = $child;
						break;
					case 'StockAllocated':
						$stockUpdateRequest['StockAllocated'] = $child;
						break;
					case 'StockAvailable':
						$stockUpdateRequest['StockAvailable'] = (int) $child;
						break;
					default:
						// Not interested
						break;
				}
			}
			$stockUpdateRequest;
		}
		return $stockUpdateRequest;
	}
  //Initialization
  // load server configuration parameters
  	if (file_exists('../../config/config.inc.php')) {
		include('../../config/config.inc.php');
	}
	header('Content-type: application/xml; charset=utf-8');
	$pageSize = 10;
	$lang_id = Context::getContext()->language->id;
	if ($_SERVER['HTTPS']=='' || $_SERVER['HTTPS']=='off') {
		$base = 'http://' . $_SERVER['HTTP_HOST'] . __PS_BASE_URI__;
	} else {
		$base = 'https://' . $_SERVER['HTTP_HOST'] . __PS_BASE_URI__;
	}

  	// Parse input
	$AccessKey = (isset($_GET['AccessKey']) ? $_GET['AccessKey'] : '');
	$Page = ((isset($_GET['Page']) && (is_numeric($_GET['Page']))) ? (int) $_GET['Page'] : 0);
	$LastUpdatedTime = ((isset($_GET['LastUpdatedTime']) && (strtotime($_GET['LastUpdatedTime'])>0)) ? Date('Y-m-d H:i:s', strtotime($_GET['LastUpdatedTime'].'UCT')) : '1970-01-19T00:00:00+00:00');
	$action = (isset($_GET['Action']) ? $_GET['Action'] : '');

  	// 3) Initialise XML Response
  	$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><OneSaas></OneSaas>');
  	// Read version
	if ($os_version_result = DB::getInstance()->getRow("select value from " . _DB_PREFIX_ . "configuration where name= 'OSAPI_VERSION'")) {
		$os_version = $os_version_result['value'];
	}
	// In case of update $os_version in db changes only if they perform uninstall + install.  So just hardcoding version here
  	$xml->addAttribute('Version','1.0.6.12');
	//$xml->addAttribute('Version',$os_version);

  	// 4) Authenticate access
	$db  =Db::getInstance();
	$db->ExecuteS("select value from " . _DB_PREFIX_ . "configuration where name='OSAPI_ACCESS_KEY' and value='"  . $AccessKey . "'");
	if ($db->NumRows()==0) {
		// 5a) Prepare Error Response Message
		$xml->addChild('Error','Invalid Key');
	} else {
		// 5b) Fulfill request
		switch ($action) {
		    case "Contacts":
		    	$contacts = DB::getInstance()->ExecuteS("select * from " . _DB_PREFIX_ . "customer c left join " . _DB_PREFIX_ . "gender_lang g on c.id_gender=g.id_gender where (g.id_lang='" . $lang_id . "' or g.id_lang is null) and (c.date_add>'" . $LastUpdatedTime . "' or c.date_upd>'" . $LastUpdatedTime . "' ) limit " . $Page*$pageSize . ", " . $pageSize);
				foreach ($contacts as $contact ) {
					$xml_contact = $xml->addChild('Contact');
					$xml_contact->addAttribute('Id', $contact['id_customer']);
					$xml_contact->addAttribute('LastUpdated', max($contact['date_add'],$contact['date_upd']));
					$xml_contact->Salutation = $contact['name'];
					$xml_contact->FirstName = htmlspecialchars($contact['firstname']);
					$xml_contact->LastName = htmlspecialchars($contact['lastname']);
					$xml_contact->WorkPhone = '';
					$xml_contact->MobilePhone = '';
					$xml_contact->Email = htmlspecialchars($contact['email']);
					$xml_contact->OrganizationName = htmlspecialchars($contact['company']);
					$contactShop = Shop::getShop($contact['id_shop']);
					$xml_contact->Tags = 'StoreName:' . htmlspecialchars($contactShop['name']);
					$xml_addresses = $xml_contact->addChild('Addresses');
					$addresses = DB::getInstance()->ExecuteS("select a.*, co.iso_code as 'country_iso_code', s.name as 'state_name' from " . _DB_PREFIX_. "address a left join " . _DB_PREFIX_ . "country co on a.id_country=co.id_country left join " . _DB_PREFIX_ . "state s on a.id_state=s.id_state where a.id_customer = '" . $contact['id_customer'] ."'");
					foreach($addresses as $address) {
						// No address type available in Prestashop.  Assuming 'Billing' for all
						$xml_address = $xml_addresses->addChild('Address');
						$xml_address->addAttribute('Type', 'Billing');
						$xml_address->Line1 = htmlspecialchars($address['address1']);
						$xml_address->Line2 = htmlspecialchars($address['address2']);
						$xml_address->City = htmlspecialchars($address['city']);
						$xml_address->PostCode = $address['postcode'];
						$xml_address->State = htmlspecialchars($address['state_name']);
						$xml_address->CountryCode = $address['country_iso_code'];
						$xml_contact->WorkPhone = htmlspecialchars($address['phone']);
						$xml_contact->MobilePhone = htmlspecialchars($address['phone_mobile']);
					}
				}
		        break;
		    case "Products":
				$products = DB::getInstance()->ExecuteS("select p.id_product, p.reference, p.ean13, p.upc, p.date_add, p.date_upd, p.active, pl.name, pl.description, p.price from " . _DB_PREFIX_. "product p left join " . _DB_PREFIX_ . "product_lang pl on p.id_product=pl.id_product where (pl.id_lang='" . $lang_id . "' or pl.id_lang is null) and (p.date_add>'" . $LastUpdatedTime . "' or p.date_upd>'" . $LastUpdatedTime . "' ) limit " . $Page*$pageSize . ", " . $pageSize);
				foreach ($products as $product) {
					$code = $product['reference'];
					if (is_null($code) || $code=="") {
						$code = $product['id_product'];
					}
					// Add the Master Product first whether or not there are variations
					$xml_product = $xml->addChild('Product');
					$xml_product->addAttribute('Id', $product['id_product']);
					$xml_product->addAttribute('LastUpdated', max($product['date_add'],$product['date_upd']));
					($product['active']>0)?$xml_product->addAttribute('IsDeleted', 'false'):$xml_product->addAttribute('IsDeleted', 'true');
					$xml_product->Code = $code;
					$xml_product->Name = htmlspecialchars($product['name']);
					$xml_product->Description = htmlspecialchars(strip_tags($product['description']));
					($product['active']>0)?$xml_product->IsActive = 'true':$xml_productIsActive = 'false';
					$xml_product->PublicUrl = $base . 'index.php?controller=product&id_product=' . $product['id_product'];
					$xml_product->SalePrice = $product['price']*(Tax::getProductTaxRate($product['id_product']) + 100 )/100;
					$xml_product->StockAtHand = StockAvailable::getQuantityAvailableByProduct($product['id_product']);
					$xml_product->IsInventoried = 'true';
					$xml_product->Type = 'Product';
					// Check for Variations
					$attribute_ids = Product::getProductAttributesIds($product['id_product']);
					if (sizeof($attribute_ids)>0) {
						foreach ($attribute_ids as $attribute_id) {
							$attribute_code_query = DB::getInstance()->getRow("select pa.reference from " . _DB_PREFIX_. "product_attribute pa where pa.id_product_attribute = '" . (int) $attribute_id['id_product_attribute'] . "'");
							$attribute_code = $attribute_code_query['reference'];
							if (is_null($attribute_code) || $attribute_code=="") {
								$attribute_code = $product['id_product'] . '-' . $attribute_id['id_product_attribute'];
							}
							$xml_product = $xml->addChild('Product');
							$xml_product->addAttribute('Id', $product['id_product'] . '-' . $attribute_id['id_product_attribute']);
							$xml_product->addAttribute('LastUpdated', max($product['date_add'],$product['date_upd']));
							($product['active']>0)?$xml_product->addAttribute('IsDeleted', 'false'):$xml_product->addAttribute('IsDeleted', 'true');
							$xml_product->Code = $attribute_code;
							$xml_product->MasterCode = $code;
							$xml_product->Name = htmlspecialchars($product['name']);
							$attributeParams = Product::getAttributesParams($product['id_product'], $attribute_id['id_product_attribute']);
							if (sizeof($attributeParams)>0) {
							$xml_options = $xml_product->addChild('Options');
								foreach ($attributeParams as $attributeParam) {
									$xml_option = $xml_options->addChild('Option');
									$xml_option->Name = $attributeParam['group'];
									$xml_option->Value = $attributeParam['name'];
									$xml_product->Name .=  ' ' . htmlspecialchars($attributeParam['name']);
								}
							}
							$xml_product->Description = htmlspecialchars(strip_tags($product['description']));
							($product['active']>0)?$xml_product->IsActive = 'true':$xml_productIsActive = 'false';
							$xml_product->PublicUrl = $base . 'index.php?controller=product&id_product=' . $product['id_product'];
							$price_impact = Combination::getPrice($attribute_id['id_product_attribute']);
							$xml_product->SalePrice = ($product['price'] + $price_impact)*(Tax::getProductTaxRate($product['id_product']) + 100 )/100;
							$xml_product->StockAtHand = StockAvailable::getQuantityAvailableByProduct($product['id_product'],$attribute_id['id_product_attribute']);
							$xml_product->IsInventoried = 'true';
							$xml_product->Type = 'Product';
						}
					}
				}
		        break;
		    case "Orders":
		    	foreach (DB::getInstance()->ExecuteS("select o.id_order from " . _DB_PREFIX_. "orders o where (o.date_add>'" . $LastUpdatedTime . "' or o.date_upd>'" . $LastUpdatedTime . "' ) limit " . $Page*$pageSize . ", " . $pageSize) as $order) {
					$order_obj = new Order($order['id_order']);
					$xml_order = $xml->addChild('Order');
					$xml_order->addAttribute('Id', $order_obj->id);
					$xml_order->addAttribute('LastUpdated', max($order_obj->date_add,$order_obj->date_upd));
					//$xml_order->Object = print_r($order_obj,1);
					$xml_order->OrderNumber = $order_obj->id;
					$xml_order->Date = $order_obj->date_add;
					$xml_order->Type = 'Order';

					switch($order_obj->current_state) {
						//Available from osapi New|FullyPaid|Shipped|Cancelled|Refunded
						case 1: // Awaiting cheque payment
							$xml_order->Status = 'New';
							break;
						case 2: // Payment accepted
							$xml_order->Status = 'FullyPaid';
							break;
						case 3: // Preparation in progress
							$xml_order->Status = 'New';
							break;
						case 4: // Shipped
							$xml_order->Status = 'Shipped';
							break;
						case 5: // Delivered
							$xml_order->Status = 'Shipped';
							break;
						case 6: // Canceled
							$xml_order->Status = 'Cancelled';
							break;
						case 7: // Refund
							$xml_order->Status = 'Refunded';
							break;
						case 8: // Payment error
							$xml_order->Status = 'New';
							break;
						case 9: // On backorder
							$xml_order->Status = 'New';
							break;
						case 10: // Awaiting bank wire payment
							$xml_order->Status = 'New';
							break;
						case 11: // Awaiting PayPal payment
							$xml_order->Status = 'New';
							break;
						case 12: // Payment remotely accepted
							$xml_order->Status = 'FullyPaid';
							break;
					}
					$contactShop = Shop::getShop($order_obj->id_shop);
					$xml_order->Tags = 'StoreName:' . htmlspecialchars($contactShop['name']);

					$xml_order->Total = $order_obj->total_paid;
					$xml_order->Discounts = $order_obj->total_discounts_tax_incl;
					$xml_order->addChild('Contact')->addAttribute('Id', $order_obj->id_customer);
					// Shipping Address
					$shipping_address = new Address((int)$order_obj->id_address_delivery);
					if (isset($shipping_address) && $shipping_address != null) {
						$addresses = $xml_order->addChild('Addresses');
						$shipping_xml = $addresses->addChild('Address');
						$shipping_xml->addAttribute('type','Shipping');
						$shipping_xml->FirstName = $shipping_address->firstname;
						$shipping_xml->LastName = $shipping_address->lastname;
						$shipping_xml->OrganizationName = $shipping_address->company;
						$shipping_xml->Line1 = $shipping_address->address1;
						$shipping_xml->Line2 = $shipping_address->address2;
						$shipping_xml->City = $shipping_address->city;
						$shipping_xml->PostCode = $shipping_address->postcode;
						if ($shipping_zone = DB::getInstance()->getRow("select s.iso_code as 'state', co.iso_code as 'country' from " . _DB_PREFIX_. "address a left join " . _DB_PREFIX_ . "country co on a.id_country=co.id_country left join " . _DB_PREFIX_ . "state s on a.id_state=s.id_state where a.id_address = '" . (int)$order_obj->id_address_delivery ."'")) {
							$shipping_xml->State = $shipping_zone['state'];
							$shipping_xml->CountryCode = $shipping_zone['country'];
						}
					}
					
					// - Items
					$items = $xml_order->addChild('Items');
					foreach($order_obj->getProductsDetail() as $item_result) {
						$item = $items->addChild('Item');
						//$item->Obj = print_r($item_result,1);
						if ($item_result['product_attribute_id'] == 0) {
							$item->ProductId = $item_result['product_id'];
							//$product_code = DB::getInstance()->getRow("select p.reference from " . _DB_PREFIX_. "product p where p.product_id='" . (int) $item_result['product_id'] . "'");
							if (isset($item_result['reference']) && ($item_result['reference'] != null) && ($item_result['reference'] != '')) {
								$item->ProductCode = $item_result['reference'];
							} else {
								$item->ProductCode = $item_result['product_id'];
							}
						} else {
							$attribute_code = DB::getInstance()->getRow("select pa.reference from " . _DB_PREFIX_. "product_attribute pa where pa.id_product_attribute = '" . (int) $item_result['product_attribute_id'] . "'");
							$item->ProductId = $item_result['product_id'] . '-' . $item_result['product_attribute_id']; 
							if(isset($attribute_code['reference']) && ($attribute_code['reference'] != null) && ($attribute_code['reference'] != '')) {
								$item->ProductCode = $attribute_code['reference'];
							} else {
								$item->ProductCode = $item_result['product_id'] . '-' . $item_result['product_attribute_id'];
							}
						}
						$item->ProductName = htmlspecialchars($item_result['product_name']);
						$item->Quantity = $item_result['product_quantity'];
						$item->Price = $item_result['unit_price_tax_incl'];
						$item->UnitPriceExTax = $item_result['unit_price_tax_excl'];
						$item->Discount = $item_result['discount_quantity_applied'];
						if ($item_result['unit_price_tax_excl'] != $item_result['unit_price_tax_incl']) {
							$taxDetails = DB::getInstance()->ExecuteS("select odt.id_tax, t.rate, tl.name from " . _DB_PREFIX_ . "order_detail_tax odt left join " . _DB_PREFIX_ . "tax t on odt.id_tax=t.id_tax left join " . _DB_PREFIX_ . "tax_lang tl on t.id_tax=tl.id_tax where odt.id_order_detail='" . $item_result['id_order_detail'] . "' and tl.id_lang='" . $lang_id . "'");
							$itemTaxes = $item->addChild('Taxes');
							$itemTax = $itemTaxes->addChild('Tax');
							if (is_array($taxDetails) && sizeof($taxDetails)>0) {
								$itemTax->TaxName = htmlspecialchars($taxDetails[0]['name']);
								$itemTax->TaxRate = $taxDetails[0]['rate'];
							}
							$itemTax->TaxAmount = $item_result['total_price_tax_incl'] - $item_result['total_price_tax_excl'];
						}
						$item->LineTotalIncTax = $item_result['total_price_tax_incl'];
					}

					// - Shipping
					$shipping = $xml_order->addChild('Shipping');
					$carrier = new Carrier($order_obj->id_carrier);
					$shipping->addAttribute('Name', htmlspecialchars($carrier->name));
					$shipping->Amount = $order_obj->total_shipping_tax_incl;

					// - Payment
					$paymentRecords = DB::getInstance()->ExecuteS("select op.* from " . _DB_PREFIX_. "order_payment op where op.order_reference = '" . $order_obj->reference . "'");
					$payments = $xml_order->addChild('Payments');
					//$payments->Query = "select op.* from " . _DB_PREFIX_. "order_payment op where op.order_reference = '" . $order_obj->reference . "'";
					foreach($paymentRecords as $paymentRecord) {
						$paymentMethodXml = $payments->addChild('PaymentMethod');
						$paymentMethodXml->addAttribute('Name', htmlspecialchars($paymentRecord['payment_method']));
						$paymentMethodXml->MethodName = htmlspecialchars($paymentRecord['payment_method']);
						$paymentMethodXml->Amount = $paymentRecord['amount'];
						$paymentMethodXml->Date = $paymentRecord['date_add'];
						$paymentMethodXml->ReferenceNumber = $paymentRecord['id_order_payment'];
					}
					

				}
		        break;
		    case "Settings":
				$payment_modules = PaymentModule::getInstalledPaymentModules();
		    	if (sizeof($payment_modules)>0) {$payments = $xml->addChild('PaymentGateways');}
				foreach ($payment_modules as $paymentModule) {
					// Config file
					$configFile = _PS_MODULE_DIR_.$paymentModule['name'].'/config.xml';
					if (!file_exists($configFile)) {
						$payment = $payments->addChild('PaymentGateway');
						//$payment->Object = print_r($paymentModule, 1);
						$payment->Name = htmlspecialchars($paymentModule['name']);
						$payment->Description = '';
					} else {
						// Load config.xml
						libxml_use_internal_errors(true);
						$xml_module = simplexml_load_file($configFile);
						$payment = $payments->addChild('PaymentGateway');
						//$payment->Object = print_r($xml_module, 1);
						//$payment->Name = htmlspecialchars($xml_module->name);
						$payment->Name = htmlspecialchars($xml_module->displayName);
						$payment->Description = htmlspecialchars($xml_module->description);
					}
				}

				// TaxCodes
				$taxes = Tax::getTaxes($lang_id);
				if (sizeof($taxes)>0) {$tax_codes = $xml->addChild('TaxCodes');}
				foreach ($taxes as $tax) {
					$tax_code = $tax_codes->addChild('TaxCode');
					$tax_code->Name = htmlspecialchars($tax['name']);
					$tax_code->Rate = $tax['rate'];
				}

				// ShippingMethods
				$carriers = Carrier::getCarriers($lang_id);
				if (sizeof($carriers)>0) {$shipments = $xml->addChild('ShippingMethods');}
				foreach ($carriers as $carrier) {
					$shipment = $shipments->addChild('ShippingMethod');
					$shipment->Name = htmlspecialchars($carrier['name']);
					$shipment->Description = htmlspecialchars($carrier['delay']);
				}
		    	break;
		    case "UpdateStock":
				// Parse posted parameters StockUpdateId, ProductCode, StockAtHand, StockAllocated, StockAvailable
				$xmlRequest = new SimpleXmlElement(file_get_contents("php://input"));
                                
				$stockUpdateRequests = array();
				$batchMode='false';
				if ($xmlRequest->getName()==='ProductStockUpdate') {
					// Single product stock update
					$stockUpdateRequests[] = parseSingleStockUpdateRequest($xmlRequest);
				} elseif ($xmlRequest->getName()==='ProductStockUpdates') {
					// Multiple product stock update
					$batchMode='true';
					foreach ($xmlRequest->children() as $aXmlRequest) {
						$stockUpdateRequests[] = parseSingleStockUpdateRequest($aXmlRequest);
					}
				} else {
					// Wrong format
				}
                                
				$psus = ($batchMode=='true')?$xml->addChild('ProductStockUpdates'):'';
				foreach ($stockUpdateRequests as $stockUpdateRequest) {
					if ($batchMode=='true') {
						$psu = $psus->addChild('ProductStockUpdate');
						$psu->addAttribute('Id', $stockUpdateRequest['ProductCode']);
					} else {
						$psu = &$xml;
					}
                                        
					if ($stockUpdateRequest['ProductCode'] != ''){
						$product_elements = explode('-',$stockUpdateRequest['ProductCode']);
						try {
							if (sizeof($product_elements) == 1) {
								// Only product without attribute
								//StockAvailable::setQuantity($product_elements[0], 0, $stockUpdateRequest['StockAvailable']);
								setStockQuantity($product_elements[0], 0, $stockUpdateRequest['StockAvailable']);
                                DB::getInstance()->Execute("update " . _DB_PREFIX_ . "product set date_upd = NOW() where id_product = '" . $product_elements[0] ."'");
								$psu->addChild('Success', 'Operation Succeeded');
							} elseif (sizeof($product_elements) == 2) {
								// Product + attribute
								//StockAvailable::setQuantity($product_elements[0], $product_elements[1], $stockUpdateRequest['StockAvailable']);
								setStockQuantity($product_elements[0], $product_elements[1], $stockUpdateRequest['StockAvailable']);
                                DB::getInstance()->Execute("update " . _DB_PREFIX_ . "product set date_upd = NOW() where id_product = '" . $product_elements[0] ."'");
								$psu->addChild('Success', 'Operation Succeeded. Batch mode=' . $batchMode);
							} else {
								$psu->addChild('Error', 'Wrong Product Code: ' . $stockUpdateRequest['ProductCode']);
							}
						} catch (Exception $ex) {
							$psu->addChild('Error', 'Exception during update: ' . $ex);
						}
					} else {
						$psu->addChild('Error','Wrong Paramenters. ProductCode=' . $stockUpdateRequest['ProductCode'] . ' StockAvailable=' . $stockUpdateRequest['StockAvailable']);
					}
				}
		    	break;
		    case "ShippingTracking":
				// Parse posted parameters ShippingTrackingId, OrderNumber, Date, TrackingCode, CarrierCode, CarrierName, Notes
				$xmlRequest = new SimpleXmlElement(file_get_contents("php://input"));
				if ($xmlRequest->getName()==='OrderShippingTracking') {
					foreach ($xmlRequest->attributes() as $attr) {
						if ($attr->getName() === 'Id') {
							$OrderNumber = $attr;
						}
					}
					foreach ($xmlRequest->children() as $child) {
						switch ($child->getName()) {
							case 'OrderNumber':
								$OrderIncrementId = $child;
								break;
							case 'Date':
								$Date = $child;
								break;
							case 'TrackingCode':
								$TrackingCode = $child;
								break;
							case 'CarrierCode':
								$CarrierCode = $child;
								break;
							case 'CarrierName':
								$CarrierName = $child;
								break;
							case 'Notes':
								$Notes = $child;
								break;
							default:
								// Not interested
								break;
						}
					}
					if ($OrderNumber != '') {
						try {
							// Set order Status to 5: // Delivered
							$order_obj = new Order($OrderNumber);
							$order_obj->setCurrentState(5);
							$xml->addChild('Success', 'Operation Succeeded');
						} catch (Exception $ex) {
							$xml->addChild('Error','Update failed: ' . $ex);
						}
					} else {
						$xml->addChild('Error','Wrong Paramenters. OrderNumber=' . $OrderNumber);
					}
				} else {
					$xml->addChild('Error','Wrong xml request format');
				}
		    	break;
		    default:
				$xml->addChild('Error','Invalid Action Request');
		    	break;
		}
	}
 	// 6) Print XML Response
	print($xml->asXML());
?>