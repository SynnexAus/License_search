<?php include_once("connect.php");
	if(isset($_SESSION['UserID']) && $_SESSION['UserID']>0) 
	{
		$mfp->mf_redirect($SITE_URL.'dashboard.php');
	}	
	$PageName = "Homepage";
	$pageId =1;

	list($pagetitle,$pagename,$content,$browserTitle,$metaname,$metaKeywords,$metaDescription)=$mfp->mf_getMultiValue("staticpages",array("pagetitle","pagename","content","browsertitle","metaname","keywords","description"),"id",$pageId);
	
if(isset($_REQUEST['btnSubmit'])) 
{
	//print_r($_POST); die();
	if($_POST['chkRember'] == 1) 
	{
		$year = time() + 31536000;
		$_COOKIE['remember_me_user'] = $_POST['useremail'];
		$_COOKIE['remember_me_pass'] = $_POST['password'];
		setcookie('remember_me_user', $_POST['useremail'], $year);
		setcookie('remember_me_pass', $_POST['password'], $year);		
	}
	else 
	{ 
		if($_COOKIE['remember_me_user'] == $_POST['useremail'] && $_COOKIE['remember_me_pass'] == $_POST['password']) 
		{
			$year = time() - 31536000;
			setcookie("remember_me_user", "", $year);
			setcookie("remember_me_pass", "", $year);
		}
	}
	
	$valid=$mfp->mf_check_user_login("users",$_POST['useremail'],$_POST['password']);
	if($valid) 
	{
		list($first_name,$last_name,$status)=$mfp->mf_getMultiValue("users",array("first_name","last_name","status"),"id",$valid);
		if($status==0) 
		{
			$mfp->mf_setmessage('<div class="alert alert-danger"><i class="fa fa-times-circle fa-1x middletxt"></i>&nbsp;Your account is inactive/under review. </div>');
		}
		$_SESSION['UserID']=$valid;
		$_SESSION['User_fName']=$first_name;
		$_SESSION['User_lName']=$last_name;
		$mfp->mf_redirect($SITE_URL.'dashboard.php');
		exit;
	}
	else 
	{
		$mfp->mf_setmessage('<div class="alert alert-danger"><i class="fa fa-times-circle fa-1x middletxt"></i>&nbsp;Invalid username/password.</div>');
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
        	<div class="login-middle">
                <div class="container">
                    <div class="login-header">
                    	<img src="images/synnex-cloud-icon2.png" alt="" />
                        <span class="logodtl">License Search Portal</span>
                    </div>
                    <div class="login-form">
                    	<h2 class="login-formTitle">Sign In</h2>
                    	<div class="inve-msg"><?=$mfp->mf_viewmessage();?></div>
                    	<form name="frm_login" id="frm_login" method="post" action="" novalidate="novalidate" class="clearfix" >
                        	<div class="form-field">
                            	<input id="txtUserName" name="useremail" type="text" maxlength="50" placeholder="Email" class="user-field required email" size="16" value="<?php echo $_COOKIE['remember_me_user']; ?>" />
                            </div>
                            <div class="form-field">
                            	<input id="txtPassword" name="password" type="password" maxlength="50" placeholder="Password" class="pass-field required" size="16" value="<?php echo $_COOKIE['remember_me_pass']; ?>" />
                            </div>
                            <div class="form-field check-box remember-me">
                            	<label class="label-field"><input type="checkbox" name="chkRember" id="chkRember" <?php if($_COOKIE['remember_me_user']!="") { echo 'checked="checked"';  } ?> value="1"/> <span>Remember me</span></label>
                            </div>
                             <div class="form-field forgo-pass">
                            	<a class="" href="forgot-password.php">Forgot Password</a>
                            </div>
                            <div class="form-btn text-center">
                            	<input type="submit" name="btnSubmit" id="btnSubmit" value="Login" />
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