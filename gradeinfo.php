<?php
session_start();
include_once('virtualstore/header.php');
require(dirname(__FILE__).'/config/config.inc.php');
if(isset($_GET['sid']) && $_GET['sid'] !='')
	$_SESSION['sid'] = $_GET['sid'];
$schoolid = isset($_GET['sid']) ? $_GET['sid']: "";
$schoolName = isset($_GET['sch']) ? $_GET['sch']: "";
if($schoolid!=''){
	$qry = "SELECT fsc.course_name, fcb.id, fcb.course_id, fcb.school_id FROM fed_course_books as fcb LEFT JOIN fed_school_courses as fsc ON fcb.course_id = fsc.id WHERE fcb.school_id =$schoolid GROUP BY fcb.course_id ";
	$gradeDwn = '<option value="">'.$lang_form_lable_select.'</option>';
	$grades = Db::getInstance()->ExecuteS($qry);
	for($i = 0; $i < count($grades); $i++) {
		$gradeDwn .= '<option value="'.$grades[$i]['course_id'].'">'.$grades[$i]['course_name'].'</option>';
	}
}

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

        <form name="frmParentInfo" id="frmParentInfo" action="index.php?controller=precart&add=1" method="post">
        <input type="hidden" name="id_lang" value="<?php echo $lang_id_shopmatch;?>" />
		<div class="form-step">
                    <div class="form-text">
						<div id="slider1_container" style="position: relative; top: 0px; left: 0px; width: 870px;
        height: 275px; overflow: hidden;">

        <!-- Loading Screen -->
        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                background-color: #000; top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
            <div style="position: absolute; display: block; background: url(../img/loading.gif) no-repeat center center;
                top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
        </div>
        
        <!-- Slides Container -->
        <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 870px; height: 275px;
            overflow: hidden;">
            <div>
                <a u=image href="#"><img src="virtualstore/images/banner.png" /></a>
            </div>
            <div>
                <a u=image href="#"><img src="virtualstore/images/main-banner-1.jpg" /></a>
            </div>
            <div>
                <a u=image href="#"><img src="virtualstore/images/main-banner-3.jpg" /></a>
            </div>
        </div>
        
        <!--#region Bullet Navigator Skin Begin -->
        <!-- Help: http://www.jssor.com/development/slider-with-bullet-navigator-jquery.html -->
        <style>
            /* jssor slider bullet navigator skin 01 css */
            /*
            .jssorb01 div           (normal)
            .jssorb01 div:hover     (normal mouseover)
            .jssorb01 .av           (active)
            .jssorb01 .av:hover     (active mouseover)
            .jssorb01 .dn           (mousedown)
            */
            .jssorb01 {
                position: absolute;
            }
            .jssorb01 div, .jssorb01 div:hover, .jssorb01 .av {
                position: absolute;
                /* size of bullet elment */
                width: 12px;
                height: 12px;
                filter: alpha(opacity=70);
                opacity: .7;
                overflow: hidden;
                cursor: pointer;
                border: #000 1px solid;
            }
            .jssorb01 div { background-color: gray; }
            .jssorb01 div:hover, .jssorb01 .av:hover { background-color: #d3d3d3; }
            .jssorb01 .av { background-color: #fff; }
            .jssorb01 .dn, .jssorb01 .dn:hover { background-color: #555555; }
        </style>
        <!-- bullet navigator container -->
        <div u="navigator" class="jssorb01" style="bottom: 16px; right: 10px;">
            <!-- bullet navigator item prototype -->
            <div u="prototype"></div>
        </div>
        <!--#endregion Bullet Navigator Skin End -->
        
        <!--#region Arrow Navigator Skin Begin -->
        <!-- Help: http://www.jssor.com/development/slider-with-arrow-navigator-jquery.html -->
        <style>
            /* jssor slider arrow navigator skin 05 css */
            /*
            .jssora05l                  (normal)
            .jssora05r                  (normal)
            .jssora05l:hover            (normal mouseover)
            .jssora05r:hover            (normal mouseover)
            .jssora05l.jssora05ldn      (mousedown)
            .jssora05r.jssora05rdn      (mousedown)
            */
            .jssora05l, .jssora05r {
                display: block;
                position: absolute;
                /* size of arrow element */
                width: 40px;
                height: 40px;
                cursor: pointer;
                background: url(../img/a17.png) no-repeat;
                overflow: hidden;
            }
            .jssora05l { background-position: -10px -40px; }
            .jssora05r { background-position: -70px -40px; }
            .jssora05l:hover { background-position: -130px -40px; }
            .jssora05r:hover { background-position: -190px -40px; }
            .jssora05l.jssora05ldn { background-position: -250px -40px; }
            .jssora05r.jssora05rdn { background-position: -310px -40px; }
        </style>
        <!-- Arrow Left -->
        <span u="arrowleft" class="jssora05l" style="top: 123px; left: 8px;">
        </span>
        <!-- Arrow Right -->
        <span u="arrowright" class="jssora05r" style="top: 123px; right: 8px;">
        </span>
        <a style="display: none" href="http://www.jssor.com">Bootstrap Slider</a>
    </div>
					</div><br />
					<div style="font-weight:bold; text-align:center; font-size:15px;"><?php if($schoolName !=""){ echo utf8_encode($schoolName); } ?></div>					
					<div class="rowleft" style="padding-top:30px;">
                        <div class="form-left fform"><?php echo $lang_form_lable_1child_grade;?></div>
                        <div class="form-right">
						<select name="courseIdArr[]" id="s1g1">
						    <?php echo $gradeDwn;?>
						</select>
						</div>
                        <div class="form-error"></div>
                    </div>
					<div class="rowright" style="padding-top:30px;">
                        <div class="form-left fform"><?php echo $lang_form_lable_2child_grade;?></div>
                        <div class="form-right">
						<select name="courseIdArr[]" id="s2g2">
						     <?php echo $gradeDwn;?>
						</select>
						</div>
                        <div class="form-error"></div>
                    </div>
					<div style="clear:both;"></div>
					<div class="rowleft">
                        <div class="form-left fform"><?php echo $lang_form_lable_3child_grade;?></div>
                        <div class="form-right">
						<select name="courseIdArr[]" id="s3g3">
						     <?php echo $gradeDwn;?>
						</select>
						</div>
                         <div class="form-error"></div>
                    </div>
					<div class="rowright">
                        <div class="form-left fform"><?php echo $lang_form_lable_4child_grade;?></div>
                        <div class="form-right">
						<select name="courseIdArr[]" id="s4g4">
						     <?php echo $gradeDwn;?>
						</select>
						</div>
                         <div class="form-error"></div>
                    </div>
					<div class="row">
					<input type="hidden" name="sid" value="<?php echo $schoolid ; ?>" />
					<input type="button" name="proceed" id="btnProceed" value="<?php echo $lang_submitBtn[2];?>" class="submit-btn button" style="width:200px;"/>
					<span class="submit-btn button backbutton"><a style="color:#FFFFFF; text-decoration:none;" href="schools.php"><?php echo $lang_submitBtn[3];?></a></span></div>
					<div class="row"></div>
					
		</div>
        </form>

    </div>
</div>

<?php include('virtualstore/footer.php'); ?>

