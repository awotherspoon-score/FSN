<?php

include_once("../includes/connect.php");

$item_id = $_POST['id'];
$item_type = $_POST['type'];

$array = '';

if($item_id&&$item_type)
{	
	if($item_type=='article'){
		$table = 'articles';
		$field = 'article_id';
		$date = 'article_date';
	}elseif($item_type=='advert'){
		$table = 'adverts';
		$field = 'ad_id';
	}elseif($item_type=='course'){
		$table = 'courses';
		$field = 'course_id';
	}
	elseif($item_type=='course_date'){
		$table = 'course_dates';
		$field = 'course_date_id';
		$date = 'course_date';
	}
	
	if($date){
	
		$get_date = mysql_query("SELECT $date FROM $table WHERE $field='$item_id'");
		
		$date_info = mysql_fetch_array($get_date);
		
		$item_date = $date_info[$date];
		
		$get_similar = mysql_query("SELECT $date FROM $table WHERE $date='$item_date'");
		
		$num_rows = mysql_num_rows($get_similar);
	
		if($num_rows==1){
			
			#extract(mysql_fetch_array($get_date));
		
			$array['date'] = date("dmy",$item_date);
		
		}
				
	}
	
	$delete_item = mysql_query("DELETE FROM $table WHERE $field='$item_id' LIMIT 1");
	
	if($delete_item)
	{	
		 $array['done'] =  'true';
	
	}else
	{
		$array['done'] =  'false';
	}
	
}else
{
	$array['done'] = 'false';
}

echo json_encode($array);

?>