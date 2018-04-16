<?php
	include_once "connect.php";
	$mfp->mf_isadmin();
	$currentMenu="Users";
	$currentPage="Manage Users";
	$add_page_link="add-user.php";
	$import_page_link="import-users.php";
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
                <a href="<?=$add_page_link?>" class="btn btn-primary pull-right">Add New</a>       
			  </h1>
			  <br/>
			</section>
			<section class="content">
			<div class="suspmsgouter"><span id="SuspMsg"><?=$mfp->mf_viewmessage();?></span></div>
				<div class="row">
					<div class="col-xs-12">
						<div class="box">                                
							<div class="box-body table-responsive">
								<table id="example1" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th width="8%">No.</th>
											<th>First Name</th>
                                            <th>Last Name</th>
											<th>Email</th>
											<!--<th>Join Date</th>-->
											<th width="10%">Status</th>
											<th width="10%">Actions</th>
										</tr>
										</thead>
										<tbody>
										 <?php
											$n = 0;
											$result=$mfp->mf_query("SELECT * FROM users where 1 = 1 order by id desc");
											if($mfp->mf_affected_rows()>0)
											{
												while($row=$mfp->mf_fetch_array($result))
												{ $n++;
											?>
											<tr>
										    <td><?=$n;?></td>
											<td><?=ucwords(stripslashes($row['first_name']));?></td>
                                            <td><?=ucwords(stripslashes($row['last_name']));?></td>
											<td><?=stripslashes($row['email']);?></td>
											<!--<td><?=date("M d, Y",strtotime($row['add_date']));?></td>-->
											<td><input type="checkbox" name="chkstatus" id="chkstatus_<?=$row['id'];?>" value="<?=$row['id'];?>" <?=$row['status']==1?"checked":"";  ?> onChange="setUserSt(this)" data-size="small"></td>
											<td>
											<a href="<?=$add_page_link;?>?id=<?=$row['id'];?>"><i class="fa fa-pencil-square-o"></i></a>&nbsp;
											<a href="<?=$add_page_link;?>?act=del&id=<?=$row['id'];?>" onClick="return check_delete();"><i class="fa fa-times"></i></a></td>                                           
										</tr>
											<?php }	} ?>   
										</tbody>
									</table>
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
<script src="js/bootstrap-switch.js"></script>
<script type="text/javascript">
	$(function() {
		$("#example1").dataTable({
			"bPaginate": true,
			"bLengthChange": true,
			"bFilter": true,
			"bSort": false,
			"bInfo": true,
			"bAutoWidth": true
		});
	});
</script>
<script>
function check_delete()
{
	return confirm("Sure to delete selected record...?");
}		
</script>
<script>
setInterval(function(){ 
 $("[name='chkstatus']").bootstrapSwitch();
 $("[name='chkfeatSus']").bootstrapSwitch();
 }, 500);

function setUserSt(chkbx)
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
	xmlHttp.open("GET","setuserstatus.php?uid="+recid+"&ust="+stsuspend,true);
	xmlHttp.send(null);
}
</script>
</body>
</html>
<? include_once "custom-footer.php"; ?>