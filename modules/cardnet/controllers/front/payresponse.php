<?php
/*
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
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
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

/**
 * @since 1.5.0
 */
class CardnetPayresponseModuleFrontController extends ModuleFrontController
{
	public $ssl = true;
	public $display_column_left = false;

	/**
	 * @see FrontController::initContent()
	 */
	public function initContent()
	{
		parent::initContent();
		
		if(isset($_POST['ResponseCode ']) && ($_POST['ResponseCode '] !="") ){
			$responseCode = $_POST['ResponseCode '];
			//check if payment got successful, response code will be 00.
			if($responseCode=='00'){
				$creditCardNumber = isset($_POST['CreditCardNumber'])? $_POST['CreditCardNumber']:'';
				$authorizationCode  = isset($_POST['AuthorizationCode'])? $_POST['AuthorizationCode']:''; 
				$RetrivalReferenceNumber = isset($_POST['RetrivalReferenceNumber'])? $_POST['RetrivalReferenceNumber']:'';
				$ordenId = isset($_POST['OrdenId'])? $_POST['OrdenId']:'';
				$transactionId = isset($_POST['TransactionId'])? $_POST['TransactionId']:'';
				//update order status to successful payment
				$objOrder = new Order($ordenId); 
				$history = new OrderHistory();
				$history->id_order = (int)$objOrder->id;
				$order_reference = $objOrder->reference;
				$currentDateTime = date('Y-m-d h:i:s');
				if($order_reference !=""){
					$history->changeIdOrderState(2, (int)($objOrder->id)); //order status=2 for payment successful
					if($creditCardNumber !="" && $transactionId !=""){
						//update few fields related to order
						$sql = "UPDATE ps_order_payment SET `transaction_id`= $transactionId , `card_number`= $creditCardNumber WHERE order_reference = $order_reference";
						Db::getInstance()->execute($sql);
						//check if the order with same status doesnt exist:
						$sql3 = "SELECT * FROM ps_order_history WHERE id_order = $ordenId and id_order_state = 2";
						if ($row = Db::getInstance()->getRow($sql3)){ //do nothing
						}else{
							//create a new record in history table
							$sql2 = "INSERT INTO ps_order_history (id_order, id_order_state, date_add) VALUES($ordenId, 2, '$currentDateTime')";
							Db::getInstance()->execute($sql2);
						}
					}
				}
			}
		}
		
		$this->context->smarty->assign(array(
			'responseCode' => $responseCode,
			'reference' => $order_reference
		));
		$this->setTemplate('payment_response.tpl');
	}
}
