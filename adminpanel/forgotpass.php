<?
	include_once "connect.php";
	$adminemail=addslashes($_REQUEST['email']);
	//$chkmail=$mfp->mf_getValue("admin","admin_email","id","1");
	$chkmail=$mfp->mf_getValue("admin","admin_email","admin_email",$adminemail);
	$chkId=$mfp->mf_getValue("admin","id","admin_email",$adminemail);
	if($chkmail==$adminemail)
	{
		$newpass=rand(11111111,99999999);
		$insArr=array();
		$insArr['password']=md5($newpass);
		$mfp->mf_dbupdate("admin",$insArr," where id='".$chkId."'");
		$limite = "_parties_".md5 (uniqid (rand()));
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= "From: admin\r\n";
		
		$body="<table border='0' cellspacing='0' cellpadding='5' width='600' align='center' style='font-family:verdana; font-size:13px;'>";
		$body.="<tr><td>Dear Admin,<br><br>Your account details are below:<br></td></tr>";
		$body.="<tr><td>Username : admin</td></tr>";
		$body.="<tr><td>Password : $newpass</td></tr>";
		$body.="<tr><td><br><br>Thanks,<br>$SITE_NAME Team</td></tr>";
		$body.="</table>";
		//echo $body; exit;
		
		mail($chkmail,"Site admin area account details.",$body,$headers);
		$mfp->mf_setmessage("<div class='msggreen'>Your new password has been sent <br /> to your email address.</div>","index.php");
	}
	else
	{
		$mfp->mf_setmessage("<div class='invalid-msg'>Invalid email address to retrive password.</div>","index.php");
	}
?>