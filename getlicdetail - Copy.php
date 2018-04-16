<?php include_once("connect.php");
$id=intval($_REQUEST['pageId']);
if($_REQUEST['paging']>0){
  define('PAGE_PER_NO',$_REQUEST['paging']);
}else { 
  define('PAGE_PER_NO',10);
}
$pageLimit=PAGE_PER_NO*$id;

$license_id = $_REQUEST['license_id'];
$order_id = $_REQUEST['order_id'];
$reseller_company = $_REQUEST['reseller_company'];
$customer_email = $_REQUEST['customer_email'];
$license_number = $_REQUEST['license_number'];
$from_date = $_REQUEST['from_date'];
$to_date = $_REQUEST['to_date'];
$excQry = "";
if($license_id!="")
{
	$excQry.=" AND license_id = '".$license_id."'";
}
if($order_id!="")
{
	$excQry.=" AND order_id = '".$order_id."'";
}
if($reseller_company!="")
{
	$excQry.=" AND reseller_company LIKE '%".$reseller_company."%'";
}
if($customer_email!="")
{
	$excQry.=" AND customer_email = '".$customer_email."'";
}

if($license_number!="")
{
	$excQry.=" AND license_number = '".$license_number."'";
}
if(isset($from_date) && $from_date!="")
{	
	$excQry.=" and date_expired >= '".date("Y-m-d",strtotime($from_date))."'";
}

if(isset($to_date) && $to_date!="")
{	
	$excQry.=" and date_expired <= '".date("Y-m-d",strtotime($to_date))."'";
}
$customeids = $mfp->mf_getvalue("users","customer_ids","id",$_SESSION['UserID']);
$custArr = explode(",",$customeids);
if(!empty($custArr))
{
	//$excQry.=" AND id IN ('".implode("','",$idArr)."')";
	$custqry = "";
	foreach($custArr as $cid)
	{
		$compny_name = $mfp->mf_getvalue("customers","reseller_company","id",$cid);
		$custqry.= "reseller_company='".mysql_real_escape_string($compny_name)."' OR ";
	}
	$excQry.= " and (".substr($custqry,0,-3).")";
}

?>
<div class="container">
<div class="pagination-main downside pagination-top">
 <ul>
  <?php 
	$tquery = $mfp->mf_query("SELECT * from customers where 1 = 1 $excQry Order by id desc");
	$count=mysql_num_rows($tquery);
	if($mfp->mf_affected_rows()>0)
	{
		$count=mysql_num_rows($tquery);
		$paginationCount=$mfp->getPagination($count);
		$totPages=ceil($count/PAGE_PER_NO);
		if($totPages>1 && $totPages<=10){
			
			if($id>0){ ?>
				 <li class="prev-arrow"><a href="javascript:void(0)" onClick="getlicdetail('<?php echo $id-1;?>')"><i class="fa fa-angle-left"></i></a></li>
			   <? }else{ ?>
				  <li class="prev-arrow"><a href="javascript:void(0)" onClick="javascript:void(0)"><i class="fa fa-angle-left"></i></a></li>
			   <? }
				  for($i=0;$i<$paginationCount;$i++)
				  {
					?>
					<li id="<?php echo $i;?>_no" class='<?php if($id==$i){echo "current";}?>'>
						<a href="javascript:void(0)" onClick="getlicdetail('<?php echo $i;?>')"><?php echo $i+1;?></a>
					</li>
					<?
				   }
				   
				   if($id<($totPages-1)){ ?>
					 <li class="next-arrow"><a href="javascript:void(0)" onClick="getlicdetail('<?php echo $id+1;?>')"><i class="fa fa-angle-right"></i></a></li>
				   <? }else{ ?>
					  <li class="next-arrow"><a href="javascript:void(0)" onClick="javascript:void(0)"><i class="fa fa-angle-right"></i></a></li>
				   <? } ?>
                   <li class="show-all"><a href="javascript:void(0)" onClick="showAll()">Show All</a></li>
     <?php           
			
		}
		elseif($totPages>1){
			
		 ?>
		   <?php  if($id>0){ ?>
			 <li class="prev-arrow"><a href="javascript:void(0)" onClick="getlicdetail('<?php echo $id-1;?>')"><i class="fa fa-angle-left"></i></a></li>
		   <? }else{ ?>
			  <li class="prev-arrow"><a href="javascript:void(0)" onClick="javascript:void(0)"><i class="fa fa-angle-left"></i></a></li>
		   <? }  ?>
		   <?php
		   
		   $showFst=0;
		   $showMid=1;
		   $showLst=0;
		   if($id<=4) { $showFst=1; $showMid=0; }
		   if($id>=$totPages-5) { $showLst=1; $showMid=0; }
		   
		   if($showFst==1)
		   {
			   for($i=0;$i<6;$i++)
				{
					?>
					<li id="<?php echo $i;?>_no" class='<?php if($id==$i){echo "current";}?>'>
						<a href="javascript:void(0)" onClick="getlicdetail('<?php echo $i;?>')"><?php echo $i+1;?></a>
					</li>
					<?php 
				}
		   }
		   else
		   {
			   for($i=0;$i<=1;$i++)
				{
					?>
					<li id="<?php echo $i;?>_no" class='<?php if($id==$i){echo "current";}?>'>
						<a href="javascript:void(0)" onClick="getlicdetail('<?php echo $i;?>')"><?php echo $i+1;?></a>
					</li>
					<?php
				}
		   }
		   echo '<li><a href="javascript:void(0)">......</a></li>';
		   
		   
		   if($showMid==1)
		   {
			   for($i=$id-1;$i<=$id+1;$i++)
				{
					?>
					<li id="<?php echo $i;?>_no" class='<?php if($id==$i){echo "current";}?>'>
						<a href="javascript:void(0)" onClick="getlicdetail('<?php echo $i;?>')"><?php echo $i+1;?></a>
					</li>
					<?php
				}
			   echo '<li><a href="javascript:void(0)">......</a></li>';
		   }
		   
		   
		   if($showLst==1)
		   {
			   for($i=$totPages-6;$i<$totPages;$i++)
				{
					?>
					<li id="<?php echo $i;?>_no" class='<?php if($id==$i){echo "current";}?>'>
						<a href="javascript:void(0)" onClick="getlicdetail('<?php echo $i;?>')"><?php echo $i+1;?></a>
					</li>
					<?php 
				}
		   }
		   else
		   {
			   for($i=$totPages-2;$i<$totPages;$i++)
				{
					?>
					<li id="<?php echo $i;?>_no" class='<?php if($id==$i){echo "current";}?>'>
						<a href="javascript:void(0)" onClick="getlicdetail('<?php echo $i;?>')"><?php echo $i+1;?></a>
					</li>
					<?php
				}
		   }
		   if($id<($totPages-1)){ ?>
			 <li class="next-arrow"><a href="javascript:void(0)" onClick="getlicdetail('<?php echo $id+1;?>')"><i class="fa fa-angle-right"></i></a></li>
		   <? }else{ ?>
			  <li class="next-arrow"><a href="javascript:void(0)" onClick="javascript:void(0)"><i class="fa fa-angle-right"></i></a></li>
		   <? } ?>
          <li class="show-all"><a href="javascript:void(0)" onClick="showAll()">Show All</a></li>
   <?php
	} 
 }
