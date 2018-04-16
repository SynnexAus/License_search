<?php
	include_once "connect.php";
	$mfp->mf_isadmin();
	$currentMenu="Dashboard";
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
      <h1> Dashboard </h1>
    </section>
    <section class="content">
	<div class="row">
		<div class="col-lg-3 col-xs-6">
		  <!-- small box -->
		  <div class="small-box bg-blue">
			<div class="inner">
			  <h3>
				<?php $actconinq=$mfp->mf_query("select * from users");
				echo $Totactconinq = mysql_num_rows($actconinq); ?>
			  </h3>
			  <p>Users</p>
			</div>
			<div class="icon"> <i class="ion ion-ios7-pricetag-outline"></i> </div>
			<a href="manage-users.php" class="small-box-footer"> More info <i class="fa fa-arrow-circle-right"></i> </a> </div>
		</div>
        <div class="col-lg-3 col-xs-6">
		  <!-- small box -->
		  <div class="small-box bg-blue">
			<div class="inner">
			  <h3>
				<?php $actconinq=$mfp->mf_query("select * from customers");
				echo $Totactconinq = mysql_num_rows($actconinq); ?>
			  </h3>
			  <p>Customers</p>
			</div>
			<div class="icon"> <i class="ion ion-ios7-pricetag-outline"></i> </div>
			<a href="manage-customers.php" class="small-box-footer"> More info <i class="fa fa-arrow-circle-right"></i> </a> 			
          </div>
		</div>
		</div>      
    </section>    
  </aside>  
</div>
<script src="js/jquery.min.js"></script>
<script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="js/plugins/morris/morris.min.js" type="text/javascript"></script>
<script src="js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
<script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
<script src="js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
<script src="js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<script src="js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
<script src="js/AdminLTE/app.js" type="text/javascript"></script>
<script src="js/AdminLTE/dashboard.js" type="text/javascript"></script>
<script src="js/AdminLTE/demo.js" type="text/javascript"></script>
</body>
</html>