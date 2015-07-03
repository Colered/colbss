/*! Customized Jquery from Mahesh Vaghani.  mahesh@templatemela.com  : www.templatemela.com
Authors & copyright (c) 2013: TemplateMela - Megnor Computer Private Limited. */
// Megnor Start
var widthClassOptions = [];
var widthClassOptions = ({
		bestseller       : 'bestseller_default_width',
		newproduct       : 'tmnewproduct_default_width',
		featured         : 'featured_default_width',
		subcategory      : 'subcategory_default_width',
		accessories      : 'grid_default_width',
		crossselling     : 'cross_default_width',
		productscategory : 'productcategory_default_width',
		manufacturer     : 'brand_default_width'		
});
function setListGrid(ListOrGrid) { 
	if(ListOrGrid != 'list_view')
	{
		$("#product_list").addClass('grid_view');
		$("#product_list").removeClass('list_view');
		$("#view_as_grid").addClass('active');
		$("#view_as_list").removeClass('active');
		$.cookie("grid-list", 'grid_view');
	}else {
		$("#product_list").addClass('list_view');
		$("#product_list").removeClass('grid_view');
		$("#view_as_list").addClass('active');
		$("#view_as_grid").removeClass('active');
		$.cookie("grid-list", 'list_view');
	}
}
$(document).ready(function () {
							
	if ($.cookie("grid-list") != 'list_view') {
		$("#product_list").addClass('grid_view');
		$("#product_list").removeClass('list_view');
		$("#view_as_grid").addClass('active');
		$("#view_as_list").removeClass('active');

	} else {
		$("#product_list").addClass('list_view');
		$("#product_list").removeClass('grid_view');
		$("#view_as_list").addClass('active');
		$("#view_as_grid").removeClass('active');

	}	
	
	$('.informations_block_left ul li:first-child').addClass('first');
	$('.informations_block_left ul li:last-child').addClass('last');
	$('.sf-contener ul li:first-child').addClass('first');
	$('.sf-contener ul li:last-child').addClass('last');
	$('#reinsurance_block ul li:first-child').addClass('first');
	$('#reinsurance_block ul li:last-child').addClass('last');	
	
	$('.tm_links_block1 ul li:first-child').addClass('first');
	$('.tm_links_block1 ul li:last-child').addClass('last');
	$('.tm_links_block2 ul li:first-child').addClass('first');
	$('.tm_links_block2 ul li:last-child').addClass('last');
	$('.tm_links_block3 ul li:first-child').addClass('first');
	$('.tm_links_block3 ul li:last-child').addClass('last');
	$('.tm_links_block4 ul li:first-child').addClass('first');
	$('.tm_links_block4 ul li:last-child').addClass('last');
	$('#tm_subbanner ul li:first-child').addClass('first');
	$('#tm_topbanner ul li:first-child').addClass('first');
	$('#tm_bottombanner ul li:first-child').addClass('first');
	$('#tm_leftbanner ul li:first-child').addClass('first');
	$('#tm_rightbanner ul li:first-child').addClass('first');
		
	
	$('input[type="checkbox"]').tmMark(); 
	$('input[type="radio"]').tmMark();

	$('select.selectProductSort').customSelect();
	$('select#nb_item').customSelect();
	$('select#radiusSelect').customSelect();
	$('select#manufacturer_list').customSelect();
	$('select#supplier_list').customSelect();
	$('select.attribute_select').customSelect();
	$('select#wishlists').customSelect();

});
function hideListView(){
	if ($(window).width() < 768 )
	{	
		$("#product_list").addClass('grid_view');
		$("#product_list").removeClass('list_view');
		$("#view_as_grid").addClass('active');
		$("#view_as_list").removeClass('active');
		$.cookie("grid-list", 'grid_view');
		$("#view_as").css('display','none');
	}else{
		$("#view_as").css('display','block');
	}
}
$(document).ready(function(){hideListView();});
$(window).resize(function(){hideListView();});
//$(window).bind('resize', hideListView);

function mobileToggleMenu(){
	//alert($(window).width());
	if ($(window).width() < 980)
	{
		$('#footer .mobile_togglemenu').remove();
		$( "#footer .title_block" ).append( "<a class='mobile_togglemenu'>&nbsp;</a>" );
		$( "#footer .title_block" ).addClass('toggle');
		$("#footer .mobile_togglemenu").click(function(){
			$(this).parent().toggleClass('active').parent().find('ul').toggle('slow');
		});

	}else{
		$( "#footer .title_block" ).parent().find('ul').removeAttr('style');
		$( "#footer .title_block" ).removeClass('active');
		$( "#footer .title_block" ).removeClass('toggle');
		$('#footer .mobile_togglemenu').remove();
	}	
}
$(document).ready(function(){mobileToggleMenu();});
$(window).resize(function(){mobileToggleMenu();});
//$(window).bind('resize', mobileToggleMenu);

