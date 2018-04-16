<?php
	include_once "connect.php";
	$mfp->mf_isadmin();
	$currentMenu="Users";
	$currentPage="Manage Users";
	$manage_page_link="manage-users.php";
	$id=intval($_REQUEST['id']);
	$page=(($id>0)?"Edit":"Add")." User";
	
	if($_REQUEST['act']=="del") {
		$mfp->delUploadFile("users","image_path","id",$id,"../uploads/users_profile/");
		$mfp->mf_dbdelete("users","id",$id);
		$mfp->mf_setmessage('<div class="alert alert-danger"><i class="fa fa-check-circle"></i>User information deleted successfully.<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>',"manage-users.php");
	}
	
	if($_REQUEST['act']=="delvid") {
		$mfp->delUploadFile("users","image_path","id",$id,"../uploads/users_profile/");
		$mfp->mf_setmessage('<div class="alert alert-danger"><i class="fa fa-check-circle"></i>User profile image deleted successfully.<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>', $add_page_link."?id=".$id);
	}

	//$exeQr=""; $compnyqry = '';
	$selRes=$mfp->mf_query("SELECT * FROM users where id='".$id."'");
	if($mfp->mf_affected_rows()>0) {
		$selRow=$mfp->mf_fetch_array($selRes);
		//$exeQr=" and id!='".$id."' ";
		$customer_ids=stripslashes($selRow['customer_ids']);
		$first_name=stripslashes($selRow['first_name']);
		$last_name=stripslashes($selRow['last_name']);
		$email=stripslashes($selRow['email']);
		$address=stripslashes($selRow['address']);
		$city=stripslashes($selRow['city']);
		$state=stripslashes($selRow['state']);
		$country=stripslashes($selRow['country']);
		$zip=stripslashes($selRow['zip']);
		$phone=stripslashes($selRow['phone']);
		$image_path=stripslashes($selRow['image_path']);
		
		/*$custArr = explode(",",$customer_ids);
		foreach($custArr as $cid)
		{
			$compny_name = $mfp->mf_getvalue("customers","reseller_company","id",$cid);
			$compnyqry.= "AND reseller_company!='".mysql_real_escape_string($compny_name)."'";
		}*/		
	}
	
	if(isset($_POST['btnSubmit'])) {
		$selRes=$mfp->mf_query("SELECT * FROM users where (email='".$_POST['email']."') and id!='".$id."' ");
		if($mfp->mf_affected_rows()>0){	
			$first_name=$_POST['first_name'];
			$last_name=$_POST['last_name'];
			$address=$_POST['address'];
			$city=$_POST['city'];
			$state=$_POST['state'];
			$country=$_POST['country'];
			$zip=$_POST['zip'];
			$phone=$_POST['phone'];
			$mfp->mf_setmessage('<div class="alert alert-danger"><i class="fa fa-check-circle"></i>Your email address is already registered.<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>');
		} else {
			$insArr=array();
			if($_POST['to_customer']!='')
			{
				$customer_ids = '';
				foreach($_POST['to_customer'] as $relat)
				{
					$customer_ids.= $relat.',';
				}
			}
			$insArr['customer_ids']=substr($customer_ids,0,-1);
			
			$insArr['first_name']=$_POST['first_name'];
			$insArr['last_name']=$_POST['last_name'];
			$insArr['email']=$_POST['email'];
			if($_POST['password']!=""){ $insArr['password']=md5($_POST['password']); }
			$insArr['address']=$_POST['address'];
			$insArr['city']=$_POST['city'];
			$insArr['state']=$_POST['state'];
			$insArr['country']=$_POST['country'];
			$insArr['zip']=$_POST['zip'];
			$insArr['phone']=$_POST['phone'];
			if( ! ($_FILES['image_path']['error'])){
				$mfp->delUploadFile("users","image_path","id",$id,"../uploads/users_profile/");
				$image_path=time()."_".$mfp->mf_puretext($_FILES['image_path']['name']); 
				if(copy($_FILES['image_path']['tmp_name'],"../uploads/users_profile/".$image_path))
					$insArr['image_path']=$image_path;
			}
			if($id>0) 
			{
				//echo '<pre>'; print_r($insArr); exit;
				if($mfp->mf_dbupdate("users",$insArr," where id='$id'")) 
				{
					$mfp->mf_setmessage('<div class="alert alert-success"> <i class="fa fa-check-circle"></i>Users information updated successfully.<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>',"manage-users.php");
				}
			} 
			else 
			{
				$insArr['status']=1;
				$insArr['add_date']=$mfp->curTimedate();
				//print_r($insArr);
				//var_dump($mfp->mf_dbinsert("users",$insArr));
				//die();
				if($mfp->mf_dbinsert("users",$insArr)) 
				{
					$mfp->mf_setmessage('<div class="alert alert-success"> <i class="fa fa-check-circle"></i>Users information inserted successfully.<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>',"manage-users.php");
				}
			}
		}
	}
	if($country==""){ $country="US"; }
