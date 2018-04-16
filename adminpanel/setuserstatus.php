<?php
	include_once "connect.php";
	$mfp->mf_isadmin();

	$uid=intval($_REQUEST['uid']);
	$ust=intval($_REQUEST['ust']);

	$insArr=array();
	$insArr['status']=$ust;
	
	$mfp->mf_dbupdate("users",$insArr," where id='$uid'");
	if($ust==1)
		echo '<div class="alert alert-success"><i class="fa fa-check-circle"></i>User has been actived successfully.<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>';
	else
		echo '<div class="alert alert-danger"> <i class="fa fa-check-circle"></i>User has been deactivated successfully.<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>';
		
		
?>