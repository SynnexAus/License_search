<?php include_once("connect.php");
	//print_r($_SESSION); exit;
	if(!isset($_SESSION['UserID'])) 
	{
		//$mfp->mf_redirect($SITE_URL);
	}
	$cid = $_REQUEST['id'];
	$PageName = "Homepage";
	$pageId =1;
	list($pagetitle,$pagename,$content,$browserTitle,$metaname,$metaKeywords,$metaDescription)=$mfp->mf_getMultiValue("staticpages",array("pagetitle","pagename","content","browsertitle","metaname","keywords","description"),"id",$pageId);
	$licenseid = $mfp->mf_getValue("customers","id","id",$_REQUEST["id"]);
	if(isset($_POST['btnUpdateLic'])) {
	  $avg_id = $mfp->mf_getValue("customers","contact_id","id",$_REQUEST["id"]);
	  extract($_POST);
	  $updQry = "UPDATE customers SET licence_id='$licence_id', licence_number='$licence_number', licence_status='$licence_status', licence_type='$licence_type', customer_id='$customer_id', company='$cust_company', first_name='$cust_first_name', last_name='$cust_last_name', email='$cust_email', phone='$cust_phone', streets='$cust_streets', city='$cust_city', state='$cust_state', zip='$cust_zip', country='$cust_country', customer_po='$cust_customer_po', club='$cust_club', end_user_company='$cust_end_user_company', sale_id='$sale_id', product_type='$product_type', total_price='$total_price', protected_computers='$protected_computers', validity='$validity', expiration_date='$expiredDate' WHERE id='".$licenseid."'";
	  $license=$mfp->mf_query($updQry);
	  
	  $updQry = "UPDATE reseller_code_mapping SET reseller_company='$reseller_company' WHERE avg_id='$avg_id'";
	  $license=$mfp->mf_query($updQry);
	  $mfp->mf_setmessage("<div class='frmgreen'>Details has been updated successfully.</div>");
	  //$mfp->mf_redirect('license-edit.php?id='.$cid); exit;
	  $mfp->mf_redirect('dashboard.php'); exit;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XH	TML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("header-section.php"); ?>
</head>
<body class="license-page" onload="getlicdetail(0)">
<div class="container2">
<div class="page-bg">
<?php include_once("header.php"); ?>
<div class="main-con">
  <form name="frmUpdateLic" id="frmUpdateLic" action="license-edit.php" method="post">
    <input type="hidden" name="id" id="id" value="<?php echo $cid;?>" />
	<div class="section-white section-grey section-box-license">
    	<div class="container">
        	<?php $n=0;
			$license=$mfp->mf_query("SELECT * FROM customers WHERE id='".$licenseid."'");
			if($mfp->mf_affected_rows()>0) {
				while($row=$mfp->mf_fetch_array($license)) { $n++;
				//$submited_date = $row['add_date'];
				//$submitedDate = date("d-m-Y", strtotime($submited_date));
				//$date_expired = $row['date_expired'];
				//$expiredDate = date("d-m-Y", strtotime($date_expired)); ?>
                <div class="inve-msg"><?=$mfp->mf_viewmessage();?></div>
                    <div class="liboxouter clearfix">
            <div class="box-license">
                <h2>License Detail</h2>
                <div class="box-license-inn clearfix">
                    <!--<h3>Mapstaff</h3>-->
                    <div class="form-group">
                        <label>ID:</label>
                        <input type="text" class="form-control" name="licence_id" value="<?=$row['licence_id'];?>" />
                    </div>
                    <div class="form-group">
                        <label>Number:</label>
                        <input type="text" class="form-control" name="licence_number" value="<?=$row['licence_number'];?>" />
                    </div>
                    <div class="form-group">
                        <label>Status:</label>
                        <input type="text" class="form-control" name="licence_status" value="<?=$row['licence_status'];?>" />
                    </div>
                    <div class="form-group">
                        <label>Type:</label>
                        <input type="text" class="form-control" name="licence_type" value="<?=$row['licence_type'];?>" />
                    </div>
                </div>
            </div> 
            <div class="box-license tax-invoice-box">
                <h2>Customer Detail</h2>
                <div class="box-license-inn clearfix">
                    <!--<h3>GGSA701923</h3>-->
                    <div class="form-group">
                        <label>Customer ID</label>
                        <input type="text" class="form-control" name="customer_id" value="<?=$row['customer_id'];?>" />
                    </div>
                    <div class="form-group">
                        <label>Company</label>
                        <input type="text" class="form-control" name="cust_company" value="<?=$row['company'];?>" />
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" name="cust_first_name" value="<?=$row['first_name'];?>" />
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" name="cust_last_name" value="<?=$row['last_name'];?>" />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" name="cust_email" value="<?=$row['email'];?>" />
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" name="cust_phone" value="<?=$row['phone'];?>" />
                    </div>
                    <div class="form-group">
                        <label>Streets</label>
                        <input type="text" class="form-control" name="cust_streets" value="<?=$row['streets'];?>" />
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" class="form-control" name="cust_city" value="<?=$row['city'];?>" />
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <input type="text" class="form-control" name="cust_state" value="<?=$row['state'];?>" />
                    </div>
                    <div class="form-group">
                        <label>Zip</label>
                        <input type="text" class="form-control" name="cust_zip" value="<?=$row['zip'];?>" />
                    </div>
                    <div class="form-group">
                        <label>Country</label>
                        <input type="text" class="form-control" name="cust_country" value="<?=$row['country'];?>" />
                    </div>
                    <div class="form-group">
                        <label>Customer_po</label>
                        <input type="text" class="form-control" name="cust_customer_po" value="<?=$row['customer_po'];?>" />
                    </div>
                    <div class="form-group">
                        <label>Club</label>
                        <input type="text" class="form-control" name="cust_club" value="<?=$row['club'];?>" />
                    </div>
                    <div class="form-group">
                        <label>End User Company</label>
                        <input type="text" class="form-control" name="cust_end_user_company" value="<?=$row['end_user_company'];?>" />
                    </div>
                </div>
            </div>
            <div class="box-license delivery-box last">
                <h2>Reseller Detail</h2>
                <div class="box-license-inn clearfix">
                    <!--<h3>Mapstaff</h3>-->
                    <?php
						$license=$mfp->mf_query("SELECT * FROM reseller_code_mapping WHERE avg_id='".$row['contact_id']."'");
						if($mfp->mf_affected_rows()>0) {
							while($row=$mfp->mf_fetch_array($license)) {
					?>	
                    <div class="form-group">				
                        <label>Reseller Company</label>
                        <input type="text" class="form-control" name="reseller_company" value="<?=$row['reseller_company'];?>" />
                    </div>
                    <div class="form-group">
                    	<label>Reseller Code</label>
                        <?=$row['reseller_code'];?>
                    </div>
                    
                    <?php } } ?>
                </div>
            </div> 
            </div>
          <?php } } ?>
        </div>
    </div>
	<div class="section-white tab order-details-sec custome-detail">
    	<div class="container">
            <div class="sec-tit2">
                <div class="container"><h3>order Details</h3></div>
            </div>
            <?php $n=0;
            $license=$mfp->mf_query("SELECT * FROM customers WHERE id='".$licenseid."'");
            if($mfp->mf_affected_rows()>0) {
                while($row=$mfp->mf_fetch_array($license)) { $n++;
                //$submited_date = $row['add_date'];
                //$submitedDate = date("d-m-Y", strtotime($submited_date));
                $date_expired = $row['expiration_date'];
                //$expiredDate = date("d-m-Y", strtotime($date_expired)); 
			?>
                <div class="order-details form-box">
                  <ul>
                    <li><span>Sale Id</span> <input type="text" name="sale_id" value="<?=$row['sale_id'];?>" /></li>
                    <li><span>Product Type</span> <input type="text" name="product_type" value="<?=$row['product_type'];?>" /></li>
                    <li><span>Total Price</span> <input type="text" name="total_price" value="<?=$row['total_price'];?>" /></li>
                    <li><span>Zipcode</span> <input type="text" name="zip" value="<?=$row['zip'];?>" /></li>
                    <li><span>State</span> <input type="text" name="state" value="<?=$row['state'];?>" /></li>
                    <li><span>Protected Computers</span> <input type="text" name="protected_computers" value="<?=$row['protected_computers'];?>" /></li>
                    <li><span>Validity</span> <input type="text" name="validity" value="<?=$row['validity'];?>" /></li>
                    <li><span>License Status</span> <input type="text" name="licence_status" value="<?=$row['licence_status'];?>" /></li>                    
                    <li><span>Expired Date</span> <input type="text" name="expiredDate" value="<?=$date_expired;?>" /></li>
                  </ul>                        
                </div>
            <?php } } ?>
        	<div class="form-btn text-center"><button class="submit-button fst" type="submit" name="btnUpdateLic" id="btnUpdateLic"><i class="fa fa-save"></i>Update</button></div>
        </div>
    </div>
  </form>
</div>
<?php //include_once("footer.php"); ?>
<script src="js/jQuery 1.11.3.js" type="text/javascript"></script>
<script src="js/jquery-ui.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css">
<script src="https://img07.en25.com/i/livevalidation_standalone.compressed.js" type="text/javascript" ></script>
<script type="text/javascript" >
$(function() {
	$(".datepicker").datepicker({
		dateFormat : 'dd-mm-yy',
	});
});
function getlicdetail(pageId){
	var paging  = $('#paging').val();
	var license_id = jQuery("#license_id").val();
	var order_id   = jQuery("#order_id").val();
	var reseller_company = jQuery("#reseller_company").val();
	var customer_email = jQuery("#customer_email").val();
	jQuery.ajax({
		url: "getlicdetail.php",
		type: "POST",
		data:  jQuery("#licFrm").serialize()+"&pageId="+pageId+"&paging="+paging,
		success: function(data) 
		{ 
			jQuery("#licenseData").html(data);
			return false;
		}
	});
}
</script>
<script>
equalheight = function(container){
var currentTallest = 0,
     currentRowStart = 0,
     rowDivs = new Array(),
     jQueryel,
     topPosition = 0;
 jQuery(container).each(function() {

   jQueryel = jQuery(this);
   jQuery(jQueryel).height('auto')
   topPostion = jQueryel.position().top;
   if (currentRowStart != topPostion) {
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
     rowDivs.length = 0; // empty the array
     currentRowStart = topPostion;
     currentTallest = jQueryel.height();
     rowDivs.push(jQueryel);
   } else {
     rowDivs.push(jQueryel);
     currentTallest = (currentTallest < jQueryel.height()) ? (jQueryel.height()) : (currentTallest);
  }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }
 });
}


jQuery(window).load(function() {
  equalheight('.section-box-license .liboxouter');
 // equalheight('.testimonials-page .row');
});
jQuery(window).resize(function(){
  equalheight('.section-box-license .liboxouter');
  //equalheight('.testimonials-page .row');
});
</script>
</div>
</div><!--/.page-bg-->
</body>
</html>