<?php
	include_once "connect.php";
	$mfp->mf_isadmin();

	$time_out=$_REQUEST['time_out'];
	$time_in=$_REQUEST['time_in'];
	
	$time_in1  = date("H:i", strtotime($time_in));
	$time_out1  = date("H:i", strtotime($time_out));
	
	if($time_in1>$time_out1)
	{
		echo 1;
	}else{	
	$date1 = "2014-11-13 ".$time_in1;
	$date2 = "2014-11-13 ".$time_out1;
	$timestamp1 = strtotime($date1);
	$timestamp2 = strtotime($date2);
	echo $hour = abs($timestamp2 - $timestamp1)/(60*60) . " Hours";	
	}
	

		
?>