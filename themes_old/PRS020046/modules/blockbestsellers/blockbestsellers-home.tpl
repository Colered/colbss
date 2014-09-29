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

<!-- MODULE Home Block best sellers -->
<div id="best-sellers_block_center" class="block products_block clearfix">
	<p class="title_block"><a href="{$link->getPageLink('best-sales')|escape:'html'}" title="{l s='Top sellers' mod='blockbestsellers'}">{l s='Top sellers' mod='blockbestsellers'}</a></p>
	{if isset($best_sellers) AND $best_sellers}
		<div class="block_content">

			<!-- Megnor start -->
			{assign var='sliderFor' value=4} <!-- Define Number of product for SLIDER -->
			{assign var='productCount' value=count($best_sellers)}
			{if $productCount >= $sliderFor}
			<div class="customNavigation">
				<a class="btn prev">&nbsp;</a>
				<a class="btn next">&nbsp;</a>
			</div>
			{/if}
			<!-- Megnor End -->		
			
			<ul id="{if $productCount >= $sliderFor}bestseller-carousel{else}bestseller-grid{/if}" class="{if $productCount >= $sliderFor}product-carousel{else}product_list{/if} clearfix">
			{foreach from=$best_sellers item=product name=bestProducts}
				
	<li class="ajax_block_product {if $productCount >= $sliderFor}slider-item{/if}">
				
<!-- Megnor Start -->
	<div class="product-block">
		<div class="product-inner">
<!-- Megnor End -->						
					
					<a href="{$product.link|escape:'html'}" title="{$product.name|escape:html:'UTF-8'}" class="product_image"><img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html'}" height="{$homeSize.height}" width="{$homeSize.width}" alt="{$product.name|escape:html:'UTF-8'}" /></a>
					<p class="s_title_block"><a href="{$product.link|escape:'html'}" title="{$product.name|truncate:20:'...'|escape:'htmlall':'UTF-8'}">{$product.name|truncate:20:'...'|escape:'htmlall':'UTF-8'}</a></p>
					<!--<div class="product_desc"><a href="{$product.link|escape:'html'}" title="{l s='More' mod='blockbestsellers'}">{$product.description_short|strip_tags|truncate:130:'...'}</a></div>-->

					<div>
						{if !$PS_CATALOG_MODE}<p class="price_container"><span class="price">{$product.price}</span></p>{else}<!--<div style="height:21px;"></div>-->{/if}			
						<a class="button" href="{$product.link|escape:'html'}" title="{l s='View' mod='blockbestsellers'}">{l s='View' mod='blockbestsellers'}</a>
					</div>
<!-- Megnor Start -->
</div>
</div>
<!-- Megnor End -->						
				</li>
			{/foreach}
			</ul>
			
		</div>
	{else}
		<p class="no-products">{l s='No best sellers at this time' mod='blockbestsellers'}</p>
	{/if}
</div>
<span class="bestseller_default_width" style="display:none; visibility:hidden"></span>
<!-- /MODULE Home Block best sellers -->