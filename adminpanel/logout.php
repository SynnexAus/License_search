<?
	session_start();
	unset($_SESSION['Admin_UserID']);
	unset($_SESSION['Role_ID']);
	echo "<script> window.location='index.php'; </script>";
	exit;
?>