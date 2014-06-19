	<link rel="stylesheet" type="text/css" href="{$module_dir}css/skin.css"/>
	<script src="{$module_dir}js/jquery.jcarousel.min.js" type="text/javascript"></script>
    <script src="{$module_dir}js/slide.js" type="text/javascript"></script>
    
{if $manufacturers}
   <ul id="mycarousel" class="jcarousel-skin-tango">
      {foreach from=$manufacturers item='manufacturer' name=manufacturer}
		<li>
		<a href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)}" title="{$manufacturer.name|truncate:25:'...'|escape:'htmlall':'UTF-8'}"><img src="{$img_ps_dir}m/{$manufacturer.id_manufacturer}-small_default.jpg" alt="{$manufacturer.name|truncate:15:'...'|escape:'htmlall':'UTF-8'}" /></a>
		</li>
      {/foreach}
    </ul>
  

{/if}
