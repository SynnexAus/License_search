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
				//$submited_date = $row['add_date'];
				//$submitedDate = date("d-m-Y", strtotime($submited_date));
				//$date_expired = $row['date_expired'];
				//$expiredDate = date("d-m-Y", strtotime($date_expired)); ?>
            <div class="liboxouter clearfix">
            <div class="box-license">
                <h2>License Detail</h2>
                <div class="box-license-inn clearfix">
                    <?php /*?><h3>Mapstaff</h3><?php */?>
                    <ul>
                    <li><span>ID:</span> <?=$row['licence_id'];?></li>
                    <li><span>Status:</span> <?=$row['licence_status'];?></li>
                    <li><span>Type:</span> <?=$row['licence_type'];?></li>
                    <li class="licNum"><span>License Number:</span> <?=$row['licence_number'];?></li>
                   </ul>
                </div>
            </div> 
            <div class="box-license tax-invoice-box">
                <h2>Customer Detail</h2>
                <div class="box-license-inn clearfix">
                    <?php /*?><h3>GGSA701923</h3><?php */?>
                    <ul>
                    <li><span>Customer ID:</span> <?=$row['customer_id'];?></li>
                    <li><span>Company:</span> <?=$row['company'];?></li>
                    <li><span>Fullname:</span> <?=$row['first_name'];?>&nbsp;<?=$row['last_name'];?></li>
                    <li><span>Email:</span> <?=$row['email'];?></li>
                    <li><span>Phone:</span> <?=$row['phone'];?></li>
                    <li><span>Streets:</span> <?=$row['streets'];?></li>
                    <li><span>Address:</span> <?=$row['city'];?>, <?=$row['state'];?>, <?=$row['zip'];?></li>
                    <li><span>Country:</span> <?=$row['country'];?></li>
                    <li><span>Customer PO:</span> <?=$row['customer_po'];?></li>
                    <li><span>Club:</span> <?=$row['club'];?></li>
                    <li><span>End User Company:</span> <?=$row['end_user_company'];?></li>
                   </ul>
                </div>
            </div>
            <div class="box-license delivery-box last">
                <h2>Reseller Detail</h2>
                <div class="box-license-inn clearfix">
                    <?php /*?><h3>Mapstaff</h3><?php */?>
                    <?php
						$license=$mfp->mf_query("SELECT * FROM reseller_code_mapping WHERE avg_id='".$row['contact_id']."'");
						if($mfp->mf_affected_rows()>0) {
							while($row=$mfp->mf_fetch_array($license)) {
					?>					
                    <ul>
                    <li><span>Reseller Company:</span> <?=$row['reseller_company'];?></li>
                    <li><span>Reseller Code:</span> <?=$row['reseller_code'];?></li>
                   </ul>
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
                $expiredDate = date("d-m-Y", strtotime($date_expired)); 
			?>
            <div class="lic-detail">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
             <thead>
              <tr>
               <th>Sale Id</th>
               <th>Product Type</th>
               <th>Total Price</th>
               <th>Zipcode</th>
               <th>State</th>
               <th>Protected Computers</th>
               <th>Validity</th>
               <th>License Status</th>
               <th>Expired Date</th>
              </tr>
             </thead>
             <tbody>
              <td><?=$row['sale_id'];?></td>
              <td><?=$row['product_type'];?></td>
              <td><?='$'.$row['total_price'];?></td>
              <td><?=$row['zip'];?></td>
              <td><?=$row['state'];?></td>
              <td><?=$row['protected_computers'];?></td>
              <td><?=$row['validity'];?></td>
              <td><?=$row['licence_status'];?></td>
              <td><?=$expiredDate;?></td>
             </tbody>
            </table></div>
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