﻿<?php include_once("connect.php");
	//print_r($_SESSION); exit;
	/*if(!isset($_SESSION['UserID'])) 
	{
		$mfp->mf_redirect($SITE_URL.'login.php');
	}*/
	$cid = $_REQUEST['id'];
	$PageName = "Homepage";
	$pageId =1;

	list($pagetitle,$pagename,$content,$browserTitle,$metaname,$metaKeywords,$metaDescription)=$mfp->mf_getMultiValue("staticpages",array("pagetitle","pagename","content","browsertitle","metaname","keywords","description"),"id",$pageId);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("header-section.php"); ?>
<style>
/*form-css*/
  /* RESET */ /* RESET */ .elq-form * {
	margin: 0;
	padding: 0;
}
.elq-form input, textarea {
	-webkit-box-sizing:content-box;
	-moz-box-sizing:content-box;
	box-sizing:content-box;
}
.elq-form button, input[type=reset], input[type=button], input[type=submit], input[type=checkbox], input[type=radio], select {
	-webkit-box-sizing:border-box;
	-moz-box-sizing:border-box;
	box-sizing:border-box;
}
/* GENERIC */.elq-form input {
	height: 16px;
	line-height: 16px;
}
.elq-form .item-padding {
	/*padding:6px 5px 9px 9px;*/
	padding:0 0 15px;
}
.elq-form .pp-group {
	padding:0px 5px 0px 9px;
}
.elq-form .pp-field {
	padding:6px 0px 9px 0px;
}
.elq-form .field-wrapper.individual {
	float: left;
	width: 100%;
	clear: both;
}
.elq-form .field-p {
	position: relative;
	margin: 0;/*padding: 0;*/
  }
