{if isset($tmrightbanner_slides)}
<div id="tm_rightbanner">
	<ul>
	{assign var='ItemsPerLine' value=1}
	{foreach from=$tmrightbanner_slides item=slide name=columnBanner}
	{if $slide.active}
		<li>
			<a href="{$slide.url}" target="_blank">
				<img src="{$smarty.const._MODULE_DIR_}/tmrightbanner/images/{$slide.image}" alt="{$slide.title}" title="{$slide.title}" />
			</a>
		</li>
	{/if}
	{/foreach}
	</ul>
</div>
{/if}
