<?php include_once("connect.php"); @session_start();
$id=intval($_REQUEST['pageId']);
if($_REQUEST['paging']>0){
  define('PAGE_PER_NO',$_REQUEST['paging']);
}else { 
  define('PAGE_PER_NO',10);
}
$pageLimit=PAGE_PER_NO*$id;

$search_type = $_REQUEST['search_type'];
$club = $_REQUEST['club'];
$company = $_REQUEST['company'];
$contact_id = $_REQUEST['contact_id'];
$country = $_REQUEST['country'];
$city = $_REQUEST['city'];
$end_user_company = $_REQUEST['end_user_company'];
$customer_id = $_REQUEST['customer_id'];
$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];
$email = $_REQUEST['email'];
$phone = $_REQUEST['phone'];
$streets = $_REQUEST['streets'];
$state = $_REQUEST['state'];
$zip = $_REQUEST['zip'];
$customer_po = $_REQUEST['customer_po'];
$sale_id = $_REQUEST['sale_id'];
$product_type = $_REQUEST['product_type'];
$total_price = $_REQUEST['total_price'];
$licence_id = $_REQUEST['licence_id'];
$licence_number = $_REQUEST['licence_number'];
$licence_status = $_REQUEST['licence_status'];
$licence_type = $_REQUEST['licence_type'];
$protected_computers = $_REQUEST['protected_computers'];
$validity = $_REQUEST['validity'];
$reseller_company = $_REQUEST['reseller_company'];
$reseller_code = $_REQUEST['reseller_code'];

$from_date = $_REQUEST['from_date'];
$to_date = $_REQUEST['to_date'];

$excQry = "";
if($club!="")
{
	$excQry.=" AND c.club = '".$club."'";
}
if($company!="")
{
	$excQry.=" AND c.company = '".$company."'";
}
if($contact_id!="" && $search_type==1)
{
	$excQry.=" AND c.contact_id = '".$contact_id."'";
}
if($country!="")
{
	$excQry.=" AND c.country = '".$country."'";
}
if($city!="")
{
	$excQry.=" AND c.city = '".$city."'";
}
if($end_user_company!="")
{
	$excQry.=" AND c.end_user_company = '".$end_user_company."'";
}
if($customer_id!="")
{
	$excQry.=" AND c.customer_id = '".$customer_id."'";
}
if($first_name!="")
{
	$excQry.=" AND c.first_name = '".$first_name."'";
}
if($last_name!="")
{
	$excQry.=" AND c.last_name = '".$last_name."'";
}
if($email!="" && $search_type==4)
{
	$excQry.=" AND c.email = '".$email."'";
}
if($phone!="" && $search_type==6)
{
	$excQry.=" AND c.phone = '".$phone."'";
}
if($streets!="")
{
	$excQry.=" AND c.streets = '".$streets."'";
}
if($state!="")
{
	$excQry.=" AND c.state = '".$state."'";
}
if($zip!="")
{
	$excQry.=" AND c.zip = '".$zip."'";
}
if($customer_po!="")
{
	$excQry.=" AND c.customer_po = '".$customer_po."'";
}
if($sale_id!="")
{
	$excQry.=" AND c.sale_id = '".$sale_id."'";
}
if($product_type!="")
{
	$excQry.=" AND c.product_type = '".$product_type."'";
}
if($total_price!="")
{
	$excQry.=" AND c.total_price = '".$total_price."'";
}
if($licence_id!="")
{
	$excQry.=" AND c.licence_id = '".$licence_id."'";
}
if($licence_number!="" && $search_type==5)
{
	$excQry.=" AND c.licence_number = '".$licence_number."'";
}
if($licence_status!="")
{
	$excQry.=" AND c.licence_status = '".$licence_status."'";
}
if($licence_type!="")
{
	$excQry.=" AND c.licence_type = '".$licence_type."'";
}
if($protected_computers!="")
{
	$excQry.=" AND c.protected_computers = '".$protected_computers."'";
}
if($validity!="")
{
	$excQry.=" AND c.validity = '".$validity."'";
}
if($reseller_company!="" && $search_type==3)
{
	$excQry.=" AND r.reseller_company = '".$reseller_company."'";
}
if($reseller_code!="" && $search_type==2)
{
	$excQry.=" AND r.reseller_code = '".$reseller_code."'";
}

