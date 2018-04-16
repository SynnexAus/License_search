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
</head>
<!--<body class="dashboard-page" onload="getlicdetail(0)">-->
<body class="dashboard-page">
<div class="container2">
<div class="page-bg">
<?php include_once("header.php"); ?>
<div class="main-con">
	<div class="section-white section-grey license-info">
    	<div class="container">
        	<h3 class="sec-tit">License Information Search</h3>
            <div class="form-main">
              <div class="inve-msg"><?=$mfp->mf_viewmessage();?></div>
              <span id="Errormsg"></span>
              <form name="licFrm" id="licFrm" action="" method="post">
              	<input type="hidden" name="paging" id="paging" value="0" />
                
                <div class="form-field">
                	<select name="search_type" id="search_type" class="field-size-top-large" onchange="get_typeval(this.value);">
                      <option value="1"> - AVG ID - </option>
                      <option value="2"> - Reseller Code - </option>
                      <option value="3"> - Reseller Company - </option>
                      <option value="4"> - Email - </option>
                      <option value="5"> - Licence Number - </option>
                      <option value="6"> - Contact Number - </option>
                    </select>
                </div>
                
                <div class="form-field" id="shwavgid">
                	<?php /*?><select name="contact_id" id="contact_id" class="field-size-top-large">
                      <?=$mfp->mf_createcombo("select avg_id from reseller_code_mapping WHERE avg_id != ''","avg_id","avg_id",$avg_id," - Select AVG ID - ");?>
                    </select><?php */?>
                    <input type="text" name="contact_id" id="contact_id" list="avgid" placeholder="AVG ID">
                    <datalist id="avgid" class="searchRecord">
                        <?=$mfp->mf_createcombo("select avg_id from reseller_code_mapping WHERE avg_id != ''","avg_id","avg_id",$avg_id,"");?>
                    </datalist>
                </div>
                <div class="form-field" id="shwrescode" style="display:none;">
                	<?php /*?><select name="reseller_code" id="reseller_code" class="field-size-top-large">
                      <?=$mfp->mf_createcombo("select reseller_code from reseller_code_mapping group by reseller_code","reseller_code","reseller_code",$reseller_code," - Select Reseller Code - ");?>
                    </select><?php */?>
                    <input type="text" name="reseller_code" id="reseller_code" list="resellercode" placeholder="Reseller Code">
                    <datalist id="resellercode">
                        <?=$mfp->mf_createcombo("select reseller_code from reseller_code_mapping group by reseller_code","reseller_code","reseller_code",$reseller_code,"");?>
                    </datalist>
                </div>
                <div class="form-field" id="shwcompany" style="display:none;">
                	<?php /*?><select name="reseller_company" id="reseller_company" class="field-size-top-large">
                      <?=$mfp->mf_createcombo("select reseller_company from reseller_code_mapping","reseller_company","reseller_company",$reseller_company," - Select Reseller Company - ");?>
                    </select><?php */?>
                    <input type="text" name="reseller_company" id="reseller_company" list="resellercompany" placeholder="Reseller Company">
                    <datalist id="resellercompany">
                        <?=$mfp->mf_createcombo("select reseller_company from reseller_code_mapping","reseller_company","reseller_company",$reseller_company,"");?>
                    </datalist>
                </div>
                <div class="form-field" id="shwemail" style="display:none;">
                	<?php /*?><select name="email" id="email" class="field-size-top-large">
                      <?=$mfp->mf_createcombo("select email from customers","email","email",$email," - Select Email - ");?>
                    </select><?php */?>
                    <input type="text" name="email" id="email" list="avgemail" placeholder="Email">
                    <datalist id="avgemail">
                        <?=$mfp->mf_createcombo("select email from customers","email","email",$email,"");?>
                    </datalist>
                </div>
                <div class="form-field" id="shwlicnum" style="display:none;">
                	<?php /*?><select name="licence_number" id="licence_number" class="field-size-top-large">
                      <?=$mfp->mf_createcombo("select licence_number from customers WHERE licence_number != '' ","licence_number","licence_number",$licence_number," - Select Licence Number - ");?>
                    </select><?php */?>
                    <input type="text" name="licence_number" id="licence_number" list="lic_number" placeholder="Licence Number">
                    <datalist id="lic_number">
                        <?=$mfp->mf_createcombo("select licence_number from customers WHERE licence_number != '' ","licence_number","licence_number",$licence_number,"");?>
                    </datalist>
                </div>
                <div class="form-field" id="shwphone" style="display:none;">
                	<?php /*?><select name="phone" id="phone" class="field-size-top-large">
                      <?=$mfp->mf_createcombo("select phone from customers WHERE phone != '' ","phone","phone",$phone," - Select Contact Number - ");?>
                    </select><?php */?>
                    <input type="text" name="phone" id="phone" list="avgphone" placeholder="Contact Number">
                    <datalist id="avgphone">
                        <?=$mfp->mf_createcombo("select phone from customers WHERE phone != '' ","phone","phone",$phone,"");?>
                    </datalist>
                </div>
                
                <?php /*?><div class="form-field">
                	<input id="club" name="club" type="text" value="" class="field-size-top-large" placeholder="Club"  />
                </div>
                <div class="form-field">
                	<input id="company" name="company" type="text" value="" class="field-size-top-large" placeholder="Company"  />
                </div>                
                <div class="form-field">
                	<input id="country" name="country" type="text" value="" class="field-size-top-large" placeholder="Country" />
                </div>
                <div class="form-field last">
                	<input id="city" name="city" type="text" value="" class="field-size-top-large" placeholder="City"  />
                </div>
                <div class="form-field">
                	<input id="end_user_company" name="end_user_company" type="text" value="" class="field-size-top-large" placeholder="End User Company"  />
                </div>
                <div class="form-field">
                	<input id="customer_id" name="customer_id" type="text" value="" class="field-size-top-large" placeholder="Customer ID"  />
                </div>
                <div class="form-field">
                	<input id="first_name" name="first_name" type="text" value="" class="field-size-top-large" placeholder="First Name"  />
                </div>
                <div class="form-field">
                	<input id="last_name" name="last_name" type="text" value="" class="field-size-top-large" placeholder="Last Name"  />
                </div>
                <div class="form-field">
                	<input id="streets" name="streets" type="text" value="" class="field-size-top-large" placeholder="Streets"  />
                </div>
                <div class="form-field">
                	<input id="state" name="state" type="text" value="" class="field-size-top-large" placeholder="State/Province"  />
                </div>
                <div class="form-field">
                	<input id="zip" name="zip" type="text" value="" class="field-size-top-large" placeholder="Zip"  />
                </div>
                <div class="form-field last">
                	<input id="customer_po" name="customer_po" type="text" value="" class="field-size-top-large" placeholder="Purchase Order#"  />
                </div>
                <div class="form-field">
                	<input id="sale_id" name="sale_id" type="text" value="" class="field-size-top-large" placeholder="Sale ID"  />
                </div>
                <div class="form-field">
                	<input id="product_type" name="product_type" type="text" value="" class="field-size-top-large" placeholder="Product Type"  />
                </div>
                <div class="form-field">
                	<input id="total_price" name="total_price" type="text" value="" class="field-size-top-large" placeholder="Total Price"  />
                </div>
                <div class="form-field">
                	<input id="licence_id" name="licence_id" type="text" value="" class="field-size-top-large" placeholder="Licence ID"  />
                </div>                
                <div class="form-field">
                	<input id="licence_status" name="licence_status" type="text" value="" class="field-size-top-large" placeholder="Licence Status"  />
                </div>
                <div class="form-field">
                	<input id="licence_type" name="licence_type" type="text" value="" class="field-size-top-large" placeholder="Licence Type"  />
                </div>
                <div class="form-field">
                	<input id="protected_computers" name="protected_computers" type="text" value="" class="field-size-top-large" placeholder="Protected Computers"  />
                </div>
                <div class="form-field">
                	<input id="validity" name="validity" type="text" value="" class="field-size-top-large" placeholder="Validity"  />
                </div><?php */?>
                <div class="form-field expiry-date" >
                	<label class="form-label"><span>OR &nbsp;</span> Expiration Date</label>
                    <div class="date-field">
                        <input id="from_date" name="from_date" type="text" value="" class="field-size-top-large datepicker" placeholder="From"/>
                    </div>
                    <div class="date-field last">
                        <input id="to_date" name="to_date" type="text" value="" class="field-size-top-large datepicker" placeholder="To"/>
                    </div>
                </div>
                <div class="form-btn"><button type="button" class="submit-button fst" onclick="getlicdetail(0);"><i class="fa fa-search"></i>Search</button>
                <button type="button" class="reset-button last" onclick="window.location='<?=$SITE_URL.'dashboard.php';?>'"><i class="fa fa-refresh"></i>Reset</button>
                </div>
              </form>
            </div>
        </div>
    </div>
	<div class="section-white license-dtl tab">
    	<div id="licenseData"></div>
        <div id="shwlicpart" class="lic-detail">
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
            <thead>
            <tr>
               <th class="avgid">AVG ID</th>
               <th class="license-number">Licence Number</th>
               <th class="licdate">Licence Expiry Date</th>
               <th class="comnm">Company Name</th>
               <th class="connum">Contact Number</th>
               <th class="reselcd">Reseller Code</th>
               <th class="reseller-company">Reseller Company</th>
               <th class="action">&nbsp;</th>
            </tr>
            </thead>
            <tbody>        
            	<tr>
              		<td colspan="8">There are no reseller detail found.</td>
            	</tr>        
            </tbody>
        </table>
        </div>
  	</div>
