/*
* 2007-2015 PrestaShop
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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2015 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

$(document).ready( function() {
							//alert(ajaxdestpath);
	$('#paybycardnet').click(function() {
		//disable the button after first click
		$('#paybycardnet').val("Processing, please wait...");
		$('#paybycardnet').prop("disabled", true);					  
		$.ajax({
			url: 'index.php?fc=module&module=cardnet&controller=ajaxorder&id_lang=1',
			method: "POST",
			dataType: "html",
			data: {},
			success: function(response){
				$result = $(response).filter('#oidval').val();
				$result2 = $(response).filter('#otimeval').val();
				$('#OrdenId').val($result);
				$('#transactionId').val($result2);
				$('#cardnetForm').submit();
		 	}
		});							  
	});
});