?>
 </ul>
</div>
</div>
<div class="sec-tit2 slideDown">
	<div class="container">
		<h3>License Details</h3>
	</div>
</div>
<div class="lic-detail slideUp">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <thead>
    <tr>
       <th class="order-id">Order ID</th>
       <th class="license-id">License ID</th>
       <th class="license-number">License Number</th>
       <th class="reseller-code">Reseller Code</th>
       <th class="purchase-type">Purchase Type</th>
       <th class="seats">Seats</th>
       <th class="reseller-company">Reseller Company</th>
       <th class="customer-email">Customer Email</th>
       <th class="customer-phone">Customer Phone</th>
    </tr>
    </thead>
    <tbody>
<?php //echo  "SELECT * from customers where 1 = 1 $excQry Order by id desc limit $pageLimit,".PAGE_PER_NO;
$licQry = $mfp->mf_query("SELECT * from customers where 1 = 1 $excQry Order by id desc limit $pageLimit,".PAGE_PER_NO);
if($mfp->mf_affected_rows()>0)
{ 
	$totrows=$mfp->mf_affected_rows();
	$no=0;
	while($licRow = $mfp->mf_fetch_array($licQry)) { 
	$no++; 
	?>
	<tr>
	  	<td class="order-id"><a href="license-detail.php?id=<?=$licRow['id'];?>"><?php echo $licRow['order_id'];?></a></td>
        <td class="license-id"><?php echo $licRow['license_id'];?></td>
        <td class="license-number"><?php echo $licRow['license_number'];?></td>
        <td class="reseller-code"><?php echo $licRow['reseller_code'];?></td>
    	<td class="purchase-type"><?php echo $licRow['purchase_type'];?></td>
        <td class="seats"><?php echo $licRow['seats'];?></td>
        <td class="reseller-company"><?php echo $licRow['reseller_company'];?></td>
        <td class="customer-email"><?php echo $licRow['customer_email'];?></td>
        <td class="customer-phone"><?php echo $licRow['customer_phone'];?></td>
    </tr>
<?php } } else { ?>
	<tr>
	  <td colspan="27">There are no reseller detail found.</td>
	</tr>
<?php }?>
	</tbody>
