<?php
$lang = isset($_GET['lang']) ? $_GET['lang']: "es";
include_once('lang/'.$lang.'.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo utf8_encode($lang_title);?></title>
<link type="text/css" rel="stylesheet" href="virtualstore/css/style.css" />
<script type="text/javascript" src="virtualstore/js/jquery.min.js"></script>
<script type="text/javascript">
 var lang_select_school = "<?php echo utf8_encode($lang_select_school);?>";
 var lang_for_blank = "<?php echo utf8_encode($lang_for_blank);?>";
 var lang_choose_one_grade = "<?php echo utf8_encode($lang_choose_one_grade);?>";

</script>
<script type="text/javascript" src="virtualstore/js/common.js"></script>
</head>
<body>
<div style="width:930px; margin:0 auto;">
	<div class="header">
			<div style="float:right">
					<form name="lanffrm" id="lanffrm" action="" method="get">
					<input type="hidden" name="sch" value="<?php echo isset($_GET['sch']) ? $_GET['sch']: "";?>" />
					 <?php echo utf8_encode($lang_Text); ?>:
			          <select name="lang" id="lang-id" onchange="this.form.submit();">
			             <option value="es"><?php echo utf8_encode($lang_Esp); ?></option>
						 <option value="en"><?php echo utf8_encode($lang_Eng); ?></option>
						 <option value="fr"><?php echo utf8_encode($lang_Frch); ?></option>
			          </select>
					  <script type="text/javascript">
					    jQuery('#lang-id').val("<?php echo $lang;?>");
					  </script>
					 </form>
			</div>

		<div class="head-logo">
		     <div class="logo"><img width="200" src="virtualstore/images/logo.png"></div>
			 <div class="logo-right">
				<div class="header-text"><?php echo utf8_encode($lang_header_title);?></div>
				<div class="header-image"><img src="virtualstore/images/logo-right.png"></div>
		     </div>
	   </div>
	</div>