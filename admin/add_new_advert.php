<?php

session_start();

if(!$_SESSION['logged_in']=='798hJR31')
{
	header("Location: http://www.scorecomms.com/fsn/admin/index.php");
}

error_reporting(0);

$admin=1;
$admin_page='adverts';

include_once("../includes/connect.php");
include_once("../includes/functions.php");

/*$course_id = $_GET['course_id'];

$get_course = mysql_query("SELECT * FROM courses WHERE course_id=$course_id");

$course_info = mysql_fetch_array($get_course);

extract($course_info);

$course_category=$course_type;*/

/*if(@$_POST['preview']){
	
	$course_title = $_POST['course_title'];
	$course_code = $_POST['course_code'];
	
	$course_day = $_POST['course_day'];
	$course_month = $_POST['course_month'];
	$course_year = $_POST['course_year'];
	$course_date = mktime(0,0,0,$course_month,$course_day,$course_year);
	
}else*/if(@$_POST['submit']){
	
	//// UPLOAD IMAGE FUNCTION ///////////////////

function upload_image($file,$img_type,$img_desc){

	$e_allowedExt = array("gif","jpeg","jpg","png");
	$e_bits = explode('.',$file['name']); 
	$e_ext = strtolower(array_pop($e_bits));
	$e_allowed = "no";

	if(!in_array($e_ext, $e_allowedExt)){
		//error message - bad filetype.
		header("location:edit-images.php?id=$id&error=filetype") or die();
	}else{
		
		$e_img_target_path = $_SERVER['DOCUMENT_ROOT']."/upload/side-images/user-files/temp/".basename($file['name']);
	
		if(move_uploaded_file($file['tmp_name'], $e_img_target_path)) {
			//sucess don't give errors.
		} else{
			//error message - couldn't upload image
			header("location:edit-images.php?id=$id&error=upload");
		}
		
		////END ORIGINAL IMAGE UPLOAD AND BEGIN THUMBNAIL UPLOAD
		
		
		////////////////		
		////////////////
		//LARGE THUMBNAIL
		$e_file      = basename($file['name']);
		$e_file_info = getimagesize($_SERVER['DOCUMENT_ROOT']."/images/side-images/user-files/temp/".$e_file);
		
		$e_width = $e_file_info[0] ;
		$e_height = $e_file_info[1];
		
		$e_ratio = $e_width/206;
		$e_new_height = floor($e_height/$e_ratio);
		$e_new_width = 206;
		
		/*$e_ratio = $e_height/192;
		$e_new_width = $e_width/$e_ratio;
		$e_new_width = round($e_new_width);
		$e_new_height = $e_height/$e_ratio;
		$e_new_height = round($e_new_height);
		*/
		
		//for cropping
		$e_xMove = $e_new_width-380;
		$e_xMove = $e_xMove/2;
		$e_xMove = round($e_xMove);
		
		$e_yMove = $e_new_height-192;
		$e_yMove = $e_yMove/2;
		$e_yMove = round($e_yMove);
		
		$e_filename= $_SERVER['DOCUMENT_ROOT']."/images/side-images/user-files/temp/$e_file";
		
		if(filesize($e_filename)>800000){
				
			unlink($_SERVER['DOCUMENT_ROOT']."/images/side-images/user-files/temp/$e_file");
			
			return FALSE;
			
		}else{
			
			if($e_ext=="jpeg" || $e_ext=="jpg"){
			$e_img = imagecreatefromjpeg($e_filename);
			}else if($e_ext=="gif"){ 
			$e_img = imagecreatefromgif($e_filename);
			}else if($e_ext=="png"){ 
			$e_img = imagecreatefrompng($e_filename);
			}

			$e_tmp_img = imagecreatetruecolor(206, $e_new_height);
			
			$e_white = imagecolorallocate($e_tmp_img, 255, 255, 255);
			imagefill($e_tmp_img, 0, 0, $e_white);
			
			// copy and resize old image into new image
			imagecopyresampled( $e_tmp_img, $e_img, 0, 0, 0, 0, $e_new_width, $e_new_height, $e_width, $e_height );						
			
			$e_date_added = time();
			// save large thumbnail into a file
			if(imagejpeg( $e_tmp_img, $_SERVER['DOCUMENT_ROOT']."/images/side-images/user-files/$e_date_added-$e_file", 100 )){
				//successfully created thumbnail 1
				//add new overview for this party
				$e_image = "$e_date_added-$e_file";
			}
			
			// DELETE TEMP IMAGE//
				
			unlink($_SERVER['DOCUMENT_ROOT']."/images/side-images/user-files/temp/$e_file");
			
			$img_src="images/side-images/user-files/$e_date_added-$e_file";
		
			mysql_query("INSERT INTO site_images (img_id, img_src, img_desc, img_type) VALUES ('', '$img_src', '$img_desc', '$img_type')");
			
			return mysql_insert_id();
		
		}

	}

}

/// END UPLOAD FUNCITON ////////////////////////
	
	/*$course_code = $_POST['course_code'];
	
	$course_day = $_POST['course_day'];
	$course_month = $_POST['course_month'];
	$course_year = $_POST['course_year'];
	$course_date = mktime(0,0,0,$course_month,$course_day,$course_year);
	*/
	if(!$error){
		
		$insert_course_code = mysql_escape_string(strip_tags($course_code));
		$insert_course_date = $course_date;
		
	#|	$add_course = mysql_query("INSERT INTO course_dates (course_date_id, course_code, course_date) VALUES ('','$insert_course_code','$insert_course_date')");
		
		if($add_course)
		{
			$status['good']="the course '$course_code' has been updated";
			
		}else{
			echo mysql_error();
			$status['bad'] = "There was an error";	
		}
	
	}
	
}else{
	
	$course_date = time();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FSN ~ Admin Panel ~ Add course</title>

<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/style/layout.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/style/admin.css" />

<script type="text/javascript" src="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/admin/jscripts/tiny_mce/tiny_mce_gzip.js"></script>

<script type="text/javascript">
tinyMCE_GZ.init({
	plugins : 'spellchecker,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,'+ 
        'searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras',
	languages : 'en',
	disk_cache : true,
	debug : false
});
</script>

<script type="text/javascript">
tinyMCE.init({
	theme : 'fsn',
	plugins : "spellchecker,table,paste",
	//theme_advanced_buttons3_add : "spellchecker",
	theme_fsn_buttons1 : "code,|,bold,italic,underline,|,justifyleft,justifycenter,justifyright,|,bullist,numlist,|,outdent,indent,|,link,unlink,anchor,charmap,|,undo,redo,cut,copy,paste,pasteword",
	theme_fsn_buttons2 : "tablecontrols",
	spellchecker_languages : "+English=en",
	mode : "exact",
	elements : "course_details"
});
</script>

<script type="text/javascript">
tinyMCE.init({
	theme : 'fsn',
	plugins : "spellchecker,table,paste",
	//theme_advanced_buttons3_add : "spellchecker",
	theme_fsn_buttons1 : "code,|,bold,italic,underline,|,formatselect,|,justifyleft,justifycenter,justifyright,|,bullist,numlist,|,outdent,indent,|,link,unlink,image,anchor,charmap,|,undo,redo,cut,copy,paste,pasteword",
	theme_fsn_buttons2 : "tablecontrols",
	theme_fsn_blockformats : "p,h2,h4",
	spellchecker_languages : "+English=en",
	mode : "exact",
	elements : "course_content,course_programme"
});
</script>

<script type="text/javascript" src="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/includes/jquery.js"></script>

</head>

<body>

	<div id="background-wrapper">
	
		<div class="container">
		
			<?php include("includes/admin_nav.php"); ?>	
		
			<div id="main-holder">
			
			<?php if($status['good']){
			?>
			<div class="status-good"><?php echo $status['good']; ?></div>
			<?php
			}elseif($status['bad']){
			?>
			<div class="status-bad"><?php echo $status['bad']; ?></div>
			<?php
			}?>
			
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="course_form">
			
			<?php
				if($error['title']==1){
					
				}
			?>
			
			<div class="form-container<?php if($error['title']==1){ echo " error";	}?>">
			<label for="course">Advert Title: </label>
			<input type="text" id="ad_title" name="ad_title" value="<?php echo $ad_title; ?>" />
			</div>
			
			<div class="form-container<?php if($error['file']==1){ echo " error";	}?>">
			<label for="course">Advert Image: </label>
			<input type="file" id="ad_image" name="ad_image" /><p><em>Images should be no greater than 500KB</em></p>
			</div>
			<div class="form-container<?php if($error['date']==1){ echo " error";	}?>">
			<label for="advert_type">Advert Type: </label>
			<select name="advert_type" id="advert_type">
				<option value="banner" <?php if($advert_type=='banner'){ echo 'selected="selected"'; } ?>>Banner</option>
				<option value="skyscraper" <?php if($advert_type=='skyscraper'){ echo 'selected="selected"'; } ?>>Skyscraper</option>
				<option value="square" <?php if($advert_type=='sky'){ echo 'selected="selected"'; } ?>>Square</option>
			</select>
			</div>

			<div class="form-container">
			
			<input type="submit" value="add advert" name="submit" id="course_submit" />
			</div>
			</form>
		
				<div style="clear:both;"></div>
		
			</div>
		
		</div>
		
		</div>
		
		<div class="bottom-round"><div class="bottom-left"></div></div>

</body>
</html>