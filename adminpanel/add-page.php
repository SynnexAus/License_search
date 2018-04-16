<?php
	include_once "connect.php";
	$mfp->mf_isadmin();
	$currentMenu="Static Pages";
	$currentPage="Manage Pages";
	$manage_page_link="manage-pages.php";
	$id=intval($_REQUEST['id']);
	if($id>0){ $page="Edit Page";} else { $page="Add Page"; }
	
	$selRes=$mfp->mf_query("SELECT * FROM staticpages where id='".$id."'");
	if($mfp->mf_affected_rows()>0)
	{
		$selRow=$mfp->mf_fetch_array($selRes);
		
		$pagetitle =stripslashes($selRow['pagetitle']);
		$pagename=stripslashes($selRow['pagename']);
		$subtitle=stripslashes($selRow['subtitle']);
		$description=stripslashes($selRow['content']);
		$browser_title=stripslashes($selRow['browsertitle']);
		$metaname=stripslashes($selRow['metaname']);
		$meta_keywords=stripslashes($selRow['keywords']);
		$meta_description=stripslashes($selRow['description']);
		$meta_keywords=stripslashes($selRow['keywords']);
		$meta_description=stripslashes($selRow['description']);		
		$georegion=stripslashes($selRow['georegion']);
	}
	
	if(isset($_POST['btnSubmit']))
	{
		$insArr=array();
			$insArr['pagetitle']=$_POST['pagetitle'];
			$insArr['pagename']=$_POST['pagename'];
			$insArr['subtitle']=$_POST['subtitle']; 
			$insArr['content']=$_POST['description']; 
			$insArr['browsertitle']=$_POST['browser_title']; 
			$insArr['metaname']=$_POST['metaname']; 
			$insArr['keywords']=$_POST['meta_keywords']; 
			$insArr['description']=$_POST['meta_description']; 
			$insArr['metaabstract']=$_POST['metaabstract']; 
			$insArr['georegion']=$_POST['georegion'];				
			$insArr['modify_date']=$mfp->curTimedate();
		
		if($id>0)
		{
			if($mfp->mf_dbupdate("staticpages",$insArr," where id='$id'"))
			{
				$mfp->mf_setmessage('<div class="alert alert-success"> <i class="fa fa-check-circle"></i>Page information updated successfully.<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>',"manage-pages.php");
				
			}
		}
		else
		{
			if($mfp->mf_dbinsert("staticpages",$insArr))
			{				
				$mfp->mf_setmessage('<div class="alert alert-success"> <i class="fa fa-check-circle"></i>Page information inserted successfully.<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>',"manage-pages.php");
			}
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
        <?=$page;?>
		<a href="<?=$manage_page_link;?>" class="btn btn-primary pull-right">Back</a> </h1>
      </h1>
	  <br>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-warning"> <br/>
            <div id="SuccMSG">
              <?=$mfp->mf_viewmessage();?>
            </div>
            <div class="form">
              <form class="cmxform form-horizontal " name="commentForm" id="commentForm" method="post" action="" enctype="multipart/form-data">
                <br/>
                <div class="form-group ">
                  <label for="first_name" class="control-label col-lg-3">Page Name*</label>
                  <div class="col-lg-6">                    
					<input name="pagename" id="pagename" value="<?=$pagename;?>" type="text" class="form-control required" />
                  </div>
                </div>
                
                <div class="form-group ">
               	 <label class="control-label col-lg-3"></label>
               	 <?php /*?><div class="col-lg-6"><h4>Page Information</h4></label></div><?php */?>
                </div>
                    <div class="form-group ">
						<label for="curl" class="control-label col-lg-3">Page Title*</label>
						<div class="col-lg-6">
							<input name="pagetitle" id="pagetitle" value="<?=$pagetitle;?>" type="text" class="form-control required" />
						</div>
					</div>
                                        
                <div class="form-group ">
                    <label for="curl" class="control-label col-lg-3">Description</label>
                    <div class="col-sm-6">
                        <textarea class="form-control ckeditor" name="description" rows="10"><?=$description;?></textarea>
                    </div>
                </div>
                
                <div class="form-group ">
                    <label for="curl" class="control-label col-lg-3">Browser Title*</label>
                    <div class="col-sm-6">
                        <textarea class="form-control required" name="browser_title" rows="2" required><?=$browser_title;?></textarea>
                    </div>
                </div>
                <?php /*?><div class="form-group ">
                    <label for="curl" class="control-label col-lg-3">Meta Name</label>
                    <div class="col-sm-6">
                        <textarea class="form-control" name="metaname" rows="3"><?=$metaname;?></textarea>
                    </div>
                </div><?php */?>
				<div class="form-group ">
                    <label for="curl" class="control-label col-lg-3">Meta Keywords</label>
                    <div class="col-sm-6">
                        <textarea class="form-control" name="meta_keywords" rows="8"><?=$meta_keywords;?></textarea>
                    </div>
                </div>
                <div class="form-group ">
                    <label for="curl" class="control-label col-lg-3">Meta Description</label>
                    <div class="col-sm-6">
                        <textarea class="form-control" name="meta_description" rows="8"><?=$meta_description;?></textarea>
                    </div>
                </div>
                <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                    <button class="btn btn-primary" type="submit" name="btnSubmit">Save</button>
                    <? if($id>0){ ?>
                    <button type="button" class="btn" onClick="window.location='<?=$manage_page_link?>';">Back</button>
                    <? } else { ?>
                    <button type="reset" class="btn btn-default">Cancel</button>
                    <? } ?>
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