</div>

<?php //include_once("footer.php"); ?>
<script src="js/jQuery 1.11.3.js" type="text/javascript"></script>
<script src="js/jquery-ui.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css">
<script src="https://img07.en25.com/i/livevalidation_standalone.compressed.js" type="text/javascript" ></script>
<script type="text/javascript" >
function get_typeval(val)
{
	var seaval = val;	
	if(seaval == "1")
	{
		$("#shwavgid").show();
		$("#shwrescode").hide();
		$("#shwcompany").hide();
		$("#shwemail").hide();
		$("#shwlicnum").hide();
		$("#shwphone").hide();
	}
	else if(seaval == "2")
	{
		$("#shwrescode").show();
		$("#shwavgid").hide();
		$("#shwcompany").hide();
		$("#shwemail").hide();
		$("#shwlicnum").hide();
		$("#shwphone").hide();
	}
	else if(seaval == "3")
	{
		$("#shwcompany").show();
		$("#shwavgid").hide();
		$("#shwrescode").hide();
		$("#shwemail").hide();
		$("#shwlicnum").hide();
		$("#shwphone").hide();
	}
	else if(seaval == "4")
	{
		$("#shwemail").show();
		$("#shwavgid").hide();
		$("#shwrescode").hide();
		$("#shwcompany").hide();
		$("#shwlicnum").hide();
		$("#shwphone").hide();
	}
	else if(seaval == "5")
	{
		$("#shwlicnum").show();
		$("#shwavgid").hide();
		$("#shwrescode").hide();
		$("#shwcompany").hide();
		$("#shwemail").hide();
		$("#shwphone").hide();
	}
	else if(seaval == "6")
	{
		$("#shwphone").show();
		$("#shwavgid").hide();
		$("#shwrescode").hide();
		$("#shwcompany").hide();
		$("#shwemail").hide();
		$("#shwlicnum").hide();
	}
	else
	{
		$("#shwavgid").show();
		$("#shwrescode").hide();
		$("#shwcompany").hide();
		$("#shwemail").hide();
		$("#shwlicnum").hide();
		$("#shwphone").hide();
	}
}

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
				jQuery("#shwlicpart").hide();
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
<!--<link rel="stylesheet" href="chosen/chosen.css">
<script src="chosen/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
var config = 
{
  '.chosen-select' : {}
}
for(var selector in config) 
{
  jQuery(selector).chosen(config[selector]);
}
</script>-->
<script>
// Get the <datalist> and <input> elements.
var dataList = document.getElementById('json-datalist');
var input = document.getElementById('ajax');

// Create a new XMLHttpRequest.
var request = new XMLHttpRequest();
// Handle state changes for the request.
request.onreadystatechange = function(response) {
	
  if (request.readyState === 4) {
    if (request.status === 200) {
      // Parse the JSON
      var jsonOptions = JSON.parse(request.responseText);
  
      // Loop over the JSON array.
      jsonOptions.forEach(function(item) {
        // Create a new <option> element.
        var option = document.createElement('option');
        // Set the value using the item in the JSON array.
        option.value = item;
        // Add the <option> element to the <datalist>.
        dataList.appendChild(option);
      });
      
      // Update the placeholder text.
      input.placeholder = "e.g. datalist";
    } else {
      // An error occured :(
      input.placeholder = "Couldn't load datalist options :(";
    }
  }
};

// Update the placeholder text.
input.placeholder = "Loading options...";

// Set up and make the request.
request.open('GET', 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/4621/html-elements.json', true);
request.send();
</script>
</div>
</div><!--/.page-bg-->
</body>
</html>