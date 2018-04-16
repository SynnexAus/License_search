<?
	include_once "connect.php";
	$mfp->mf_isadmin(); 
	$country_iso=$_REQUEST['country'];
?>
<select name="state" id="state" class="form-control"><?=$mfp->mf_createcombo("select * from states where country_iso='".$country_iso."'","state","state_name",0," - Select One - ");?></select>