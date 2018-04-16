<?php
	include_once "connect.php";
	$mfp->mf_isadmin();
	$currentMenu="Email Templates";
	$currentPage="Manage Email Templates";
	$back_page_link="manage-email-template.php";
	
	$id=intval($_REQUEST['id']);
	$currentPage=(($id>0)?"Edit":"Add")." Email Template";

	if($_REQUEST['act']=="del")
	{
		$mfp->delUploadFile("email_templates","image_path","id",$id,"../uploads/template_images/");
		$mfp->mf_dbdelete("email_templates","id",$id);
		$mfp->mf_setmessage('<div class="alert alert-danger"><i class="fa fa-check-circle"></i>Email template information deleted successfully.<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>',"manage-email-template.php");
	}
	
	if($_REQUEST['act']=="delvid")
	{
		$mfp->delUploadFile("email_templates","image_path","id",$id,"../uploads/template_images/");
		$mfp->mf_setmessage('<div class="alert alert-danger"><i class="fa fa-check-circle"></i>Image deleted successfully.<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>', $add_page_link."?id=".$id);
	}
	
	$selRes=$mfp->mf_query("SELECT * FROM email_templates where id='".$id."'");
	if($mfp->mf_affected_rows()>0)
	{
		$selRow=$mfp->mf_fetch_array($selRes);
		$template_type=stripslashes($selRow['template_type']);
		$title=stripslashes($selRow['title']);
		$subject=stripslashes($selRow['subject']);
		$short_codes=stripslashes($selRow['short_codes']);
		$mail_content=stripslashes($selRow['content']);
		$text_find=stripslashes($selRow['short_codes']);
		$image_path=stripslashes($selRow['image_path']);
		$embeded_code=stripslashes($selRow['embeded_code']);
	}
	
	if(isset($_POST['btnSubmit']))
	{
		$insArr=array();
		$insArr['template_type']=$_POST['template_type'];
		if($_POST['title']!=""){ $insArr['title']=$_POST['title']; }
		$insArr['subject']=$_POST['subject'];
		$insArr['short_codes']=$_POST['short_codes'];
		$insArr['embeded_code']=$_POST['embeded_code'];
		$insArr['content']=$_POST['mail_content'];
		
		if( ! ($_FILES['image_path']['error']))
		{
			$mfp->delUploadFile("email_templates","image_path","id",$id,"../uploads/template_images/");
			$image_path=time()."_".$mfp->mf_puretext($_FILES['image_path']['name']);
			if(copy($_FILES['image_path']['tmp_name'],"../uploads/template_images/".$image_path))
				$insArr['image_path']=$image_path;
		}
		
		if($id>0)
		{
			if($mfp->mf_dbupdate("email_templates",$insArr," where id='$id'"))
			{
				$mfp->mf_setmessage('<div class="alert alert-success"> <i class="fa fa-check-circle"></i>Email Template information updated successfully.<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>',"manage-email-template.php");
			}
		}
		else
		{
			if($mfp->mf_dbinsert("email_templates",$insArr))
			{
				$mfp->mf_setmessage('<div class="alert alert-success"> <i class="fa fa-check-circle"></i>File information inserted successfully.<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span><span class="sr-only">Close</span></button></div>',"manage-email-template.php");
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
		<?=ucwords($currentPage);?>
		<a href="<?=$back_page_link;?>" class="btn btn-primary pull-right">Back</a>       
	  </h1>
	  <br/>
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
              <form class="cmxform form-horizontal " name="emailtemplate" id="emailtemplate" method="post" action="" enctype="multipart/form-data">
                <br/>
                <div class="form-group ">
                  <label for="first_name" class="control-label col-lg-3">Template Name</label>
                  <div class="col-lg-6">                    
                    <?php /*?><input class=" form-control required" id="title" name="title" value=""  type="text" /><?php */?>
                    <?=$title;?>
                  </div>
                </div>
                
                <div class="form-group ">
                    <label for="curl" class="control-label col-lg-3">Email Subject*</label>
                    <div class="col-lg-6">
                        <input name="subject" id="subject" value="<?=$subject;?>" type="text" class="form-control required" />
                    </div>
                </div>
				
				<div class="form-group ">
                    <label for="curl" class="control-label col-lg-3">Short Code</label>
                    <div class="col-sm-6">
                        <textarea name="short_codes" id="short_codes" rows="5" cols="51" readonly="readonly" disabled ><?=$short_codes;?></textarea>
                        <input name="short_codes" id="short_codes" type="hidden" readonly="readonly" value="<?=$short_codes;?>" />
                    </div>
                </div>
                   
                 <div class="form-group ">
                     <label class="control-label col-lg-3">&nbsp;</label>
                     <div class="col-lg-6">
                     	Please use below variable in mail template for displaying dynamic value:<br />
                     </div>
                </div>                     
                <div class="form-group ">
                    <label for="curl" class="control-label col-lg-3">Mail Content</label>
                    <div class="col-sm-6">
                        <textarea class="form-control ckeditor" name="mail_content" rows="10"><?=$mail_content;?></textarea>
                    </div>
                </div>
                
                 <div class="form-group">
                  <div class="col-lg-offset-3 col-lg-6">
                    <button class="btn btn-primary" type="submit" name="btnSubmit">Save</button>
                    <? if($id>0){ ?>
                    <button type="button" class="btn" onClick="window.location='manage-email-template.php';">Back</button>
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
      		 $("#emailtemplate").validate();
    	});
</script>
</body>
</html>
