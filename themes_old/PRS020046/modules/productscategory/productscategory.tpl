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

{if count($categoryProducts) > 0 && $categoryProducts !== false}
<div class="clearfix blockproductscategory block products_block">
	<p class="productscategory_h2 title_block">{$categoryProducts|@count} {l s='other products in the same category:' mod='productscategory'}</p>
	<div id="productscategory_productblock">
	<div id="productscategory_productlist">

			<!-- Megnor start -->
			{assign var='sliderFor' value=6} <!-- Define Number of product for SLIDER -->
			{assign var='productCount' value=count($categoryProducts)}
			{if $productCount >= $sliderFor}
			<div class="customNavigation">
				<a class="btn prev">&nbsp;</a>
				<a class="btn next">&nbsp;</a>
			</div>
			{/if}
			<!-- Megnor End -->
	
		<ul id="{if $productCount >= $sliderFor}productscategory-carousel{else}productscategory-grid{/if}" class="{if $productCount >= $sliderFor}product-carousel{else}product_list{/if} clearfix">
			{foreach from=$categoryProducts item='categoryProduct' name=categoryProduct}
			<li  class="{if $productCount >= $sliderFor}slider-item{/if}">
<!-- Megnor Start -->
	<div class="product-block">
		<div class="product-inner">
<!-- Megnor End -->					
				<a href="{$link->getProductLink($categoryProduct.id_product, $categoryProduct.link_rewrite, $categoryProduct.category, $categoryProduct.ean13)}" class="lnk_img" title="{$categoryProduct.name|htmlspecialchars}"><img src="{$link->getImageLink($categoryProduct.link_rewrite, $categoryProduct.id_image, 'home_default')|escape:'html'}" alt="{$categoryProduct.name|htmlspecialchars}" />
				</a>
				<p class="product_name">
					<a href="{$link->getProductLink($categoryProduct.id_product, $categoryProduct.link_rewrite, $categoryProduct.category, $categoryProduct.ean13)|escape:'html'}" title="{$categoryProduct.name|htmlspecialchars}">{$categoryProduct.name|truncate:14:'...'|escape:'htmlall':'UTF-8'}</a>
				</p>
				{if $ProdDisplayPrice AND $categoryProduct.show_price == 1 AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}
				<p class="price_display">
					<span class="price">{convertPrice price=$categoryProduct.displayed_price}</span>
				</p>
				{else}
				
				{/if}
<!-- Megnor Start -->
</div>
</div>
<!-- Megnor End -->					
			</li>
			{/foreach}
		</ul>
	</div>
	
	</div>
	<span class="productcategory_default_width" style="display:none; visibility:hidden"></span>
	
</div>
{/if}
