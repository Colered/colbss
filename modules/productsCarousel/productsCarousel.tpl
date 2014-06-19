{if $page_name == "index"}
<div class="clear"></div>
<!-- jCarousel library -->
<script>
$(function() {
    $(".main .jCarouselLite").jCarouselLite_f({
        btnNext: ".main .nav_next",
        btnPrev: ".main .nav_prev",
        speed: 300,
        visible: {$visible_products},
        scroll: {$products_to_scroll},
        auto: 0,
    });       
});

//alert(favorite_products_id_product); 
</script>
<style type="text/css">
  #productsCarousel ul li { width:{$cell_width}px; }
  .preloadImg {
    background:url({$content_dir}modules/productsCarousel/images/buttons_active.png) 0 0;
    position:absolute;
    left:-9999px;
  }
  .preloadImg div{ background:url({$content_dir}modules/productsCarousel/images/buttons_pressed.png) 0 0; }
  #mycarousel { height:200px }

</style>
<div class="preloadImg"><div></div></div>
<div id="productsCarousel" class="main">
<div class="container_border">
  {if $products_type == 0}
    <h4>{l s='New products' mod='productsCarousel'}</h4>
  {else}
    <h4>{l s='Featured products' mod='productsCarousel'}</h4>
  {/if}
<button class="nav_prev"></button>
<button class="nav_next"></button>
<div class="viewport">
  <div class="jCarouselLite">
    {if $products_type == 0}
      {if $new_products}
          <ul id="mycarousel">
          {foreach from=$new_products item=product name=products}
            {assign var='productLink' value=$link->getProductLink($product.id_product, $product.link_rewrite)}
            <li class="block_product">
              {if $show_funcbuttons == 1}
              <script>              
                  $("#favprod_{$product['id_product']} #favoriteproducts_block_extra_add").click(function(){
                  var favorite_products_id_product = $("#favprod_{$product['id_product']}").attr("class");                  
                    $.ajax({
                      url: favorite_products_url_add,
                      type: "POST",
                      data: {
                        "id_product": favorite_products_id_product
                      },
                      success: function(result){
                        if (result == '0')
                        {
                            $("#favprod_{$product['id_product']} #favoriteproducts_block_extra_add").slideUp(function() {
                              $("#favprod_{$product['id_product']} #favoriteproducts_block_extra_added").slideDown("slow");
                            });

                        }
                      }
                    });
                  });
                  $("#favprod_{$product['id_product']} #favoriteproducts_block_extra_remove").click(function(){
                    var favorite_products_id_product = $("#favprod_{$product['id_product']}").attr("class");                  
                    $.ajax({
                      url: favorite_products_url_remove,
                      type: "POST",
                      data: {
                        "id_product": favorite_products_id_product
                      },
                      success: function(result){
                        if (result == '0')
                        {
                            $("#favprod_{$product['id_product']} #favoriteproducts_block_extra_remove").slideUp(function() {
                              $("#favprod_{$product['id_product']} #favoriteproducts_block_extra_removed").slideDown("slow");
                            });

                        }
                      }
                    });
                  });
                  $("#favprod_{$product['id_product']} #favoriteproducts_block_extra_added").click(function(){
                    var favorite_products_id_product = $("#favprod_{$product['id_product']}").attr("class");                  
                    $.ajax({
                      url: favorite_products_url_remove,
                      type: "POST",
                      data: {
                        "id_product": favorite_products_id_product
                      },
                      success: function(result){
                        if (result == '0')
                        {
                            $("#favprod_{$product['id_product']} #favoriteproducts_block_extra_added").slideUp(function() {
                              $("#favprod_{$product['id_product']} #favoriteproducts_block_extra_removed").slideDown("slow");
                            });

                        }
                      }
                    });
                  });
                  $("#favprod_{$product['id_product']} #favoriteproducts_block_extra_removed").click(function(){
                    var favorite_products_id_product = $("#favprod_{$product['id_product']}").attr("class");                  
                    $.ajax({
                      url: favorite_products_url_add,
                      type: "POST",
                      data: {
                        "id_product": favorite_products_id_product
                      },
                      success: function(result){
                        if (result == '0')
                        {
                            $("#favprod_{$product['id_product']} #favoriteproducts_block_extra_removed").slideUp(function() {
                              $("#favprod_{$product['id_product']} #favoriteproducts_block_extra_added").slideDown("slow");
                            });

                        }
                      }
                    });
                  });
              </script>
              {/if}
              <a href="{$productLink}" title="{$product.legend}" class="slide-animate">
                <img src="{$link->getImageLink($product.link_rewrite,$product.id_image, 'large')}" alt="{$product.name|escape:html:'UTF-8'}" /><br />              
              </a>
              <a class="f_title" href="{$productLink}" title="{$product.legend}">{$product.name|escape:htmlall:'UTF-8'|truncate:35}</a>{if isset($product.manufacturer_name)}
            <span>{$product.manufacturer_name|escape:htmlall:'UTF-8'|truncate:35}</span><br />{/if}          
              {if isset($show_price) && $show_price == 1}
              <div class="price">
                <span>{convertPrice price=$product.price_tax_exc}</span>                
              </div>
              {/if}
              {if ($product.quantity > 0 OR $product.allow_oosp)}
                  <a class="exclusive ajax_add_to_cart_button" rel="ajax_id_product_{$product.id_product}" href="{$link->getPageLink('cart.php')}?qty=1&amp;id_product={$product.id_product}&amp;token={$static_token}&amp;add" title="{l s='Add to cart' mod='productsCarousel'}">{l s='Add to cart' mod='productsCarousel'}</a>
                {else}
                  <span class="exclusive">{l s='Add to cart' mod='productsCarousel'}</span>
                {/if}
              {if $show_funcbuttons == 1}
              {if $errors}{$errors}{/if}
              <div class="function_buttons">              
                <div class="function_button product_favorites">              
                  <div class="{$product['id_product']}" id="favprod_{$product['id_product']}">                
                  {if !$newIsCustomerFavoriteProduct[$product['id_product']]}
                    <div id="favoriteproducts_block_extra_add" class="add favproduct">{l s='Add'}</div>
                  {/if}
                  {if $newIsCustomerFavoriteProduct[$product['id_product']]}
                    <div id="favoriteproducts_block_extra_remove" class="favproduct">{l s='Rem'}</div>
                  {/if}
                    <div id="favoriteproducts_block_extra_added" class="favproduct">{l s='Rem2'}</div>
                    <div id="favoriteproducts_block_extra_removed" class="favproduct">{l s='Add2'}</div>
                  </div>
                </div>
                <div class="function_button product_rating">
                    {$p_comments_grade[$product['id_product']]['grade']}/5
                </div>
                <div class="function_button product_wishlist">
                    <a href="#" onclick="WishlistCart('wishlist_block_list', 'add', '{$product['id_product']}', '1', '1'); return false;">&raquo;</a>
                </div>
                <div class="function_button comment_number">
                    {$p_comments_number[$product['id_product']]}
                </div>                                
              </div>
              {/if}
            </li>
          {/foreach}
        </ul>
      {else}<b>{l s='No products' mod='productsCarousel'}</b>{/if}
    {else}
      {if $featuredProducts}
          <ul id="mycarousel">
          {foreach from=$featuredProducts item=product name=products}
            {assign var='productLink' value=$link->getProductLink($product.id_product, $product.link_rewrite)}            
            <li class="block_product">
              {if $show_funcbuttons == 1}
              <script>              
                  $("#favprod_{$product['id_product']} #favoriteproducts_block_extra_add").click(function(){
                  var favorite_products_id_product = $("#favprod_{$product['id_product']}").attr("class");                  
                    $.ajax({
                      url: favorite_products_url_add,
                      type: "POST",
                      data: {
                        "id_product": favorite_products_id_product
                      },
                      success: function(result){
                        if (result == '0')
                        {
                            $("#favprod_{$product['id_product']} #favoriteproducts_block_extra_add").slideUp(function() {
                              $("#favprod_{$product['id_product']} #favoriteproducts_block_extra_added").slideDown("slow");
                            });

                        }
                      }
                    });
                  });
                  $("#favprod_{$product['id_product']} #favoriteproducts_block_extra_remove").click(function(){
                    var favorite_products_id_product = $("#favprod_{$product['id_product']}").attr("class");                  
                    $.ajax({
                      url: favorite_products_url_remove,
                      type: "POST",
                      data: {
                        "id_product": favorite_products_id_product
                      },
                      success: function(result){
                        if (result == '0')
                        {
                            $("#favprod_{$product['id_product']} #favoriteproducts_block_extra_remove").slideUp(function() {
                              $("#favprod_{$product['id_product']} #favoriteproducts_block_extra_removed").slideDown("slow");
                            });

                        }
                      }
                    });
                  });
                  $("#favprod_{$product['id_product']} #favoriteproducts_block_extra_added").click(function(){
                    var favorite_products_id_product = $("#favprod_{$product['id_product']}").attr("class");                  
                    $.ajax({
                      url: favorite_products_url_remove,
                      type: "POST",
                      data: {
                        "id_product": favorite_products_id_product
                      },
                      success: function(result){
                        if (result == '0')
                        {
                            $("#favprod_{$product['id_product']} #favoriteproducts_block_extra_added").slideUp(function() {
                              $("#favprod_{$product['id_product']} #favoriteproducts_block_extra_removed").slideDown("slow");
                            });

                        }
                      }
                    });
                  });
                  $("#favprod_{$product['id_product']} #favoriteproducts_block_extra_removed").click(function(){
                    var favorite_products_id_product = $("#favprod_{$product['id_product']}").attr("class");                  
                    $.ajax({
                      url: favorite_products_url_add,
                      type: "POST",
                      data: {
                        "id_product": favorite_products_id_product
                      },
                      success: function(result){
                        if (result == '0')
                        {
                            $("#favprod_{$product['id_product']} #favoriteproducts_block_extra_removed").slideUp(function() {
                              $("#favprod_{$product['id_product']} #favoriteproducts_block_extra_added").slideDown("slow");
                            });

                        }
                      }
                    });
                  });
              </script>
              {/if}
              <a href="{$productLink}" title="{$product.legend}" class="slide-animate">
                <img src="{$link->getImageLink($product.link_rewrite,$product.id_image, 'large')}" alt="{$product.name|escape:html:'UTF-8'}" /><br />              
              </a>
              <a class="f_title" href="{$productLink}" title="{$product.legend}">{$product.name|escape:htmlall:'UTF-8'|truncate:35}</a>
              {if isset($product.manufacturer_name)}
              <span>{$product.manufacturer_name|escape:htmlall:'UTF-8'|truncate:35}</span><br />{/if}
              {if isset($show_price) && $show_price == 1}
              <div class="price">
                <span>{convertPrice price=$product.price_tax_exc}</span>                
              </div>
              {/if}
              {if ($product.quantity > 0 OR $product.allow_oosp)}
                  <a class="exclusive ajax_add_to_cart_button" rel="ajax_id_product_{$product.id_product}" href="{$link->getPageLink('cart.php')}?qty=1&amp;id_product={$product.id_product}&amp;token={$static_token}&amp;add" title="{l s='Add to cart' mod='productsCarousel'}">{l s='Add to cart' mod='productsCarousel'}</a>
                {else}
                  <span class="exclusive">{l s='Add to cart' mod='productsCarousel'}</span>
                {/if}
              {if $show_funcbuttons == 1}
              {if $errors}{$errors}{/if}
              <div class="function_buttons">              
                <div class="function_button product_favorites">              
                  <div class="{$product['id_product']}" id="favprod_{$product['id_product']}">                
                  {if !$newIsCustomerFavoriteProduct[$product['id_product']]}
                    <div id="favoriteproducts_block_extra_add" class="add favproduct">{l s='Add'}</div>
                  {/if}
                  {if $newIsCustomerFavoriteProduct[$product['id_product']]}
                    <div id="favoriteproducts_block_extra_remove" class="favproduct">{l s='Rem'}</div>
                  {/if}
                    <div id="favoriteproducts_block_extra_added" class="favproduct">{l s='Rem2'}</div>
                    <div id="favoriteproducts_block_extra_removed" class="favproduct">{l s='Add2'}</div>
                  </div>
                </div>
                <div class="function_button product_rating">
                    {$p_comments_grade[$product['id_product']]['grade']}/5
                </div>
                <div class="function_button product_wishlist">
                    <a href="#" onclick="WishlistCart('wishlist_block_list', 'add', '{$product['id_product']}', '1', '1'); return false;">&raquo;</a>
                </div>
                <div class="function_button comment_number">
                    {$p_comments_number[$product['id_product']]}
                </div>                                
              </div>
              {/if}
            </li>
            
          {/foreach}
        </ul>
      {else}<b>{l s='No products' mod='productsCarousel'}</b>{/if}
    {/if}
  </div>
</div>
</div>
</div>
{/if}