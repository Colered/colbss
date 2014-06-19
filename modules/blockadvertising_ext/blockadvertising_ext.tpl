{literal}
	<!-- SLIDER ---->
	<div id="left_show" class="block">
		<div id="slider_left">
		{/literal}
			{foreach from=$xml->item item=my_item name=loop}
				{literal}
				   <a href='{/literal}{$my_item->url}{literal}'>
					<img src='{/literal}{$module_dir}{$my_item->img}{literal}'alt="" />
				  </a> 
				{/literal}
			{/foreach}{literal}
		</div>
		<script type="text/javascript">
		$(window).load(function() {
		$('#slider_left').nivoSlider({
			effect: 'boxRandom', // Specify sets like: 'fold,fade,sliceDown'
			slices: 15, // For slice animations
			boxCols: 4, // For box animations
			boxRows: 8, // For box animations
			animSpeed: 300, // Slide transition speed
			pauseTime: 4000, // How long each slide will show
			startSlide: 0, // Set starting Slide (0 index)
			directionNav: true, // Next & Prev navigation
			directionNavHide: true, // Only show on hover
			controlNav: true, // 1,2,3... navigation
			controlNavThumbs: false, // Use thumbnails for Control Nav
			controlNavThumbsFromRel: false, // Use image rel for thumbs
			controlNavThumbsSearch: '.jpg', // Replace this with...
			controlNavThumbsReplace: '_thumb.jpg', // ...this in thumb Image src
			keyboardNav: true, // Use left & right arrows
			pauseOnHover: true, // Stop animation while hovering
			manualAdvance: false, // Force manual transitions
			captionOpacity: 0.8, // Universal caption opacity
			prevText: '', // Prev directionNav text
			nextText: '', // Next directionNav text
			randomStart: false, // Start on a random slide
			beforeChange: function(){}, // Triggers before a slide transition
			afterChange: function(){}, // Triggers after a slide transition
			slideshowEnd: function(){}, // Triggers after all slides have been shown
			lastSlide: function(){}, // Triggers when last slide is shown
			afterLoad: function(){} // Triggers when slider has loaded
			});
		});

		</script>
	</div>
	<!-- SLIDER ---->
{/literal} 