<!-- ===================== Homepage Slider Module ============ -->
{if $page_name == 'index'} 
{if isset($tmhomeslider_slides)}
<div class="flexslider">
	<ul class="slides">
	{foreach from=$tmhomeslider_slides item=slide}
	{if $slide.active}
		<li>
			<a href="{$slide.url}" title="{$slide.title}">
				<img src="{$smarty.const._MODULE_DIR_}/tmhomeslider/images/{$slide.image}" alt="{$slide.title}" title="{$slide.title}" />
			</a>
		</li>
	{/if}
	{/foreach}
</ul>
</div>
{/if}
{/if}