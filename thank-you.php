<?php include_once("connect.php");
	if(!isset($_SESSION['UserID'])) {
		$mfp->mf_redirect($SITE_URL.'login.php');
	}
	$PageName = "Homepage";
	$pageId =1;
	list($pagetitle,$pagename,$content,$browserTitle,$metaname,$metaKeywords,$metaDescription)=$mfp->mf_getMultiValue("staticpages",array("pagetitle","pagename","content","browsertitle","metaname","keywords","description"),"id",$pageId);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php include_once("header-section.php"); ?>
</head>

<body class="login-page">
	<?php include_once("header.php"); ?>
    <div class="login-main">
    	<div class="login-center">
        	<div class="login-middle fadeIn">
                <div class="container">
                    <div class="login-header"><a href=""><img src="images/logo2.png" alt="" /></a></div>
                    <div class="login-form">
                    	<center><h3>Thank you for submitting your Cloud Lead Registration</h3></center>
                        <br/>
                        <center><a href="index.php">Return to Cloud Leaderboard</a></center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

<script src="js/jQuery 1.11.3.js" type="text/javascript"></script>

<script>
$('.banner-logo-image').delay(8000).show(400); 
	$(window).scroll(function() {
		$('.downside').each(function(){
		var imagePos = $(this).offset().top;
		var topOfWindow = $(window).scrollTop();
			if (imagePos < topOfWindow+600) {
				$(this).addClass("slideDown");
			}
		});
		$('.lhside').each(function(){
		var imagePos = $(this).offset().top;

		var topOfWindow = $(window).scrollTop();
			if (imagePos < topOfWindow+600) {
				$(this).addClass("slideRight");
			}
		});		
		$('.rhside').each(function(){
		var imagePos = $(this).offset().top;

		var topOfWindow = $(window).scrollTop();
			if (imagePos < topOfWindow+600) {
				$(this).addClass("slideLeft");
			}
		});
		$('.upside').each(function(){
		var imagePos = $(this).offset().top;

		var topOfWindow = $(window).scrollTop();
			if (imagePos < topOfWindow+600) {
				$(this).addClass("slideUp");
			}
		});
		$('.expnd').each(function(){
			var imagePos = $(this).offset().top;
			var topOfWindow = $(window).scrollTop();
			if (imagePos < topOfWindow+600) {
				$(this).addClass("expandOpen");
			}
		});
	});
</script>
<script src="js/jquery.validate.min.js"></script>
<script>
// MAP
jQuery(document).ready(function($) {
	$("#frm_login").validate();
});
</script>
</body>
</html>








 

