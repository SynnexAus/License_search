<?	session_start();
	include_once "../include/config.php";
	include_once "../include/class.php";
	//include_once "../include/functions.php";
	
	$mfp=new db_class;
	$mfp->set_connection($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE);
	$ADMIN_MAIL=$mfp->mf_getvalue("admin","e_mail","id","1");
	$CURRENCY=$mfp->mf_getvalue("settings","currency","id","1");
?>