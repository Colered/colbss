{include file="toolbar.tpl" toolbar_btn=$toolbar_btn toolbar_scroll=$toolbar_scroll title=$title}
{if isset($success)}
    <div class="conf">{$success}</div>
{/if}
<form id="featured_brands" method="post" action="index.php?controller=AdminFeaturedBrands&amp;token={getAdminToken tab='AdminFeaturedBrands'}" enctype="multipart/form-data">
  <fieldset id="fieldset_main_conf">
    <legend>
      <img alt="Edit carrier" src="../img/t/AdminPreferences.gif">  {l s='Add a Brand'}</legend>
     <label>Brand Name:</label>
     <div class="margin-form">
	  <input type="text" id="brand_name" name="brand_name" style="width:250px; resize: none;">
     </div>
     <div class="clear"></div>
     <label>Brand Description:</label>
      <div class="margin-form">
	
		<textarea id="brand_desc" name="brand_desc" style="width:500px;height:100px; resize: none;"></textarea>
		{*<br>
		<p style="display:block; position:relative; display:inline-block;" class="hint">
			<span>Fill the comma separated ISBN values(i.e. xxx44, xxx55).</span>
		</p>
		<p class="text"><b> OR </b></p>
		<p class="text">Browse the CSV file with ISBN and associated categories.
		    <br>
			<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
			<input type="file" name="csvUpload" id="csvUpload" />
		</p>*}
	 </div>	 
    
    <div class="clear"></div>
     <label>Enable:</label>
	<div class="margin-form">
		<input type="radio" name="active" id="active_on" value="1">
		<label class="t" for="active_on"><img src="../img/admin/enabled.gif" alt="Enabled" title="Enabled"></label>
		<input type="radio" name="active" id="active_off" value="0" checked="checked">
		<label class="t" for="active_off"><img src="../img/admin/disabled.gif" alt="Disabled" title="Disabled"></label>
	</div>
	<div class="margin-form">
      
		<div style="float:left;"><br>
      		<input type="submit" class="button" name="featured_brands" value="{l s='Proceed'}" id="isbn_data_btn">
      	</div>	 	
    </div>
  </fieldset>
</form>