function mobileToggleColumn(){
	
	if ($(window).width() < 980){
		$('#right_column .mobile_togglecolumn,#left_column .mobile_togglecolumn').removeClass('clearfix');
		$('#right_column .mobile_togglecolumn,#left_column .mobile_togglecolumn').remove();
		$("#right_column .title_block" ).append( "<span class='mobile_togglecolumn'>&nbsp;</span>" );
		$("#left_column .title_block" ).append( "<span class='mobile_togglecolumn'>&nbsp;</span>" );
		$("#left_column .title_block" ).addClass('toggle');
		$("#right_column .title_block" ).addClass('toggle');
		$("#right_column .mobile_togglecolumn,#left_column .mobile_togglecolumn").click(function(){
			$(this).parent().toggleClass('active').parent().find('.block_content').toggle('slow');
		});
	}
	else{
		$("#right_column .title_block" ).parent().find('.block_content').removeAttr('style');
		$("#left_column .title_block" ).parent().find('.block_content').removeAttr('style');
		$("#left_column .title_block" ).removeClass('toggle');
		$("#right_column .title_block" ).removeClass('toggle');
		$("#left_column .title_block" ).removeClass('active');
		$("#right_column .title_block" ).removeClass('active');
		$('#right_column .mobile_togglecolumn').remove();
		$('#left_column .mobile_togglecolumn').remove();
	}
}
$(document).ready(function(){mobileToggleColumn();});
$(window).resize(function(){mobileToggleColumn();});
//$(window).bind('resize', mobileToggleColumn);
  
