<?php

//// UPLOAD IMAGE FUNCTION ///////////////////

echo "hello";

echo upload_image($_FILES['image']);

function upload_image($file){
	
	$image_folder = $_SERVER['DOCUMENT_ROOT']."upload/";

	$e_allowedExt = array("gif","jpeg","jpg","png");
	$e_bits = explode('.',$file['name']); 
	$e_ext = strtolower(array_pop($e_bits));
	$e_allowed = "no";

	if(!in_array($e_ext, $e_allowedExt)){
		//error message - bad filetype.
		#header("location:edit-images.php?id=$id&error=filetype") or die();
	}else{
		
		$e_img_target_path = $image_folder."temp/".basename($file['name']);
	
		if(move_uploaded_file($file['tmp_name'], $e_img_target_path)) {
			//sucess don't give errors.
		} else{
			//error message - couldn't upload image
			#header("location:edit-images.php?id=$id&error=upload");
		}
		
		////END ORIGINAL IMAGE UPLOAD AND BEGIN THUMBNAIL UPLOAD
		
		
		////////////////		
		////////////////
		//LARGE THUMBNAIL
		$e_file      = basename($file['name']);
		$e_file_info = getimagesize($image_folder."temp/".$e_file);
		
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
		
		$e_filename= $image_folder."temp/$e_file";

	}

}

/// END UPLOAD FUNCITON ////////////////////////

function move_n_insert(){

	if(filesize($e_filename)>800000){
				
		unlink($image_folder."temp/$e_file");
		
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
		if(imagejpeg( $e_tmp_img, $image_folder."/images/$e_date_added-$e_file", 100 )){
			//successfully created thumbnail 1
			//add new overview for this party
			$e_image = "$e_date_added-$e_file";
		}
		
		// DELETE TEMP IMAGE//
			
		unlink($image_folder."temp/$e_file");
		
		$img_src="upload/images/$e_date_added-$e_file";
	
		mysql_query("INSERT INTO site_images (img_id, img_src, img_desc, img_type) VALUES ('', '$img_src', '$img_desc', '$img_type')");
		
		return mysql_insert_id();
	
	}

}

?>