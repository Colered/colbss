</div>
{if $MENU != ''}
	
	<!-- Menu -->
	<div class="sf-contener nav-container clearfix">
		<ul id="main_menu" class="sf-menu clearfix">
			{$MENU}
			{if $MENU_SEARCH}
				<li class="sf-search noBack" style="float:right">
					<form id="searchbox" action="{$link->getPageLink('search')|escape:'html'}" method="get">
						<p>
							<input type="hidden" name="controller" value="search" />
							<input type="hidden" value="position" name="orderby"/>
							<input type="hidden" value="desc" name="orderway"/>
							<input type="text" name="search_query" value="{if isset($smarty.get.search_query)}{$smarty.get.search_query|escape:'htmlall':'UTF-8'}{/if}" />
						</p>
					</form>
				</li>
			{/if}
		</ul>
	</div>
	<div class="sf-right">&nbsp;</div>


	<script type="text/javascript">		
		$(document).ready(function(){
			$(".nav-button").click(function () {
			$(".primary-nav").toggleClass("open");
			$(this).parent().toggleClass('active').parent().find('.nav-button');
			});    
		});
	</script>

	<!-- Mobile Menu -->
	<div class="nav-container-mobile">
		<div class="nav-button main-but">
		<div class="tm_mobilemenu_text">{l s='Menu'}</div>
		<div class="tm_mobilemenu_img">&nbsp;</div>
	</div>	
		<ul id="main_menu_mobile" class="primary-nav tree dhtml">
			{$MENU}
		</ul>	
	</div>	
	<!--/ Menu -->
	<div class="header_bottom"></div>
{/if}