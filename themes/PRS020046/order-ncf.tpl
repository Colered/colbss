{*
* 2007-2013 PrestaShop
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
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{if !$opc}
	<script type="text/javascript">
	//<![CDATA[
	var orderProcess = 'order';
	var currencySign = '{$currencySign|html_entity_decode:2:"UTF-8"}';
	var currencyRate = '{$currencyRate|floatval}';
	var currencyFormat = '{$currencyFormat|intval}';
	var currencyBlank = '{$currencyBlank|intval}';
	var txtProduct = "{l s='Product' js=1}";
	var txtProducts = "{l s='Products' js=1}";
	var orderUrl = '{$link->getPageLink("order", true)|addslashes}';

	var msg = "{l s='You must agree to the terms of service before continuing.' js=1}";
	{literal}
	function acceptCGV()
	{
		if ($('#cgv').length && !$('input#cgv:checked').length)
		{
			alert(msg);
			return false;
		}
		else
			return true;
	}
	{/literal}
	//]]>
	</script>
{else}
	<script type="text/javascript">
		var txtFree = "{l s='Free'}";
	</script>
{/if}

{if isset($virtual_cart) && !$virtual_cart && $giftAllowed && $cart->gift == 1}
<script type="text/javascript">
{literal}
// <![CDATA[
	function checkRadio(){
		if($('#ncf').is(":checked")){
			$('#ncftype1').attr("checked", "checked");
		}else{
			$('#ncftype1').removeAttr("checked");
		}
	}
//]]>
{/literal}
</script>
{/if}

{if !$opc}
	{capture name=path}{l s='Shipping:'}{/capture}
	{include file="$tpl_dir./breadcrumb.tpl"}
{/if}

{if !$opc}
	<div id="carrier_area">
{else}
	<div id="carrier_area" class="opc-main-block">
{/if}

{if !$opc}
	<h1>{l s='Fiscal Receipt Number'}</h1>
{else}
	<h2><span>3</span> {l s='Fiscal Receipt Number'}</h2>
{/if}
<div class="opc-main-block">
	<div class="addresses clearfix">
	<form id="form" action="{$link->getPageLink('order', true, NULL, "multi-shipping={$multi_shipping}")|escape:'html'}" method="post">
	<p class="checkbox">
		<input type="checkbox" name="ncf" id="ncf" value="1" onclick="checkRadio()" {if isset($oldName) && $oldName!=""}checked="checked"{/if} autocomplete="off"/>
		<label for="cgv">{l s='Do you want a NCF?'}</label>
	</p>
	<!-- Error return block -->
	<div id="opc_login_errors" class="error" style="display:none;"></div>
	<!-- END Error return block -->
	<div style="margin-left:40px;margin-bottom:5px;">
		<div style="float:left; width:235px;">{l s='Name Person or Business*:'}</div>
		<span><input type="text" class="required" {if !isset($oldName)} disabled="disabled" {/if} id="idperName" name="perName" size="50" value="{if isset($oldName)}{$oldName|escape:'htmlall':'UTF-8'}{/if}" /></span>
	</div>
	<div style="margin-left:40px;margin-bottom:5px;">
		<div style="float:left; width:235px;">{l s='ID* (Cedula or RNC):'}</div>
		<span><input type="text" class="required" {if !isset($oldName)} disabled="disabled" {/if} id="idrncId" name="rncId" size="50" value="{if isset($oldrnc_id)}{$oldrnc_id|escape:'htmlall':'UTF-8'}{/if}" /></span>
	</div>
	<div style="margin-left:40px;margin-bottom:5px;">
		<div style="float:left; width:235px;">{l s='Phone*:'}</div>
		<span><input type="text" class="required" {if !isset($oldName)} disabled="disabled" {/if} id="idphone" name="phone" size="50" value="{if isset($oldrnc_phone)}{$oldrnc_phone|escape:'htmlall':'UTF-8'}{/if}" /></span>
	</div>
	<div style="margin-left:40px;margin-bottom:5px;">
		<div style="float:left; width:235px;">{l s='Address*:'}</div>
		<span><input type="text" class="required" {if !isset($oldName)} disabled="disabled" {/if} id="idaddress" name="address" size="50" value="{if isset($oldrnc_address)}{$oldrnc_address|escape:'htmlall':'UTF-8'}{/if}" /></span>
	</div>
	<br />
	<div class="allradios" style="padding-left:100px;">
	<p><input class="ncftypecls" type="radio" {if !isset($oldName)} disabled="disabled" {/if} name="ncftype" id="ncftype1" {if isset($oldName) && $oldName!=""}checked="checked"{/if} value="{l s='Regular Person or Business'}" />{l s='Regular Person or Business'}</p>
	<div class="non-functioning" style="background-color:#F7F7F7; width:440px;">
	<p><input class="ncftypecls" type="radio" disabled="disabled" name="ncftype" id="ncftype2" value="{l s='Free Trade Zone?'}" />{l s='Free Trade Zone?'}</p>
	<p><input class="ncftypecls" type="radio" disabled="disabled" name="ncftype" id="ncftype3" value="{l s='Government Organization?'}" />{l s='Government Organization?'}</p>
	</div>
	</div>
	<div class="allradios">
	<div id="successDiv" style="display:none; color:#009900;">{l s='Saved successfully...'}</div>
	<input type="button" name="savencfdata" class="clssavencfdata" id="savencfdata" value="{l s='Save NCF Details'}" onclick="savencf()"   style="padding-right:100px; float:right ;position: relative; display: inline-block; padding: 0px 10px; line-height: 28px; width: auto; overflow: visible; font-weight: normal; outline: 0;color: #ffffff; -moz-border-radius: 3px; border-radius: 3px; border: 1px solid #cc9900; cursor: pointer; text-transform: capitalize; text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25); background-color: #5bb75b;background-image: linear-gradient(to bottom, #62c462, #51a351); background-repeat: repeat-x;"/>
	</div>

	</div>
	
</div>
</div>
<script type="text/javascript">
{literal}
// <![CDATA[
	function checkRadio(){
		if($('#ncf').is(":checked")){
			$('#ncftype1').parent().addClass('tm-selected');
			$('#ncftype2').parent().removeClass('tm-selected');
			$('#ncftype3').parent().removeClass('tm-selected');
			$('#idperName').removeAttr('disabled');
			$('#idrncId').removeAttr('disabled');
			$('#idphone').removeAttr('disabled');
			$('#idaddress').removeAttr('disabled');
		}else{
			$('#ncftype1').parent().removeClass('tm-selected');
			$('#ncftype2').parent().removeClass('tm-selected');
			$('#ncftype3').parent().removeClass('tm-selected');
			$('#idperName').val("");
			$('#idrncId').val("");
			$('#idphone').val("");
			$('#idaddress').val("");
			$('#idperName').attr('disabled', 'disabled');
			$('#idrncId').attr('disabled', 'disabled');
			$('#idphone').attr('disabled', 'disabled');
			$('#idaddress').attr('disabled', 'disabled');
			//delete the previously saved data for this cart
			$.ajax({
							type: 'POST',
							headers: { "cache-control": "no-cache" },
							url: orderOpcUrl + '?rand=' + new Date().getTime(),
							async: false,
							cache: false,
							dataType : "json",
								data: 'ajax=true&method=updateNcfData&perName='+encodeURIComponent($('#idperName').val())+'&rncId='+encodeURIComponent($('#idrncId').val())+'&idphone='+encodeURIComponent($('#idphone').val())+'&idaddress='+encodeURIComponent($('#idaddress').val())+'&token=' + static_token ,
							success: function(jsonData)
							{
								if (jsonData.hasError)
								{
									var errors = '';
									for(var error in jsonData.errors)
										//IE6 bug fix
										if(error !== 'indexOf')
											errors += $('<div />').html(jsonData.errors[error]).text() + "\n";
									alert(errors);
								}
							else{
								//$("#successDiv").show().delay(2000).fadeOut();
								}
							},
							error: function(XMLHttpRequest, textStatus, errorThrown) {
								if (textStatus !== 'abort')
									alert("TECHNICAL ERROR: unable to save NCF data \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
								//$('#opc_delivery_methods-overlay').fadeOut('slow');
							}
						});
		}
	}
//]]>
{/literal}
</script>