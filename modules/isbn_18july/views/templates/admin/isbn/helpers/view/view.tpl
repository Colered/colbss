{include file="toolbar.tpl" toolbar_btn=$toolbar_btn toolbar_scroll=$toolbar_scroll title=$title}
<form id="isbn_data" method="post" action="index.php?controller=AdminIsbn&amp;token={getAdminToken tab='AdminIsbn'}" enctype="multipart/form-data">
  <fieldset id="fieldset_main_conf">
    <legend>
      <img alt="Edit carrier" src="../img/t/AdminPreferences.gif">  {l s='Add ISBN'}</legend>
     <div class="margin-form">
		<div style="float:left;"><label for="category_block">Associated categories:</label></div>
		<div style="float:left;">
			  {if isset($catData)}
				  <ul>
				  {foreach $catData AS $row}
					<li id="{$row.id_category}"><input type="checkbox" name="categoryChk[]" value="{$row.id_category}"  {if in_array($row.id_category, $categoriesArr)}CHECKED{/if}> <span class="category_label">{$row.catName}</span> </li>
				  {/foreach}
				  </ul> 
			  {/if}
		</div>	
		<div class="clear"></div>
    </div> 
      <div class="clear"></div>
    <div class="margin-form">
     <div style="float:left;"><p class="text"><label for="category_block">ISBN:</label></p></div>
		<div style="float:left;">
		<textarea id="isb_no" name="isb_no" style="width:500px;height:100px; resize: none;">{$isbn_values}</textarea>
		<br>
		<p style="display:block; position:relative; display:inline-block;" class="hint">
			<span>Fill the comma separated ISBN values(i.e. xxx44, xxx55).</span>
		</p>
		<p class="text"><b> OR </b></p>
		<p class="text">Browse the CSV file with ISBN and associated categories.
		    <br>
			<input type="file" name="csvUpload" id="csvUpload" />
			<br>
			<span style="color: #268CCD;"><a href="{$base_url}isbnsample.csv" style="color: #268CCD;">Download the sample CSV file.</a></span>
		</p>
	 </div>	 
    </div>
    <div class="clear"></div>
    <div class="margin-form">
      <div style="float:left;"><label for="category_block">&nbsp;</label></div>
		<div style="float:left;"><br>
      		<input type="submit" class="button" name="isbn_data" value="{l s='Proceed'}" id="isbn_data_btn">
      	</div>	 	
    </div>
  </fieldset>
</form>
