<?php
/**
 * Archiv connector file
 * 
 * @version 0.1
 * @author Wouter van Kuipers Archiv@pwnd.nl
 * @copyright 2008 pwnd.nl
 * @license GPL
 * @see http://archiv.pwnd.nl
 *
 */

# Error reportings
error_reporting(6143+2048);

class Archiv{
	var $data; 					// all post/get/file data set by function getParameters	
	var $settings = array(); 	// holds all the configuration settings	
	var $language = array();	// holds all the language lines		
	
	/**
	 * PHP5 constructor
	 * 
	 * @return void
	 */ 
	//function __construct(){
		//$this->Archiv();
	//}
	
	/**
	 * CMS Files constructor
	 *
	 * @return void
	 */
	function Archiv(){
		
		$this->getParameters();		

		if(!isset($this->data['js'])){
			if(isset($this->data['settings_file']) && is_file("../".$this->data['settings_file'])){
				require_once("../".$this->data['settings_file']);
			}
			else{
				die("Cannot include config file!!"); 
			}
			
			$this->getLanguageFile();	

			if($this->settings['security_level'] == 1){
				if(!isset($this->data['security_passphrase']) || $this->data['security_passphrase'] != md5($this->settings['security_passphrase'].$_SERVER['REMOTE_ADDR'])){
					die($this->language["ErrorNoAccess"]." (1)"); 		
				}
			}
			elseif($this->settings['security_level'] == 2){
				if(!in_array($_SERVER['REMOTE_ADDR'], $this->settings['security_ips_allowed'])){
					die($this->language["ErrorNoAccess"]." (2)"); 	
				}
			}
			elseif($this->settings['security_level'] == 3){
				if(!isset($this->data['security_password']) || !in_array($this->data['security_password'], $this->settings['security_password'])){
					die($this->language["ErrorNoAccess"]." (3)"); 	
				}
			}
			elseif($this->settings['security_level'] == 4){
				if(!isset($_COOKIE[$this->settings['security_coockie_obj']['object_name']]) || $_COOKIE[$this->settings['security_coockie_obj']['object_name']] != $this->settings['security_coockie_obj']['object_value']){
					die($this->language["ErrorNoAccess"]." (4)");  	
				}
			}
		}		
		
		if(isset($this->data['get'])){
			switch($this->data['get']){			
				case "dirList":
					$this->getDirList();
					break;
					
				case "dirContent":
					$this->getDirContent();
					break;
					
				default:
					break;				
			}
		}
		elseif(isset($this->data['do'])){
			switch($this->data['do']){			
				case "addMap":
					$this->addMap();
					break;
					
				case "addFile":
					$this->addFile();
					break;
					
				case "deleteFile":
					$this->deleteFile();
					break;
					
				case "deleteFolder":
					$this->deleteFolder();
					break;
					
				default:
					break;				
			}
		}
	}
	
	/**
	 * Function gets all the parameters from get/post/file data
	 * 
	 * @return void 
	 */
	function getParameters(){
		$this->data = $_GET;
		$this->data = array_merge($this->data,$_POST);		
	}
	
	/**
	 * Function gets all the language lines
	 * 
	 * @return void 
	 */
	function getLanguageFile(){
		if(is_file("../langs/".$this->settings['language'].".php")){
			require_once("../langs/".$this->settings['language'].".php");
			$this->language = $lang;
		}
		else{
			die("Cannot include language file `../langs/".$this->settings['language'].".php"."`");
		}		
	}
	
	/**
     * Function returns the javascript settings in xml format
     * 
     * @return void
     */ 
	function displaySettings(){
		$this->dumpXML(array("settings"=>$this->settings));
	}

	/**
	 * Function to add a map to the current selected map or to the root if no map selected
	 *
	 * @return void
	 */
	function addMap(){
		$file = isset($this->data['dirName']) ? $this->data['dirName'] : null;
		$path = isset($this->data['dirRoot']) ? $this->settings['path']."/".$this->data['dirRoot'] : null;
		
		if( is_dir($path) && is_writable($path)){
			if(!is_dir($path."/".$file)){
				if(mkdir($path."/".$file)){
					echo "ok";		
				}
				else{
					echo $this->language['ErrorCreatingFolder'];
				}
			}
			else{
				echo $this->language['ErrorFolderAlreadyExists'];
			}
		}
		else{
			echo $this->language['ErrorUnableToReadPath']." `".$path."`";		
		}
	}
	