?>
<!DOCTYPE html>
<html>
<head>
<?php include_once("head-section.php"); ?>
</head>
<body class="skin-blue">
<!-- header logo: style can be found in header.less -->
<header class="header">
  <?php include_once("header.php"); ?>
</header>
<div class="wrapper row-offcanvas row-offcanvas-left">
  <?php include_once("sidebar.php"); ?>
  <!-- Right side column. Contains the navbar and content of the page -->
  <aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$page;?>
        <a href="<?=$manage_page_link;?>" class="btn btn-primary pull-right">Back</a> </h1>
      <br>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-warning"> <br/>
            <div id="SuccMSG">
              <?=$mfp->mf_viewmessage();?>
            </div>
            <div class="form">
             <form class="cmxform form-horizontal " name="commentForm" id="commentForm" method="post" action="" autocomplete="off" enctype="multipart/form-data">
               <input type="hidden" name="id" id="id" value="<?=$id;?>" />
                <div class="form-group ">
                 <label for="first_name" class="control-label col-lg-3">Assign Reseller Companies</label>
                 <div class="col-lg-3">
                   <label for="first_name" class="control-label">Reseller Companies</label>
                   <select name="from_customer[]" id="multiselect" class="form-control" size="8" multiple="multiple">
                  <?php $custQry = $mfp->mf_query("SELECT id,reseller_company FROM reseller_code_mapping order by id asc");
						if($mfp->mf_affected_rows()>0) 
						{   
							while($custRow = $mfp->mf_fetch_array($custQry))
							{
								$reseller_company = $custRow['reseller_company'];
						?>
                        <option value="<?=$custRow['id'];?>"><?=ucfirst($reseller_company);?></option>
                      <?php } } ?>
                    </select>
                  </div>
                  <div class="col-lg-1" style="top:25px;">
                    <button type="button" id="multiselect_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                    <button type="button" id="multiselect_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                    <button type="button" id="multiselect_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                    <button type="button" id="multiselect_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                  </div>
                  <div class="col-lg-3">
                    <label for="first_name" class="control-label">Assigned Reseller Companies</label>
                    <select name="to_customer[]" id="multiselect_to" class="form-control" size="8" multiple="multiple">
                    	<?php if($id>0) { ?>
							<?php 
							echo "SELECT id,reseller_company FROM reseller_code_mapping WHERE id IN (".$customer_ids.") order by id asc";
							$custQry = $mfp->mf_query("SELECT id,reseller_company FROM reseller_code_mapping WHERE id IN (".$customer_ids.") order by id asc");
                            if($mfp->mf_affected_rows()>0) 
                            {   
                                while($custRow = $mfp->mf_fetch_array($custQry))
                                {
                                    $reseller_company = $custRow['reseller_company'];
                            ?>
                                <option value="<?=$custRow['id'];?>"><?=ucfirst($reseller_company);?></option>
                            <?php } } ?>                        	
                        <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group ">
                  <label for="first_name" class="control-label col-lg-3">First Name*</label>
                  <div class="col-lg-6">
                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?=$first_name;?>" minlength="2" required />
                  </div>
                </div>
                <div class="form-group ">
                  <label for="last_name" class="control-label col-lg-3">Last Name*</label>
                  <div class="col-lg-6">
                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?=$last_name;?>" minlength="2" required />
                  </div>
                </div>
                <div class="form-group ">
                  <label for="email" class="control-label col-lg-3">Email*</label>
                  <div class="col-lg-6">
                    <input type="email" class="form-control" id="email" name="email" value="<?=$email;?>" minlength="2" required />
                  </div>
                </div>
                <div class="form-group ">
                  <label for="password" class="control-label col-lg-3">Password*</label>
                  <div class="col-lg-6">
                    <input type="password" class="form-control" id="password" name="password" value="<?=$password;?>" minlength="2" <?php if(!$id>0) { ?> required <?php } ?> />
                    <?php if($id>0) { ?>
                    <p style="color:#F00; font-size:12px;">Leave blank, if you want to remain as it is.</p>
                    <?php } ?>
                  </div>
                </div>
                <div class="form-group ">
                  <label for="city" class="control-label col-lg-3">Address</label>
                  <div class="col-lg-6">
                    <textarea class="form-control" id="city" name="address"><?=$address;?>
</textarea>
                  </div>
                </div>
                <div class="form-group ">
                  <label for="city" class="control-label col-lg-3">City</label>
                  <div class="col-lg-6">
                    <input class="form-control" id="city" name="city" value="<?=$city;?>" type="text" />
                  </div>
                </div>
                <div class="form-group ">
                  <label for="country" class="control-label col-lg-3">Country</label>
                  <div class="col-lg-6">
                    <select name="country" id="country" class="form-control" onChange="ajaxoutput('subStateDiv', 'get_state.php', new Array('country'));" >
                      <?=$mfp->mf_createcombo("select * from country","iso","country_name",$country," - Select One - ");?>
                    </select>
                  </div>
                </div>
                <div class="form-group ">
                  <label for="state" class="control-label col-lg-3">State</label>
                  <div class="col-lg-6">
                    <div id="subStateDiv">
                      <select name="state" id="state" class="form-control">
                        <?=$mfp->mf_createcombo("select * from states where country_iso='".$country."' ","state_name","state_name",$state," - Select One - ");?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group ">
                  <label for="zip" class="control-label col-lg-3">Zip</label>
                  <div class="col-lg-6">
                    <input class="form-control" id="zip" name="zip" value="<?=$zip;?>" type="text" />
                  </div>
                </div>
                <div class="form-group ">
                  <label for="phone" class="control-label col-lg-3">Phone</label>
                  <div class="col-lg-6">
                    <input class="form-control" id="phone" name="phone" value="<?=$phone;?>" type="text" />
                  </div>
                </div>
                <div class="form-group">
                  <label id="image_path" class="control-label col-md-3">Profile Image</label>
                  <div class="col-md-4">
                    <input type="file" id="image_path" name="image_path"  class="default"/>
                    <br>
                    <?php if(is_file("../uploads/users_profile/".$image_path)) { ?>
                    Current Image | <a href="?act=delvid&id=<?=$id;?>" onClick="return confirm('Sure to delete this image...?');">Delete</a><br />
                    <img src="../uploads/users_profile/<?=$image_path;?>" style="max-height:100px; max-width:400px;" />
                    <?php } ?>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                    <button class="btn btn-primary" type="submit" name="btnSubmit">Save</button>
                    <?php if($id>0){ ?>
                    <button type="button" class="btn" onClick="window.location='manage-users.php';">Back</button>
                    <?php } else { ?>
                    <button type="reset" class="btn btn-default">Cancel</button>
                    <?php } ?>
                  </div>
                </div>
              </form>
            </div>
            <div class="box-header">
              <h3 class="box-title">&nbsp;</h3>
            </div>
            <!-- /.box-header -->
          </div>
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </aside>
  <!-- /.right-side -->
</div>
<!-- ./wrapper -->
<!-- jQuery 2.0.2 -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/AdminLTE/app.js" type="text/javascript"></script>
<script src="js/validation.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/multiselect/multiselect.min.js"></script>
<script type="text/javascript" src="assets/ckeditor/ckeditor.js"></script>
<script>
jQuery(document).ready(function() {
	jQuery("#commentForm").validate();
	jQuery('#multiselect').multiselect();
});
</script>
</body>
</html>
