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

{if $responseCode == '00'}
	<p>{l s='Your order on %s is complete.' sprintf=$shop_name mod='cardnet'}
		<br /><br /><strong>{l s='Your order reference is <b>%s</b>.' sprintf=$reference mod='cardnet'}</strong>
		<br /><br />{l s='An email has been sent to you with this information.' mod='cardnet'}
		<!--<br /><br /><strong>{l s='Your order will be sent as soon as we receive your payment.' mod='cardnet'}</strong>-->
		<br /><br />{l s='For any questions or for further information, please contact our' mod='cardnet'} <a href="{$link->getPageLink('contact', true)|escape:'html'}">{l s='customer service department.' mod='cardnet'}</a>.
	</p>
{else}
	<p class="warning">
		{l s='We have noticed that there is some problem with the payment. Please contact to your card provider or you can also contact our' mod='cardnet'} 
		<a href="{$link->getPageLink('contact', true)|escape:'html'}">{l s='customer service department.' mod='cardnet'}</a>.
	</p>
{/if}
