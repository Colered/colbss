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

<!-- MODULE Home Featured Products -->
<div id="featured-products_block_center" class="block products_block clearfix">
	<p class="title_block">{l s='Featured products' mod='homefeatured'}</p>
	{if isset($products) AND $products}
		<div class="block_content">
			
			<!-- Megnor start -->
			{assign var='sliderFor' value=50} <!-- Define Number of product for SLIDER -->
			{assign var='productCount' value=count($products)}
			{if $productCount >= $sliderFor}
			<div class="customNavigation">
				<a class="btn prev">&nbsp;</a>
				<a class="btn next">&nbsp;</a>
			</div>
			{/if}
			<!-- Megnor End -->
			
			<ul id="{if $productCount >= $sliderFor}featured-carousel{else}featured-grid{/if}" class="{if $productCount >= $sliderFor}product-carousel{else}product_list{/if} clearfix">
			{foreach from=$products item=product name=homeFeaturedProducts}
				
		<li class="ajax_block_product {if $productCount >= $sliderFor}slider-item{/if}">
				
<!-- Megnor Start -->
	<div class="product-block">
		<div class="product-inner">
<!-- Megnor End -->				
					<a href="{$product.link|escape:'html'}" title="{$product.name|escape:html:'UTF-8'}" class="product_image"><img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html'}" height="{$homeSize.height}" width="{$homeSize.width}" alt="{$product.name|escape:html:'UTF-8'}" />{if isset($product.new) && $product.new == 1}<span class="new">{l s='New' mod='homefeatured'}</span>{/if}</a>
					<p class="s_title_block"><a href="{$product.link|escape:'html'}" title="{$product.name|truncate:20:'...'|escape:'htmlall':'UTF-8'}">{$product.name|truncate:20:'...'|escape:'htmlall':'UTF-8'}</a></p>
					
					
					<!--<div class="product_desc"><a href="{$product.link|escape:'html'}" title="{l s='More' mod='homefeatured'}">{$product.description_short|strip_tags|truncate:65:'...'}</a></div>-->
					<div>
						<!--<a class="lnk_more" href="{$product.link|escape:'html'}" title="{l s='View' mod='homefeatured'}">{l s='View' mod='homefeatured'}</a>-->
						{if $product.show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}<p class="price_container"><span class="price">{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}</span></p>{else}<!--<div style="height:21px;"></div>-->{/if}
						
						{if ($product.id_product_attribute == 0 OR (isset($add_prod_display) AND ($add_prod_display == 1))) AND $product.available_for_order AND !isset($restricted_country_mode) AND $product.minimal_quantity == 1 AND $product.customizable != 2 AND !$PS_CATALOG_MODE}
							{if ($product.quantity > 0 OR $product.allow_oosp)}
							<a class="exclusive ajax_add_to_cart_button" rel="ajax_id_product_{$product.id_product}" href="{$link->getPageLink('cart')|escape:'html'}?qty=1&amp;id_product={$product.id_product}&amp;token={$static_token}&amp;add" title="{l s='Add to cart' mod='homefeatured'}">{l s='Add to cart' mod='homefeatured'}</a>
							{else}
							<span class="exclusive">{l s='Add to cart' mod='homefeatured'}</span>
							{/if}
						{else}
							<!--<div style="height:23px;"></div>-->
						{/if}
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
		<p class="no-products">{l s='No featured products' mod='homefeatured'}</p>
	{/if}
</div>
<span class="featured_default_width" style="display:none; visibility:hidden"></span>
<!-- /MODULE Home Featured Products -->