function tableMakeResponsive(){

	// CART  SUMMARY
	if ($(window).width() < 640){
		if($("table#cart_summary").length != 0) {
			if($("#order-cart-table").length == 0) {
				$('<div id="order-cart-table"></div>').insertBefore('#order-detail-content');
			}
			$('table#cart_summary').addClass("table-responsive");
			$('table#cart_summary thead').addClass("table-head");
			$('table#cart_summary tfoot').addClass("table-foot");
			$('table#cart_summary tr').addClass("row-responsive");
			$('table#cart_summary td').addClass("column-responsive clearfix");
			$("table#cart_summary").responsiveTable({prefix:'tm_responsive',target:'#order-cart-table'});
		}
	}else{
		if($("table#cart_summary").length != 0) {
			$('table#cart_summary').removeClass("table-responsive");
			$('table#cart_summary thead').removeClass("table-head");
			$('table#cart_summary tfoot').removeClass("table-foot");
			$('table#cart_summary tr').removeClass("row-responsive");
			$('table#cart_summary td').removeClass("column-responsive");
			$("#order-cart-table").remove();
		}
	}
	
	// ORDER  HISTORY
	if ($(window).width() < 640){
		if($("table#order-list").length != 0) {
			if($("#order-history-table").length == 0) {
				$('<div id="order-history-table"></div>').insertBefore('#block-history');
			}
			$('table#order-list').addClass("table-responsive");
			$('table#order-list thead').addClass("table-head");
			$('table#order-list tfoot').addClass("table-foot");
			$('table#order-list tr').addClass("row-responsive");
			$('table#order-list td').addClass("column-responsive clearfix");
			$("table#order-list").responsiveTable({prefix:'tm_responsive',target:'#order-history-table'});
		}
	}else{		
		if($("table#order-list").length != 0) {
			$('table#order-list').removeClass("table-responsive");
			$('table#order-list thead').removeClass("table-head");
			$('table#order-list tfoot').removeClass("table-foot");
			$('table#order-list tr').removeClass("row-responsive");
			$('table#order-list td').removeClass("column-responsive");
			$("#order-history-table").remove();
		}
	}
	
	// ORDER  HISTORY LOYALTy
	if ($(window).width() < 640){
		if($("table#order-list-loyalty").length != 0) {
			if($("#order-loyalty-table").length == 0) {
				$('<div id="order-loyalty-table"></div>').insertBefore('#block-history-loyalty');
			}
			$('table#order-list-loyalty').addClass("table-responsive");
			$('table#order-list-loyalty thead').addClass("table-head");
			$('table#order-list-loyalty tfoot').addClass("table-foot");
			$('table#order-list-loyalty tr').addClass("row-responsive");
			$('table#order-list-loyalty td').addClass("column-responsive clearfix");
			$("table#order-list-loyalty").responsiveTable({prefix:'tm_responsive',target:'#order-loyalty-table'});
		}
	}else{		
		if($("table#order-list-loyalty").length != 0) {
			$('table#order-list-loyalty').removeClass("table-responsive");
			$('table#order-list-loyalty thead').removeClass("table-head");
			$('table#order-list-loyalty tfoot').removeClass("table-foot");
			$('table#order-list-loyalty tr').removeClass("row-responsive");
			$('table#order-list-loyalty td').removeClass("column-responsive");
			$("#order-loyalty-table").remove();
		}
	}
	
	
	// VOUCHER
	if ($(window).width() < 640){	
		if($("#discount table.std").length != 0) {
			if($("#discount-table").length == 0) {
				$('<div id="discount-table"></div>').insertBefore('table.discount ');
			}
			$('#discount table.std').addClass("table-responsive");
			$('#discount table.std thead').addClass("table-head");
			$('#discount table.std tfoot').addClass("table-foot");
			$('#discount table.std tr').addClass("row-responsive");
			$('#discount table.std td').addClass("column-responsive clearfix");
			$("#discount table.std").responsiveTable({prefix:'tm_responsive',target:'#discount-table'});
		}
	}else{
		if($("#discount table.std").length != 0) {
			$('#discount table.std').removeClass("table-responsive");
			$('#discount table.std thead').removeClass("table-head");
			$('#discount table.std tfoot').removeClass("table-foot");
			$('#discount table.std tr').removeClass("row-responsive");
			$('#discount table.std td').removeClass("column-responsive");
			$("#discount-table").remove();
		}
	}
	
	// WISHLIST
	if ($(window).width() < 640){	
		if($("#mywishlist table.std").length != 0) {
			if($("#wishlist-table").length == 0) {
				$('<div id="wishlist-table"></div>').insertBefore('#block-history');
			}
			$('#mywishlist table.std').addClass("table-responsive");
			$('#mywishlist table.std thead').addClass("table-head");
			$('#mywishlist table.std tfoot').addClass("table-foot");
			$('#mywishlist table.std tr').addClass("row-responsive");
			$('#mywishlist table.std td').addClass("column-responsive clearfix");
			$("#mywishlist table.std").responsiveTable({prefix:'tm_responsive',target:'#wishlist-table'});
		}
	}else{
		if($("#mywishlist table.std").length != 0) {
			$('#mywishlist table.std').removeClass("table-responsive");
			$('#mywishlist table.std thead').removeClass("table-head");
			$('#mywishlist table.std tfoot').removeClass("table-foot");
			$('#mywishlist table.std tr').removeClass("row-responsive");
			$('#mywishlist table.std td').removeClass("column-responsive");
			$("#wishlist-table").remove();
		}
	}
	
	// ORDER DETAILS 
	if ($(window).width() < 640){	
		if($("#order-detail-content table.std").length != 0) {
			if($("#order-detail-table").length == 0) {
				$('<div id="order-detail-table"></div>').insertBefore('#order-detail-content');
			}
			$('#order-detail-content table.std').addClass("table-responsive");
			$('#order-detail-content table.std thead').addClass("table-head");
			$('#order-detail-content table.std tfoot').addClass("table-foot");
			$('#order-detail-content table.std tr').addClass("row-responsive");
			$('#order-detail-content table.std td').addClass("column-responsive clearfix");
			$("#order-detail-content table.std").responsiveTable({prefix:'tm_responsive',target:'#order-detail-table'});
		}
	}else{
		if($("#order-detail-content table.std").length != 0) {
			$('#order-detail-content table.std').removeClass("table-responsive");
			$('#order-detail-content table.std thead').removeClass("table-head");
			$('#order-detail-content table.std tfoot').removeClass("table-foot");
			$('#order-detail-content table.std tr').removeClass("row-responsive");
			$('#order-detail-content table.std td').removeClass("column-responsive");
			$("#order-detail-table").remove();
		}
	}
	
	
	// RFERRALPROGRAM TAB1 TABLE
	if ($(window).width() < 640){	
		if($("#idTab1 table.std").length != 0) {
			if($("#referralprogram-idTab1-table").length == 0) {
				$('<div id="referralprogram-idTab1-table"></div>').insertBefore('#idTab1 table.std');
			}
			$('#idTab1 table.std').addClass("table-responsive");
			$('#idTab1 table.std thead').addClass("table-head");
			$('#idTab1 table.std tfoot').addClass("table-foot");
			$('#idTab1 table.std tr').addClass("row-responsive");
			$('#idTab1 table.std td').addClass("column-responsive clearfix");
			$("#idTab1 table.std").responsiveTable({prefix:'tm_responsive',target:'#referralprogram-idTab1-table'});
		}
	}else{
		if($("#idTab1 table.std").length != 0) {
			$('#idTab1 table.std').removeClass("table-responsive");
			$('#idTab1 table.std thead').removeClass("table-head");
			$('#idTab1 table.std tfoot').removeClass("table-foot");
			$('#idTab1 table.std tr').removeClass("row-responsive");
			$('#idTab1 table.std td').removeClass("column-responsive");
			$("#referralprogram-idTab1-table").remove();
		}
	}
	
	
	// RFERRALPROGRAM TAB2 TABLE
	if ($(window).width() < 640){	
		if($("#idTab2 table.std").length != 0) {
			if($("#referralprogram-idTab2-table").length == 0) {
				$('<div id="referralprogram-idTab2-table"></div>').insertBefore('#idTab2 table.std');
			}
			$('#idTab2 table.std').addClass("table-responsive");
			$('#idTab2 table.std thead').addClass("table-head");
			$('#idTab2 table.std tfoot').addClass("table-foot");
			$('#idTab2 table.std tr').addClass("row-responsive");
			$('#idTab2 table.std td').addClass("column-responsive clearfix");
			$("#idTab2 table.std").responsiveTable({prefix:'tm_responsive',target:'#referralprogram-idTab2-table'});
		}
	}else{
		if($("#idTab2 table.std").length != 0) {
			$('#idTab2 table.std').removeClass("table-responsive");
			$('#idTab2 table.std thead').removeClass("table-head");
			$('#idTab2 table.std tfoot').removeClass("table-foot");
			$('#idTab2 table.std tr').removeClass("row-responsive");
			$('#idTab2 table.std td').removeClass("column-responsive");
			$("#referralprogram-idTab2-table").remove();
		}
	}
	
	// RFERRALPROGRAM TAB3 TABLE
	if ($(window).width() < 640){	
		if($("#idTab3 table.std").length != 0) {
			if($("#referralprogram-idTab3-table").length == 0) {
				$('<div id="referralprogram-idTab3-table"></div>').insertBefore('#idTab3 table.std');
			}
			$('#idTab3 table.std').addClass("table-responsive");
			$('#idTab3 table.std thead').addClass("table-head");
			$('#idTab3 table.std tfoot').addClass("table-foot");
			$('#idTab3 table.std tr').addClass("row-responsive");
			$('#idTab3 table.std td').addClass("column-responsive clearfix");
			$("#idTab3 table.std").responsiveTable({prefix:'tm_responsive',target:'#referralprogram-idTab3-table'});
		}
	}else{
		if($("#idTab3 table.std").length != 0) {
			$('#idTab3 table.std').removeClass("table-responsive");
			$('#idTab3 table.std thead').removeClass("table-head");
			$('#idTab3 table.std tfoot').removeClass("table-foot");
			$('#idTab3 table.std tr').removeClass("row-responsive");
			$('#idTab3 table.std td').removeClass("column-responsive");
			$("#referralprogram-idTab3-table").remove();
		}
	}
}
$(document).ready(function(){tableMakeResponsive();});
$(window).resize(function(){tableMakeResponsive();});
//$(window).bind('resize', tableMakeResponsive);

