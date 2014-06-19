<!-- Block links module -->
<div id="tm_blocklink1_footer" class="block_footer">
	<p class="title_block">
	{if $url}
		<a href="{$url|escape}">{$title|escape}</a>
	{else}
		{$title|escape}
	{/if}
	</p>
	<ul class="block_content bullet">
	{foreach from=$tmblocklink1_links item=tmblocklink1_link}
		{if isset($tmblocklink1_link.$lang)} 
			<li><a href="{$tmblocklink1_link.url|escape}"{if $tmblocklink1_link.newWindow} onclick="window.open(this.href);return false;"{/if}>{$tmblocklink1_link.$lang|escape}</a></li>
		{/if}
	{/foreach}
	</ul>
</div>
<!-- /Block links module -->
