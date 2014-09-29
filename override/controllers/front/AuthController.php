<?php
/*
* 2007-2011 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2011 PrestaShop SA
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class AuthController extends AuthControllerCore
{
	public function preProcess()
	{
		if (Tools::isSubmit('submitAccount') || Tools::isSubmit('submitGuestAccount'))
		{
			include_once(dirname(__FILE__).'/../../modules/avalaratax/avalaratax.php');
			$avalaraModule = new AvalaraTax();
			$avalaraModule->fixPOST();
		}

		parent::preProcess();
	}
	protected function processSubmitLogin()
	{
		Hook::exec('actionBeforeAuthentication');
		$passwd = trim(Tools::getValue('passwd'));
		$email = trim(Tools::getValue('email'));
		if (empty($email))
			$this->errors[] = Tools::displayError('An email address required.');
		elseif (!Validate::isEmail($email))
			$this->errors[] = Tools::displayError('Invalid email address.');
		elseif (empty($passwd))
			$this->errors[] = Tools::displayError('Password is required.');
		elseif (!Validate::isPasswd($passwd))
			$this->errors[] = Tools::displayError('Invalid password.');
		else
		{
			$customer = new Customer();
			$authentication = $customer->getByEmail(trim($email), trim($passwd));
			if (!$authentication || !$customer->id)
				$this->errors[] = Tools::displayError('Authentication failed.');
			else
			{

				$this->context->cookie->id_compare = isset($this->context->cookie->id_compare) ? $this->context->cookie->id_compare: CompareProduct::getIdCompareByIdCustomer($customer->id);
				$this->context->cookie->id_customer = (int)($customer->id);
				$this->context->cookie->customer_lastname = $customer->lastname;
				$this->context->cookie->customer_firstname = $customer->firstname;
				$this->context->cookie->logged = 1;
				$customer->logged = 1;
				$this->context->cookie->is_guest = $customer->isGuest();
				$this->context->cookie->passwd = $customer->passwd;
				$this->context->cookie->email = $customer->email;
				$this->addStoreAddress();
				// Add customer to the context
				$this->context->customer = $customer;

				if (Configuration::get('PS_CART_FOLLOWING') && (empty($this->context->cookie->id_cart) || Cart::getNbProducts($this->context->cookie->id_cart) == 0) && $id_cart = (int)Cart::lastNoneOrderedCart($this->context->customer->id))
					$this->context->cart = new Cart($id_cart);
				else
				{
					$this->context->cart->id_carrier = 0;
					$this->context->cart->setDeliveryOption(null);
					$this->context->cart->id_address_delivery = Address::getFirstCustomerAddressId((int)($customer->id));
					$this->context->cart->id_address_invoice = Address::getFirstCustomerAddressId((int)($customer->id));
				}
				$this->context->cart->id_customer = (int)$customer->id;
				$this->context->cart->secure_key = $customer->secure_key;
				$this->context->cart->save();
				$this->context->cookie->id_cart = (int)$this->context->cart->id;
				$this->context->cookie->write();
				$this->context->cart->autosetProductAddress();

				Hook::exec('actionAuthentication');

				// Login information have changed, so we check if the cart rules still apply
				CartRule::autoRemoveFromCart($this->context);
				CartRule::autoAddToCart($this->context);

				if (!$this->ajax)
				{
					if (($back = Tools::getValue('back')) && $back == Tools::secureReferrer($back))
						Tools::redirect(html_entity_decode($back));
					Tools::redirect('index.php?controller='.(($this->authRedirection !== false) ? urlencode($this->authRedirection) : 'my-account'));
				}
			}
		}
		if ($this->ajax)
		{
			$return = array(
				'hasError' => !empty($this->errors),
				'errors' => $this->errors,
				'token' => Tools::getToken(false)
			);
			die(Tools::jsonEncode($return));
		}
		else
			$this->context->smarty->assign('authentification_error', $this->errors);
	}
	protected function addStoreAddress()
	{
				$sql =Db::getInstance()->getRow('SELECT * FROM '._DB_PREFIX_.'shop_address WHERE id_shop='.$this->context->shop->id.'');
				$id_country=$sql['id_country'];
				$id_state=$sql['id_state'];
				$id_customer=$this->context->cookie->id_customer;
				$address1=$sql['address1'];
				$address2=$sql['address2'];
				$postcode=$sql['postcode'];
				$city=$sql['city'];
				$date_upd=strtotime($sql['date_upd']);
				$phone=$sql['phone'];
				$school_address="School address";

				$sql_alias =Db::getInstance()->ExecuteS('SELECT alias,date_upd FROM '._DB_PREFIX_.'address WHERE id_customer="'.$id_customer.'" and alias="'.$school_address.'"');
				if (Db::getInstance()->NumRows() && $date_upd >= strtotime($sql_alias[0]['date_upd'])){

						Db::getInstance()->execute("UPDATE "._DB_PREFIX_."address SET id_country = '".$id_country."',id_state = '".$id_state."',address1='".$address1."',address2='".$address2."',postcode='".$postcode."',city='".$city."',phone='".$phone."',date_upd = '".date("Y-m-d H:i:s")."' WHERE id_customer='".$id_customer."' and alias='".$school_address."'");


				}else{
					$insertData = array(
									'id_country'  => $id_country,
                             		'id_state'  => $id_state,
         							'id_customer'  => $id_customer,
        							'address1'   => $address1,
         							'address2'  => $address2,
		 							'postcode'  => $postcode,
		 							'city'  => $city,
									'phone'=>$phone,
		 							'alias'  => $school_address,
									'date_add' =>date("Y-m-d H:i:s")

		        				);

                   $inserted=Db::getInstance()->insert("address", $insertData);

				}

	}
}