if(isset($from_date) && $from_date!="")
{	
	$excQry.=" and DATE(c.expiration_date) >= '".date("Y-m-d",strtotime($from_date))."'";
}

if(isset($to_date) && $to_date!="")
{	
	$excQry.=" and DATE(c.expiration_date) <= '".date("Y-m-d",strtotime($to_date))."'";
}

$avgList = "'0',";
$customeids = $mfp->mf_getvalue("users","customer_ids","id",$_SESSION['UserID']);
$cntidRes = $mfp->mf_query("SELECT avg_id from reseller_code_mapping WHERE id IN ($customeids)");
if($mfp->mf_affected_rows()>0){
  while($cntidRw = $mfp->mf_fetch_array($cntidRes)) { 
    $avgList .= "'".$cntidRw['avg_id']."',";
  }
}
$avgList = substr($avgList, 0, -1);
$excQry.= " AND contact_id IN (".$avgList.")";
/*$custArr = explode(",",$customeids);
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
}*/

?>

<div class="sec-tit2">
	<div class="container">
		
        <div class="secLeft"><h3>License Details</h3></div>
        <div class="secRight">        
<div class="pagination-main downside pagination-top">
 <ul>
  <?php 
	$tquery = $mfp->mf_query("SELECT c.*, r.reseller_company, r.reseller_code FROM customers c LEFT JOIN reseller_code_mapping r ON c.contact_id=r.avg_id WHERE 1 = 1 $excQry Order by id desc");
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
        
        
	</div>
</div>
<div class="lic-detail ">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <thead>
    <tr>
       <th class="avgid">AVG ID</th>
       <th class="license-number">Licence Number</th>
       <th class="licdate">Licence Expiry Date</th>
       <th class="comnm">Company Name</th>
       <th class="connum">Contact Number</th>
       <th class="reselcd">Reseller Code</th>
       <th class="reseller-company">Reseller Company</th>
       <th class="action">&nbsp;</th>
    </tr>
    </thead>
    <tbody>
<?php //echo "SELECT c.*, r.reseller_company, r.reseller_code FROM customers c LEFT JOIN reseller_code_mapping r ON c.contact_id=r.avg_id WHERE 1 = 1 $excQry Order by id desc limit $pageLimit,".PAGE_PER_NO;
$licQry = $mfp->mf_query("SELECT c.*, r.reseller_company, r.reseller_code FROM customers c LEFT JOIN reseller_code_mapping r ON c.contact_id=r.avg_id WHERE 1 = 1 $excQry Order by id desc limit $pageLimit,".PAGE_PER_NO);

if($mfp->mf_affected_rows()>0)
{ 
	$totrows=$mfp->mf_affected_rows();
	$no=0;
	while($licRow = $mfp->mf_fetch_array($licQry)) { 
	$no++; 
	?>
	<tr>
	  	<td><a href="license-detail.php?id=<?=$licRow['id'];?>"><?php echo $licRow['contact_id'];?></a></td>
        <td class="lic-numinn"><?php echo $licRow['licence_number'];?></td>
        <td><?php echo $licRow['expiration_date'];?></td>
        <td><?php echo $licRow['company'];?></td>
    	<td><?php echo $licRow['phone'];?></td>
        <td><?php echo $licRow['reseller_code'];?></td>
        <td><?php echo $licRow['reseller_company'];?></td>
        <td class="table-action"><a class="btn" href="license-edit.php?id=<?=$licRow['id'];?>"><i class="fa fa-pencil"></i></a></td>
    </tr>
<?php } } else { ?>
	<tr>
	  <td colspan="8">There are no reseller detail found.</td>
	</tr>
<?php }?>
	</tbody>
</table>
</div>
<div class="container">
<div class="pagination-main downside pagination-bottom">
 <ul>
  <?php 
	$tquery = $mfp->mf_query("SELECT c.*, r.reseller_company, r.reseller_code FROM customers c LEFT JOIN reseller_code_mapping r ON c.contact_id=r.avg_id WHERE 1 = 1 $excQry Order by id desc");
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