.elq-form .zIndex-fix {
	position: absolute;
	z-index: 1;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
}
.elq-form .field-design {
	position:absolute;
	z-index:2;
	top:0;
	left:0;
	right:0;
	bottom:0;
	margin:0;
	padding:0;
}
.elq-form .no-fields-prompt {
	float: left;
	width: 100%;
	height: 150px;
	padding-top: 50px;
	clear: both;
}
/* SECTION BREAKS */.elq-form .section-break {
	float:left;
	width: 97%;
	margin-right:2%;
	margin-left:1%;
	padding-bottom:6px;
}
.elq-form .section-break .heading {
	width:100%;
	font-weight: bold;
	margin:0;
	padding:0;
}
/* LABEL */.elq-form .required {
	color: red !important;
	display: inline;
	float: none;
	font-weight: bold;
	margin: 0pt 0pt 0pt;
	padding: 0pt 0pt 0pt;
}
/* FIELD GROUP */.elq-form .field-group {
	float: left;
	clear: both;
}
.elq-form .field-group.large {
	width:100%;
}
.elq-form .field-group.medium {
	width:51%;
}
.elq-form .field-group.small {
	width:31%;
}
.elq-form .field-group .label {
	float:left;
	width:97%;
	margin-right:2%;
	margin-left:1%;
	padding-bottom:6px;
	font-weight: bold;
}
.elq-form .field-group .field-style {
	float: left;
}
.elq-form .progressive-profile .pp-inner {
	float: left;
	clear: both;
}
.elq-form .progressive-profile .pp-inner.large {
	width:100%;
}
.elq-form .progressive-profile .pp-inner.medium {
	width:51%;
}
.elq-form .progressive-profile .pp-inner.small {
	width:31%;
}
/* RADIO */.elq-form .radio-option {
	display: inline-block;
}
.elq-form .radio-option .label {
	display:block;
	float:left;
	padding-right:10px;
	padding-left:22px;
	text-indent:-22px;
}
.elq-form .radio-option .input {
	vertical-align:middle;
	margin-right:7px;
}
.elq-form .radio-option .inner {
	vertical-align:middle;
}
/* CHECKBOX */.elq-form .checkbox-span {
	display:inline-block;
}
.elq-form .checkbox-label {
	margin-left:4px;
}
/* INPUT */.elq-form .accept-default {
	width:100%;
}
/* SIZING */.elq-form .field-style {
	/*margin-right:2%;
    margin-left:2%;*/
	margin-right:0;
	margin-left:0;
}
.elq-form .field-style._25 {
	width:21%;
}
.elq-form .field-style._50 {
	width:46%;
}
.elq-form .field-style._50_left {
	clear:left;
	width:46%;
}
.elq-form .field-style._75 {
	width:71%;
}
.elq-form .field-style._100 {
	/*width:96%;*/width:100%;
}
.elq-form .field-size-top-small {
	width:30%;
}
.elq-form .field-size-top-medium {
	width:75%;
}
.elq-form .field-size-top-large {
	width:100%;
}
.elq-form .field-size-left-small {
	width:21%;
}
.elq-form .field-size-left-medium {
	width:46%;
}
.elq-form .field-size-left-large {
	width:60%;
}
/* INSTRUCTIONS */.elq-form .instructions.default {
	color:#444444;
	display:block;
	font-size:10px;
	padding:6px 0pt 3px;
}
.elq-form .instructions.group {
	float:left;
	width:97%;
	margin-right:2%;
	margin-left:2%;
	padding:6px 0pt 3px;
	color:#444444;
	display:block;
	font-size:10px;
}
.form-field select.department-select {
	height:45px;
}
.elq-form .instructions.left-single {
	margin:0 0 0 33%;
}
.elq-form .instructions-other {
	margin:0;
}
/* POSITIONING */.elq-form .label-position.left {
	display:block;
	line-height:150%;
	padding:1px 0pt 3px;
	float:left;
	width:31%;
	margin:0pt 15px 0pt 0pt;
	word-wrap:break-word;
}
.elq-form .label-position.top {
	display:block;
	line-height:150%;
	padding:1px 0pt 3px;
	white-space:nowrap;
}
.elq-form .label-position.alignment-left {
	text-align: left;
}
.elq-form .label-position.alignment-right {
	text-align: right;
}
/* LIST ORDER */.elq-form .list-order {
	display:block;
}
.elq-form .list-order.oneColumn {
	margin:0pt 7px 0pt 0pt;
	width:100%;
	clear:both;
}
.elq-form .list-order.twoColumn {
	float:left;
	margin:0pt 7px 0pt 0pt;
	width:38%;
}
.elq-form .list-order.threeColumn {
	float:left;
	margin:0pt 7px 0pt 0pt;
	width:30%;
}
.elq-form .list-order.oneColumnLeft {
	float:left;
	margin:0pt 7px 0pt 0pt;
	width:100%;
}
.elq-form .list-order.twoColumnLeft {
	float:left;
	margin:0pt 7px 0pt 0pt;
	width:38%;
}
.elq-form .list-order.threeColumnLeft {
	float:left;
	margin:0pt 7px 0pt 0pt;
	width:30%;
}
/* GRID STYLE */.elq-form .grid-style {
	display:inline;
	float:left;
	margin-left:2%;
	margin-right:2%;
}
.elq-form .grid-style._25 {
	width:21%;
}
.elq-form .grid-style._50 {
	width:46%;
}
.elq-form .grid-style._75 {
	width:71%;
}
.elq-form .grid-style._100 {
	width:96%;
}
.LV_invalid_field, input.LV_invalid_field:hover, input.LV_invalid_field:active, textarea.LV_invalid_field:hover, textarea.LV_invalid_field:active {
	border: 1px solid #cc0000 !important;
}
.LV_invalid {
	color: #cc0000;
	font-size: 10px;
}
.LV_valid {
	color:#009900;
	font-size: 10px;
	display:none;
}
.LV_validation_message {
	font-weight: bold;
	margin: 0 0 0 5px;
}
.LV_valid_field, input.LV_valid_field:hover, input.LV_valid_field:active, textarea.LV_valid_field:hover, textarea.LV_valid_field:active {
	border: 1px solid #00CC00 !important;
}
.LV_invalid_field, input.LV_invalid_field:hover, input.LV_invalid_field:active, textarea.LV_invalid_field:hover, textarea.LV_invalid_field:active {
	border: 1px solid #CC0000 !important;
}
.elq-form .field-wrapper.terms-field input {
	width:auto;
	height:auto;
	margin:4px 10px 0 0;
}
.elq-form .field-wrapper.terms-field label {
	position:relative;
	top:0;
	max-width:100%;
}

