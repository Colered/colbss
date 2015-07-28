<?php
session_start();
include_once('virtualstore/header.php');
require(dirname(__FILE__).'/config/config.inc.php');
if(isset($_SESSION['sid']))
	unset($_SESSION['sid']);
//get the list of all schools
$sql = 'SELECT * FROM fed_schools';
$schools = Db::getInstance()->ExecuteS($sql);
?>

<div id="page">
    <div id="wrapper">
		
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
                background: url(virtualstore/images/a17.png) no-repeat;
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
    </div>
     </div>
	 <br /><br />
		<fieldset style="border:1px solid #DCDADA">
 		<legend><strong> <?php echo $choose_school; ?> </strong></legend>
           
				<div class="form-text1">
					<div class="num-text1">
						<?php for($i = 1; $i <= count($schools); $i++) { ?>
						 <a href="gradeinfo.php?sid=<?php echo $schools[$i-1]['id']; ?>&sch=<?php echo $schools[$i-1]['school_name']; ?>"><?php echo $schools[$i-1]['school_name']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
						<?php
						if($i % 4 == 0){ echo "<br/>";} 
						 } ?>
					</div>
				</div>
           </div>
		</fieldset>
		<br /><br />
		<div style="padding-left:30px; padding-right:30px;"><div style="float:left"> <strong>Mi colegio no aparece en la lista.</strong> </div><div style="width:225px; margin:0px; float:none; margin-left:288px;" class="submit-btn"><a style="color:#FFFFFF; text-decoration:none;" href="/bookstore"><?php echo $lang_store_link; ?></a></div></div>
		   <br /><br />
    </div>
	
</div>

<?php include_once('virtualstore/footer.php'); ?>

