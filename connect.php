<?php error_reporting(0); 

	ini_set('session.gc_maxlifetime', 3600);
	session_set_cookie_params(3600);
	session_start(); 
	include_once "include/config.php";
	include_once "include/class.php";
	
	$mfp=new db_class;
	$mfp->set_connection($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE);
	
	$ADMIN_MAIL=$mfp->mf_getValue("admin","admin_email","id",1);
	include_once("content_check.php");
	$CURRENCY=$mfp->mf_getvalue("settings","currency","id","1");
?>