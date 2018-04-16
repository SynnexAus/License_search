<?php
	include_once "connect.php";
	if($_SESSION['Role_ID']!="1"){ $mfp->mf_redirect('dashboard.php'); }
	$mfp->mf_isadmin();
	$currentMenu="Settings";
	$currentPage="Manage Settings";
	$page="Settings";
	$id=intval($_REQUEST['id']);	

	$selRes=$mfp->mf_query("SELECT * FROM settings where id='1'");
	if($mfp->mf_affected_rows()>0)
	{
		$selRow=$mfp->mf_fetch_array($selRes);
		$facebook=stripslashes($selRow['facebook']);
		$twitter=stripslashes($selRow['twitter']);
		$youtube=stripslashes($selRow['youtube']);
		$too=stripslashes($selRow['too']);
		$currency=stripslashes($selRow['currency']);
		$address=stripslashes($selRow['address']);
		$city=stripslashes($selRow['city']);
		$state=stripslashes($selRow['state']);
		$zipcode=stripslashes($selRow['zipcode']);
		$phone=stripslashes($selRow['phone']);
		$email=stripslashes($selRow['email']);
		$about_company=stripslashes($selRow['about_company']);
	}	

	if(isset($_POST['btnSubmit']))
	{
		$insArr=array();
		$insArr['facebook']=$_POST['facebook'];
		$insArr['twitter']=$_POST['twitter'];
		$insArr['youtube']=$_POST['youtube'];
		$insArr['too']=$_POST['too'];
		$insArr['currency']=$_POST['currency'];
		$insArr['address']=$_POST['address'];
		$insArr['city']=$_POST['city'];
		$insArr['state']=$_POST['state'];
		$insArr['zipcode']=$_POST['zipcode'];
		$insArr['phone']=$_POST['phone'];
		$insArr['email']=$_POST['email'];
		$insArr['about_company']=$_POST['about_company'];
		$map = $mfp->getCoordLL($_POST['address'].', '.$_POST['city'].', '.$_POST['state'].', '.$_POST['zipcode']);
		$insArr['latitude'] = $map[0];
		$insArr['longitude'] = $map[1];
				
		
		if($mfp->mf_dbupdate("settings",$insArr," where id=1"))
		{
			$mfp->mf_setmessage('<div class="alert alert-success"> <i class="fa fa-check-circle"></i>Settings information updated successfully.<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>',"manage-settings.php");
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
      <h1><?=$page;?></h1>
    </section>
    
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
             <br/>
            <!-- /.box-header -->
            <?=$mfp->mf_viewmessage();?>
            <form class="cmxform form-horizontal" id="setting" method="post" action="" enctype="multipart/form-data" />
             <div class=" form">
              <div class="suspmsgouter"><span id="SuspMsg">
                <?=$mfp->mf_viewmessage();?>
                </span></div>
                <br/>              
                <?php /*?><div class="form-group">
                <label for="cemail" class="control-label col-lg-3">Facebook</label>
                <div class="col-lg-6">
                  <input class="form-control" type="text" name="facebook" id="facebook" value="<?=$facebook;?>" />
                </div>
              </div>
			    <div class="form-group">
                <label for="cemail" class="control-label col-lg-3">Twitter</label>
                <div class="col-lg-6">
                  <input class="form-control" type="text" name="twitter" id="twitter" value="<?=$twitter;?>" />
                </div>
              </div>
			    <div class="form-group">
                <label for="cemail" class="control-label col-lg-3">Youtube</label>
                <div class="col-lg-6">
                  <input class="form-control" type="text" name="youtube" id="youtube" value="<?=$youtube;?>" />
                </div>
              </div><?php */?>
                <div class="form-group">
                <label for="cemail" class="control-label col-lg-3">Email</label>
                <div class="col-lg-6">
                  <input class="form-control required email" type="text" name="email" id="email" value="<?=$email;?>" />
                </div>
              </div>
                <div class="form-group">
                <label for="cemail" class="control-label col-lg-3">Address</label>
                <div class="col-lg-6">
                  <input class="form-control required" type="text" name="address" id="address" value="<?=$address;?>" />
                </div>
              </div>
                <div class="form-group">
                <label for="cemail" class="control-label col-lg-3">City</label>
                <div class="col-lg-6">
                  <input class="form-control required" type="text" name="city" id="city" value="<?=$city;?>" />
                </div>
              </div>
                <div class="form-group">
                <label for="cemail" class="control-label col-lg-3">State</label>
                <div class="col-lg-6">
                  <input class="form-control required" type="text" name="state" id="state" value="<?=$state;?>" />
                </div>
              </div>
                <div class="form-group">
                <label for="cemail" class="control-label col-lg-3">Zipcode</label>
                <div class="col-lg-6">
                  <input class="form-control required" type="text" name="zipcode" id="zipcode" value="<?=$zipcode;?>" />
                </div>
              </div>
               <div class="form-group">
                <label for="cemail" class="control-label col-lg-3">Phone</label>
                <div class="col-lg-6">
                  <input class="form-control required" type="text" name="phone" id="phone" value="<?=$phone;?>" />
                </div>
              </div>
               <div class="form-group">
                <label for="cemail" class="control-label col-lg-3">Currency</label>
                <div class="col-lg-6">
                  <input class="form-control required" type="text" name="currency" id="currency" value="<?=$currency;?>" />
                </div>
              </div>
			    <div class="form-group">
                <label for="cemail" class="control-label col-lg-3">To</label>
                <div class="col-lg-6">
                  <input class="form-control required email" type="text" name="too" id="too" value="<?=$too;?>" />
                </div>
              </div>
                <?php /*?><div class="form-group">
                <label for="cemail" class="control-label col-lg-3">Is Special</label>
                <div class="col-lg-6">
                  <input name="is_special" id="is_special" value="1" type="checkbox" onClick="ShowSpecial();" <?=($is_special==1)?"checked":"";?>/>
                </div>
              </div>
			  <div id="dvspecial">
					<div class="form-group ">
						<label for="cemail" class="control-label col-lg-3">Special Off (%)</label>
						<div class="col-lg-6">
							<input class="form-control" name="percent" id="percent" value="<?=$percent;?>" type="text" />
						</div>
					</div>
					<div class="form-group">
						<label for="cemail" class="control-label col-lg-3">Special Amount</label>
						<div class="col-lg-6">
							<input class="form-control" name="amount" id="amount" value="<?=$amount;?>" type="text" />
						</div>
					</div>
				</div><?php */?>
			
			<?php /*?><div class="form-group">
				<label for="curl" class="control-label col-lg-3">New Beginnings</label>
				<div class="col-sm-6">
					<textarea class="form-control" name="new_begining" rows="4"><?=$new_begining;?></textarea>
				</div>
			</div><?php */?>
                <?php /*?><div class="form-group">
                    <label for="curl" class="control-label col-lg-3">About Company</label>
                    <div class="col-sm-6">
                        <textarea class="form-control" name="about_company" rows="4"><?=$about_company;?></textarea>
                    </div>
                </div><?php */?>
				<div class="form-group">
              <div class="col-lg-offset-3 col-lg-6">
                <input type="submit" class="btn btn-primary" name="btnSubmit" value="Save">
                <button type="button" class="btn" onClick="window.location='dashboard.php';">Back</button>
                
              </div>
            </div>
            	<div class="box-header">
              <h3 class="box-title">&nbsp;</h3>
            </div>
              </div>
            </form>
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
<!-- add new calendar event modal -->
<!-- jQuery 2.0.2 -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/AdminLTE/app.js" type="text/javascript"></script>
<script src="js/validation.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script>
	$( document ).ready(function() {
		$("#setting").validate();
	});
</script>
</body>
</html>