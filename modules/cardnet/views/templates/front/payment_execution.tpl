{*
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
*}



{capture name=path}{l s='CardNet' mod='cardnet'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<h2>{l s='Order summary' mod='cardnet'}</h2>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

{if isset($nbProducts) && $nbProducts <= 0}
	<p class="warning">{l s='Your shopping cart is empty.' mod='cardnet'}</p>
{else}
<h3>{l s='Payment Using CardNet' mod='cardnet'}</h3>
<script type="text/javascript" src="{$this_path_cardnet}views/js/cardnet.js"></script>
<form id="cardnetForm" method="post" action="https://cert.btrans.evertecinc.com/postwebbtrans/amexpostlog.php">

	<p>
		<img src="{$this_path_cardnet}cardnet.png" alt="{l s='Check' mod='cardnet'}" width="170" height="50" style="float:left; margin: 0px 10px 5px 0px;" />
		{l s='You have chosen to pay using CardNet.' mod='cardnet'}
		<br/><br />
		{l s='You will be redirected to the cardnet payment page.' mod='cardnet'}
	</p>
	<p style="margin-top:20px;">
		- {l s='The total amount of your order comes to:' mod='cardnet'}
		<span id="amount" class="price">{displayPrice price=$totaltoDisplay}</span>
		{if $use_taxes == 1}
			{l s='(tax incl.)' mod='cardnet'}
		{/if}
	</p>
	
<p><input name="TransactionType" value="0200" type="hidden"></p>
<p><input name="CurrencyCode" value="214" type="hidden"></p> 
<p><input name="AcquiringInstitutionCode" value="349" type="hidden"></p>
<p><input name="MerchantType" value="5440" type="hidden"></p>
<p><input name="MerchantNumber" value="349000000      " type="hidden"></p>
<p><input name="MerchantTerminal" value="256242374000" type="hidden"></p>

<!--<p><input name="ReturnUrl" value="http://209.208.79.76/bookstore/index.php?fc=module&module=cardnet&controller=payresponse&id_lang=1" type="hidden"></p>
<p><input name="CancelUrl" value="http://209.208.79.76/bookstore/index.php?controller=history" type="hidden"></p> -->

<p><input name="ReturnUrl" value="http://localhost/bookstore/index.php?fc=module&module=cardnet&controller=payresponse&id_lang=1" type="hidden"></p>
<p><input name="CancelUrl" value="http://localhost/bookstore/index.php?controller=history" type="hidden"></p> 

<p><input name="PageLanguaje" value="ENG" type="hidden"></p>

<p><input id ="OrdenId" name="OrdenId" value="" type="hidden"></p> 
<p><input id="transactionId" name="TransactionId" value="" type="hidden"></p>

<p><input name="Amount" value="{$total}" type="hidden"></p>
<p><input name="Tax" value="{$tax}" type="hidden"></p> 
<p><input name="MerchantName" value="COMERCIO PARA REALIZAR PRUEBAS        DO"  type="hidden"></p>
<p><input name="KeyEncriptionKey" value="{$keyEncriptionKey}" type="hidden"></p>
<p><input name="Ipclient" value="{$client_ip}" type="hidden"></p>
	<p class="cart_navigation" id="cart_navigation">
		<input type="button" id="paybycardnet" value="{l s='Pay Now' mod='cardnet'}" class="exclusive_large"/>
		<a href="{$link->getPageLink('order', true, NULL, "step=3")|escape:'html'}" class="button_large">{l s='Other payment methods' mod='cardnet'}</a>
	</p>
</form>
{/if}
