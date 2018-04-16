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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XH	TML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("header-section.php"); ?>
<link href="css/style.css" rel="stylesheet" />
</head>
<body class="license-page" onload="getlicdetail(0)">
<div class="container2">
<div class="page-bg">
<?php include_once("header.php"); ?>
<div class="main-con">
	<div class="section-white section-grey section-box-license">
    	<div class="container">
        	<?php $n=0;
			$license=$mfp->mf_query("SELECT * FROM customers WHERE id='".$licenseid."'");
			if($mfp->mf_affected_rows()>0) {
				while($row=$mfp->mf_fetch_array($license)) { $n++;
				$submited_date = $row['add_date'];
				$submitedDate = date("d-m-Y", strtotime($submited_date));
				$date_expired = $row['date_expired'];
				$expiredDate = date("d-m-Y", strtotime($date_expired)); ?>
                        
            <div class="box-license">
            <h2>License Detail</h2>
            <div class="box-license-inn">
            <!--<h3>Mapstaff</h3>-->
			<?=$row['license_id'];?> <br/>
            <?=$row['license_number'];?> <br/>
            <?=$row['purchase_type'];?> <br/>
            CUst Reference: <?=$row['next_license_id'];?></div>
            </div> 
            <div class="box-license tax-invoice-box">
            <h2>Customer Detail</h2>
            <div class="box-license-inn">
            <!--<h3>GGSA701923</h3>-->
            <?=$row['customer_company'];?> <br/>
			<?=$row['customer_email'];?><br/>
            <?=$row['customer_phone'];?><br/>
            <?=$row['customer_address'];?><br/>
            <?=$row['customer_country'];?></div>
            </div>
            <div class="box-license delivery-box last">
            <h2>Reseller Detail</h2>
            <div class="box-license-inn">
            <!--<h3>Mapstaff</h3>-->
            <?=$row['reseller_company'];?><br/>
			<?=$row['reseller_status'];?><br/>
            <?=$row['reseller_country'];?></div>
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
                $submited_date = $row['add_date'];
                $submitedDate = date("d-m-Y", strtotime($submited_date));
                $date_expired = $row['date_expired'];
                $expiredDate = date("d-m-Y", strtotime($date_expired)); ?>
                <div class="order-details">
                <ul>
                    <li><span>Order Id</span> <?=$row['order_id'];?></li>
                    <li><span>QTY Seats</span> <?=$row['qty_seats'];?></li>
                    <li><span>Seats</span> <?=$row['seats'];?></li>
                    <li><span>Zipcode</span> <?=$row['zipcode'];?></li>
                    <li><span>State</span> <?=$row['state'];?></li>
                    <li><span>Account Manager</span> <?=$row['account_manager'];?></li>
                    <li><span>Validity</span> <?=$row['validity'];?></li>
                    <li><span>Revenue</span> <?=$row['revenue'];?></li>
                    <li><span>EDU Discount</span> <?=$row['edu_discount'];?></li>
                    <li><span>Discount</span> <?=$row['discount'];?></li>
                    <li><span>Channel</span> <?=$row['channel'];?></li>
                    <li><span>License Status</span> <?=$row['license_status'];?></li>
                    <li><span>IS Renewed</span> <?=$row['is_renewed'];?></li>
                    <li><span>Product</span> <?=$row['product'];?></li>
                    <li><span>Submitted Date</span> <?=$submitedDate;?></li>
                    <li><span>Expired Date</span> <?=$expiredDate;?></li>
                </ul>
                <?php /*?><table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <thead>
                        <tr>
                            <th class="order-id2">Order Id</th>
                            <th class="qty-seats2">QTY Seats</th>
                            <th class="seats2">Seats</th>
                            <th class="zipcode2">Zipcode</th>
                            <th class="state2">State</th>
                            <th class="account-manager2">Account Manager</th>
                            <th class="validity2">Validity</th>
                            <th class="revenue2">Revenue</th>
                            <th class="edu-discount2">EDU Discount</th>
                            <th class="discount2">Discount</th>
                            <th class="channel2">Channel</th>
                            <th class="license-status2">License Status</th>
                            <th class="is-renewed2">IS Renewed</th>
                            <th class="product2">Product</th>
                            <th class="submited-date2">Submitted Date</th>
                            <th class="date-expired2">Expired Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="order-id2"><?=$row['order_id'];?></td>
                            <td class="qty-seats2"><?=$row['qty_seats'];?></td>
                            <td class="seats2"><?=$row['seats'];?></td>
                            <td class="zipcode2"><?=$row['zipcode'];?></td>
                            <td class="state2"><?=$row['state'];?></td>
                            <td class="account-manager2"><?=$row['account_manager'];?></td>
                            <td class="validity2"><?=$row['validity'];?></td>
                            <td class="revenue2"><?=$row['revenue'];?></td>
                            <td class="edu-discount2"><?=$row['edu_discount'];?></td>
                            <td class="discount2"><?=$row['discount'];?></td>
                            <td class="channel2"><?=$row['channel'];?></td>
                            <td class="license-status2"><?=$row['license_status'];?></td>
                            <td class="is-renewed2"><?=$row['is_renewed'];?></td>
                            <td class="product2"><?=$row['product'];?></td>
                            <td class="submited-date2"><?=$submitedDate;?></td>
                            <td class="date-expired2"><?=$expiredDate;?></td>
                        </tr>
                    </tbody>
                </table><?php */?>            
                </div>
            <?php } } ?>
        </div>
    </div>
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
</div>
</div><!--/.page-bg-->
</body>
</html>