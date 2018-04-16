<?php include_once("connect.php");
unset($_SESSION['UserID']);
unset($_SESSION['User_fName']);
unset($_SESSION['User_lName']);
session_destroy();
$mfp->mf_redirect($SITE_URL);
?>








 

