<?php
	include_once "connect.php";
	$mfp->mf_isadmin();
	$currentPage = "Change Password";
	$currentMenu="Settings";
	
	if(isset($_POST['btnSubmit']))
	{
		$old_password=$_POST['old_password'];
		$new_password=$_POST['new_password'];
		
		if($_REQUEST['new_password']==$_REQUEST['re_password']){
			$mfp->mf_query("SELECT * FROM admin where password='".md5($old_password)."'");
			if(mysql_affected_rows()>0)
			{
				if($mfp->mf_dbupdate("admin",array("password"=>md5($new_password))," where id='".$_SESSION['Admin_UserID']."'"))
				{
					$mfp->mf_setmessage('<div class="alert alert-success"> <i class="fa fa-check-circle"></i>Admin area password changed successfully.<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>',"change-password.php");
					
				}
			}
			else
			{
				$mfp->mf_setmessage('<div class="alert alert-danger"><i class="fa fa-check-circle"></i>Current password does not match.<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>',"change-password.php");
				
			}
		}else
		{
			$mfp->mf_setmessage('<div class="alert alert-danger"><i class="fa fa-check-circle"></i>Confirm password does not match.<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>',"change-password.php");
			
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
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> Change Password </h1>
    </section>
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-warning"> <br/>
            <div id="SuccMSG">
              <?=$mfp->mf_viewmessage();?>
            </div>
            <div class="form">
              <form class="cmxform form-horizontal" name="changepwd" id="changepwd" method="post" action="" enctype="multipart/form-data">
                <div class="box-body">
               	  <div class="form-group">
                  <label for="first_name" class="control-label col-lg-3">Current Password *</label>
                  <div class="col-lg-6">
                    <input class="form-control required" id="old_password" name="old_password" value="<?=$old_password;?>"  type="password"  />
                  </div>
                </div>
                
                  <div class="form-group">
                  <label for="first_name" class="control-label col-lg-3">New Password *</label>
                  <div class="col-lg-6">
                     <input class="form-control required" id="new_password" type="password" name="new_password" value="<?=$new_password;?>" />
                  </div>
                </div>
              	  <div class="form-group">
                  <label for="first_name" class="control-label col-lg-3">Confirm Password *</label>
                  <div class="col-lg-6">
                     <input class="form-control required" id="re_password" type="password" equalto="#new_password"  name="re_password" value="<?=$re_password;?>"  />
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
      		 $("#changepwd").validate();
    	});
</script>
</body>
</html>