/*form-css-End*/
</style>
<link href="css/style.css" rel="stylesheet" />
</head>
<body onload="getlicdetail(0)">
<?php include_once("header.php"); ?>
<div class="main-con">
  <div class="section-main">
    <div class="container">
      <div id="tabs-container">
        <ul class="tabs-menu slideDown">
          <li class="current"><a href="#tab-1"><i class="tab-icon icon1"></i>License Information Search</a></li>
        </ul>
        <div class="tab">
          <div id="tab-1" class="tab-content">
            <div class="responsive-table slideUp">
              <div class="form-main">
              <span id="Errormsg"></span>
              <form name="licFrm" id="licFrm" action="" method="post">
                <div id="formElement1" class="sc-view form-design-field sc-static-layout item-padding sc-regular-size" >
                  <div class="field-wrapper"></div>
                  <div class="individual field-wrapper">
                    <div class="_100 field-style">
                      <p class="field-p form-field">
                        <input id="license_id" name="license_id" type="text" value="" class="field-size-top-large" placeholder="License ID"  />
                      </p>
                    </div>
                  </div>
                </div>
                <div id="formElement2" class="sc-view form-design-field sc-static-layout item-padding sc-regular-size" >
                  <div class="field-wrapper" ></div>
                  <div class="individual field-wrapper" >
                    <div class="_100 field-style" >
                      <p class="field-p form-field" >
                        <input id="order_id" name="order_id" type="text" value="" class="field-size-top-large" placeholder="Order ID"  />
                      </p>
                    </div>
                  </div>
                </div>
                <div id="formElement2" class="sc-view form-design-field sc-static-layout item-padding sc-regular-size" >
                  <div class="field-wrapper" ></div>
                  <div class="individual field-wrapper" >
                    <div class="_100 field-style" >
                      <p class="field-p form-field" >
                        <input id="license_number" name="license_number" type="text" value="" class="field-size-top-large" placeholder="License number"  />
                      </p>
                    </div>
                  </div>
                </div>
                <div id="formElement3" class="sc-view form-design-field sc-static-layout item-padding sc-regular-size" >
                  <div class="field-wrapper" ></div>
                  <div class="individual field-wrapper" >
                    <div class="_100 field-style" >
                      <p class="field-p form-field" >
                        <input id="reseller_company" name="reseller_company" type="text" value="" class="field-size-top-large" placeholder="Reseller company" />
                      </p>
                    </div>
                  </div>
                </div>
                <div id="formElement4" class="sc-view form-design-field sc-static-layout item-padding sc-regular-size" >
                  <div class="field-wrapper" > </div>
                  <div class="individual field-wrapper" >
                    <div class="_100 field-style" >
                      <p class="field-p form-field" >
                        <input id="customer_email" name="customer_email" type="text" value="" class="field-size-top-large" placeholder="Customer Email"  />
                      </p>
                    </div>
                  </div>
                </div>
                 <div id="formElement4" class="sc-view form-design-field sc-static-layout item-padding sc-regular-size" >
                  <div class="field-wrapper" > </div>
                  <div class="individual field-wrapper" >
                    <div class="_100 field-style" >
                      <p class="field-p form-field" >
                      <label for="field2" class="label-position top">Expiry Date</label>
                        <input id="from_date" name="from_date" type="text" value="" class="field-size-top-large datepicker" placeholder="From"/>
                         <input id="to_date" name="to_date" type="text" value="" class="field-size-top-large datepicker" placeholder="To"/>
                      </p>
                    </div>
                  </div>
                </div>
                <div id="formElement5" class="sc-view form-design-field sc-static-layout item-padding sc-regular-size" >
                  <div class="field-wrapper" ></div>
                  <div class="individual field-wrapsper">
                    <div class="_100 field-style">
                      <p class="field-p form-field">
                        <input type="button" value="Search" class="submit-button" onclick="getlicdetail(0);" />
                        <input type="reset" value="Reset" class="submit-button" />
                      </p>
                    </div>
                  </div>
                </div>
             </form>
              </div>
              <div id="licenseData"></div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once("footer.php"); ?>
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
</script>
</body>
</html>