	/**
	 * Function to upload a file to the current selected map or to the root if no map selected
	 *
	 * @return true on success else false
	 */
	function addFile(){
		// Check the upload
		if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0) {
			header("HTTP/1.1 500 Internal Server Error");
			echo $this->language['ErrorInvalidUpload'];
			exit(0);
		}
	
		#set filename to lower case
		$file['name'] = strtolower($_FILES["Filedata"]['name']);
		
		#move file to upload dir
		$move = move_uploaded_file($_FILES["Filedata"]['tmp_name'], $this->settings['path']."/".$this->data['path']."/".$file['name']);

		#create the prefix
		$prefix = md5(time()).'_';

		#get the info of the image
		list($width, $height) = @getimagesize($this->settings['path']."/".$this->data['path']."/".$file['name']);
		$mime_type = $this->returnMIMEType($this->settings['path']."/".$this->data['path']."/".$file['name']);

		#check if it is a picture
		if(in_array($mime_type,$this->settings['allowedImageMimes']) && $this->data['browser']=="images"){
			#picture
			$img['p_name']   = $prefix.$file['name'];
			$img['p_width']  = $width;
			$img['p_height'] = $height;
			
			#thumb
			$img['i_width']  = $img['p_width'];
			$img['i_height'] = $img['p_height'];
	
			#scale the image if needed				
			//fixing a bug in the resize functionality ...
			if($img['p_width'] > $this->settings['max_image_size']){
				$image_width  = $this->settings['max_image_size'];
				$image_height = round(($this->settings['max_image_size']/$img['i_width'])*$img['i_height']);
			}elseif($img['p_height'] > $this->settings['max_image_size']){
				$image_width  = round(($this->settings['max_image_size']/$img['i_height'])*$img['i_width']);
				$image_height = $this->settings['max_image_size'];
			}else{
				$image_width  = $img['i_width'];
				$image_height = $img['i_height'];
			}
			$img['p_width']  = $image_width; 
			$img['p_height'] = $image_height;
	
			#resize the thumb if needed	
			if($img['i_width'] > $img['i_height']){
				$image_small_width  = $this->settings['max_thumb_size'];
				$image_small_height = round(($this->settings['max_thumb_size']/$img['i_width'])*$img['i_height']);	
			}
			else{
				$image_small_width  = round(($this->settings['max_thumb_size']/$img['i_height'])*$img['i_width']);
				$image_small_height = $this->settings['max_thumb_size'];					
			}
	
			$img['i_width']  = $image_small_width;
			$img['i_height'] = $image_small_height;			
			
			switch($mime_type){
				case "image/jpg":
					$this->create_jpg($this->settings['path']."/".$this->data['path']."/".$file['name'], $prefix, $width, $height, $img['p_width'], $img['p_height'], $img['i_width'], $img['i_height']);
					#unlink the uploaded file
					$unlink = unlink($this->settings['path']."/".$this->data['path']."/".$file['name']);
					break;
					
				case "image/png":
					$this->create_png($this->settings['path']."/".$this->data['path']."/".$file['name'], $prefix, $width, $height, $img['p_width'], $img['p_height'], $img['i_width'], $img['i_height']);
					#unlink the uploaded file
					$unlink = unlink($this->settings['path']."/".$this->data['path']."/".$file['name']);
					break;
					
				case "image/gif":
					$this->create_gif($this->settings['path']."/".$this->data['path']."/".$file['name'], $prefix, $width, $height, $img['p_width'], $img['p_height'], $img['i_width'], $img['i_height']);
					#unlink the uploaded file
					$unlink = unlink($this->settings['path']."/".$this->data['path']."/".$file['name']);
					break;
					
				default:
					rename($this->settings['path']."/".$this->data['path']."/".$file['name'],$this->settings['path']."/".$this->data['path']."/".$prefix.$file['name']);					
					break;				
			}			
		}
		#else just upload
		#check if it is a picture
		elseif(in_array($mime_type,$this->settings['allowedFileMimes']) && $this->data['browser'] == "files"){
			rename($this->settings['path']."/".$this->data['path']."/".$file['name'],$this->settings['path']."/".$this->data['path']."/".$prefix.$file['name']);					
		}
		else{
			$unlink = unlink($this->settings['path']."/".$this->data['path']."/".$file['name']);
			echo $this->language['ErrorWrongMimeType']." ".$mime_type;
			exit(0);
		}
		
