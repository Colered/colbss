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

{if isset($orderProducts) && count($orderProducts)}
<div id="crossselling" class="clearfix block products_block">
	<script type="text/javascript">var cs_middle = {$middlePosition_crossselling};</script>
	<p class="productscategory_h2 title_block">{l s='Customers who bought this product also bought:' mod='crossselling'}</p>
	<div id="crossselling_productblock">
		<div id="crossselling_productlist">
		
			<!-- Megnor start -->
			{assign var='sliderFor' value=6} <!-- Define Number of product for SLIDER -->
			{assign var='productCount' value=count($orderProducts)}
			{if $productCount >= $sliderFor}
			<div class="customNavigation">
				<a class="btn prev">&nbsp;</a>
				<a class="btn next">&nbsp;</a>
			</div>
			{/if}
			<!-- Megnor End -->
		
			<ul id="{if $productCount >= $sliderFor}crossselling-carousel{else}crossselling-grid{/if}" class="{if $productCount >= $sliderFor}product-carousel{else}product_list{/if} clearfix">
				{foreach from=$orderProducts item='orderProduct' name=orderProduct}
				<li  class="{if $productCount >= $sliderFor}slider-item{/if}">
<!-- Megnor Start -->
	<div class="product-block">
		<div class="product-inner">
<!-- Megnor End -->					
					<a href="{$orderProduct.link}" title="{$orderProduct.name|htmlspecialchars}" class="lnk_img"><img src="{$link->getImageLink($orderProduct.link_rewrite, $orderProduct.id_image, 'home_default')|escape:'html'}" alt="{$orderProduct.name|htmlspecialchars}" /></a>
					<p class="product_name"><a href="{$orderProduct.link}" title="{$orderProduct.name|htmlspecialchars}">{$orderProduct.name|truncate:15:'...'|escape:'htmlall':'UTF-8'}</a></p>
					{if $crossDisplayPrice AND $orderProduct.show_price == 1 AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}
						<span class="price_display">
							<span class="price">{convertPrice price=$orderProduct.displayed_price}</span>
						</span>
					{else}
						
					{/if}
					<!-- <a title="{l s='View' mod='crossselling'}" href="{$orderProduct.link}" class="button_small">{l s='View' mod='crossselling'}</a><br /> -->
<!-- Megnor Start -->
</div>
</div>
<!-- Megnor End -->						
				</li>
				{/foreach}
			</ul>
		</div>

	</div>
</div>
<span class="cross_default_width" style="display:none; visibility:hidden"></span>
{/if}
