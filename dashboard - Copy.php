<?php include_once("connect.php");
	if(!isset($_SESSION['UserID'])) 
	{
		//$mfp->mf_redirect($SITE_URL);
	}
	$PageName = "Homepage";
	$pageId =1;

	list($pagetitle,$pagename,$content,$browserTitle,$metaname,$metaKeywords,$metaDescription)=$mfp->mf_getMultiValue("staticpages",array("pagetitle","pagename","content","browsertitle","metaname","keywords","description"),"id",$pageId);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("header-section.php"); ?>
<link href="css/style.css" rel="stylesheet" />
</head>
<body class="dashboard-page" onload="getlicdetail(0)">
<div class="container2">
<div class="page-bg">
<?php include_once("header.php"); ?>
<div class="main-con">
	<div class="section-white section-grey license-info">
    	<div class="container">
        	<h3 class="sec-tit slideDown">License Information Search</h3>
            <div class="form-main slideUp">
              <span id="Errormsg"></span>
              <form name="licFrm" id="licFrm" action="" method="post">
              	<input type="hidden" name="paging" id="paging" value="0" />
                <div class="form-field">
                	<input id="license_id" name="license_id" type="text" value="" class="field-size-top-large" placeholder="License ID"  />
                </div>
                <div class="form-field">
                	<input id="order_id" name="order_id" type="text" value="" class="field-size-top-large" placeholder="Order ID"  />
                </div>
                <div class="form-field">
                	<input id="license_number" name="license_number" type="text" value="" class="field-size-top-large" placeholder="License number"  />
                </div>
                <div class="form-field">
                	<input id="reseller_company" name="reseller_company" type="text" value="" class="field-size-top-large" placeholder="Reseller company" />
                </div>
                <div class="form-field last">
                	<input id="customer_email" name="customer_email" type="text" value="" class="field-size-top-large" placeholder="Customer Email"  />
                </div>
                <div class="form-field expiry-date" >
                  <label class="form-label">Expiry Date</label>
                  <div class="date-field">
                    <input id="from_date" name="from_date" type="text" value="" class="field-size-top-large datepicker" placeholder="From"/>
                  </div>
                  <div class="date-field last">
                    <input id="to_date" name="to_date" type="text" value="" class="field-size-top-large datepicker" placeholder="To"/>
                  </div>
                </div>
                <div class="form-btn">
                 <button type="button" class="submit-button fst" onclick="getlicdetail(0);"><i class="fa fa-search"></i>Search</button>
                 <button type="button" class="reset-button last" onclick="window.location='<?=$SITE_URL.'dashboard.php';?>'"><i class="fa fa-refresh"></i>Reset</button>
                </div>
              </form>
              </div>
        </div>
    </div>
	<div class="section-white license-dtl tab">
    <div id="licenseData"></div>
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
function getlicdetail(pageId)
{
	var paging  = $('#paging').val();
	var license_id = jQuery("#license_id").val();
	var order_id   = jQuery("#order_id").val();
	var reseller_company = jQuery("#reseller_company").val();
	var customer_email = jQuery("#customer_email").val();
	//if(license_id!='' || order_id!='' || reseller_company!='' || customer_email!='')
	//{
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
	//}
	//else
	//{
		//jQuery("#Errormsg").html('<center><div class="alert alert-danger">Fill at least one field</div></center>');
	//}
}

function showAll()
{
	$("#paging").val('10000');
	getlicdetail(0);
}
</script>
</div>
</div><!--/.page-bg-->
</body>
</html>