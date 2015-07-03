<?php
include_once('virtualstore/header.php');
require(dirname(__FILE__).'/config/config.inc.php');

// fetch all the store created on bookstore
if(isset($_SERVER['HTTPS'])){
	$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
}else{
	$protocol = 'http';
}
$schools_dropdwn = '<option value="">'.$lang_form_lable_select.'</option>';
$host = pSQL(Tools::getHttpHost());

$sql = 'SELECT s.id_shop,su.physical_uri, su.virtual_uri, CONCAT(su.physical_uri, su.virtual_uri) AS uri, su.domain, su.main
		FROM '._DB_PREFIX_.'shop_url su
		LEFT JOIN '._DB_PREFIX_.'shop s ON (s.id_shop = su.id_shop)
		WHERE (su.domain = \''.$host.'\' OR su.domain_ssl = \''.$host.'\')
			AND s.active = 1
			AND s.deleted = 0
		ORDER BY LENGTH(CONCAT(su.physical_uri, su.virtual_uri))';
$stores = Db::getInstance()->ExecuteS($sql);
$total_stores = count($stores);
$row = Db::getInstance()->ExecuteS($sql." limit 1 , $total_stores");

if(empty($stores))
	die('There is no active store.');
else {
    for($i = 0; $i < count($row); $i++) {
		$schools_dropdwn .= '<option value="'.substr($row[$i]['virtual_uri'],0,-1).'">'.$protocol . "://".$row[$i]['domain'] . $row[$i]['physical_uri'].$row[$i]['virtual_uri'].'</option>';
    }
}
// end fetch store

$qry = 'SELECT c.id_category, cl.name
							FROM ps_category c
							INNER JOIN ps_category_lang cl ON ( c.id_category = cl.id_category )
							WHERE c.level_depth <>0
							AND c.active = "1"
							AND cl.name <> "home"
							GROUP BY c.id_category
							ORDER BY cl.name';
$gradeDwn = '<option value="">'.$lang_form_lable_select.'</option>';

$categories = Db::getInstance()->ExecuteS($qry);
for($i = 0; $i < count($categories); $i++) {
		$gradeDwn .= '<option value="'.$categories[$i]['id_category'].'">'.$categories[$i]['name'].'</option>';
    }

//$school = $_GET['sch'];
$school = isset($_GET['sch']) ? $_GET['sch']: "";

// for language selection
if($lang=='en'){
   $lang_id_shopmatch = 1;
}else if($lang=='fr'){
   $lang_id_shopmatch = 2;
}else if($lang=='es'){
   $lang_id_shopmatch = 3;
}else{
  $lang_id_shopmatch = 1;
}
// end language selection

?>
<div id="page">
    <div id="wrapper">

        <form name="frmParentInfo" id="frmParentInfo" action="" method="post">
        <input type="hidden" name="id_lang" value="<?php echo $lang_id_shopmatch;?>" />
		<div class="form-step">
                    <div class="form-text">
                        <div class="numbers"><img src="virtualstore/images/1.png"  /></div>
						<div class="num-text"><?php echo utf8_encode($lang_form_desc_about_form);?></div>
                    </div>
					<div class="row" style="padding-top:30px;">
                        <div class="form-left fform"><?php echo utf8_encode($lang_form_lable_school);?></div>
                        <div class="form-right">
						<select name="school_url" id="school_url"  onchange="removeErr();">
						   <?php echo utf8_encode($schools_dropdwn);?>
						</select>
						<script type="text/javascript">
						  jQuery("#school_url").val("<?php echo $school;?>");
						</script>
						</div>
						<div class="form-right store-link"><a href="#" onclick="goDirectlyStore();" ><?php echo utf8_encode($lang_store_link);?></a> </div>
                        <div class="form-error"></div>
                    </div>
					<div class="row">
                        <div class="form-left fform"><?php echo utf8_encode($lang_form_lable_parent_name);?></div>
                        <div class="form-right"><input type="text" name="parent_name" id="parent_name" value="" /></div>
                        <div class="form-error"></div>
                    </div>
					<div class="rowleft">
                        <div class="form-left fform"><?php echo utf8_encode($lang_form_lable_1child_grade);?></div>
                        <div class="form-right">
						<select name="s1g1" id="s1g1">
						    <?php echo utf8_encode($gradeDwn);?>
						</select>
						</div>
                        <div class="form-error"></div>
                    </div>
					<div class="rowright">
                        <div class="form-left fform"><?php echo utf8_encode($lang_form_lable_2child_grade);?></div>
                        <div class="form-right">
						<select name="s2g2" id="s2g2">
						     <?php echo utf8_encode($gradeDwn);?>
						</select>
						</div>
                        <div class="form-error"></div>
                    </div>
					<div style="clear:both;"></div>
					<div class="rowleft">
                        <div class="form-left fform"><?php echo utf8_encode($lang_form_lable_3child_grade);?></div>
                        <div class="form-right">
						<select name="s3g3" id="s3g3">
						     <?php echo utf8_encode($gradeDwn);?>
						</select>
						</div>
                         <div class="form-error"></div>
                    </div>
					<div class="rowright">
                        <div class="form-left fform"><?php echo utf8_encode($lang_form_lable_4child_grade);?></div>
                        <div class="form-right">
						<select name="s4g4" id="s4g4">
						     <?php echo utf8_encode($gradeDwn);?>
						</select>
						</div>
                         <div class="form-error"></div>
                    </div>
					<div class="row"><input type="button" name="proceed" id="btnProceed" value="<?php echo utf8_encode($lang_submitBtn[2]);?>" class="submit-btn"/></div>
					
		</div>
        </form>

    </div>
</div>

<?php include('virtualstore/footer.php'); ?>

