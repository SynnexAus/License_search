<?php
	include_once "connect.php";
	$mfp->mf_isadmin();
	$currentMenu="Customers";
	$currentPage="Manage Customers";
	$add_page_link="add-customer.php";
	$import_page_link="import-customers.php";
	
	$ExQry="";
	if(isset($_REQUEST['btnSubmit']))
	{
		if(isset($_REQUEST['contact_id']) && $_REQUEST['contact_id']!="")
		{
			$ExQry.=" and contact_id = '".$_REQUEST['contact_id']."'";
		}
		
		if(isset($_REQUEST['customer_id']) && $_REQUEST['customer_id']!="")
		{
			$ExQry.=" and customer_id = '".$_REQUEST['customer_id']."'";
		}
		/*if(isset($_REQUEST['license_number']) && $_REQUEST['license_number']!="")
		{
			$ExQry.=" and license_number = '".$_REQUEST['license_number']."'";
		}		
		if(isset($_REQUEST['reseller_company']) && $_REQUEST['reseller_company']!="")
		{
			$ExQry.=" and reseller_company LIKE '%".$_REQUEST['reseller_company']."%'";
		}*/
		
		if(isset($_REQUEST['email']) && $_REQUEST['email']!="")
		{
			$ExQry.=" and email = '".$_REQUEST['email']."'";
		}
		
		if(isset($_REQUEST['start_date']) && $_REQUEST['start_date']!="")
		{	
			$ExQry.=" and expiration_date >= '".date("Y-m-d",strtotime($_REQUEST['start_date']))."'";
		}
		
		if(isset($_REQUEST['to_date']) && $_REQUEST['to_date']!="")
		{	
			$ExQry.=" and expiration_date <= '".date("Y-m-d",strtotime($_REQUEST['to_date']))."'";
		}
		
	} 
	if(isset($_REQUEST['delFrmBtn']))
	{
		$chkids = $_REQUEST['chkids'];
		$delqry = $mfp->mf_query("DELETE FROM customers where id IN (".implode(",",$chkids).")");
		if($delqry)
		{
			$mfp->mf_setmessage('<div class="alert alert-success"><i class="fa fa-check-circle"></i>License information deleted successfully.<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>');
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<?php include_once("head-section.php"); ?>
</head>
<body class="skin-blue">
<header class="header">
  <?php include_once("header.php"); ?>
</header>
<div class="wrapper row-offcanvas row-offcanvas-left">
  <?php include_once("sidebar.php"); ?>
  <aside class="right-side">
    <section class="content-header">
      <h1>
        <?=ucwords($currentPage);?>
        <a href="<?=$import_page_link?>" class="btn btn-primary pull-right">Import</a> <span class="pull-right">&nbsp;&nbsp;</span> 
        <a href="../uploads/customers_sample.xlsx" download class="btn btn-primary pull-right">Download Sample File</a>
        <?php /*?><span class="pull-right">&nbsp;&nbsp;</span>
                <a href="<?=$add_page_link?>" class="btn btn-primary pull-right">Add New</a>  <?php */?>
      </h1>
      <br/>
    </section>
    <section class="content">
      <div class="suspmsgouter"><span id="SuspMsg">
        <?=$mfp->mf_viewmessage();?>
        </span></div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body table-responsive table-res customers-tb">
              <form name="SearchForm" id="SearchForm" method="post" action="" autocomplete="off" enctype="multipart/form-data">
                <label>Contact ID
                <input class="form-control" id="contact_id" name="contact_id" value="<?=$_REQUEST['contact_id'];?>" type="text" />
                </label>
                <label>Customer ID
               <input class="form-control" id="customer_id" name="customer_id" value="<?=$_REQUEST['customer_id'];?>" type="text" />
                </label>
                <?php /*?><label>License Number
               <input class="form-control" id="license_number" name="license_number" value="<?=$_REQUEST['license_number'];?>" type="text" />
                </label>
                <label>Reseller Company
                <input class="form-control" id="reseller_company" name="reseller_company" value="<?=$_REQUEST['reseller_company'];?>" type="text" />
                </label><?php */?>
                <label>Email
                <input class="form-control" id="email" name="email" value="<?=$_REQUEST['email'];?>" type="email" />
                </label>
                <div class="clear">&nbsp;</div>
                <label>Date Expired
                <input class="form-control datepicker" id="start_date" type="text" name="start_date" value="<?=$_REQUEST['start_date'];?>" placeholder="From Date" />
                
                </label>
                <label>
                <input class="form-control datepicker" id="to_date" type="text" name="to_date" placeholder="To date" value="<?=$_REQUEST['to_date'];?>" />
                </label>
                <div class="btn-setright">
                    <button class="btn btn-primary" type="submit" name="btnSubmit">Search</button>
                    <button type="reset" class="btn btn-primary last-btn" id="btnReset" onClick="window.location='manage-customers.php'">Reset</button>
                </div>
              </form>
              <div class="clear"></div>
              <div class="pull-right">
              <!--<a href="javascript:;" onClick="return chkExportList()" class="btn btn-primary">Export License info</a> &nbsp;&nbsp; <a href="javascript:;" class="btn btn-primary" onClick="delRecord();">Delete</a>-->
              </div>
              <form name="custFrm" id="custFrm" action="" method="post">
              	<table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <!--<th width="8%">&nbsp;</th>-->
                    <th width="8%">No.</th>
                    <th>Club</th>
                    <th>Company</th>
                    <th>Contact ID</th>
                    <th>Country</th>
                    <th>City</th>
                    <th>End User Company</th>
                    <th>Customer ID</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Streets</th>
                    <th>State/Province</th>
                    <th>Zip</th>
                    <th>Purchase Order#</th>
                    <th>Sale ID</th>
                    <th>Product type</th>
                    <th>Total Price</th>
                    <th>Expiration Date</th>
                    <th>Licence ID</th>
                    <th>Licence number</th>
                    <th>Licence status</th>
                    <th>Licence type</th>
                    <th>Protected computers</th>
                    <th>Validity</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $n = 0;
                    //$result=$mfp->mf_query("SELECT * FROM customers where 1 = 1 $ExQry order by id desc");
					list($result,$pglink,$pgcombo)=$mfp->mf_admin_paging("SELECT * FROM customers where 1 = 1 $ExQry ",50);
                    if($mfp->mf_affected_rows()>0)
                    {
                        while($row=$mfp->mf_fetch_array($result))
                        { $n++;
                ?>
                  <tr>
                    <?php /*?><td class="check-main"><input type="checkbox" name="chkids[]" id="chkid" value="<?=$row['id'];?>"></td><?php */?>
                    <td><?=$row['id'];?></td>
                    <td><?=$row['club'];?></td>
                    <td><?=$row['company'];?></td>
                    <td class="license-number"><?=$row['contact_id'];?></td>
                    <td><?=$row['country'];?></td>
                    <td><?=$row['city'];?></td>
                    <td><?=$row['end_user_company'];?></td>
                    <td><?=$row['customer_id'];?></td>
                    <td><?=$row['first_name'];?></td>
                    <td><?=$row['last_name'];?></td>
                    <td><?=$row['email'];?></td>
                    <td><?=$row['phone'];?></td>
                    <td><?=$row['streets'];?></td>
                    <td><?=$row['state'];?></td>
                    <td><?=$row['zip'];?></td>
                    <td><?=$row['customer_po'];?></td>
                    <td><?=$row['sale_id'];?></td>
                    <td><?=$row['product_type'];?></td>
                    <td><?=$row['total_price'];?></td>
                    <td><?=$row['expiration_date'];?></td>
                    <td><?=$row['licence_id'];?></td>
                    <td><?=$row['licence_number'];?></td>
                    <td><?=$row['licence_status'];?></td>
                    <td><?=$row['licence_type'];?></td>
                    <td><?=$row['protected_computers'];?></td>                    
                    <td><?=$row['validity'];?></td>
                  </tr>
                  <?php }	} ?>
                </tbody>
              </table>
                <table border="0" cellpadding="0" cellspacing="0" id="paging-table">
                  <tr>
                    <td>
                        <?=$pglink;?>
                    </td>
                    <td>
                        <?=$pgcombo;?>
                    </td>
                  </tr>
                </table>
                <input type="submit" name="delFrmBtn" id="delFrmBtn" style="display:none">
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </aside>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="js/AdminLTE/app.js" type="text/javascript"></script>
<script src="assets/bootstrap-switch-master/build/js/bootstrap-switch.js"></script>
<script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="js/bootstrap-switch.js"></script>
<script type="text/javascript">
	/*$(function() {
		$("#example1").dataTable({
			"bPaginate": true,
			"bLengthChange": true,
			"bFilter": false,
			"bSort": false,
			"bInfo": true,
			"bAutoWidth": true
		});
	});*/	
	$("#start_date").datepicker({ autoclose: true });
	$("#to_date").datepicker({ autoclose: true });
</script>
<script>
function check_delete()
{
	return confirm("Sure to delete selected record...?");
}

function delRecord()
{
	var $boxes = $("input[name='chkids[]']:checked");
	if($boxes.length>0)
	{
	 	if(confirm('Sure to delete selected record...?'))
		{
			$("#delFrmBtn").click();
		}
	} else {
		alert('Please select at least one record.');
		return false;
	}
}		
</script>
<script>
setInterval(function(){ 
 $("[name='chkstatus']").bootstrapSwitch();
 $("[name='chkfeatSus']").bootstrapSwitch();
 }, 500);

function setCustomerSt(chkbx)
{
	ajaxFunction();
	xmlHttp.onreadystatechange=function()
	{
		if(xmlHttp.readyState==4)
		{
			document.getElementById('SuspMsg').innerHTML=xmlHttp.responseText;
			//alert(xmlHttp.responseText);
		}
	}
	stsuspend=0;
	if(chkbx.checked) { stsuspend=1; }
	recid=chkbx.value;
	xmlHttp.open("GET","setcustomerstatus.php?uid="+recid+"&ust="+stsuspend,true);
	xmlHttp.send(null);
}

function chkExportList()
{
	window.location.href = 'export-customers.php';
}
</script>
</body>
</html>
<?php include_once "custom-footer.php"; ?>