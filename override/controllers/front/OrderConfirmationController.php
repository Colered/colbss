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
		//check if order file has already been generated for shipping
		$orderFileName = $_SERVER['DOCUMENT_ROOT']."/bookstore/docs/ffp/940_".$order->reference.'.txt';
		if (file_exists($orderFileName)) {
			//do nothing
		}else{
        	$this->createFile_940($order);
		}
	}
	public function createFile_940($order)
	{
			$order_invoice = new OrderInvoice((int)($this->id_order));
            $customer= new Customer((int)$order->id_customer);
			$address = new Address(intval($order->id_address_delivery));
			$state = State::getNameById($address->id_state);
			$carrier = new Carrier($order->id_carrier);
            $allProductInfo = $order->getProducts();
            $back_order_flag = (int)Configuration::get('PS_ORDER_OUT_OF_STOCK');
			$dataArrHDR = array(
			            '1'=>'HDR',
			            '2'=>'A',
						'3'=>'',
			            '4'=>'O',
						'5'=>'',
			            '6'=>date('mdY'),
			            '7'=>date('mdY'),
			            '8'=>'',
			            '9'=>'',
						'10'=>'',
			            '11'=>'',
			            '12'=>'A',
			            '13'=>'',
			            '14'=>'T',
						'15'=>'',
			            '16'=>$order->reference,
			            '17'=>'3RD',
			            '18'=>$address->firstname.' '.$address->lastname,
			            '19'=>$address->firstname.' '.$address->lastname,
			            '20'=>$address->address1,
			            '21'=>$address->address2,
			            '22'=>$address->city,
			            '23'=>strtoupper(substr($state, 0, 2)),
			            '24'=>$address->postcode,
			            '25'=>strtoupper(substr($address->country, 0, 3)),
			            '26'=>$address->phone,
			            '27'=>'',
			            '28'=>$customer->email,
			            '29'=>$address->firstname.' '.$address->lastname,
			            '30'=>$address->firstname.' '.$address->lastname,
			            '31'=>$address->address1,
			            '32'=>$address->address2,
			            '33'=>$address->city,
						'34'=>strtoupper(substr($state, 0, 2)),
						'35'=>$address->postcode,
			            '36'=>strtoupper(substr($address->country, 0, 3)),
			            '37'=>'',
			            '38'=>'',
			            '39'=>$customer->email,
			            '40'=>'','41'=>'','42'=>'','43'=>'','44'=>'','45'=>'','46'=>'','47'=>'','48'=>'',
			            '49'=>'','50'=>'','51'=>'','52'=>'','53'=>'','54'=>'','55'=>'','56'=>'','57'=>'',
			            '58'=>'','59'=>'','60'=>'','61'=>'','62'=>'','63'=>'','64'=>'','65'=>'','66'=>'',
			            '67'=>'','68'=>'','69'=>'','70'=>'','71'=>'','72'=>'','73'=>'','74'=>'','75'=>'',
			            '76'=>'','77'=>'','78'=>'','79'=>'',
						'80'=>date('mdY'),
						'81'=>'','82'=>'','83'=>'','84'=>'','85'=>'','86'=>'','87'=>'','88'=>'','89'=>'','90'=>'','91'=>'','92'=>'','93'=>''
			           );
			//prepare an array for all product details
			$dataArrDTL = array();
			foreach($allProductInfo as $productInfo){
			 $dataArrDTL[] = array('DTL',
			              $productInfo['product_id'], // its item-
			              '','', 
			              $productInfo['product_quantity'],'','',
						  'E',
						  '','','','','','','','','','','','','','','','','','',
			              '','','','','','','','','','','','','','','','','','',
						  '','','','','','','',
						  'A',
						  '',
						  $order->reference);
			}
			  // concate data with pipe for HDR
			  $dataHDR = '';
			  $dataString = '';
			  for($i=1;$i<=93;$i++){
			     $dataHDR .= $dataArrHDR[$i].'|';
			  }
			  // concate data with pipe for DTL
			  $dataDTL = '';
			 foreach($dataArrDTL as $dataArr){
				  for($i=0;$i<=53;$i++){
					 $dataDTL .= $dataArr[$i].'|';
				  }
				  $dataDTL .= PHP_EOL;
			  }

			$dataString .= $dataHDR.PHP_EOL.PHP_EOL;
			$dataString .= $dataDTL;
			$filename = '940_'.$order->reference.'.txt';
			//if filename doesnt exist create a new order file
			$filepath = $_SERVER['DOCUMENT_ROOT']."/bookstore/docs/ffp/sent/";
			$this->writeFile($filename,$dataString,$filepath);
	}
	public function writeFile($filename,$content,$filepath)
	{
        
		$as2filepath = $_SERVER['DOCUMENT_ROOT']."/mendelson/messages/fschad/outbox/cidot/";
		$fp = fopen($filepath.$filename,"w+");
		fwrite($fp,$content);
		fclose($fp);
		copy($filepath.$filename, $as2filepath.$filename);

	}


}

