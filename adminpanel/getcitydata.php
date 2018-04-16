<?php include_once("connect.php");
	$add_page_link="add-cities.php";
	$id=intval($_REQUEST['pageId']);
	if($_REQUEST['paging']>0){
		define('PAGE_PER_NO',$_REQUEST['paging']);
	}else { 
		define('PAGE_PER_NO',20);
	}
	$pageLimit=PAGE_PER_NO*$id;
	$exeQr='';
	if(isset($_REQUEST['txtSearch']) && $_REQUEST['txtSearch']!="")
	{	
		$exeQr .= ' and city like "%'.$_REQUEST['txtSearch'].'%" ';
		/*if($txtSearch=='Yes' || $txtSearch=='yes'  || $txtSearch=='YES')
		{
			$txtSearch=0;
		}elseif($txtSearch=='No' || $txtSearch=='no' || $txtSearch=='NO'){
			$txtSearch=1;
		}elseif($txtSearch=='Backorder' || $txtSearch=='backorder' || $txtSearch=='BACKORDER'){
			$txtSearch=2;
		}*/
	}
	if(isset($_REQUEST['txtState']) && $_REQUEST['txtState']!="")
	{
		$exeQr .= ' and state = "'.$_REQUEST['txtState'].'" ';
	}
	if(isset($_REQUEST['txtCounty']) && $_REQUEST['txtCounty']!="")
	{
		$exeQr .= ' and county = "'.$_REQUEST['txtCounty'].'" ';
	}
	//$exeQr.=" and (state like '%".$txtSearch."%' or statefullname like '%".$txtSearch."%' or county like '%".$txtSearch."%' or city like '%".$txtSearch."%' or is_sale like '%".$txtSearch."%') ";
	//$exeQr.=" and (state like '%".$txtSearch."%' or statefullname like '%".$txtSearch."%' or county like '%".$txtSearch."%' or city like '%".$txtSearch."%' or is_sale like '%".$txtSearch."%') ";
	
	$orderby = "order by city asc"; ?>
   
	<?php
    $n = 0;
    //echo "select * from cities where 1=1 $exeQr $orderby";
    $result = $mfp->mf_query("select * from cities where 1=1 $exeQr $orderby limit $pageLimit,".PAGE_PER_NO);
    if($mfp->mf_affected_rows()>0)
    {
        while($row=$mfp->mf_fetch_array($result))
        { $n++; ?>
            <tr>
                <td><?=$n;?></td>
                <td><?=ucwords(stripslashes($row['city']));?></td>
                <td><?=ucwords(stripslashes($row['county']));?></td>
                <td><?=ucwords(stripslashes($row['statefullname']));?></td>
                <td><?php if($row['is_sale']==0){ echo 'Yes'; } else if($row['is_sale']==2){ echo 'Backorder'; } else { echo 'No'; }?></td>
               
                <td><a href="<?=$add_page_link;?>?id=<?=$row['id'];?>">Edit</a> | <a class="" href="<?=$add_page_link;?>?act=del&id=<?=$row['id'];?>" onClick="return check_delete();">Delete</a></td>
               
               
            </tr>
    <?php	}
    }else{	?>
    <tr>
        <td colspan="6">No data available in table</td>
    </tr>
    
    <? } ?>
