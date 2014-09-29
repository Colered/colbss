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

<!-- Block currencies module -->
<div id="currencies_block_top">
	<form id="setCurrency" action="{$request_uri}" method="post">
		<p>
			<input type="hidden" name="id_currency" id="id_currency" value=""/>
			<input type="hidden" name="SubmitCurrency" value="" />
			<!--{l s='Currency' mod='blockcurrencies'} : {$blockcurrencies_sign}-->
			{$blockcurrencies_sign}
			<span class="top_downarrow">&nbsp;</span>
		</p>
		<ul id="first-currencies" class="currencies_ul">
			{foreach from=$currencies key=k item=f_currency}
				<li {if $cookie->id_currency == $f_currency.id_currency}class="selected"{/if}>
					<a href="javascript:setCurrency({$f_currency.id_currency});" title="{$f_currency.name}" rel="nofollow">{$f_currency.name}-{$f_currency.sign}</a>
				</li>
			{/foreach}
		</ul>
	</form>
</div>
<script type="text/javascript">
// Megnor Start
	var cur_block = new HoverWatcher('#currencies_block_top');
	var currencies_ul = new HoverWatcher('.currencies_ul');
	$("#currencies_block_top").click(function() {
		$("#currencies_block_top").addClass('active');
		$(".currencies_ul").slideToggle('slow');
		setTimeout(function() {
			if (!cur_block.isHoveringOver() && !currencies_ul.isHoveringOver())
				$(".currencies_ul").stop(true, true).slideUp(450);
				$("#currencies_block_top").removeClass('active');
		}, 4000);
	});
	
	$(".currencies_ul").hover(function() {
		setTimeout(function() {
			if (!cur_block.isHoveringOver() && !currencies_ul.isHoveringOver())
				$(".currencies_ul").stop(true, true).slideUp(450);
		}, 4000);
	});
// Megnor End	
</script>
<!-- /Block currencies module -->
