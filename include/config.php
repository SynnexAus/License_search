<?php error_reporting(0);
	$mode="LOCAL";
	if($mode=="LIVE") 
	{
		$HOSTNAME="synnexcloud.com.au";
		$USERNAME="synnexcl_root";
		$PASSWORD="root@123";
		$DATABASE="synnexcl_avg_renewals";
		$SITE_URL="http://licensesearch.synnexcloud.com.au/";
		$SITE_URLS="http://licensesearch.synnexcloud.com.au/";
	}
	else 
	{
		$HOSTNAME="synnexcloud.com.au";
		$USERNAME="synnexcl_root";
		$PASSWORD="root@123";
		$DATABASE="synnexcl_avg_renewals";
		$SITE_URL="http://licensesearch.synnexcloud.com.au/";
		$SITE_URLS="http://licensesearch.synnexcloud.com.au/";
	}
	$ADMIN_URL = $SITE_URL."adminpanel";
	$SITE_NAME="Avg License Renewals";
	$CURRENCY="$";
	
	ini_set('memory_limit', '4000M');
	ini_set('post_max_size', '300M');
	ini_set('upload_max_filesize', '300M');
	ini_set('max_execution_time', 3600);
	
	$time_zone = "America/Los_Angeles";
	date_default_timezone_set('America/Los_Angeles');
?>