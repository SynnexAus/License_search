<?php
	include_once "connect.php";
	$mfp->mf_isadmin();
	$currentPage = "Profile";
	$currentMenu="Settings";	
	
	if($_REQUEST['act']=="delvid")
	{
		$mfp->delUploadFile("admin","image_path","id",$_SESSION['Admin_UserID'],"../uploads/profile/");
		$mfp->mf_setmessage('<div class="alert alert-danger"> <i class="fa fa-check-circle"></i>Profile Image deleted successfully.<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>',"profile.php");
	}
	
	$selqry = $mfp->mf_query("select * from admin where id =".$_SESSION['Admin_UserID']);
	if($mfp->mf_affected_rows()>0)
	{
		$selRow=$mfp->mf_fetch_array($selqry);
		$role=stripslashes($selRow['role']);
		$first_name=stripslashes($selRow['first_name']);
		$last_name=stripslashes($selRow['last_name']);	
		$username=stripslashes($selRow['username']);	
		$admin_email=stripslashes($selRow['admin_email']);
		$status=stripslashes($selRow['status']);		
		$image_path=stripslashes($selRow['image_path']);
		$address=stripslashes($selRow['address']);	
		$city=stripslashes($selRow['city']);
		$state=stripslashes($selRow['state']);
		$cellphone=stripslashes($selRow['cellphone']);
		if($selRow['last_login']!="0000-00-00 00:00:00"){ $last_login=$mfp->dispTZTimedate($selRow['last_login']); }
		
	}
	if(isset($_REQUEST['btnSubmit']))
	{
		$insArr=array();
		$insArr['first_name']=$_POST['first_name'];
		$insArr['last_name']=$_POST['last_name'];
		$insArr['address']=$_POST['address'];
		$insArr['city']=$_POST['city'];
		$insArr['state']=$_POST['state'];
		$insArr['admin_email']=$_POST['admin_email'];
		$insArr['cellphone']=$_POST['cellphone'];			
		
		if( ! ($_FILES['image_path']['error']))
		{ 
			$mfp->delUploadFile("admin","image_path","id",$id,"../uploads/profile/");
			$image_path=time()."_".$mfp->mf_puretext($_FILES['image_path']['name']);
			if(copy($_FILES['image_path']['tmp_name'],"../uploads/profile/".$image_path))
				$insArr['image_path']=$image_path;
		}
	
		if($mfp->mf_dbupdate("admin",$insArr," where id='".$_SESSION['Admin_UserID']."'"))
		{
			$mfp->mf_setmessage('<div class="alert alert-success"> <i class="fa fa-check-circle"></i>Profile information updated successfully.<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>',"profile.php");
			
			exit;
		}
	}
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
  <!-- Left side column. contains the logo and sidebar -->
  <?php include_once("sidebar.php"); ?>
  <!-- Right side column. Contains the navbar and content of the page -->
  <aside class="right-side">
   <section class="content-header">
      <h1>
        Profile
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-warning">
            <br/>
            <div id="SuccMSG">
              <?=$mfp->mf_viewmessage();?>
            </div>
            <div class="form">
              <form class="cmxform form-horizontal " name="commentForm" id="commentForm" method="post" action="" autocomplete="off" enctype="multipart/form-data">
                <br/>
                <div class="form-group ">
                  <label for="first_name" class="control-label col-lg-3">First Name*</label>
                  <div class="col-lg-6">
                    <input class="form-control required" id="first_name" name="first_name" value="<?=$first_name;?>"  type="text"  />
                  </div>
                </div>
                <div class="form-group ">
                  <label for="username" class="control-label col-lg-3">Last Name*</label>
                  <div class="col-lg-6">
                    <input class="form-control required" id="last_name" name="last_name" value="<?=$last_name;?>"  type="text"  />
                  </div>
                </div>
                    
                <div class="form-group ">
                  <label for="admin_email" class="control-label col-lg-3">Email*</label>
                  <div class="col-lg-6">
                    <input class="form-control required email" id="admin_email" type="text" name="admin_email" value="<?=$admin_email;?>"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3">Profile Image</label>
                  <div class="col-md-4">
                    <input type="file" name="image_path"  class="default" value="<?=$image_path;?>" />
                    <br>
                    <?php if(is_file("../uploads/profile/".$image_path)) { ?>
                    Current Image | <a href="?act=delvid&id=<?=$id;?>" onClick="return confirm('Sure to delete this image...?');">Delete</a><br>
                    <img src="../uploads/profile/<?=$image_path;?>" style="max-width: 150px; max-height: 100px; line-height: 20px;"/><br>
                    <?php } ?>
                  </div>
                </div>
                
                <div class="form-group ">
                  <label for="username" class="control-label col-lg-3">Address*</label>
                  <div class="col-lg-6">
                    <input class=" form-control required" id="address" name="address" value="<?=$address;?>" type="text" />
                  </div>
                </div>
                <div class="form-group ">
                  <label for="username" class="control-label col-lg-3">City*</label>
                  <div class="col-lg-6">
                    <input class=" form-control required" id="city" name="city" value="<?=$city;?>" type="text" />
                  </div>
                </div>
                <div class="form-group ">
                  <label for="username" class="control-label col-lg-3">State*</label>
                  <div class="col-lg-6">
                    <input class=" form-control required" id="state" name="state" value="<?=$state;?>" type="text" />
                  </div>
                </div>
                <?php /*?><div class="form-group ">
                  <label for="username" class="control-label col-lg-3">Zip*</label>
                  <div class="col-lg-6">
                    <input class=" form-control required" id="zip" name="zip" value="<?=$zip;?>" type="text" />
                  </div>
                </div><?php */?>
                <div class="form-group ">
                  <label for="username" class="control-label col-lg-3">Cell Phone</label>
                  <div class="col-lg-6">
                    <input class=" form-control" id="cellphone" name="cellphone" value="<?=$cellphone;?>"  type="text"  />
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                    <button class="btn btn-primary" type="submit" name="btnSubmit">Save</button>
                     <button type="button" class="btn" onClick="window.location='dashboard.php';">Back</button>
                  
                  </div>
                </div>
              </form>
           </div>
            <div class="box-header">
              <h3 class="box-title">&nbsp;</h3>
            </div>
          </div>
        </div>
      </div>
    </section>
  </aside>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/AdminLTE/app.js" type="text/javascript"></script>
<script src="js/validation.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script>
		 $( document ).ready(function() {
      		 $("#commentForm").validate();
    	});
</script>
</body>
</html>
