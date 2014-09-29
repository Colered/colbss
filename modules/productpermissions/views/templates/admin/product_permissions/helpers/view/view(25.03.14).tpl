{include file="toolbar.tpl" toolbar_btn=$toolbar_btn toolbar_scroll=$toolbar_scroll title=$title}
{if isset($success)}
    <div class="conf">{$success}</div>
{/if}
<form id="product_permissions" method="post" action="index.php?controller=AdminProductPermissions&amp;token={getAdminToken tab='AdminProductPermissions'}" enctype="multipart/form-data">
  <fieldset id="fieldset_main_conf">
    <legend>
      <img alt="Edit carrier" src="../img/t/AdminPreferences.gif">  {l s='Add Product tabs permissions'}</legend>
     <label>Select the Role:</label>
     <div class="margin-form">
   
	  <select name="profiles" onchange="this.form.submit();">
	  <option value="">------Select One-----</option>
	  {foreach $profileData AS $row}
		<option value="{$row.id_profile}" {if $row.id_profile eq $profilename}selected='selected'{/if}> {$row.name}</option>
	  {/foreach}

	  </select>
     </div>
     <div class="clear"></div>
     <label>Choose the Product tabs:</label>
      <div class="margin-form">
      <ul>
      
	<li><input type="checkbox" name="profileChk[]" value="1" {if in_array("1", $profilesArr)}CHECKED{/if}> <span class="category_label">Prices</span> </li>
	<li><input type="checkbox" name="profileChk[]" value="2" {if in_array("2", $profilesArr)}CHECKED{/if}> <span class="category_label">SEO</span> </li>
	<li><input type="checkbox" name="profileChk[]" value="3" {if in_array("3", $profilesArr)}CHECKED{/if} > <span class="category_label">Associations</span> </li>
	<li><input type="checkbox" name="profileChk[]" value="4" {if in_array("4", $profilesArr)}CHECKED{/if}> <span class="category_label">Shipping</span> </li>
	<li><input type="checkbox" name="profileChk[]" value="5" {if in_array("5", $profilesArr)}CHECKED{/if}> <span class="category_label">Combinations</span> </li>
	<li><input type="checkbox" name="profileChk[]" value="6" {if in_array("6", $profilesArr)}CHECKED{/if}> <span class="category_label">Quantities</span> </li>
	<li><input type="checkbox" name="profileChk[]" value="9" {if in_array("9", $profilesArr)}CHECKED{/if}> <span class="category_label">Images</span> </li>
	<li><input type="checkbox" name="profileChk[]" value="10" {if in_array("10", $profilesArr)}CHECKED{/if}> <span class="category_label">Features</span> </li>
	<li><input type="checkbox" name="profileChk[]" value="11" {if in_array("11", $profilesArr)}CHECKED{/if}> <span class="category_label">Customization</span> </li>
	<li><input type="checkbox" name="profileChk[]" value="12" {if in_array("12", $profilesArr)}CHECKED{/if}> <span class="category_label">Attachments</span> </li>
	<li><input type="checkbox" name="profileChk[]" value="13" {if in_array("13", $profilesArr)}CHECKED{/if}> <span class="category_label">Suppliers</span> </li>
	
      </ul>
      </div>	 
    
    <div class="clear"></div>
     	<div class="margin-form">
      
		<div style="float:left;"><br>
      		<input type="submit" class="button" name="product_permissions_data" value="{l s='Proceed'}" id="product_permissions_data_btn">
      	</div>	 	
    </div>
  </fieldset>
</form>
