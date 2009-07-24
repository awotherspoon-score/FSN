<?php

include_once("../includes/connect.php");

$ad_id = $_POST['ad_id'];

if($ad_id)
{	
	$delete_ad = mysql_query("DELETE FROM adverts WHERE ad_id='$ad_id' LIMIT 1");
	
	if($delete_ad)
	{	
		echo 'true';
	
	}else
	{
		echo 'false';
	}
	
}else
{
	echo 'false';
}

?>