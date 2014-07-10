<?php
/*
* 2007-2013 PrestaShop
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
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class OrderConfirmationController extends OrderConfirmationControllerCore
{

	/**
	 * Assign template vars related to page content
	 * @see FrontController::initContent()
	 */
	public function initContent()
	{
		parent::initContent();

        $order = new Order((int)($this->id_order));
        $this->createFile_940($order);

	}

	public function createFile_940($order)
	{

			$order_invoice = new OrderInvoice((int)($this->id_order));

            $customer= new Customer((int)$order->id_customer);

			$address = new Address(intval($order->id_address_delivery));
			$state = State::getNameById($address->id_state);

			$carrier = new Carrier($order->id_carrier);

            $productInfo = $order->getProducts();

            // get total products in this order
            $totalProdQty = 0;
            foreach($productInfo as $i=>$k){
               $totalProdQty += $k['product_quantity'];
            }

            $back_order_flag = (int)Configuration::get('PS_ORDER_OUT_OF_STOCK');

			$dataArrHDR = array(
			            '1'=>'HDR',
			            '2'=>'A',
			            '3'=>$order->id_customer,
			            '4'=>'O',
			            '5'=>date('mdY'),
			            '6'=>'',
			            '7'=>'',
			            '8'=>'', // not clear- Facility-its required field
			            '9'=>'',
			            '10'=>$address->address1,
			            '11'=>'',
			            '12'=>'A',
			            '13'=>'',
			            '14'=>'T',
			            '15'=>$carrier->delay[1],
			            '16'=>$order->reference,
			            '17'=>'3RD',
			            '18'=>$address->firstname.' '.$address->lastname,
			            '19'=>$address->firstname.' '.$address->lastname, // not clear
			            '20'=>$address->address1,
			            '21'=>$address->address2,
			            '22'=>$address->city,
			            '23'=>$state,
			            '24'=>$address->postcode,
			            '25'=>$address->country,
			            '26'=>$address->phone,
			            '27'=>'',
			            '28'=>$customer->email,
			            '29'=>$address->firstname.' '.$address->lastname,
			            '30'=>$address->firstname.' '.$address->lastname, // not clear
			            '31'=>$address->address1,
			            '32'=>$address->address2,
			            '33'=>$address->city,
						'34'=>$state,
						'35'=>$address->postcode,
			            '36'=>$address->country,
			            '37'=>$address->phone,
			            '38'=>'',
			            '39'=>$customer->email,
			            '40'=>'','41'=>'','42'=>'','43'=>'','44'=>'','45'=>'','46'=>'','47'=>'','48'=>'',
			            '49'=>'','50'=>'','51'=>'','52'=>'','53'=>'','54'=>'','55'=>'','56'=>'','57'=>'',
			            '58'=>'','59'=>'','60'=>'','61'=>'','62'=>'','63'=>'','64'=>'','65'=>'','66'=>'',
			            '67'=>'','68'=>'','69'=>'','70'=>'','71'=>'','72'=>'','73'=>'','74'=>'','75'=>'',
			            '76'=>'','77'=>'','78'=>'','79'=>'','80'=>'','81'=>'','82'=>'','83'=>'','84'=>'',
			            '85'=>'','86'=>'','87'=>'','88'=>'','89'=>'','90'=>'','91'=>'','92'=>'','93'=>''



			           );


			          $dataArrNTE = array(

			             '1'=>'NTE|BOL|IMPORTANT    orders cannot deliver more than 3',
						 '2'=>'NTE|BOL|calendar days early and cannot deliver past the',
						 '3'=>'NTE|BOL|requested delivery date. A 3% penalty will be',
						 '4'=>'NTE|BOL|incurred if the delivery schedule is not',
						 '5'=>'NTE|BOL|followed.If these dates are missed  the carrier',
						 '6'=>'NTE|BOL|MUST contact TRANSPLACE (3PL). Anything delivered',
						 '7'=>'NTE|BOL|outside of the four calendar day window (early or',
						 '8'=>'NTE|BOL|late) will be subject to reimbursement',
						 '9'=>'NTE|BOL|charges.       2 PACKING SLIPS REQUIRED FOR EACH',
						 '10'=>'NTE|BOL|SHIPMENT. 1 ATTACHED TO FREIGHT  1 ON BOL/GIVEN TO',
						 '11'=>'NTE|BOL|DRIVER.    MARK B/L: CARRIER SHOULD USE RETAIL',
						 '12'=>'NTE|BOL|LINK TO SCHEDULE DELIVERY APPTS.',
					     '13'=>'NTE|BOL|PO MUST APPEAR ON B/L  MANIFEST  & EACH CASE.'


			           );


			 $dataArrDTL = array(
			              '1'=>'DTL',
			              '2'=>'', // its item- not clear in case of multiple products ordered
			              '3'=>$order->reference, //its lot number --not clear
			              '4'=>'', // Unit of Measure -- not clear
			              '5'=>$totalProdQty,
			              '6'=>$back_order_flag,
			              '7'=>'','8'=>'','9'=>'','10'=>'','11'=>'','12'=>'','13'=>'','14'=>'','15'=>'','16'=>'',
			              '17'=>'','18'=>'','19'=>'','20'=>'','21'=>'','22'=>'','23'=>'','24'=>'','25'=>'','26'=>'',
			              '27'=>'','28'=>'','29'=>'','30'=>'','31'=>'','32'=>'','33'=>'','34'=>'','35'=>'','36'=>'',
			              '37'=>'','38'=>'','39'=>'','40'=>'','41'=>'','42'=>'','43'=>'','44'=>'','45'=>'','46'=>'',
			              '47'=>'','48'=>'','49'=>'','50'=>'','51'=>'','52'=>'','53'=>'','54'=>''

			            );




			  // concate data with pipe for HDR
			  $dataHDR = '';
			  $dataString = '';
			  for($i=1;$i<=93;$i++){
			     $dataHDR .= $dataArrHDR[$i].'|';
			  }
			  // concate data with pipe for NTE
			  $dataNTE = '';
			  for($i=1;$i<=13;$i++){
			     $dataNTE .= $dataArrNTE[$i].PHP_EOL;
			  }
			  // concate data with pipe for DTL
			  $dataDTL = '';
			  for($i=1;$i<=54;$i++){
			     $dataDTL .= $dataArrDTL[$i].'|';
			  }

			$dataString .= $dataHDR.PHP_EOL.PHP_EOL;
			$dataString .= $dataNTE.PHP_EOL;
			$dataString .= $dataDTL;

			$filename = '940_'.$order->reference.'.txt';
			$this->writeFile($filename,$dataString);


	}

	public function writeFile($filename,$content)
	{
        $filepath = $_SERVER['DOCUMENT_ROOT'] . "/bookstore/docs/ffp/";
		$fp = fopen($filepath.$filename,"w+");
		fwrite($fp,$content);
		fclose($fp);

	}


}

