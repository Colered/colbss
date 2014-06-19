{if $page_name == 'index'}  
{if isset($tmsubbanner_slides)}
<div id="tm_subbanner">
	<div class="tm_subbennerinner">
	<ul>
	{foreach from=$tmsubbanner_slides item=slide name=SubBanner}
	{if $slide.active}
		<li>
			<a href="{$slide.url}" target="_blank">
				<img src="{$smarty.const._MODULE_DIR_}/tmsubbanner/images/{$slide.image}" alt="{$slide.title}" title="{$slide.title}" />
			</a>
		</li>
	{/if}
	{/foreach}
	</ul>
	</div>
</div>
{/if}
{/if}