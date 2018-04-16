<?php
	include_once "connect.php";
	$mfp->mf_isadmin();
	$currentMenu="Customers";
	$currentPage="Manage Customers";
	$manage_page_link="manage-customers.php";
	$id=intval($_REQUEST['id']);
	$page=(($id>0)?"Edit":"Add")." Customer";
	
	if($_REQUEST['act']=="del") {
		$mfp->mf_dbdelete("customers","id",$id);
		$mfp->mf_setmessage('<div class="alert alert-danger"><i class="fa fa-check-circle"></i>Customer information deleted successfully.<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>',"manage-customers.php");
	}
	
	$exeQr="";
	$selRes=$mfp->mf_query("SELECT * FROM customers where id='".$id."'");
	if($mfp->mf_affected_rows()>0) {
		$selRow=$mfp->mf_fetch_array($selRes);
		//$exeQr=" and id!='".$id."' ";
		$license_id=stripslashes($selRow['license_id']);
		$order_id=stripslashes($selRow['order_id']);
		$license_number=stripslashes($selRow['license_number']);
		$purchase_type=stripslashes($selRow['purchase_type']);
		$qty_seats=stripslashes($selRow['qty_seats']);
		$seats=stripslashes($selRow['seats']);
		$reseller_company=stripslashes($selRow['reseller_company']);
		$reseller_status=stripslashes($selRow['reseller_status']);
		$reseller_country=stripslashes($selRow['reseller_country']);
		$customer_company=stripslashes($selRow['customer_company']);
		$customer_email=stripslashes($selRow['customer_email']);
		$customer_phone=stripslashes($selRow['customer_phone']);
		$customer_address=stripslashes($selRow['customer_address']);
		$zipcode=stripslashes($selRow['zipcode']);
		$state=stripslashes($selRow['state']);
		$account_manager=stripslashes($selRow['account_manager']);
		$customer_country=stripslashes($selRow['customer_country']);
		$validity=stripslashes($selRow['validity']);
		$date_expired=stripslashes($selRow['date_expired']);
		$revenue=stripslashes($selRow['revenue']);
		$edu_discount=stripslashes($selRow['edu_discount']);
		$discount=stripslashes($selRow['discount']);
		$channel=stripslashes($selRow['channel']);
		$is_renewed=stripslashes($selRow['is_renewed']);
		$product=stripslashes($selRow['product']);
		$next_license_id=stripslashes($selRow['next_license_id']);
	}
	
	if(isset($_POST['btnSubmit'])) 
	{
		$insArr=array();
		$insArr['license_id']=$_POST['license_id'];
		$insArr['order_id']=$_POST['order_id'];
		$insArr['license_number']=$_POST['license_number'];
		$insArr['purchase_type']=$_POST['purchase_type'];
		$insArr['qty_seats']=$_POST['qty_seats'];
		$insArr['seats']=$_POST['seats'];
		$insArr['reseller_company']=$_POST['reseller_company'];
		$insArr['reseller_status']=$_POST['reseller_status'];
		$insArr['reseller_country']=$_POST['reseller_country'];
		$insArr['customer_company']=$_POST['customer_company'];
		$insArr['customer_email']=$_POST['customer_email'];
		$insArr['customer_phone']=$_POST['customer_phone'];
		$insArr['customer_address']=$_POST['customer_address'];
		$$insArr['zipcode']=$_POST['zipcode'];
		$insArr['state']=$_POST['state'];
		$insArr['account_manager']=$_POST['account_manager'];
		$insArr['customer_country']=$_POST['customer_country'];
		$$insArr['validity']=$_POST['validity'];
		$insArr['date_expired']=$_POST['date_expired'];
		$insArr['revenue']=$_POST['revenue'];
		$insArr['edu_discount']=$_POST['edu_discount'];
		$$insArr['discount']=$_POST['discount'];
		$insArr['channel']=$_POST['channel'];
		$insArr['is_renewed']=$_POST['is_renewed'];
		$insArr['product']=$_POST['product'];
		$insArr['next_license_id']=$_POST['next_license_id'];
		
		if($id>0) {
			if($mfp->mf_dbupdate("customers",$insArr," where id='$id'")) {
				$mfp->mf_setmessage('<div class="alert alert-success"> <i class="fa fa-check-circle"></i>Customer information updated successfully.<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>',"manage-customers.php");
			}
		} else {
			$insArr['status']=1;
			$insArr['add_date']=$mfp->curTimedate();
			//print_r($insArr);
			//var_dump($mfp->mf_dbinsert("users",$insArr));
			//die();
			if($mfp->mf_dbinsert("customers",$insArr)) {
				$mfp->mf_setmessage('<div class="alert alert-success"> <i class="fa fa-check-circle"></i>Customer information inserted successfully.<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>',"manage-customers.php");
			}
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
  <?php include_once("sidebar.php"); ?>
  <!-- Right side column. Contains the navbar and content of the page -->
  <aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
	  	<?=$page;?>
		<a href="<?=$manage_page_link;?>" class="btn btn-primary pull-right">Back</a>
	</h1>
	<br>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-warning"> <br/>
            <div id="SuccMSG"><?=$mfp->mf_viewmessage();?></div>
            <div class="form">
              <form class="cmxform form-horizontal " name="commentForm" id="commentForm" method="post" action="" autocomplete="off" enctype="multipart/form-data">
			  		<input type="hidden" name="id" id="id" value="<?=$id;?>" />
					<div class="form-group">
						<label for="first_name" class="control-label col-lg-3">License ID</label>
						<div class="col-lg-6">
							<input class="form-control" id="license_id" name="license_id" value="<?=$license_id;?>" minlength="2" type="text" required />
						</div>
					</div>
                    <div class="form-group">
						<label for="last_name" class="control-label col-lg-3">Order ID*</label>
						<div class="col-lg-6">
							<input class="form-control" id="order_id" name="order_id" value="<?=$order_id;?>" minlength="2" type="text" required />
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="control-label col-lg-3">License Number*</label>
						<div class="col-lg-6">
							<input class="form-control" id="license_number" name="license_number" value="<?=$license_number;?>" type="text" required />
						</div>
					</div>
					<div class="form-group">
						<label for="city" class="control-label col-lg-3">Purchase Type</label>
						<div class="col-lg-6">
							<input class="form-control" id="purchase_type" name="purchase_type" value="<?=$purchase_type;?>" type="text" />
						</div>
					</div>
					<div class="form-group">
						<label for="zip" class="control-label col-lg-3">Qty Seats</label>
						<div class="col-lg-6">
							<input class="form-control" id="qty_seats" name="qty_seats" value="<?=$qty_seats;?>" type="text" />
						</div>
					</div>
					<div class="form-group">
						<label for="phone" class="control-label col-lg-3">Seats</label>
						<div class="col-lg-6">
							<input class="form-control" id="seats" name="seats" value="<?=$seats;?>" type="text" />
						</div>
					</div>
                    <div class="form-group">
						<label for="phone" class="control-label col-lg-3">Reseller Company*</label>
						<div class="col-lg-6">
							<input class="form-control" id="reseller_company" name="reseller_company" value="<?=$reseller_company;?>" type="text" required />
						</div>
					</div>
                    <div class="form-group">
						<label for="phone" class="control-label col-lg-3">Reseller Status</label>
						<div class="col-lg-6">
							<input class="form-control" id="reseller_status" name="reseller_status" value="<?=$reseller_status;?>" type="text" />
						</div>
					</div>
                    <div class="form-group">
						<label for="phone" class="control-label col-lg-3">Reseller Country</label>
						<div class="col-lg-6">
							<input class="form-control" id="reseller_country" name="reseller_country" value="<?=$reseller_country;?>" type="text" />
						</div>
					</div>
                    <div class="form-group">
						<label for="phone" class="control-label col-lg-3">Customer Company</label>
						<div class="col-lg-6">
							<input class="form-control" id="customer_company" name="customer_company" value="<?=$customer_company;?>" type="text" />
						</div>
					</div>
                    <div class="form-group">
						<label for="phone" class="control-label col-lg-3">Customer Email*</label>
						<div class="col-lg-6">
							<input class="form-control email" id="customer_email" name="customer_email" value="<?=$customer_email;?>" type="text" required />
						</div>
					</div>
                    <div class="form-group">
						<label for="phone" class="control-label col-lg-3">Customer Phone</label>
						<div class="col-lg-6">
							<input class="form-control" id="customer_phone" name="customer_phone" value="<?=$customer_phone;?>" type="text" />
						</div>
					</div>
                    <div class="form-group">
						<label for="phone" class="control-label col-lg-3">Customer Address</label>
						<div class="col-lg-6">
							<input class="form-control" id="customer_address" name="customer_address" value="<?=$customer_address;?>" type="text" />
						</div>
					</div>
                    <div class="form-group">
						<label for="phone" class="control-label col-lg-3">Zip</label>
						<div class="col-lg-6">
							<input class="form-control" id="zipcode" name="zipcode" value="<?=$zipcode;?>" type="text" />
						</div>
					</div>
                    <div class="form-group">
						<label for="phone" class="control-label col-lg-3">State</label>
						<div class="col-lg-6">
							<input class="form-control" id="state" name="state" value="<?=$state;?>" type="text" />
						</div>
					</div>
                    <div class="form-group">
						<label for="phone" class="control-label col-lg-3">Account Manager</label>
						<div class="col-lg-6">
							<input class="form-control" id="account_manager" name="account_manager" value="<?=$account_manager;?>" type="text" />
						</div>
					</div>
                    <div class="form-group">
						<label for="phone" class="control-label col-lg-3">Customer Country</label>
						<div class="col-lg-6">
							<input class="form-control" id="customer_country" name="customer_country" value="<?=$customer_country;?>" type="text" />
						</div>
					</div>
                    <div class="form-group">
						<label for="phone" class="control-label col-lg-3">Validity</label>
						<div class="col-lg-6">
							<input class="form-control" id="validity" name="validity" value="<?=$validity;?>" type="text" />
						</div>
					</div>
                    <div class="form-group">
						<label for="phone" class="control-label col-lg-3">Date Expired</label>
						<div class="col-lg-6">
							<input class="form-control datepicker" id="date_expired" name="date_expired" value="<?=$date_expired;?>" type="text" />
						</div>
					</div>
                    <div class="form-group">
						<label for="phone" class="control-label col-lg-3">Revenue</label>
						<div class="col-lg-6">
							<input class="form-control" id="revenue" name="revenue" value="<?=$revenue;?>" type="text" />
						</div>
					</div>
                    <div class="form-group">
						<label for="phone" class="control-label col-lg-3">EDU Discount</label>
						<div class="col-lg-6">
							<input class="form-control" id="edu_discount" name="edu_discount" value="<?=$edu_discount;?>" type="text" />
						</div>
					</div>
                    <div class="form-group">
						<label for="phone" class="control-label col-lg-3">Discount</label>
						<div class="col-lg-6">
							<input class="form-control" id="discount" name="discount" value="<?=$discount;?>" type="text" />
						</div>
					</div>
                    <div class="form-group">
						<label for="phone" class="control-label col-lg-3">Channel</label>
						<div class="col-lg-6">
							<input class="form-control" id="channel" name="channel" value="<?=$channel;?>" type="text" />
						</div>
					</div>
                    <div class="form-group">
						<label for="phone" class="control-label col-lg-3">Is Renewed</label>
						<div class="col-lg-6">
							<input class="form-control" id="is_renewed" name="is_renewed" value="<?=$is_renewed;?>" type="text" />
						</div>
					</div>
                    <div class="form-group">
						<label for="phone" class="control-label col-lg-3">Product</label>
						<div class="col-lg-6">
							<input class="form-control" id="product" name="product" value="<?=$product;?>" type="text" />
						</div>
					</div>
                    <div class="form-group">
						<label for="phone" class="control-label col-lg-3">Next License ID</label>
						<div class="col-lg-6">
							<input class="form-control" id="next_license_id" name="next_license_id" value="<?=$next_license_id;?>" type="text" />
						</div>
					</div>
                    <div class="form-group">
						<div class="col-lg-offset-3 col-lg-6">
							<button class="btn btn-primary" type="submit" name="btnSubmit">Save</button>
							<?php if($id>0){ ?>
								<button type="button" class="btn" onClick="window.location='manage-customers.php';">Back</button>
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
<script type="text/javascript" src="assets/ckeditor/ckeditor.js"></script>
<script>
$( document ).ready(function() {
	$("#commentForm").validate();
});
</script>
</body>
</html>