		echo "ok";
	}
	
	/**
	 * Function to create a resized image from a jpg file
	 *
	 * @param jpg file
	 * @param prefix for the new image
	 * @param width of the origional image
	 * @param height of the origional image
	 * @param width for the new image
	 * @param height for the new image
	 * @param width for the thumb image 
	 * @param height for the thumb image 
	 *
	 * @return void
	 */
	function create_jpg($file, $prefix, $width, $height, $pic_new_width, $pic_new_height, $thumb_width, $thumb_height){
		#fetch the extention from the file
		$file_path 	= substr($file,0,strrpos($file,"/"));
		$file_name 	= substr($file,strlen($file_path)+1, (strrpos($file,".")-(strlen($file_path)+1)));
		$file_ext	= substr($file,strrpos($file,"."));

		#create the picture
		$thumb  = imagecreatetruecolor($pic_new_width, $pic_new_height);
		$source = imagecreatefromjpeg($file);
		$imgcpyrsmpld = imagecopyresampled( $thumb, $source, 0, 0, 0, 0, $pic_new_width, $pic_new_height, $width, $height );

		$imagejpeg = imagejpeg($thumb, $file_path."/".$prefix.$file_name.$file_ext, 100);
		$imagedestroy = imagedestroy($thumb);

		#create the thumb
		$thumb2  = imagecreatetruecolor($thumb_width, $thumb_height);
		$source2 = imagecreatefromjpeg( $file );
		$imgcpyrsmpld2 = imagecopyresampled( $thumb2, $source2, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height );
		
		$imagejpeg2 = imagejpeg($thumb2, $file_path."/".$prefix.$file_name.'_thumb'.$file_ext, 100);
		$imagedestroy2 = imagedestroy($thumb2);
	}
	
	/**
	 * Function to create a resized image from a gif file
	 * 
	 * @param gif file
	 * @param prefix for the new image
	 * @param width of the origional image
	 * @param height of the origional image
	 * @param width for the new image
	 * @param height for the new image
	 * @param width for the thumb image 
	 * @param height for the thumb image 
	 *
	 * @return void
	 */
	function create_gif($file, $prefix, $width, $height, $pic_new_width, $pic_new_height, $thumb_width, $thumb_height){
		#fetch the extention from the file
		$file_path 	= substr($file,0,strrpos($file,"/"));
		$file_name 	= substr($file,strlen($file_path)+1, (strrpos($file,".")-(strlen($file_path)+1)));
		$file_ext	= substr($file,strrpos($file,"."));

		#create the picture
		$thumb  = imagecreatetruecolor($pic_new_width, $pic_new_height);
		$source = imagecreatefromgif($file);
		$imgcpyrsmpld = imagecopyresampled( $thumb, $source, 0, 0, 0, 0, $pic_new_width, $pic_new_height, $width, $height );

		$imagegif = imagegif($thumb, $file_path."/".$prefix.$file_name.$file_ext, 100);
		$imagedestroy = imagedestroy($thumb);

		#create the thumb
		$thumb2  = imagecreatetruecolor($thumb_width, $thumb_height);
		$source2 = imagecreatefromgif( $file );
		$imgcpyrsmpld2 = imagecopyresampled( $thumb2, $source2, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height );
		
		$imagegif2 = imagegif($thumb2, $file_path."/".$prefix.$file_name.'_thumb'.$file_ext, 100);
		$imagedestroy2 = imagedestroy($thumb2);
	}
	
	/**
	 * Function to create a resized image from a png file
	 *
	 * @param png file
	 * @param prefix for the new image
	 * @param width of the origional image
	 * @param height of the origional image
	 * @param width for the new image
	 * @param height for the new image
	 * @param width for the thumb image 
	 * @param height for the thumb image 
	 * 
	 * @return void
	 */
	function create_png($file, $prefix, $width, $height, $pic_new_width, $pic_new_height, $thumb_width, $thumb_height){
		#fetch the extention from the file
		$file_path 	= substr($file,0,strrpos($file,"/"));
		$file_name 	= substr($file,strlen($file_path)+1, (strrpos($file,".")-(strlen($file_path)+1)));
		$file_ext	= substr($file,strrpos($file,"."));

		#create the picture
		$thumb  = imagecreatetruecolor($pic_new_width, $pic_new_height);
		$source = imagecreatefrompng($file);
		$imgcpyrsmpld = imagecopyresampled( $thumb, $source, 0, 0, 0, 0, $pic_new_width, $pic_new_height, $width, $height );

		if(version_compare(PHP_VERSION, '5.1.2' , '<')){
			$imagepng = imagepng($thumb, $file_path."/".$prefix.$file_name.$file_ext, 100);
		}
		elseif(version_compare(PHP_VERSION, '5.1.3' , '<')){
			$imagepng = imagepng($thumb, $file_path."/".$prefix.$file_name.$file_ext, 9);
		}
		else{
			$imagepng = imagepng($thumb, $file_path."/".$prefix.$file_name.$file_ext, 9, PNG_ALL_FILTERS);
		}

		$imagedestroy = imagedestroy($thumb);

		#create the thumb
		$thumb2  = imagecreatetruecolor($thumb_width, $thumb_height);
		$source2 = imagecreatefrompng( $file );
		$imgcpyrsmpld2 = imagecopyresampled( $thumb2, $source2, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height );
		
		if(version_compare(PHP_VERSION, '5.1.2' , '<')){
			$imagepng2 = imagepng($thumb2, $file_path."/".$prefix.$file_name.'_thumb'.$file_ext, 100);
		}
		elseif(version_compare(PHP_VERSION, '5.1.3' , '<')){
			$imagepng2 = imagepng($thumb2, $file_path."/".$prefix.$file_name.'_thumb'.$file_ext, 9);
		}
		else{
			$imagepng2 = imagepng($thumb2, $file_path."/".$prefix.$file_name.'_thumb'.$file_ext, 9, PNG_ALL_FILTERS);
		}
		
		$imagedestroy2 = imagedestroy($thumb2);
	}
	
	/**
     * Function returns file MIME type
     * 
     * @param filename
     * @return image file type
     */ 
	function returnMIMEType($filename)
    {
        preg_match("|\.([a-z0-9]{2,4})$|i", $filename, $fileSuffix);

        switch(strtolower($fileSuffix[1]))
        {
            case "js" :
                return "application/x-javascript";

            case "json" :
                return "application/json";

            case "jpg" :
            case "jpeg" :
            case "jpe" :
                return "image/jpg";

            case "png" :
            case "gif" :
            case "bmp" :
            case "tiff" :
                return "image/".strtolower($fileSuffix[1]);

            case "css" :
                return "text/css";

            case "xml" :
                return "application/xml";

            case "doc" :
            case "docx" :
                return "application/msword";

            case "xls" :
            case "xlt" :
            case "xlm" :
            case "xld" :
            case "xla" :
            case "xlc" :
            case "xlw" :
            case "xll" :
                return "application/vnd.ms-excel";

            case "ppt" :
            case "pps" :
                return "application/vnd.ms-powerpoint";

            case "rtf" :
                return "application/rtf";

            case "pdf" :
                return "application/pdf";

            case "html" :
            case "htm" :
            case "php" :
                return "text/html";

            case "txt" :
                return "text/plain";

            case "mpeg" :
            case "mpg" :
            case "mpe" :
                return "video/mpeg";

            case "mp3" :
                return "audio/mpeg3";

            case "wav" :
                return "audio/wav";

            case "aiff" :
            case "aif" :
                return "audio/aiff";

            case "avi" :
                return "video/msvideo";

            case "wmv" :
                return "video/x-ms-wmv";

            case "mov" :
                return "video/quicktime";

            case "zip" :
                return "application/zip";

            case "tar" :
                return "application/x-tar";

            case "swf" :
                return "application/x-shockwave-flash";

            default :
            if(function_exists("mime_content_type"))
            {
                $fileSuffix = mime_content_type($filename);
            }

            return "unknown/" . trim($fileSuffix[0], ".");
        }
    }
	
	/**
	 * Function delete's a given file
	 * 
	 * @return void
	 */
	function deleteFile(){
		$file = isset($this->data['fileName']) ? $this->data['fileName'] : null;
		$path = isset($this->data['fileRoot']) ? $this->settings['path']."/".$this->data['fileRoot'] : null;
		
		if(!is_dir($path."/".$file) && is_file($path."/".$file)){
			if(unlink($path."/".$file)){
				
				#check for a thumb
				$file_name 	= substr($file,0,strrpos($file,"."));
				$file_ext	= substr($file,strrpos($file,"."));
				
				if(is_file($path."/".$file_name."_thumb".$file_ext)){
					if(!unlink($path."/".$file_name."_thumb".$file_ext)){
						echo $this->language['ErrorRemoveingThumb'];
					}
				}
			
				echo "ok";
			}
			else{
				echo $this->language['ErrorRemoveingFile'];

			}
		}
		else{
			echo $this->language['ErrorNoFile']." `".$path."/".$file."`!";
		}		
	}
	
	/**
	 * Function delete's a given folder
	 * 
	 * @return void
	 */
	function deleteFolder(){
		$path = isset($this->data['fileRoot']) ? $this->settings['path']."/".$this->data['fileRoot'] : null;
		
		if(is_dir($path)){
		
			#empty the dir
			if ($dh = opendir($path)) {
		        while (($file = readdir($dh)) !== false) {
		        	if(is_file($path."/".$file))
		           		unlink($path."/". $file);
		        }
		        closedir($dh);
		    }
		
			if(rmdir($path)){
				echo "ok";
			}
			else{
				echo $this->language['ErrorRemovingDirectory'];
			}
		}
		else{
			echo $this->language['ErrorNoDirectory']." `".$path."`!";
		}		
	}
	
	/**
	 * Function gets the dir listning from the root
	 *
	 * @return void
	 */
	function getDirList(){		
		$ndirs = array();
		$dirs  = $this->readDirList($this->settings['path'], 1);
		$root  = null;	
		
		if(is_array($dirs)){		
			$nr = 0;
			foreach($dirs as $dir){			
				if(is_array($dir)){
					$ndirs[$nr-1] = array("0"=>$root,"1"=>$dir);
				}
				else{
					$root = $dir;
					$ndirs[$nr] = array("0"=>$root);
				}
				$nr++;
			}
			
			$this->dumpXML(array("dirlist"=>$ndirs));
		}
	}
	
	/**
	 * Function reads dir list
	 *
	 * @param location of a dir
	 * @param cuurent dir if 1 else a subdir
	 * 
	 * @ return array of dirs
	 */
	function readDirList($dir, $hd = 1)
    {
       static $i = 0;
       static $h_dir;
       $files = Array();
       $handle = opendir($dir);

       $h_dir = ($hd == 0) ? $h_dir : $dir;

       while (false !== ($file = readdir($handle)))
       {
	       if ($file != "." && $file != ".." && $file != "CVS" && $file != "" && $file{0} != "." && is_dir($dir."/".$file))
	       {
	           $files[$i++] = $file;

	           if (is_dir($dir."/".$file))
	           {
			   		if($this->readDirList($dir."/".$file, 0) != false)
	              		$files[] = $this->readDirList($dir."/".$file, 0);
	           }
	       }
	   }
	   closedir($handle);

       return !empty($files) ? $files : false;
    }
	
	/**
	 * Function gets the content of a dir
	 *
	 * @return void
	 */
	function getDirContent(){
		$dircontent = array();
		// get a array of the files in this directory
		$files = $this->readDirContent($this->settings['path'].$this->data['folderRoot']);
		
		if(is_array($files)){
			foreach($files as $file){
				$dircontent[] = $this->readFilePropertys($file);
			}
			if(isset($dircontent))
				$this->dumpXML(array("dircontent"=>$dircontent));
		}
				
		
	}
	
	/**
	 * Function reads the content of a dir (recursive!)
	 * 
	 * @param dir location
	 * 
	 * @return array of files that are in the dir
	 */
	function readDirContent($dir){
	   $i = 0;
       $files = Array();
     
       if(is_dir($dir)){
	       $handle = opendir($dir);
	
	       while (false !== ($file = readdir($handle)))
	       {
		       if ($file != "." && $file != ".." && $file != "" && $file{0} != "." && is_file($dir."/".$file) && strpos($file,"_thumb.") === false)
		       {
		       		# if we are in image mode make sure we are only displaying images!
      				if($this->data['browser'] == "images"){
		       	   		$parts = getimagesize($dir."/".$file);
		       	   		if(in_array($parts['mime'], $this->settings['allowedImageMimes']))
		       	   			$files[$i++] = substr($dir."/".$file, 1);
      				}
      				else{
      					$files[$i++] = substr($dir."/".$file, 1);
      				}
		          	
		       }
		   }
		   closedir($handle);
	
	       return $files;
       }
       
       return false;
	}
	
	/**
	 * Function reads the property's of a file
	 * 
	 * @param location of a file
	 * 
	 * @return array of fileproperty's 
	 */
	function readFilePropertys($file){
		$short_name = (strlen(basename($file)) > 48 ) ? substr(basename($file),33,12)."..." : substr(basename($file),33);
		$name 		= basename($file);
		$thumb		= dirname($file)."/".substr($name , 0, strrpos($name , "."))."_thumb".substr($name ,strrpos($name , "."));
		$type 		= $this->returnMIMEType($file);
		$fileSize 	= array_reduce ( array (" B", " KB", " MB"), create_function ( '$a,$b', 'return is_numeric($a)?($a>=1024?$a/1024:number_format($a,2).$b):$a;' ), filesize (".".$file));
		$imageSize 	= "-";
		
		list($width, $height, $mtype) = @getimagesize(".".$file);

		if(isset($mtype)){						
			$imageSize 	= $width." x ".$height." px";
		}
	
		return array("short_name"=>$short_name,
					 "name"=>$name,
					 "thumb"=>$thumb,
					 "type"=>$type,
					 "fileSize"=>$fileSize,
					 "imageSize"=>$imageSize,
					);
	}
	
	/**
	 * Function prints data in XML format
	 *
	 * @param array of lines to display
	 * @return void
	 */
	function dumpXML($array){			
	
		# check if we need to use PHP4 domxml_new_doc or PHP5 DOM or else we will do it manualy
		if(function_exists("DOMDocument") === true){
			#create XML the PHP5 way
			$xmlDoc = new DOMDocument("1.0");
			$xmlDoc->preserveWhiteSpace = false;
			$xmlDoc->encoding='utf-8';
			
			$this->createXMLNodePHP5($xmlDoc, $array);
			
			header("Content-type: text/xml");
			
			echo $xmlDoc->saveXML();
		}		
		elseif(function_exists("domxml_new_doc") === true && version_compare(phpversion(),5,"<")){		
			#create XML the PHP4 way
			$xmlDoc = domxml_new_doc("1.0");
			
			$this->createXMLNodePHP4($xmlDoc, $array);
		
			header("Content-type: text/xml");
			
			echo $xmlDoc->dump_mem(false, 'UTF-8');
		}
		else{
			header("Content-type: text/xml");
			echo $this->createXML($array);
		}
				
	}
	
	/**
	 * Recursive XML node creation (PHP4)
	 *
	 * @param xmlDoc ref
	 * @param array of keys
	 * @param optional element to append to
	 * 
	 * @return void
	 */
	function createXMLNodePHP4($xmlDoc, $array, $refer=null){
		$element = "";
		$text 	 = "";

		foreach($array as $key => $val ){
			$element = 	$xmlDoc->create_element("Archiv_".$key);
			
			if(!is_array($val)){
				$text = $xmlDoc->create_text_node($val);
				$element->append_child($text);				
				
				$refer->append_child($element);			
			}
			else{
				$this->createXMLNodePHP4($xmlDoc, $val, $element);
				
				if($refer == null){
					$xmlDoc->append_child($element);
				}
				else{
					$refer->append_child($element);
				}
			}								
		}
	}
	
	/**
	 * Recursive XML node creation (PHP5)
	 *
	 * @param xmlDoc ref
	 * @param array of keys
	 * @param optional element to append to
	 * 
	 * @return void
	 */
	function createXMLNodePHP5($xmlDoc, $array, $refer=null){
		$element = "";
		$text 	 = "";

		foreach($array as $key => $val ){
			$element = 	$xmlDoc->createElement("Archiv_".$key);
			
			if(!is_array($val)){
				$text = $xmlDoc->createTextNode($val);
				$element->appendChild($text);				
				
				$refer->appendChild($element);			
			}
			else{
				$this->createXMLNodePHP5($xmlDoc, $val, $element);
				
				if($refer == null){
					$xmlDoc->appendChild($element);
				}
				else{
					$refer->appendChild($element);
				}
			}								
		}
	}
	
	/**
	 * Recursive XML node creation (Manualy)
	 *
	 * @param array of keys
	 * 
	 * @return void
	 */
	 function createXML($array){
		$element = "";
		$text 	 = "";

		foreach($array as $key => $val ){
			$element .= 	"<Archiv_".$key.">";
			
			if(!is_array($val)){
				$element .= $val;			
			}
			else{
				$element .= $this->createXML($val);
			}
			$element .= "</Archiv_".$key.">";
		}
		
		return $element;
	 }
}

$Archiv = new Archiv;
?>