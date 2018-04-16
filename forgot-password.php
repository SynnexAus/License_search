<?php include_once("connect.php");
	if(isset($_SESSION['UserID']) && $_SESSION['UserID']>0) {
		$mfp->mf_redirect($SITE_URL);
	}
	
	$PageName = "Homepage";
	$pageId =1;

	list($pagetitle,$pagename,$content,$browserTitle,$metaname,$metaKeywords,$metaDescription)=$mfp->mf_getMultiValue("staticpages",array("pagetitle","pagename","content","browsertitle","metaname","keywords","description"),"id",$pageId);
	
if(isset($_REQUEST['btnSubmit'])) {
	$useremail=addslashes($_REQUEST['fgt_email']);	
	$first_name=$mfp->mf_getValue("users","first_name","email",$useremail);
	$chkmail=$mfp->mf_getValue("users","email","email",$useremail);
	$chkId=$mfp->mf_getValue("users","id","email",$useremail);
	
	if($chkmail==$useremail) {
		$newpass=rand(11111111,99999999);
		$insArr=array();
		$insArr['password']=md5($newpass);
		$mfp->mf_dbupdate("users",$insArr," where email='".$chkmail."'");
		
		$userbody = "";
		$ntRes = mysql_query("select * from email_templates where id=2");
		if(mysql_affected_rows()>0) {
			$ntRow = mysql_fetch_array($ntRes);
			$subject=stripslashes($ntRow['subject']);
			$userbody = stripslashes($ntRow['content']);
			$userbody = str_replace('[NAME]',$first_name,$userbody);				
			$userbody = str_replace('[EMAIL]',$chkmail,$userbody);
			$userbody = str_replace('[PASSWORD]',$newpass,$userbody);
			$userbody = str_replace('[SITE_URL]',$SITE_URL,$userbody);
			$userbody = str_replace('[SITE_NAME]',$SITE_NAME,$userbody);
		}
		
		//echo $userbody; exit;
		$limite = "_parties_".md5 (uniqid (rand()));
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= "From: $ADMIN_MAIL\r\n";		
		@mail($useremail,$subject,$userbody,$headers);	
		
		$mfp->mf_setmessage("<div class='frmgreen'>Your new password has been sent to your email address.</div>");
	}
	else{
		
		$mfp->mf_setmessage("<div class='frmred'>Invalid email address to retrive password.</div>");
	}	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php include_once("header-section.php"); ?>
</head>

<body class="login-page">
	<div class="login-main">
    	<div class="login-center">
        	<div class="login-middle fadeIn">
                <div class="container">
                    <div class="login-header"><img src="images/synnex-cloud-icon2.png" alt="" /><span class="logodtl">License Search Portal</span></div>
                    
                    <div class="login-form">
                    	<div class="inve-msg"><?=$mfp->mf_viewmessage();?></div>
                    	<form name="frm_login" id="frm_login" method="post" action="" novalidate="novalidate" >
                        	<div class="form-field">
                            	<input id="fgt_email" name="fgt_email" type="text" placeholder="Email" class="user-field required email" size="16" maxlength="60" value="" />
                            </div>
                            <div class="form-btn text-center">
                            	<input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" /> <a class="login-button" href="<?=$SITE_URL;?>">Login</a>
                            </div>
                            <div class="clear"></div>
                        </form>
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








 

