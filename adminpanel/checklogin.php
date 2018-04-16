<?
	include_once "connect.php";
	if($_POST['login-check'] == 1)
	{
		$year = time() + 31536000;
		setcookie('remember_me_user', $_POST['username'], $year);
		setcookie('remember_me_pass', $_POST['password'], $year);
	}
	else
	{
		if($_COOKIE['remember_me_user'] == $_POST['username'] && $_COOKIE['remember_me_pass'] == $_POST['password'])
		{
			$year = time() - 31536000;
			setcookie("remember_me_user", "", $year);
			setcookie("remember_me_pass", "", $year);
			
		}
	}
	
 	$valid=$mfp->mf_check_login("admin",$_POST['username'],$_POST['password']);
		
	if($valid>0)
	{
		$is_active=$mfp->mf_getValue("admin","status","id",$valid);	
		if($is_active == 1)
		{
			session_regenerate_id();
			$_SESSION['Admin_UserID']=$valid;
			$_SESSION['Role_ID']=$mfp->mf_getvalue("admin","role","id",$valid);
			$_SESSION['SESSION_ID']=session_id();
			$mfp->mf_redirect("dashboard.php");
			exit;
		}else{
			$mfp->mf_setmessage("<div class='invalid-msg'>&nbsp;Sorry, your account is not active</div>","index.php");		
		}
		
	}
	else
	{
		$mfp->mf_setmessage("<div class='invalid-msg'>Invalid username/password.</div>","index.php");
		
	}
?>