function productCarouselAutoSet() { 
	$(".products_block .product-carousel").each(function() {
		var objectID = $(this).attr('id');
		if(widthClassOptions[objectID.replace('-carousel','')])
			var myDefClass= widthClassOptions[objectID.replace('-carousel','')];
		else
			var myDefClass= 'grid_default_width';
		var slider = $(".products_block #" + objectID);
		slider.sliderCarousel({
			defWidthClss : myDefClass,
			subElement   : '.slider-item',
			subClass     : 'product-block',
			firstClass   : 'first_item_tm',
			lastClass    : 'last_item_tm',
			slideSpeed : 200,
			paginationSpeed : 800,
			autoPlay : false,
			stopOnHover : false,
			goToFirst : true,
			goToFirstSpeed : 5000,
			goToFirstNav : true,
			pagination : true,
			paginationNumbers: false,
			responsive: true,
			responsiveRefreshRate : 200,
			baseClass : "slider-carousel",
			theme : "slider-theme",
			autoHeight : true
		});
		
		var nextButton = $(this).parent().find('.next');
		var prevButton = $(this).parent().find('.prev');
		nextButton.click(function(){
			slider.trigger('slider.next');
		})
		prevButton.click(function(){
			slider.trigger('slider.prev');
		})
	});
}
$(window).load(function(){productCarouselAutoSet();});


function productListAutoSet() { 
	$(".products_block .product_list").each(function(){

		var objectID = $(this).attr('id');
		if(objectID.length >0){
			if(widthClassOptions[objectID.replace('-grid','')])
				var myDefClass= widthClassOptions[objectID.replace('-grid','')];
		}else{
			var myDefClass= 'grid_default_width';
		}
	
		$(this).smartColumnsRows({
			defWidthClss : myDefClass,
			subElement   : 'li',
			subClass     : 'product-block'
		});
	});		
}
$(window).load(function(){productListAutoSet();});
$(window).resize(function(){productListAutoSet();});
// Megnor End
