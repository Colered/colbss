<!-- Block links module -->
<div id="tm_links_block2" class="block tm_links_block2">
	<p class="title_block">
	{if $url}
		<a href="{$url|escape}">{$title|escape}</a>
	{else}
		{$title|escape}
	{/if}
	</p>
	
	<div class="block_content">
		<ul class="bullet">
	{foreach from=$tmblocklink2_links item=tmblocklink2_link}
		{if isset($tmblocklink2_link.$lang)} 
			<li><a href="{$tmblocklink2_link.url|escape}"{if $tmblocklink2_link.newWindow} onclick="window.open(this.href);return false;"{/if}>{$tmblocklink2_link.$lang|escape}</a></li>
		{/if}
	{/foreach}
	</ul>
	</div>
</div>
<!-- /Block links module -->
