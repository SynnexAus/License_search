<?php
	include_once "connect.php";
	$mfp->mf_isadmin();
	$currentMenu="Email Templates";
	$currentPage="Manage Email Templates";
	$add_page_link="add-email-template.php";
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
                    <h1><?=$currentPage;?></h1>
                </section>
                <section class="content">
                <div class="suspmsgouter"><span id="SuspMsg"><?=$mfp->mf_viewmessage();?></span></div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-info">                                
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">No.</th>
                                                <th>Template Name</th>
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         <?php
										$no=0;
										list($result,$pglink,$pgcombo)=$mfp->mf_admin_paging("SELECT * FROM email_templates order by id",25);
										if($mfp->mf_affected_rows()>0)
										{
											while($row=$mfp->mf_fetch_array($result))
											{
												$no++;
											?>
                                            <tr>
                                           		<td><?=$no;?></td>
												<td><?=stripslashes($row['title']);?></td>
												<td>
													<a href="<?=$add_page_link;?>?id=<?=$row['id'];?>"><i class="fa fa-pencil-square-o"></i></a>
													<?php if($row['id']!=2 && $row['id']!=4 && $row['id']!=17 && $row['id']!=18 && $row['id']!=19 && $row['id']!=20){ ?>
														<a href="<?=$add_page_link;?>?act=del&id=<?=$row['id'];?>" onClick="return check_delete();"><i class="fa fa-times"></i></a>
													<?php } ?>
												</td>
										    </tr>
                                           <?php } } ?>   
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
</body>
</html>
<? include_once "custom-footer.php"; ?>