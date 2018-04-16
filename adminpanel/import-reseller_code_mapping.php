<?php
	include_once "connect.php";
	$mfp->mf_isadmin();
	$currentMenu="Customers";
	$currentPage="Manage Customers";
	$add_page_link="add-customer.php";
	$import_page_link="import-reseller_code_mapping.php";
	$manage_page_link="manage-customers.php";
	$currentPage="Import Reseller Code Mapping";

if(isset($_POST['importSubmit'])){
	$target_dir = "../uploads/reseller_csv/";
	$target_file = $target_dir . basename($_FILES["file"]["name"]);
	$FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$target_fileName = $target_dir . time() . date('_Y_m_d') . '.' . $FileType;
	$allowedTypes = array('xlsx','xls','scv','ods');
	if(!empty($_FILES['file']['name']) && in_array($FileType,$allowedTypes))
	{
		if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_fileName)) 
		{
			if(isset($_POST['is_remove']) && $_POST['is_remove']==1) {
				$mfp->mf_dbtruncate("reseller_code_mapping");
			}
			
			set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
			include 'library/phpexcel-master/Classes/PHPExcel/IOFactory.php';
			$inputFileName = $target_fileName;
			try {
				$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
			} catch(Exception $e) {
				//die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
				$mfp->mf_setmessage('<div class="alert alert-success"><i class="fa fa-check-circle"></i>Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage().'<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>',"manage-leader-board.php");
			}
			$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet
			$RowCount=0;
			$SkipRowCount=0;
			//print_r($allDataInSheet); exit;
			foreach($allDataInSheet as $DataInSheet){
				if($RowCount==0) { $RowCount++; continue; }
				//$license_id = trim($DataInSheet["A"]);
				//$order_id = trim($DataInSheet["B"]);
				$contact_id = trim($DataInSheet["C"]);
				$selRes=$mfp->mf_query("SELECT * FROM reseller_code_mapping");
				/*if($mfp->mf_affected_rows()>0){
					$RowCount++;
					$SkipRowCount++;
					continue;
				} else { */
					$user_arr['reseller_company']=trim($DataInSheet["A"]);
					$user_arr['avg_id']=trim($DataInSheet["B"]);
					$user_arr['reseller_code']=trim($DataInSheet["C"]);
					//print_r($user_arr); exit;
					$mfp->mf_dbinsert("reseller_code_mapping",$user_arr);
					$user_id = $mfp->mf_dbinsert_id();
					$RowCount++;
				//}	
			}
			$success_html = '<div class="alert alert-success"><i class="fa fa-check-circle"></i>The Data has been successfully imported<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>';
			if($SkipRowCount>0) {
				$success_html .= '<div class="alert alert-danger"><i class="fa fa-times-circle"></i><b>'.$SkipRowCount.'</b> Records not import due to duplicate license detail<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>';
			}
			$mfp->mf_setmessage($success_html,"manage-customers.php");
		
		} 
		else 
		{
			$mfp->mf_setmessage('<div class="alert alert-danger"><i class="fa fa-times-circle"></i>There was an error occurred. please try again.<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>',"import-reseller_code_mapping.php");
		}
	
	} 
	else 
	{
		$mfp->mf_setmessage('<div class="alert alert-danger"><i class="fa fa-times-circle"></i>The file you have selected is wrong. please select only CSV/EXCEL file.<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>',"import-reseller_code_mapping.php");
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
	  	<?=$currentPage;?>
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
                <div class="form-group">
                    <label id="image_path" class="control-label col-md-3">File</label>
                    <div class="col-md-4">
                        <input type="file" id="file" name="file"  class="default" required />
                    </div>
                </div>
                <?php /*?><div class="form-group">
                    <label id="" class="control-label col-md-3">&nbsp;</label>
                    <div class="col-md-4">
                        <input type="checkbox" id="is_remove" name="is_remove"  class="default" value="1" checked="checked" />
                        &nbsp;Remove Old Data
                    </div>
                </div><?php */?>
                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-6">
                        <button class="btn btn-primary" type="submit" name="importSubmit">Save</button>
                        <button type="reset" class="btn btn-default">Cancel</button>
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