</table>
</div>
<div class="container">
<div class="pagination-main downside pagination-bottom">
 <ul>
  <?php 
	$tquery = $mfp->mf_query("SELECT * from customers where 1 = 1 $excQry Order by id desc");
	$count=mysql_num_rows($tquery);
	if($mfp->mf_affected_rows()>0)
	{
		$count=mysql_num_rows($tquery);
		$paginationCount=$mfp->getPagination($count);
		$totPages=ceil($count/PAGE_PER_NO);
		if($totPages>1 && $totPages<=10){
			
			if($id>0){ ?>
				 <li class="prev-arrow"><a href="javascript:void(0)" onClick="getlicdetail('<?php echo $id-1;?>')"><i class="fa fa-angle-left"></i></a></li>
			   <? }else{ ?>
				  <li class="prev-arrow"><a href="javascript:void(0)" onClick="javascript:void(0)"><i class="fa fa-angle-left"></i></a></li>
			   <? }
				  for($i=0;$i<$paginationCount;$i++)
				  {
					?>
					<li id="<?php echo $i;?>_no" class='<?php if($id==$i){echo "current";}?>'>
						<a href="javascript:void(0)" onClick="getlicdetail('<?php echo $i;?>')"><?php echo $i+1;?></a>
					</li>
					<?
				   }
				   
				   if($id<($totPages-1)){ ?>
					 <li class="next-arrow"><a href="javascript:void(0)" onClick="getlicdetail('<?php echo $id+1;?>')"><i class="fa fa-angle-right"></i></a></li>
				   <? }else{ ?>
					  <li class="next-arrow"><a href="javascript:void(0)" onClick="javascript:void(0)"><i class="fa fa-angle-right"></i></a></li>
				   <? } ?>
                   <li class="show-all"><a href="javascript:void(0)" onClick="showAll()">Show All</a></li>
      <?php
      }
		elseif($totPages>1){
			
		 ?>
		   <?php  if($id>0){ ?>
			 <li class="prev-arrow"><a href="javascript:void(0)" onClick="getlicdetail('<?php echo $id-1;?>')"><i class="fa fa-angle-left"></i></a></li>
		   <? }else{ ?>
			  <li class="prev-arrow"><a href="javascript:void(0)" onClick="javascript:void(0)"><i class="fa fa-angle-left"></i></a></li>
		   <? }  ?>
		   <?php
		   
		   $showFst=0;
		   $showMid=1;
		   $showLst=0;
		   if($id<=4) { $showFst=1; $showMid=0; }
		   if($id>=$totPages-5) { $showLst=1; $showMid=0; }
		   
		   if($showFst==1)
		   {
			   for($i=0;$i<6;$i++)
				{
					?>
					<li id="<?php echo $i;?>_no" class='<?php if($id==$i){echo "current";}?>'>
						<a href="javascript:void(0)" onClick="getlicdetail('<?php echo $i;?>')"><?php echo $i+1;?></a>
					</li>
					<?php 
				}
		   }
		   else
		   {
			   for($i=0;$i<=1;$i++)
				{
					?>
					<li id="<?php echo $i;?>_no" class='<?php if($id==$i){echo "current";}?>'>
						<a href="javascript:void(0)" onClick="getlicdetail('<?php echo $i;?>')"><?php echo $i+1;?></a>
					</li>
					<?php
				}
		   }
		   echo '<li><a href="javascript:void(0)">......</a></li>';
		   
		   
		   if($showMid==1)
		   {
			   for($i=$id-1;$i<=$id+1;$i++)
				{
					?>
					<li id="<?php echo $i;?>_no" class='<?php if($id==$i){echo "current";}?>'>
						<a href="javascript:void(0)" onClick="getlicdetail('<?php echo $i;?>')"><?php echo $i+1;?></a>
					</li>
					<?php
				}
			   echo '<li><a href="javascript:void(0)">......</a></li>';
		   }
		   
		   
		   if($showLst==1)
		   {
			   for($i=$totPages-6;$i<$totPages;$i++)
				{
					?>
					<li id="<?php echo $i;?>_no" class='<?php if($id==$i){echo "current";}?>'>
						<a href="javascript:void(0)" onClick="getlicdetail('<?php echo $i;?>')"><?php echo $i+1;?></a>
					</li>
					<?php 
				}
		   }
		   else
		   {
			   for($i=$totPages-2;$i<$totPages;$i++)
				{
					?>
					<li id="<?php echo $i;?>_no" class='<?php if($id==$i){echo "current";}?>'>
						<a href="javascript:void(0)" onClick="getlicdetail('<?php echo $i;?>')"><?php echo $i+1;?></a>
					</li>
					<?php
				}
		   }
		   if($id<($totPages-1)){ ?>
			 <li class="next-arrow"><a href="javascript:void(0)" onClick="getlicdetail('<?php echo $id+1;?>')"><i class="fa fa-angle-right"></i></a></li>
		   <? }else{ ?>
			  <li class="next-arrow"><a href="javascript:void(0)" onClick="javascript:void(0)"><i class="fa fa-angle-right"></i></a></li>
		   <? }  ?>
           <li class="show-all"><a href="javascript:void(0)" onClick="showAll()">Show All</a></li>
   <?php 
	} 
 }
?>
 </ul>
</div>
</div>