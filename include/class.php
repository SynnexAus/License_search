<?php
	class db_class	// CLASS START
	{
		var $cn,$db,$db_host,$db_user,$db_pass,$db_name;
		function set_connection($host,$user,$pass,$dbase)	// SET DATABASE VARIABLES & CREATE CONNECTION
		{
			$this->db_host=$host;
			$this->db_user=$user;
			$this->db_pass=$pass;
			$this->db_name=$dbase;
			$this->cn=mysql_connect($this->db_host,$this->db_user,$this->db_pass);
			$this->db=mysql_select_db($this->db_name);
		}
		function add_security($val)		// RETURN VALUE WITH SECURITY
		{
			return mysql_real_escape_string($val);
		}
		function mf_query($query)	// EXECUTE USER QUERY
		{
			return mysql_query($query);
		}
		function mf_affected_rows()	// RETURN TOTAL AFFECTED ROW WHILE QUERY EXECUTED
		{
			return mysql_affected_rows();
		}
		function mf_fetch_array($result)	// RETURN SINGLE ROW IN ARRAY FORM
		{
			return mysql_fetch_array($result);
		}
		function setNewLink($table,$field,$tid)
		{
			global $SITE_URL;
			$spRes=$this->mf_query("SELECT * from ".$table." where id='".$tid."'");
			if($this->mf_affected_rows()>0)
			{
				$spRow=$this->mf_fetch_array($spRes);
				return $SITE_URL."".$spRow[$field];
			}
		}
		function setStateLink($table,$field,$tid,$id)
		{
			global $SITE_URL;
			$spRes=$this->mf_query("SELECT * from ".$table." where id='".$tid."'");
			if($this->mf_affected_rows()>0)
			{
				$spRow=$this->mf_fetch_array($spRes);
				return $SITE_URL.$id.'/'.$spRow[$field];
			}
		}
		function createSlug($str)
		{
			$str=strtolower(strip_tags(stripslashes(trim($str))));
			$str=str_replace(" & "," and ",$str);
			$str = preg_replace('/[^a-zA-Z0-9]/i', '-', $str);
			$expStr=explode("--",$str);
			while(count($expStr)>1)
			{
				echo $str=implode("-",$expStr);
				$expStr=explode("--",$str);
			}
			if(substr($str,0,1)=="-") { $str=substr($str,1); }
			if(substr($str,-1)=="-") { $str=substr($str,0,-1); }
			return $str;
		}
		
		function createSlugUrlColor($table, $pid=0, $str="")
		{
			$str=$this->createSlug($str);
			$exRes=$this->mf_query("SELECT sku from ".$table." where sku='".$str."' and id!='".$pid."'");
			$cnt=1;
			if($this->mf_affected_rows()>0)
			{
				while($exRow=$this->mf_fetch_array($exRes))
				{
					$cnt++;
					$estr=$str."-".$cnt;
					$exRes=$this->mf_query("SELECT sku from ".$table." where sku='".$estr."' and id!='".$pid."'");
				}
				$str=$estr;
			}
			return $str;
		}
		
		function createSlugUrl($table, $pid=0, $str="")
		{
			$str=$this->createSlug($str);
			$exRes=$this->mf_query("SELECT slug from ".$table." where slug='".$str."' and id!='".$pid."'");
			$cnt=1;
			if($this->mf_affected_rows()>0)
			{
				while($exRow=$this->mf_fetch_array($exRes))
				{
					$cnt++;
					$estr=$str."-".$cnt;
					$exRes=$this->mf_query("SELECT slug from ".$table." where slug='".$estr."' and id!='".$pid."'");
				}
				$str=$estr;
			} else{
				$exRes=$this->mf_query("SELECT page_name from `page` where page_name='".$str."'");
				$c=1;
				if($this->mf_affected_rows()>0)
				{
					while($exRow=$this->mf_fetch_array($exRes))
					{
						$c++;
						$estr=$str."-".$c;
					}$str=$estr;
				}
			}
			return $str;
		}
		/*
		function createSlugUrl($table, $pid=0, $str="")
		{
			$str=$this->createSlug($str);
			$exRes=$this->mf_query("SELECT slug from ".$table." where slug='".$str."' and id!='".$pid."'");
			$cnt=1;
			if($this->mf_affected_rows()>0)
			{
				while($exRow=$this->mf_fetch_array($exRes))
				{
					$cnt++;
					$estr=$str."-".$cnt;
					$exRes=$this->mf_query("SELECT slug from ".$table." where slug='".$estr."' and id!='".$pid."'");
					$exnew=$this->mf_query("SELECT page_name from `page` where page_name='".$estr."'");
					$c=1;
					if($this->mf_affected_rows()>0)
					{
						while($exRow=$this->mf_fetch_array($exnew))
						{
							$c++;
							$newestr=$estr."-".$c;
						}
						
					}
					$estr=$newestr;
				}
				$str=$estr;
			}
			return $str;
		}
		
		*/
		function mf_check_login($table,$user,$pass)	// CHECK USER AUTHENTICATION
		{
			$qry="SELECT id from ".$this->add_security($table)." where username='".$this->add_security($user)."' and password='".md5($this->add_security($pass))."'";
			$result=$this->mf_query($qry);
			if(mysql_affected_rows()>0)
			{
				$row=mysql_fetch_array($result);
				return $row['id'];
			}
			else
			{
				return 0;
			}
		}
		function mf_check_user_login($table,$user,$pass)	// CHECK USER AUTHENTICATION
		{
			$qry="SELECT id from ".$this->add_security($table)." where email='".$this->add_security($user)."' and password='".md5($this->add_security($pass))."'";
			$result=$this->mf_query($qry);
			if(mysql_affected_rows()>0)
			{
				$row=mysql_fetch_array($result);
				return $row['id'];
			}
			else
			{
				return 0;
			}
		}	
		function mf_check_duplicate($table,$field,$value,$conditions="")	// CHECK DUPLAICATE RECORD AT NEW ENTRY	// USE : MF_CHECK_DUPLICATE("USER","EMAIL",$EMAIL,ARRAY("FIELD"=>$VALUE) );
		{
			$extQry="";
			if(is_array($conditions))
			{
				foreach($conditions as $id_field=>$id_value)
				{
					$extQry.= " and `".$id_field."`='".$this->add_security($id_value)."'";
				}
			}
			$query = "select `".$field."` from `".$table."` where `".$field."` <> '".$this->add_security($value)."' $extQry "; 
			$r = mysql_query($query);
			if(mysql_affected_rows()>0)
				return true;
			else
				return false;
		}
		function mf_check_duplicate_pro_cat($table,$field,$value,$conditions="")	
		{
			$extQry="";
			if(is_array($conditions))
			{
				foreach($conditions as $id_field=>$id_value)
				{
					$extQry.= " and `".$id_field."`!='".$this->add_security($id_value)."'";
				}
			}
			$query = "select `".$field."` from `".$table."` where `".$field."` = '".$this->add_security($value)."' $extQry ";
			$r = mysql_query($query);
			if(mysql_affected_rows()>0)
				return true;
			else
				return false;
		}
		function mf_dbinsert($table,$data)	// FUNCTION TO INSERT NEW RECORD IN SPECIFIED TABLE
		{
			$qry="INSERT INTO ".$table." set ";
			foreach($data as $fld=>$val)
			{
				$qry.= $fld."='".$this->add_security($val)."',";
			}
			$qry=substr($qry,0,-1);			
			return $this->mf_query($qry);
		}
		
		function mf_dbinsert_id()
		{
			return mysql_insert_id();
		}
		
		function mf_dbselect($table,$fields,$conditions,$orderby="")	// FUNCTION TO SELECT RECORD IN SPECIFIED TABLE
		{
			$qry="SELECT ";
			foreach($fields as $fld)
			{
				$qry.= $fld.",";
			}
			$qry=substr($qry,0,-1);
			$qry .= " where 1=1 ";
			if(is_array($conditions))
			{
				foreach($conditions as $fld=>$val)
				{
					$qry .= " and $fld='$val' ";
				}
			}
			if($orderby != "")
			{
				$qry .= " order by $orderby ";
			}
			$result=mysql_query($qry);
			return $result;
		}
		
		function mf_dbupdate($table,$data, $whare)	// FUNCTION TO UPDATE TABLE DATA
		{
			$qry="UPDATE ".$table." set ";
			foreach($data as $fld=>$val)
			{
				$qry.= $fld."='".$this->add_security($val)."',";
			}
			$qry=substr($qry,0,-1);
			$qry.=" ".$whare;
			return $this->mf_query($qry);
		}
		
		function mf_dbdelete($table,$fld, $val)	// FUNCTION TO DELETE TABLE ROW
		{
			$qry="DELETE FROM ".$table." where ".$fld."='".$val."'";
			return $this->mf_query($qry);
		}
		function mf_paging($query,$recperpg=20)	// RETURN RESULTSET AND PAGINATION	// USER   LIST($RESULT,$PAGING)=MF_PAGING("SELECT * FROM USER",25);
		{
			$page=intval($_REQUEST['page']);
			$filename=$this->mf_getfilenames();
			$qstrArr=explode("&",$_SERVER['QUERY_STRING']);
			$qstr="";
			if(is_array($qstrArr) && count($qstrArr)>1){
				foreach($qstrArr as $k=>$v){
					$attArr=explode("=",$v);
					if($attArr[0]!="page" && $attArr[1]!=""){
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
			$pgtext="";
			$pgStart=$pgpergroup*$pgGroup;
			$pgEnds=($pgpergroup*($pgGroup+1));
			if($pgEnds>$totPages) { $pgEnds=$totPages; }
			if($totPages>1){
				$pgtext="<table border='0' cellspacing='0' cellpadding='3'><tr>";
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
		
		function mf_category_paging($query,$recperpg=20)	
		{
			$page=intval($_REQUEST['page']);

			$qstrArr=explode("&",$_SERVER['QUERY_STRING']);
			//print_r($qstrArr);
			$qstr="product-category";
			if($_REQUEST['slug']!="") {  $qstr .= "/".$_REQUEST['slug'].""; }
			//if($_REQUEST['cat']!="") { $qstr .= $_REQUEST['cat'].""; }
			//if($_REQUEST['sort']!="") { $qstr.="/sort/"; $qstr.=$_REQUEST['sort'].""; }
	
			$totRes=mysql_query($query);
			$totRecords=mysql_affected_rows();
			$totPages=ceil($totRecords/$recperpg);
			$pgpergroup=10;
			$pgGroup=intval($page/$pgpergroup); 
			
			$returnVal=array();
			$pgtext="";
			
			$pgStart=$pgpergroup*$pgGroup;
			$pgEnds=($pgpergroup*($pgGroup+1));
			if($pgEnds>$totPages) { $pgEnds=$totPages; }
			if($totPages>1)
			{
				$pgtext="<ul>";
				if($page>0)
				{ 
					//$pgtext.="<td><a href='".$qstr."' class='pglink' style='font-family:verdana;'>&laquo;</a></td>";
					$pgtext.="<li class='prev'><a href='".$qstr."/page/".($page-1)."'>&laquo;</a></li>";
				} 
				else
				{
					//$pgtext.="<td><a href='javascript:;' class='pglink' style='font-family:verdana;' onclick='return false;'>&laquo;</a></td>";
					$pgtext.="<li class='prev'><a href='javascript:;'>&laquo;</a></li>";
				}
				
				for($aa=$pgStart; $aa<$pgEnds; $aa++)
				{
					if($page==$aa)
					{
						$pgtext.="<li class='current'><a href='#'>".($aa+1)."</a></li>";
					}
					else
					{
						$pglink=$qstr."/page/".$aa."";
						$pgtext.="<li><a href='".$pglink."'>".($aa+1)."</a></li>";
					}
				}
				
				if($page<($totPages-1))
				{ 
					$pgtext.="<li class='next'><a href='".$qstr."/page/".($page+1)."'>&raquo;</a></li>";
					//$pgtext.="<td><a href='".$qstr."/page/".($totPages-1)."' class='pglink' style='font-family:verdana;'>&raquo;</a></td>";
				} 
				else
				{
					$pgtext.="<li class='next'><a href='javascript:;'>&raquo;</a></li>";
					//$pgtext.="<td><a href='javascript:;' class='pglink' style='font-family:verdana;' onclick='return false;'>&raquo;</a></td>";
				}
				
				$pgtext.="</ul>";
			}
			
			
			$start=$page*$recperpg;
			$newquery=$query." LIMIT $start, $recperpg";
			$result=mysql_query($newquery);
			
			$returnVal[0]=$result;
			$returnVal[1]=$pgtext;
			$returnVal[2]='Found '.$totRecords.' Results';
			return $returnVal;
		}
		
		function mf_search_paging($query,$recperpg=20)	// RETURN RESULTSET AND PAGINATION	// USER   LIST($RESULT,$PAGING)=MF_PAGING("SELECT * FROM USER",25);
		{
			$page=intval($_REQUEST['page']);
			$filename=$this->mf_getfilenames();
			$qstrArr=explode("&",$_SERVER['QUERY_STRING']);
			$qstr="";
			if(is_array($qstrArr) && count($qstrArr)>=1){
				foreach($qstrArr as $k=>$v){
					$attArr=explode("=",$v);
					if($attArr[0]!="page" && $attArr[1]!=""){
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
			$pgtext="";
			$pgStart=$pgpergroup*$pgGroup;
			$pgEnds=($pgpergroup*($pgGroup+1));
			if($pgEnds>$totPages) { $pgEnds=$totPages; }
			if($totPages>1){
				$pgtext="<ul>";
				if($page>0)
				{ 
					$pgtext.="<li class='prev'><a href='".$filename."?page=0".$qstr."'>&laquo;</a></li>";
					//$pgtext.="<li><a href='".$filename."?page=".($page-1).$qstr."'>&lsaquo;</a></li>";
				} 
				else
				{
					$pgtext.="<li><a href='#' onclick='return false;'>&laquo;</a></li>";
					//$pgtext.="<li><a href='#' onclick='return false;'>&lsaquo;</a></li>";
				}
				
				for($aa=$pgStart; $aa<$pgEnds; $aa++)
				{
					if($page==$aa)
					{
						$pgtext.="<li class='current'><a href='#'>".($aa+1)."</a></li>";
					}
					else
					{
						$pglink=$filename."?page=".$aa.$qstr;
						$pgtext.="<li><a href='".$pglink."'>".($aa+1)."</a></li>";
					}
				}
				
				if($page<($totPages-1))
				{ 
					//$pgtext.="<li><a href='".$filename."?page=".($page+1).$qstr."'>&rsaquo;</a></li>";
					$pgtext.="<li class='next'><a href='".$filename."?page=".($totPages-1).$qstr."'>&raquo;</a></li>";
				} 
				else
				{
					//$pgtext.="<li><a href='#' onclick='return false;'>&rsaquo;</a></li>";
					$pgtext.="<li class='next'><a href='#' onclick='return false;'>&raquo;</a></li>";
				}
				
				$pgtext.="</tr></table>";
			}
			
			
			$start=$page*$recperpg;
			$newquery=$query." LIMIT $start, $recperpg";
			$result=mysql_query($newquery);
			
			$returnVal[0]=$result;
			$returnVal[1]=$pgtext;
			$returnVal[2]='Found '.$totRecords.' Results';
			return $returnVal;
		}
		
		function mf_search_paging_sidebar($query,$recperpg=20)	// RETURN RESULTSET AND PAGINATION	// USER   LIST($RESULT,$PAGING)=MF_PAGING("SELECT * FROM USER",25);
		{
			$page=intval($_REQUEST['page']);
			$filename=$this->mf_getfilenames();
			$qstrArr=explode("&",$_SERVER['QUERY_STRING']);
			$qstr="";
			if(is_array($qstrArr) && count($qstrArr)>=1){
				foreach($qstrArr as $k=>$v){
					$attArr=explode("=",$v);
					if($attArr[0]!="page" && $attArr[1]!=""){
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
			$pgtext="";
			$pgStart=$pgpergroup*$pgGroup;
			$pgEnds=($pgpergroup*($pgGroup+1));
			if($pgEnds>$totPages) { $pgEnds=$totPages; }
			if($totPages>1){
				$pgtext="<ul>";
				if($page>0)
				{ 
					$pgtext.="<li class='prev'><a href='".$filename."?page=0".$qstr."'>&laquo;</a></li>";
					//$pgtext.="<li><a href='".$filename."?page=".($page-1).$qstr."'>&lsaquo;</a></li>";
				} 
				else
				{
					$pgtext.="<li><a href='#' onclick='return false;'>&laquo;</a></li>";
					//$pgtext.="<li><a href='#' onclick='return false;'>&lsaquo;</a></li>";
				}
				
				for($aa=$pgStart; $aa<$pgEnds; $aa++)
				{
					if($page==$aa)
					{
						$pgtext.="<li class='current'><a href='#'>".($aa+1)."</a></li>";
					}
					else
					{
						$pglink=$filename."?page=".$aa.$qstr;
						$pgtext.="<li><a href='".$pglink."'>".($aa+1)."</a></li>";
					}
				}
				
				if($page<($totPages-1))
				{ 
					//$pgtext.="<li><a href='".$filename."?page=".($page+1).$qstr."'>&rsaquo;</a></li>";
					$pgtext.="<li class='next'><a href='".$filename."?page=".($totPages-1).$qstr."'>&raquo;</a></li>";
				} 
				else
				{
					//$pgtext.="<li><a href='#' onclick='return false;'>&rsaquo;</a></li>";
					$pgtext.="<li class='next'><a href='#' onclick='return false;'>&raquo;</a></li>";
				}
				
				$pgtext.="</tr></table>";
			}
			
			
			$start=$page*$recperpg;
			$newquery=$query." LIMIT $start, $recperpg";
			$result=mysql_query($newquery);
			
			$returnVal[0]=$result;
			$returnVal[1]=$pgtext;
			$returnVal[2]='Found '.$totRecords.' Results';
			return $returnVal;
		}
		
		
		function mf_paging_gallery($query,$recperpg=12)	// RETURN RESULTSET AND PAGINATION	// USER   LIST($RESULT,$PAGING)=MF_PAGING("SELECT * FROM USER",25);
		{
			$page=intval($_REQUEST['page']);
			$filename=$this->mf_getfilenames();
			$qstrArr=explode("&",$_SERVER['QUERY_STRING']);
			$qstr="";
			if(is_array($qstrArr) && count($qstrArr)>=1)
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
			
			$returnVal=array();
			$pgtext="";
			
			if($totPages>1)
			{
				$pgtext="<div class='listing'>";
				if($page>0)
				{
					$pgtext.="<a href='".$filename."?page=".($page-1).$qstr."'><img src='images/prev.png' alt='' />Previous</a>";
				}
				else
				{
					$pgtext.="<a href='#' onclick='return false;'><img src='images/prev.png' alt='' />Previous</a>";
				}
				
				
				$pgtext.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				if($page<($totPages-1))
				{ 
					$pgtext.="<a href='".$filename."?page=".($page+1).$qstr."'>Next<img src='images/next.png' alt='' /></a>";
				} 
				else
				{
					$pgtext.="<a href='#' onclick='return false;'>Next<img src='images/next.png' alt='' /></a>";
				}
				
				$pgtext.="</div>";
			}
			
			$start=$page*$recperpg;
			$newquery=$query." LIMIT $start, $recperpg";
			$result=mysql_query($newquery);
			
			$returnVal[0]=$result;
			$returnVal[1]=$pgtext;
			
			return $returnVal;
		}
		function mf_group_paging($query,$recperpg=20)	// RETURN RESULTSET AND PAGINATION	// USER   LIST($RESULT,$PAGING)=MF_PAGING("SELECT * FROM USER",25);
		{
			$page=intval($_REQUEST['page']);
			$filename=$this->mf_getfilenames();
			$qstrArr=explode("&",$_SERVER['QUERY_STRING']);
			$qstr="";
			if(is_array($qstrArr) && count($qstrArr)>=1)
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
			
			$pgStart=$pgpergroup*$pgGroup;
			$pgEnds=($pgpergroup*($pgGroup+1));
			if($pgEnds>$totPages) { $pgEnds=$totPages; }
			$dispstart=($page*$recperpg)+1;
			$dispend=$dispstart+$recperpg-1;
			if($dispend>$totRecords) { $dispend=$totRecords; }
			$returnVal=array();
			$pgtext="";
			
			if($totRecords>0)
			{
				$pgtext="<div class='couponpaging'>";
				$pgtext.="<p class='left'>Displaying ".$dispstart."-".$dispend." of ".$totRecords."</p>";
				$pgtext.="<div class='right'>";
	
				if($totPages>1)
				{
	
					if($page>0)
					{ 	
						$pgtext.="<a href='".$filename."?page=".($page-1).$qstr."' class='prev'>PREV</a>";
					} 
					else
					{
						$pgtext.="<a href='javascript:;' class='prev'>PREV</a>";
					}
					
					if($pgStart>0) { $pgtext.="... "; }
					for($aa=$pgStart; $aa<$pgEnds; $aa++)
					{
						if($page==$aa)
						{
							$pgtext.="<a href='javascript:;' class='listing_act'>".($aa+1)."</a>";
						}
						else
						{
							$pglink=$filename."?page=".$aa.$qstr;
							$pgtext.="<a href='".$pglink."' class='listing'>".($aa+1)."</a>";
						}
						if($aa<($pgEnds-1)) $pgtext.="&nbsp;&nbsp;|&nbsp;";
					}
					if($pgEnds<$totPages) { $pgtext.=" ..."; }
					
					if($page<($totPages-1))
					{ 
						$pgtext.="<a href='".$filename."?page=".($page+1).$qstr."' class='next'>NEXT</a>";
					} 
					else
					{
						$pgtext.="<a href='javascript:;' class='next'>NEXT</a>";
					}
					
				}
				$pgtext.="</div></div>";
			}
			
			
			$start=$page*$recperpg;
			$newquery=$query." LIMIT $start, $recperpg";
			$result=mysql_query($newquery);
			
			$returnVal[0]=$result;
			$returnVal[1]=$pgtext;
			
			return $returnVal;
		}
		function mf_paging_form($query,$recperpg=1)	// RETURN RESULTSET AND PAGINATION	// USER   LIST($RESULT,$PAGING)=MF_PAGING("SELECT * FROM USER",25);
		{
			$page=intval($_REQUEST['page']);
			$filename=$this->mf_getfilenames();
			$_SERVER['QUERY_STRING'];
			$qstrArr=explode("&",$_SERVER['QUERY_STRING']);
			$qstr="";
			if(is_array($qstrArr) && count($qstrArr)>=1)
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
			$pgtext="";
			
			$pgStart=$pgpergroup*$pgGroup;
			$pgEnds=($pgpergroup*($pgGroup+1));
			if($pgEnds>$totPages) { $pgEnds=$totPages; }
			//if($totPages>1)
			{
				$pgtext="<table border='0' cellspacing='0' cellpadding='3' align='right'><tr>";
				if($page>0)
				{
					$pgtext.="<td><p class='previous'><a href='".$filename."?page=".($page-1).$qstr."'></a></p></td>";
				} 
				else
				{
					$pgtext.="<td><p class='previous'><a href='javascript:;'></a></p></td>";
				}
				
				if($page<($totPages-1))
				{ 
					$pgtext.="<td><p class='next'><a href='".$filename."?page=".($page+1).$qstr."'></a></p></td>";
				} 
				else
				{
					$pgtext.="<td><p class='next'><a href='javascript:;'></a></p></td>";
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
		function mf_admin_paging($query,$recperpg=20)	// RETURN RESULTSET AND PAGINATION AND COMBO	// USER   LIST($RESULT,$PAGING,$PAGECOMBO)=MF_PAGING("SELECT * FROM USER",25);
		{
			$page=intval($_REQUEST['page']);
			$filename=$this->mf_getfilenames();
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
			$pgtext="";
			$pglist="";
			$pgStart=$pgpergroup*$pgGroup;
			$pgEnds=($pgpergroup*($pgGroup+1));
			if($pgEnds>$totPages) { $pgEnds=$totPages; }
			if($totPages>1)
			{
				$pgtext="";
				if($page>0)
				{ 
					$pgtext.="<a href='".$filename."?page=0".$qstr."' class='page-far-left'></a>";
					$pgtext.="<a href='".$filename."?page=".($page-1).$qstr."' class='page-left'></a>";
				}else{
					$pgtext.="<a href='#' class='page-far-left' onclick='return false;'></a>";
					$pgtext.="<a href='#' class='page-left' onclick='return false;'></a>";
				}
				$pgtext.="<div id='page-info'>Page <strong>".($page+1)."</strong> / ".$pgEnds."</div>";
				if($page<($totPages-1))
				{ 
					$pgtext.="<a href='".$filename."?page=".($page+1).$qstr."' class='page-right'></a>";
					$pgtext.="<a href='".$filename."?page=".($totPages-1).$qstr."' class='page-far-right'></a>";
				}else{
					$pgtext.="<a href='#' class='page-right' onclick='return false;'></a>";
					$pgtext.="<a href='#' class='page-far-right' onclick='return false;'></a>";
				}
				$pglist="<select  class='styledselect_pages' onchange='window.location=\"".$filename."?page=\"+this.value+\"".$qstr."\"'>";
				for($aa=0; $aa<$totPages; $aa++)
				{
				$pglist.="<option value='".($aa)."' ".(($aa==$page)?"selected":"").">".($aa+1)."</option>";
				}
				$pglist.="</select>";
			}
			$start=$page*$recperpg;
			$newquery=$query." LIMIT $start, $recperpg";
			$result=mysql_query($newquery);
			$returnVal[0]=$result;
			$returnVal[1]=$pgtext;
			$returnVal[2]=$pglist;
			return $returnVal;
	}
		function rand_string( $length )
		{
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";			
			$size = strlen( $chars );
			for( $i = 0; $i < $length; $i++ ) {
				$str .= $chars[ rand( 0, $size - 1 ) ];
			}		
			return $str;
		}
		
		function mf_createcombo($query,$opt_value,$disp_value,$selected="",$firstval="-Select-")		// RETURN COMBOBOX OPTIONS LIST
		{
		
			$cmbtext="<option value=''>$firstval</option>";
			$result=mysql_query($query);
			if(mysql_affected_rows()>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$sel="";
					if(stripslashes($row[$opt_value])==stripslashes($selected)) { $sel="selected='selected'"; }
					$cmbtext.="<option value='".$row[$opt_value]."' $sel>".stripslashes($row[$disp_value])."</option>";
				}
			}
			return $cmbtext;
		}
		
		function mf_createcombofields($query,$opt_value,$disp_value,$disp_value2,$selected="",$firstval="-Select-")
		{
			$cmbtext="<option value=''>$firstval</option>";
			$result=mysql_query($query);
			if(mysql_affected_rows()>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$sel="";
					if(stripslashes($row[$opt_value])==stripslashes($selected)) { $sel="selected='selected'"; }
					$cmbtext.="<option value='".$row[$opt_value]."' $sel>".stripslashes(ucfirst($row[$disp_value]))."&nbsp;-&nbsp;".stripslashes(ucfirst($row[$disp_value2]))."</option>";
				}
			}
			return $cmbtext;
		}
		
		function mf_createcomboproff($query,$opt_value,$disp_value,$selected="",$firstval="-Select-")		// RETURN COMBOBOX OPTIONS LIST
		{
			//$cmbtext="<option value=''>$firstval</option>";
			$result=mysql_query($query);
			if(mysql_affected_rows()>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$sel="";
					if(stripslashes($row[$opt_value])==stripslashes($selected)) { $sel="selected='selected'"; }
					$cmbtext.="<option value='".$row[$opt_value]."' $sel>".stripslashes($row[$disp_value])."</option>";
				}
			}
			return $cmbtext;
		}
		
		
		function mf_createcomboprofessional($query,$opt_value,$disp_value,$disp_value2,$selected="",$firstval="-Select-")		// RETURN COMBOBOX OPTIONS LIST
		{
			$cmbtext="<option value=''>$firstval</option>";
			$result=mysql_query($query);
			if(mysql_affected_rows()>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$sel="";
					if(stripslashes($row[$opt_value])==stripslashes($selected)) { $sel="selected='selected'"; }
					$cmbtext.="<option value='".$row[$opt_value]."' $sel>".stripslashes(ucfirst($row[$disp_value]))." ".stripslashes(ucfirst($row[$disp_value2]))."</option>";
				}
			}
			return $cmbtext;
		}
		
		
		function mf_createcombocustomer($query,$opt_value,$disp_value,$disp_value2,$selected="",$firstval="-Select-")		// RETURN COMBOBOX OPTIONS LIST
		{
			$cmbtext="<option value=''>$firstval</option>";
			$result=mysql_query($query);
			if(mysql_affected_rows()>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$sel="";
					if(stripslashes($row[$opt_value])==stripslashes($selected)) { $sel="selected='selected'"; }
					$cmbtext.="<option value='".$row[$opt_value]."' $sel>".stripslashes(ucfirst($row[$disp_value]))." ".stripslashes(ucfirst($row[$disp_value2]))."</option>";
				}
			}
			return $cmbtext;
		}
		
		
		function mf_createcomboprofessionalcom($query,$opt_value,$disp_value,$disp_value2,$disp_value3,$selected="",$firstval="-Select-")		// RETURN COMBOBOX OPTIONS LIST
		{
			$cmbtext="<option value=''>$firstval</option>";
			$result=mysql_query($query);
			if(mysql_affected_rows()>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$sel="";
					if(stripslashes($row[$opt_value])==stripslashes($selected)) { $sel="selected='selected'"; }
					$cmbtext.="<option value='".$row[$opt_value]."' $sel>".stripslashes(ucfirst($row[$disp_value]))." ".stripslashes(ucfirst($row[$disp_value2]))."  "."[".stripslashes(ucfirst($row[$disp_value3]))."]"."</option>";
				}
			}
			return $cmbtext;
		}
		
		
		function mf_createcomboprice($query,$opt_value,$disp_value,$selected="",$firstval="-Select-")		// RETURN COMBOBOX OPTIONS LIST
		{
			$cmbtext="<option value=''>$firstval</option>";
			$result=mysql_query($query);
			if(mysql_affected_rows()>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$sel="";
					if(stripslashes($row[$opt_value])==stripslashes($selected)) { $sel="selected='selected'"; }
					$cmbtext.="<option value='".$row[$opt_value]."' $sel>"."$".stripslashes($row[$disp_value])."</option>";
				}
			}
			return $cmbtext;
		}
		
		function mf_createcombo_array($array,$selected="")		// RETURN COMBOBOX OPTIONS LIST USING ARRAY
		{
			$cmbtext="<option value=''>-Select-</option>";
			foreach($array as $key=>$value)
			{
				$sel="";
				if(stripslashes($key)==stripslashes($selected)) { $sel="selected='selected'"; }
				$cmbtext.="<option value='".$key."' $sel>".stripslashes($value)."</option>";
			}
			return $cmbtext;
		}
		
		function mf_createcombo_multi($query1,$opt_value1,$disp_value1,$query2,$opt_value2,$disp_value2,$selected="")		// RETURN COMBOBOX OPTIONS LIST  : $mfp->mf_createcombo_multi("mf_board","board_id","board_name","mf_standard","standard","standard","board_id","");
		{
			$selected = explode(",",$selected);
			$cmbtext="";
			$result=mysql_query($query1);
			if(mysql_affected_rows()>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$sel="";
					$cmbtext.="<optgroup label='".stripslashes($row[$disp_value1])."'>";
					$new_query=str_replace("[COMMON]",$row[$opt_value1],$query2);
					$result2=mysql_query($new_query);
					if(mysql_affected_rows()>0)
					{
						while($row2=mysql_fetch_array($result2))
						{
							$sel="";
							if(in_array(stripslashes($row2[$opt_value2]),$selected)) { $sel="selected='selected'"; }
							$cmbtext.="<option value='".$row2[$opt_value2]."' $sel>".stripslashes($row2[$disp_value2])."</option>";
						}
					}
					$cmbtext.="</optgroup>";
				}
			}
			return $cmbtext;
		}
		
		function mf_createradio($radioname,$opt_list,$selected="")		// RETURN RADIO BUTTONS LIST
		{
			$radtext="";
			foreach($opt_list as $rmsg=>$rval)
			{
				$sel="";
				if(stripslashes($rval)==stripslashes($selected)) { $sel="checked"; }
				$radtext.="<input type='radio' name='$radioname' id='$radioname' value='".$rval."' $sel> ".stripslashes($rmsg);
			}
			return $radtext;
		}
		
		function mf_checkpagepermission()
		{
			
		}
		
		function mf_checkuserrole()
		{
			
		}
		
		// INSERT SUB TABLE RECORDS
		// mf_insert_sub_records("table1","prod_id",$pid,array("prod_name"=>"prod_name_","prod_image"=>"prod_img_"),"sub_prod_count",array("prod_image"=>"images/"));
		function mf_sub_records($table_name,$fk_field,$fk_value,$dbfield_array,$count_box,$img_array)
		{
			if(intval($_REQUEST[$count_box])>0)
			{
				for($aa=1;$aa<=intval($_REQUEST[$count_box]);$aa++)
				{
					$ins_flat=0;
					$qry_array=array();
					$qry_array[$fk_field]=$fk_value;
					//$query="INSERT INTO ".$table." SET ".$fk_field."='".$fk_value."'";
					$fldArr=$dbfield_array;
					foreach($fldArr as $txtname=>$fldname)
					{
						$txtfieldname=$fldname.$aa;
						
						if($img_array[$txtname]!="")
						{
							if( ! ($_FILES[$txtfieldname]["error"] > 0 || trim($_FILES[$txtfieldname]["name"])==""))
							{
								$image_path = rand(111,999)."_".$this->mf_puretext(trim($_FILES[$txtfieldname]["name"])); 
								while(is_file($img_array[$txtname].$image_path))
								{
									$image_path = rand(111,999)."_".$this->mf_puretext(trim($_FILES[$img_name]["name"])); 
								}
								if(copy($_FILES[$txtfieldname]["tmp_name"],$img_array[$txtname].$image_path))
								{
									//$query.=",".$txtname."='".$image_path."'";
									$qry_array[$txtname]=$image_path;
									$ins_flat=1;
								}
							}
						}
						else
						{
							//$query.=",".$txtname."='".$_REQUEST[$txtfieldname]."'";
							$qry_array[$txtname]=$_REQUEST[$txtfieldname];
							if(trim($_REQUEST[$txtfieldname])!="") { $ins_flat=1; }
						}
	
					}
					if($ins_flat==1) { $this->mf_dbinsert($table_name,$qry_array); }
				}
			}
		}
		
		
		/*************************** GENERAL FUNCTIONS ******************************/
		function mf_redirect($pgname)	// REDIRECT TO SPECIFIED PAGE
		{
			echo "<script> window.location='".$pgname."'; </script>";
			exit;
		}
		
		function mf_setmessage($str,$pgname="")	// FUNCTION TO SET SPECIFIED MESSAGE IN SESSION
		{
			$_SESSION['custmsg']=$str;
			if($pgname!="") { $this->mf_redirect($pgname); }
		}
		
		function mf_viewmessage()	// FUNCTION TO DISPLAY USER MESSAGE FROM SESSION AND THEN CLEAR MESSAGE SESSION
		{
			echo ($_SESSION['custmsg']!="")?$_SESSION['custmsg']:"";
			$_SESSION['custmsg']="";
		}
		
		function mf_isadmin()	// CHECK USER IS LOGGED IN OR NOT
		{
			if(intval($_SESSION['Admin_UserID'])==0)
			{
				$this->mf_redirect("index.php");
			}
		}
		function mf_isuser()	// CHECK USER IS LOGGED IN OR NOT
		{
			if(intval($_SESSION['HV_UserID'])==0)
			{
				$this->mf_setmessage("<p class='msgred'>Sorry, please login to access your account.</p>","login.php");
			}
		}
		function mf_iscontrator()	// CHECK USER IS LOGGED IN OR NOT
		{
			if(intval($_SESSION['HV_ContractorID'])==0)
			{
				$this->mf_setmessage("<p class='msgred'>Sorry, please login to access your account.</p>","contractor-login.php");
			}
		}
		
		function mf_getfilenames()		// RETURN CURRENT FILENAME
		{
			$pt=substr($_SERVER['REQUEST_URI'],1);
			$pt3=explode("/",$pt);
			$totpt=count($pt3);
			$pt2=$pt3[$totpt-1];
			$ptArr=explode("?",$pt2);
			$filename=$ptArr[0];
			return $filename;
		}
		
		function mf_puretext($str)	// RETURN PURE VALUE - REMOVING ALL SPECIAL CHARACTERS/SYMBOLS ETC... 
		{
			$newstr=preg_replace("/[^A-Za-z0-9.]/","",$str);
			return $newstr;
		}
		
		function date2save($date)	// CONVERT DATE TO STORE FORMAT (MYSQL FORMAT)
		{
			if($date=="")
			{
				return "";
			}
			else
			{
				$dtArr=split("/",$date);
				$newDt=$dtArr[2]."-".$dtArr[0]."-".$dtArr[1];
				return $newDt;
			}
		}
		
		function date2disp($date)	// CONVERT DATE TO DISPLAY FORMAT (INDIAN FORMAT)
		{
			if($date=="")
			{
				return "";
			}
			else
			{
				return date("m/d/Y",strtotime($date));
			}
		}
		
		function mf_viewimage($imgpath,$width=100, $height=100)	// FUNCTION TO DISPLAY SPECIFIED IMAGE WITH SPECIFIED WIDTH X HEIGHT
		{
			if(is_file($imgpath))
			{
				echo "<img src='$imgpath' width='$width' height='$height' border='0' />";
			}
		}
		
		function mf_unlink($imgpath)	// REMOVE SPECIFIED IMAGE FROM FOLDER
		{
			if(is_file($imgpath))
			{
				unlink($imgpath);
			}
		}
		
		
		function mf_filerename($path,$oldname,$newname) // FUNCTION TO GET THE EXTENTION OF THE FILE      
		{ 
			$pathinfo = pathinfo($path.$oldname); 
			$ext =  $pathinfo['extension']; 
			rename($path.$oldname,$path.$newname.'.'.$ext);
			
			return $newname.'.'.$ext;
		} 
		
		function mf_getcommavalues($fieldname)  // FUNCTION FOR FETCH COMMA SEPRATED VALUES FROM FIELD..
		{
			$returnval="";
			if(is_array($fieldname))
			{
				foreach($fieldname as $k=>$v)
				{
					if($returnval=="") { $returnval.=$v; }
					else { $returnval.=",".$v; }
				}
			}
			return $returnval;
		}
		
		function mf_createfck($fck_name, $fck_value, $width=300, $height=600)  // FUNCTION FOR FETCH COMMA SEPRATED VALUES FROM FIELD..
		{
			/*include_once("fckeditor/fckeditor.php") ;
			$oFCKeditor = new FCKeditor($fck_name) ;
						$oFCKeditor->BasePath = 'fckeditor/' ;
						$oFCKeditor->Height = $width ;
						$oFCKeditor->Width = $height ;
						$oFCKeditor->Value = stripslashes($fck_value) ;
						$oFCKeditor->Create() ;*/
			global $ADMIN_URL;
			echo '<textarea id="'.$fck_name.'" name="'.$fck_name.'" style="width:'.$width.'px; height:'.$height.'px;">'.$fck_value.'</textarea>
				<script type="text/javascript">
						CKEDITOR.replace( "'.$fck_name.'",
						{
							filebrowserBrowseUrl :"'.$ADMIN_URL.'ckeditor/filemanager/browser/default/browser.html?Connector='.$ADMIN_URL.'ckeditor/filemanager/connectors/php/connector.php",
							filebrowserImageBrowseUrl : "'.$ADMIN_URL.'ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector='.$ADMIN_URL.'ckeditor/filemanager/connectors/php/connector.php",
							filebrowserFlashBrowseUrl :"'.$ADMIN_URL.'ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector='.$ADMIN_URL.'ckeditor/filemanager/connectors/php/connector.php",
							filebrowserUploadUrl  :"'.$ADMIN_URL.'ckeditor/filemanager/connectors/php/upload.php?Type=File",
							filebrowserImageUploadUrl : "'.$ADMIN_URL.'ckeditor/filemanager/connectors/php/upload.php?Type=Image",
							filebrowserFlashUploadUrl : "'.$ADMIN_URL.'ckeditor/filemanager/connectors/php/upload.php?Type=Flash"
						});
				</script>';
		}
		// class for review rating * 
		function disp5star($sp)
		{
			$star_result="<div id='rateMe'>";
			for($aa=1; $aa<=5; $aa++)
			{
				$star_result.="<a onClick='rateIt(\"".$sp."\",".$aa.")' id='".$sp."_".$aa."' onMouseOver='rating(\"".$sp."\",".$aa.")' onMouseOut='off(\"".$sp."\",this)'></a>";
			}
			$star_result.="</div><input type='hidden' name='txtrating_".$sp."' id='txtrating_".$sp."' readonly='readonly' />";
			echo $star_result;
		}
		
		function mf_get_max($table)	// RETURN MAXIMUM DISPLAY ORDER VALUE	// USE   $VAL=mf_get_max("TABLENAME");
		{
			$rval=0;
			$query="SELECT MAX(`disp_order`) as mx_num from `".$table."`";
			$res=mysql_query($query);
			if(mysql_affected_rows()>0)
			{
				$row=mysql_fetch_array($res);
				$rval=stripslashes($row['mx_num']);
			}
			return $rval;
		}
		
		function mf_get_nextorder($table)	// RETURN MAXIMUM DISPLAY ORDER VALUE	// USE   $VAL=mf_get_max("TABLENAME");
		{
			$rval=0;
			$query="SELECT MAX(`disp_order`) as mx_num from `".$table."`";
			$res=mysql_query($query);
			if(mysql_affected_rows()>0)
			{
				$row=mysql_fetch_array($res);
				$rval=intval($row['mx_num']);
			}
			return $rval+1;
		}
		
		function mf_getValue($table,$field,$where,$condition)	// FUNCTION TO SELECT RECORD IN SPECIFIED TABLE
		{
			$qry="SELECT $field from $table where $where='$condition' LIMIT 1";
			$result=$this->mf_query($qry);
			if($this->mf_affected_rows()>0)
			{
				$row=$this->mf_fetch_array($result);
				return stripslashes($row[$field]);
			}
			else
			{
				return "";
			}
		}
		function getValueMC($table,$field,$conditions=array())
		{
			$unm="";
			$extC="1";
			foreach($conditions as $fld=>$val)
			{
				$extC .= " and $fld='".$val."'";
			}
			$usrRes=$this->mf_query("SELECT $field from $table where $extC LIMIT 1");
			if($this->mf_affected_rows()>0)
			{
				$usrRow=$this->mf_fetch_array($usrRes);
				$unm=$usrRow[$field];
			}
			return $unm;
		}
		
		function mf_getMultiValue($table,$field,$where,$condition)	// FUNCTION TO SELECT RECORD IN SPECIFIED TABLE
		{
			$fldlist="";
			if(is_array($field))
			{
				foreach($field as $k=>$v)
				{
					if($fldlist=="") { $fldlist.=$v; }
					else { $fldlist.=",".$v; }
				}
			}
			$rval=array();
			$qry="SELECT $fldlist from $table where $where='$condition'";
			$result=mysql_query($qry);
			if(mysql_affected_rows()>0)
			{
				$row=mysql_fetch_array($result);
				foreach($field as $k=>$v)
				{
					$rval[]=stripslashes($row[$v]);
				}
			}
			return $rval;
		}
		function delUploadFile($table, $field, $where, $condition, $path="")
		{
			$qry="SELECT $field from $table where $where='$condition'";
			$result=mysql_query($qry);
			if(mysql_affected_rows()>0)
			{
				$row=mysql_fetch_array($result);
				$vid=stripslashes($row[$field]);
				if(is_file($path.$vid)) { unlink($path.$vid); }
			}
		}
		
		function checkPageAccess($isAccess,$pgMsg)
		{
			if($isAccess==0)
				$this->mf_setmessage("<p class='msgred'>Sorry, You have not permission to access: $pgMsg</p>","dashboard.php");
		}
		
		/*function generateCode($length=8)
		{
			$characters = "123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			$string = "";
			do
			{
				$string .= $characters[mt_rand(0, strlen($characters))];
			} while(strlen($string)<$length);
			return $string;
		}*/
		function generateCode($length=8,$table="", $field="")
		{
			$characters = "123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			
			$string = "";
			do
			{
				$string .= $characters[mt_rand(0, strlen($characters))];
			} while(strlen($string)<$length);
			if($table!="" && $field!="")
			{
				while($this->mf_getValue($table,$field,$field,$string))
				{
					$string = "";
					do
					{
						$string .= $characters[mt_rand(0, strlen($characters))];
					} while(strlen($string)<$length);
				}
			}
			return $string;
		}
		function generatePassword($length=8)
		{
			$characters = "0123456789AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWXxYyZz";
			$string = "";
			do
			{
				$string .= $characters[mt_rand(0, strlen($characters))];
			} while(strlen($string)<$length);
			return $string;
		}
		function checkUserAccess($sessID, $pgcheck="0")
		{
			if($pgcheck=="1")
			{
				if( ! $_SESSION[$sessID]>0)
				{
					$this->mf_setmessage("<p class='msgred'>Sorry, please login to access your account.<br>&nbsp;</p>","index.php");
				}
			}
			else
			{
				$accArr=array("Individual_UID"=>"individual_login","Employee_UID"=>"employee_login","Employer_UID"=>"employer_login","Partner_UID"=>"partner_login","PLearning_UID"=>"plearning_login");
				if($_SESSION[$sessID]>0)
				{
					$spRes=$this->mf_query("SELECT id from users where is_suspended='1' and id='".$_SESSION[$sessID]."'");
					if($this->mf_affected_rows()>0)
					{
						unset($_SESSION[$sessID]);
						$this->mf_setmessage("<p class='msgred'>Sorry, your account is suspended.<br>Please contact RIBELS Admin to Re-active your account.<br>&nbsp;</p>",$accArr[$sessID].".php");
					}
				}
				else
				{
					$this->mf_setmessage("<p class='msgred'>Sorry, please login to access your account.<br>&nbsp;</p>","index.php");
				}
			}
		}
		
		function mf_sendEMailTemplate($fldArr,$eid,$to,$from="no-reply@ribels.com")
		{
			list($subject,$body,$flds)=$this->mf_getMultiValue("email_template",array("subject","content","text_find"),"id",$eid);
			$fArr=explode(",",$flds);
			foreach($fArr as $k=>$v)
			{
				$fval=strtolower(substr(substr(trim($v),1),0,-1));
				$body = str_replace(trim($v),$fldArr[$fval],$body);
			}
			
			$limite = "_parties_".md5 (uniqid (rand()));
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$headers .= "From: ".$from."\r\n";
			
			/*$myFile = "Mails.html";
			$fh = fopen($myFile, 'a');
			$stringData = "To: $to\n";
			fwrite($fh, $stringData);
			$stringData = "Subject: $subject\n";
			fwrite($fh, $stringData);
			fwrite($fh, $body);
			fwrite($fh, "<br /><hr><br>");
			fclose($fh);*/
			
			/*echo $to."<hr>".$subject."<hr>".$body."<hr><pre>".$headers."</pre><hr>";	exit; */
			mail($to,$subject,$body,$headers);
			//return array($subj,$bdy);
		}
		
		function mf_isemail($email)
		{
			$result = TRUE;
			if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email))
			{
				$result = FALSE;
			}
			return $result;
		}
		
		 
		function curTimedate()
		{
			$tmRes=$this->mf_query("SELECT NOW() as tm FROM  `admin`");
			$tmRow=$this->mf_fetch_array($tmRes);
			return $tmRow['tm'];
		}
		function dispTZTimedate($dtval)
		{
			global $time_zone;
			$date = new DateTime(date("Y-m-d H:i:s", strtotime($dtval)), new DateTimeZone('UTC'));
			$date->setTimezone(new DateTimeZone($time_zone));
			return $date->format('m/d/Y h:i A');
		}
		
		function dispTZdate($dtval)
		{
			global $time_zone;
			$date = new DateTime(date("Y-m-d H:i:s", strtotime($dtval)), new DateTimeZone('UTC'));
			$date->setTimezone(new DateTimeZone($time_zone));
			return $date->format('m/d/Y');
		}
		
		function getSubString($string, $length,$postfix="")
		{
			$string=trim(preg_replace("[\r]", " ", $string));
			$string=trim(preg_replace("[\n]", " ", $string));
			if (strlen($string) > $length)
			{
				$string = wordwrap($string, $length);
				$i = strpos($string, "\n");
				if ($i) {
					$string = substr($string, 0, $i).$postfix;
				}
			}
			return $string;
		}
		
		/************ URL STRUCTURE GENERATOR ****************/
		function setUrlName($str)
		{
			$newstr=str_replace(" ","-",$str);
			return $newstr;
		}
		function setCountyLink($county, $state)
		{
			global $SITE_URL;
			return $SITE_URL.$this->setUrlName($state)."/".$this->setUrlName($county).'-County';
		}
		function setCityLink($city, $state)
		{
			global $SITE_URL;
			return $SITE_URL.$this->setUrlName($city)."-".$this->setUrlName($state);
		}
		function setCommunitiesLink($community, $state)
		{
			global $SITE_URL;
			return $SITE_URL.$this->setUrlName($community)."-".$this->setUrlName($state);
		}
		function setHomeLink($state, $county, $city, $community)
		{	
			global $SITE_URL;
			$urlstr=$SITE_URL;
			if($city!='')
			{
				$urlstr .= $this->setUrlName($city) . '-' . $this->setUrlName($state);
			}
			elseif($community!='')
			{
				$urlstr .= $this->setUrlName($community) . '-' . $this->setUrlName($State);
			}
			elseif($county!='')
			{
				$state_fullname=$this->mf_getValue("us_states","REPLACE(StateFullName,' ','-')","State",$state);
				$urlstr .= $this->setUrlName($state_fullname) . '/' . $this->setUrlName($county) . '-County';
			}
			elseif($state!='')
			{
				$state_fullname=$this->mf_getValue("us_states","REPLACE(StateFullName,' ','-')","State",$state);
				$urlstr .= $this->setUrlName($state_fullname);
			}
			return $urlstr;
		}
		function setCommonLink($table, $field, $tid, $state, $county, $city, $community='')
		{
			global $SITE_URL;
			$pgName = $this->mf_getValue($table,$field,"id",$tid);
			$urlstr=$SITE_URL;
			if($city!='')
			{
				$urlstr .= $this->setUrlName($city) . '-' . $this->setUrlName($state) . '/';
			}
			elseif($community!='')
			{
				$urlstr .= $this->setUrlName($community) . '-' . $this->setUrlName($state) . '/';
			}
			elseif($cnid!='')
			{
				$state_fullname=$this->mf_getValue("us_states","REPLACE(StateFullName,' ','-')","State",$state);
				$urlstr .= $this->setUrlName($state_fullname) . '/' . $this->setUrlName($county) . '-County/';
			}
			elseif($state!='')
			{
				$state_fullname=$this->mf_getValue("us_states","REPLACE(StateFullName,' ','-')","State",$state);
				$urlstr .= $this->setUrlName($state_fullname) . '/';
			}
			return $urlstr.$pgName;
		}
		function setStaticLink($url, $state, $county, $city, $community='')
		{
			global $SITE_URL;
			$urlstr=$SITE_URL;
			if($city!='')
			{
				$urlstr .= $this->setUrlName($city) . '-' . $this->setUrlName($state) . '/';
			}
			elseif($community!='')
			{
				$urlstr .= $this->setUrlName($city) . '-' . $this->setUrlName($state) . '/';
			}
			elseif($county!='')
			{
				$state_fullname=$this->mf_getValue("us_states","REPLACE(StateFullName,' ','-')","State",$state);
				$urlstr .= $this->setUrlName($state_fullname) . '/' . $this->setUrlName($county) . '-County/';
			}
			elseif($state!='')
			{
				$state_fullname=$this->mf_getValue("us_states","REPLACE(StateFullName,' ','-')","State",$state);
				$urlstr .= $this->setUrlName($state_fullname) . '/';
			}
			return $urlstr.$url;
		}
		function getPagination($count){
			  $paginationCount= floor($count / PAGE_PER_NO);
			  $paginationModCount= $count % PAGE_PER_NO;
			  if(!empty($paginationModCount)){
				 $paginationCount++;
			  }
		
			  return $paginationCount;
		}
		function mf_total_nums_row($table,$where)	// RETURN TOTAL COUNT OF RECORDS
		{
			$qry="SELECT count(*) as total from $table $where ";
			$result=mysql_query($qry);
			if(mysql_affected_rows()>0)
			{
				$row=mysql_fetch_array($result);
				return $num_results = $row['total']; 
			}
			else
			{
				return "";
			}
		}
		
		function mf_total_nums_row_price($table,$where)	// RETURN TOTAL COUNT OF RECORDS
		{
			$qry="SELECT COUNT(DISTINCT product_id) as total from $table $where ";
			$result=mysql_query($qry);
			if(mysql_affected_rows()>0)
			{
				$row=mysql_fetch_array($result);
				return $num_results = $row['total']; 
			}
			else
			{
				return "";
			}
		}
		
		function mf_total_nums_row_price_range($table,$where)	// RETURN TOTAL COUNT OF RECORDS
		{
			$qry="SELECT COUNT(DISTINCT pp.product_id) as total from $table pp left join products p on p.id=pp.product_id left join product_images pm on pm.product_id=pp.product_id $where ";
			$result=mysql_query($qry);
			if(mysql_affected_rows()>0)
			{
				$row=mysql_fetch_array($result);
				return $num_results = $row['total']; 
			}
			else
			{
				return "";
			}
		}
		
		function getCoordLL($fulladdress)   // THIS FUNCTION WILL BE DEFINED IN CLASS FILE
		{
			$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.urlencode($fulladdress).'&sensor=true');
			$output= json_decode($geocode);
			$LLArr=array();
			$LLArr[] = $output->results[0]->geometry->location->lat;	// latitude
			$LLArr[] = $output->results[0]->geometry->location->lng;	// longitude
			return $LLArr;
		}
		function writemail($subject,$body)
		{
			$fp = fopen("outmail.html","a");
			fputs($fp,"<h2 align='center'>".$subject."</h2>");
			fputs($fp,"<hr />");
			fputs($fp,$body);
			fputs($fp,"<br><br><hr />");
			fclose($fp);
		}
		function mf_getValuecity($field,$city,$community,$state)	// FUNCTION TO SELECT RECORD IN SPECIFIED TABLE
		{
			if($city!='')
			{
				$result=mysql_query("SELECT $field from us_cities where City='$city' and State='$state' and Type<>'City' LIMIT 1");
				if(mysql_affected_rows()>0)
				{
					$row=mysql_fetch_array($result);
					return stripslashes($row[$field]);
				}
			}
			else
			{
				$result=mysql_query("SELECT $field from us_cities where City='$community' and State='$state' and Type='City' LIMIT 1");
				if(mysql_affected_rows()>0)
				{
					$row=mysql_fetch_array($result);
					return stripslashes($row[$field]);
				}
			}
		}
		function mf_dbtruncate($table)	// FUNCTION TO EMPTY TABLE ROW
		{
			$qry="TRUNCATE TABLE ".$table."";
			return $this->mf_query($qry);
		}
		function mf_addhttp($url) {
			if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
				$url = "http://" . $url;
			}
			return $url;
		}
	}  
// END OF CLASS
?>
