<?php
	
	function hex2bin($str) 
	{
		$bin = "";
		$i = 0;
		do {
			$bin .= chr(hexdec($str{$i}.$str{($i + 1)}));
			$i += 2;
		} while ($i < strlen($str));
		return $bin;
	}

	function sql_injection($str)
	{
		$new_str=mysql_real_escape_string($str);
		return $new_str;
	}
	
	function is_user_session()
	{
		if($_SESSION['CAT_UserID']>0)
		{
		}
		else
		{
			echo "<script> window.location='index.php'; </script>";
			exit;
		}
	}

	function is_admin_user_session()
	{
		if($_SESSION['ADMIN_UserID']>0)
		{
		}
		else
		{
			echo "<script> window.location='index.php'; </script>";
			exit;
		}
	}
	
	function getUserName()
	{
		$unm="";
		$usrRes=mysql_query("SELECT first_name, last_name from users where id='".$_SESSION['CAT_UserID']."'");
		if(mysql_affected_rows()>0)
		{
			$usrRow=mysql_fetch_array($usrRes);
			$unm=stripslashes($usrRow['first_name'].' '.$usrRow['last_name']);
		}
		return $unm;
	}
	
	function getValue($table,$field,$where,$condition)
	{
		$unm="";
		$usrRes=mysql_query("SELECT $field from $table where $where='".$condition."'");
		if(mysql_affected_rows()>0)
		{
			$usrRow=mysql_fetch_array($usrRes);
			$unm=$usrRow[$field];
		}
		return $unm;
	}
	
	function getUserVerifyStatus()
	{
		$flag=array(0,0,0);
		$usrRes=mysql_query("SELECT email_status, mobile_status from users where id='".$_SESSION['CAT_UserID']."'");
		if(mysql_affected_rows()>0)
		{
			$usrRow=mysql_fetch_array($usrRes);
			$flag[0]=$usrRow['email_status'];
			$flag[1]=$usrRow['mobile_status'];
		}
		
		$usrRes=mysql_query("SELECT payment_id from payment_detail where uid='".$_SESSION['CAT_UserID']."' and payment_status='completed'");
		if(mysql_affected_rows()>0)
		{
			$flag[2]=1;
		}

	//	$flag[0]=1;
		$flag[1]=1;
	//	$flag[2]=1;
		return $flag;
	}
	
	function myPaging($query,$page,$recperpg,$filename="")
	{
		$qstrArr=explode("&",$_SERVER['QUERY_STRING']);
		$qstr="";
		if(is_array($qstrArr) && count($qstrArr)>1)
		{
			foreach($qstrArr as $k=>$v)
			{
				$attArr=explode("=",$v);
				if($attArr[0]!="page" && $attArr[1]!="")
				{
					$qstr.="&".$attArr[0]."=".$attArr[1];
				}
			}
		}
		
		$totRes=mysql_query($query);
		$totRecords=mysql_affected_rows();
		$totPages=ceil($totRecords/$recperpg);
		$pgpergroup=10;
		$pgGroup=intval($page/$pgpergroup);
		
		$returnVal=array();
		
		$pgtext="1";
		
		$pgStart=$pgpergroup*$pgGroup;
		$pgEnds=($pgpergroup*($pgGroup+1));
		if($pgEnds>$totPages) { $pgEnds=$totPages; }
		if($totPages>1)
		{
			$pgtext="<table border='0' cellspacing='0' class='pagi_main' cellpadding='3'><tr>";
			if($page>0)
			{ 
				$pgtext.="<td><a href='".$filename."?page=0".$qstr."' class='pglink' style='font-family:verdana;'>&laquo;</a></td>";
				$pgtext.="<td><a href='".$filename."?page=".($page-1).$qstr."' class='pglink' style='font-family:verdana;'>&lsaquo;</a></td>";
			} 
			else
			{
				$pgtext.="<td><a href='#' class='pglink' style='font-family:verdana;' onclick='return false;'>&laquo;</a></td>";
				$pgtext.="<td><a href='#' class='pglink' style='font-family:verdana;' onclick='return false;'>&lsaquo;</a></td>";
			}
			
				for($aa=$pgStart; $aa<$pgEnds; $aa++)
				{
					if($page==$aa)
					{
						$pgtext.="<td class='pglink_act'>".($aa+1)."</td>";
					}
					else
					{
						$pglink=$filename."?page=".$aa.$qstr;
						$pgtext.="<td><a href='".$pglink."' class='pglink'>".($aa+1)."</a></td>";
					}
				}
			
			if($page<($totPages-1))
			{ 
				$pgtext.="<td><a href='".$filename."?page=".($page+1).$qstr."' class='pglink' style='font-family:verdana;'>&rsaquo;</a></td>";
				$pgtext.="<td><a href='".$filename."?page=".($totPages-1).$qstr."' class='pglink' style='font-family:verdana;'>&raquo;</a></td>";
			} 
			else
			{
				$pgtext.="<td><a href='#' class='pglink' style='font-family:verdana;' onclick='return false;'>&rsaquo;</a></td>";
				$pgtext.="<td><a href='#' class='pglink' style='font-family:verdana;' onclick='return false;'>&raquo;</a></td>";
			}
			
			$pgtext.="</tr></table>";
		}
		
		
		$start=$page*$recperpg;
		$newquery=$query." LIMIT $start, $recperpg";
		$result=mysql_query($newquery);
		
		$returnVal[0]=$result;
		$returnVal[1]=$pgtext;
		
		return $returnVal;
	}
?>