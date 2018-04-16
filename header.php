<div class="logo-part">
  <div class="container">
    <div class="site-logo"><a href="<?=$SITE_URL;?>" class="logo"><img src="images/synnex-cloud-icon.png" alt="" /></a></div>
    <div class="siteName"><span>License Search Portal</span></div>
    <?php $i=0;
		$license1=$mfp->mf_query("SELECT * FROM customers WHERE id='".$licenseid."'");
		if($mfp->mf_affected_rows()>0) {
			while($row1=$mfp->mf_fetch_array($license1)) { $i++; 
		?>
    <div class="hdr-orderid">
      <ul>
        <li class="back-btn"><a href="<?=$SITE_URL;?>dashboard.php"><i class="fa fa-chevron-left"></i>back</a></li>
        <li><i class="tab-icon icon1"></i>AVG ID -
          <?=$row1['contact_id'];?>
        </li>
        <li><a class="liceditBtn" href="license-edit.php?id=<?=$row1['id'];?>"><i class="fa fa-pencil"></i></a>
        </li>
      </ul>
    </div>
    <?php } } ?>
    <div class="hdr-right">
      <ul class="hdr-profile">
        <li class="client"><span class="client"><!--<b class="client-img"><img src="images/client-img.png" alt="" /></b>--><a href="javascript:void(0);"><?php echo "<span>Staff:</span> ".$_SESSION['User_fName'].' '.$_SESSION['User_lName']; ?></a></span></li>
        <li class="sign"><a href="logout.php" class="sign-out"></a></li>
      </ul>
    </div>
  </div>
</div>
