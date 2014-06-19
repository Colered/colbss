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

{include file="$tpl_dir./breadcrumb.tpl"}
{include file="$tpl_dir./errors.tpl"}

{if isset($category)}
	{if $category->id AND $category->active}
		<h1>
			{strip}
				{$category->name|escape:'htmlall':'UTF-8'}
				{if isset($categoryNameComplement)}
					{$categoryNameComplement|escape:'htmlall':'UTF-8'}
				{/if}
			{/strip}
		</h1>
		
		
		{if $scenes || $category->description || $category->id_image}
		<div class="content_scene_cat">
			{if $scenes}
				<!-- Scenes -->
				{include file="$tpl_dir./scenes.tpl" scenes=$scenes}
			{else}
				<!-- Category image -->
				{if $category->id_image}
				<div class="align_center">
					<img src="{$link->getCatImageLink($category->link_rewrite, $category->id_image, 'category_default')|escape:'html'}" alt="{$category->name|escape:'htmlall':'UTF-8'}" title="{$category->name|escape:'htmlall':'UTF-8'}" id="categoryImage" width="{$categorySize.width}" height="{$categorySize.height}" />
				</div>
				{/if}
			{/if}

			{if $category->description}
				<div class="cat_desc">
					<p id="category_description_short">{$category->description}</p>
				</div>
			{/if}
		</div>
		{/if}
		{if isset($subcategories)}
		<!-- Subcategories -->
		<div id="subcategories" class="products_block">
			<h3>{l s='Subcategories'}</h3>
			<!-- Megnor start -->
			{assign var='sliderFor' value=3} <!-- Define Number of product for SLIDER -->
			{assign var='subCatCount' value=count($subcategories)}
			{if $subCatCount >= $sliderFor}
			<div class="customNavigation">
				<a class="btn prev">&nbsp;</a>
				<a class="btn next">&nbsp;</a>
			</div>
			{/if}
			<!-- Megnor End -->
			<ul id="{if $subCatCount >= $sliderFor}subcategory-carousel{elseif {count($subcategories)} == 2}subcategory2-grid{else}subcategory-grid{/if}" class="{if $subCatCount >= $sliderFor}product-carousel{else}subcategory_list{/if} clearfix">
			{foreach from=$subcategories item=subcategory}
				<li class="{if $subCatCount >= $sliderFor}slider-item{else}subcat-{$subCatCount}{/if}">
				<div class="inline_list">
					<a href="{$link->getCategoryLink($subcategory.id_category, $subcategory.link_rewrite)|escape:'htmlall':'UTF-8'}" title="{$subcategory.name|escape:'htmlall':'UTF-8'}" class="img">
						{if $subcategory.id_image}
							<img src="{$link->getCatImageLink($subcategory.link_rewrite, $subcategory.id_image, 'medium_default')|escape:'html'}" alt="" width="{$mediumSize.width}" height="{$mediumSize.height}" />
						{else}
							<img src="{$img_cat_dir}default-medium_default.jpg" alt="" width="{$mediumSize.width}" height="{$mediumSize.height}" />
						{/if}
					</a>
					<a href="{$link->getCategoryLink($subcategory.id_category, $subcategory.link_rewrite)|escape:'htmlall':'UTF-8'}" class="cat_name">{$subcategory.name|escape:'htmlall':'UTF-8'}</a>
					{if $subcategory.description}
						<p class="cat_desc">{$subcategory.description|truncate:30}</p>
					{/if}
					</div>
				</li>
			{/foreach}
			</ul>
			<br class="clear"/>
		</div>
		<span class="subcategory_default_width" style="display:none; visibility:hidden"></span>
		{/if}

		<!--<div class="resumecat category-product-count">-->
		{include file="$tpl_dir./category-count.tpl"}
		<!--</div>-->

		{if $products}
			<div class="content_sortPagiBar">
				<div class="sortPagiBar">
					{include file="./product-sort.tpl"}
					{include file="./nbr-product-page.tpl"}
				</div>
				
			</div>
			
			{include file="./product-list.tpl" products=$products}
			
			<div class="content_sortPagiBar">
				<div class="sortPagiBar_bottom">
					{include file="./product-compare.tpl" paginationId='bottom'}
					{include file="$tpl_dir./pagination.tpl" paginationId='bottom'}
				</div>
			</div>
			
		{/if}
		
	{elseif $category->id}
		<p class="warning">{l s='This category is currently unavailable.'}</p>
	{/if}
{/if}