###==###                      
    <div class="clear"></div>
    <div class="row">
    <div class="col-lg-6">&nbsp;</div>
    <div class="pagination col-lg-6">
    	<div class="dataTables_paginate paging_bootstrap pagination">
       	<?php 
			$tquery = $mfp->mf_query("select * from cities where 1=1 $exeQr $orderby");
			$count=mysql_num_rows($tquery);
			if($mfp->mf_affected_rows()>0)
			{
				$count=mysql_num_rows($tquery);
				$paginationCount=$mfp->getPagination($count);
				$totPages=ceil($count/PAGE_PER_NO);
				if($totPages>1 && $totPages<=10){
					echo "<ul>";
					if($id>0){ ?>
                         <li class='previous link'><a href="javascript:void(0)" onClick="displayMyLocal('<?php echo $id-1;?>')">PREV</a></li>
                       <? }else{ ?>
                          <li class='previous link'><a href="javascript:void(0)" onClick="javascript:void(0)">PREV</a></li>
                       <? }
						  for($i=0;$i<$paginationCount;$i++)
						  {
							?>
							<li id="<?php echo $i;?>_no" class='link<?php if($id==$i){echo " active";}?>'>
								<a href="javascript:void(0)" onClick="displayMyLocal('<?php echo $i;?>')"><?php echo $i+1;?></a>
							</li>
							<?
                           }
						   
						   if($id<($totPages-1)){ ?>
                             <li class='next link'><a href="javascript:void(0)" onClick="displayMyLocal('<?php echo $id+1;?>')">NEXT </a></li>
                           <? }else{ ?>
                              <li class='next link'><a href="javascript:void(0)" onClick="javascript:void(0)">NEXT</a></li>
                           <? }
					echo "</ul>";
				}
				elseif($totPages>1){
					echo "<ul>";
				 ?>
				   <?php  if($id>0){ ?>
					 <li class='previous link'><a href="javascript:void(0)" onClick="displayMyLocal('<?php echo $id-1;?>')">PREV</a></li>
				   <? }else{ ?>
					  <li class='previous link'><a href="javascript:void(0)" onClick="javascript:void(0)">PREV</a></li>
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
							<li id="<?php echo $i;?>_no" class='link<?php if($id==$i){echo " active";}?>'>
                            	<a href="javascript:void(0)" onClick="displayMyLocal('<?php echo $i;?>')"><?php echo $i+1;?></a>
                            </li>
                            <?php 
						}
				   }
				   else
				   {
					   for($i=0;$i<=1;$i++)
						{
							?>
							<li id="<?php echo $i;?>_no" class='link<?php if($id==$i){echo " active";}?>'>
								<a href="javascript:void(0)" onClick="displayMyLocal('<?php echo $i;?>')"><?php echo $i+1;?></a>
							</li>
							<?php
						}
				   }
				   echo '<li class="previous link"><a href="javascript:void(0)">......</a></li>';
				   
				   
				   if($showMid==1)
				   {
					   for($i=$id-1;$i<=$id+1;$i++)
						{
							?>
							<li id="<?php echo $i;?>_no" class='link<?php if($id==$i){echo " active";}?>'>
								<a href="javascript:void(0)" onClick="displayMyLocal('<?php echo $i;?>')"><?php echo $i+1;?></a>
							</li>
							<?php
						}
					   echo '<li class="previous link"><a href="javascript:void(0)">......</a></li>';
				   }
				   
				   
				   if($showLst==1)
				   {
					   for($i=$totPages-6;$i<$totPages;$i++)
						{
							?>
							<li id="<?php echo $i;?>_no" class='link<?php if($id==$i){echo " active";}?>'>
                            	<a href="javascript:void(0)" onClick="displayMyLocal('<?php echo $i;?>')"><?php echo $i+1;?></a>
                            </li>
                            <?php 
						}
				   }
				   else
				   {
					   for($i=$totPages-2;$i<$totPages;$i++)
						{
							?>
							<li id="<?php echo $i;?>_no" class='link<?php if($id==$i){echo " active";}?>'>
								<a href="javascript:void(0)" onClick="displayMyLocal('<?php echo $i;?>')"><?php echo $i+1;?></a>
							</li>
							<?php
						}
				   }
				   if($id<($totPages-1)){ ?>
					 <li class='next link'><a href="javascript:void(0)" onClick="displayMyLocal('<?php echo $id+1;?>')">NEXT </a></li>
				   <? }else{ ?>
					  <li class='next link'><a href="javascript:void(0)" onClick="javascript:void(0)">NEXT </a></li>
				   <? } 
				echo "</ul>";
			} 
			} ?>
    </div>
	</div>
    </div>
