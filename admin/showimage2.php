<?php

include_once("../includes/connect.php");

$ad_id = $_POST['ad_id'];

if($ad_id){

	$get_advert = mysql_query("SELECT * FROM adverts WHERE ad_id=$ad_id");
	
	$ad_info = mysql_fetch_array($get_advert);
	
	extract($ad_info);
	
	$results = array('ad_loc'=>$ad_loc,'ad_width'=>$ad_width,'ad_height'=>$ad_height,'ad_type'=>$ad_style);
	
	/*echo json_encode($results);*/
	
	?>
	<img src="<?php echo $ad_loc; ?>" width="<?php echo $ad_width/3; ?>" height="<?php echo $ad_height/3; ?>" alt="ad preview" />


	
	
<?php
	
}else{
	$results = array('ad_type'=>0);
	
	echo json_encode($results);
}

?>