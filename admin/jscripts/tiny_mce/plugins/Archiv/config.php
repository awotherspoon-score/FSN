<?php
/**
 * Archiv settings file
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

# Main settings vars
$s_js 	= array();
$s 		= array();

# javascript settings
$s_js['connector'] 			= "php/connector.php";					# relative path to connector file
$s_js['path']				= "upload/images";						# absolute path to the root of your upload dir
$s_js['files'] 				= "*";									# files to accept in filemanager (* = all)
$s_js['image_files'] 		= "*";									# files to accept in the image filemanager (* = all)
$s_js['file_size_limit'] 	= "500"; 								# max filesize (50 mb)
$s_js['file_upload_limit'] 	= "0";									# maximum file to upload at once (0 = infinite)
$s_js['debug'] 				= "true";								# maximum file to upload at once (0 = infinite)

# php settings
$s['security_level']		= 0; 									# 0 = off 		(no check, not reccomended)
																	# 1 = low 		(passphrase check) 
																	# 2 = medium 	(ip check) 
																	# 3 = high 		(password protected)  
																	# 4 = high 		(coockie object)  
$s['security_passphrase']	= "mypassphrase";						# if security_level is 1
$s['security_ips_allowed']	= array("192.168.0.100");				# if security_level is 2
$s['security_password']		= array("mypassword");					# if security_level is 3
$s['security_coockie_obj']	= array("object_name"=>"allow_archiv",	# if security_level is 4
									"object_value"=>"1");														
$s['path'] 					= "../../../../../upload/images"; 		# path to images
$s['max_image_size']		= 600; 									# max image size (width or height)
$s['max_thumb_size']		= 100; 									# max thumb image size (width or height)
$s['allowedFileMimes']		= array('application/x-javascript',		# mime types of allowed files
									'application/json',
									'image/jpg',
									'image/png',
									'image/gif',
									'image/bmp',
									'image/tiff',
									'text/css',
									'application/xml',
									'application/msword',
									'application/vnd.ms-excel',
									'application/vnd.ms-powerpoint',
									'application/rtf',
									'application/pdf',
									'text/html',
									'text/plain',
									'video/mpeg',
									'audio/mpeg3',
									'audio/wav',
									'audio/aiff',
									'video/msvideo',
									'video/x-ms-wmv',
									'video/quicktime',
									'application/zip',
									'application/x-tar',
									'application/x-shockwave-flash');
$s['allowedImageMimes'] 	= array('image/jpg', 					# mime types of allowed images
									'image/jpeg', 
									'image/png', 
									'image/gif');  
$s['language']				= "en"; 								# according to the /langs/<language>.php file

 ###########################################
 ###########################################
## 				! WARNING !					##
##											##
##       Do not edit from this point!		##
 ############################################
 ############################################

# Build the XML config if required
if(isset($_GET['js'])){
	$s_js['security_passphrase'] 	= md5($s['security_passphrase'].$_SERVER['REMOTE_ADDR']);
	$s_js['security_level'] 		= $s['security_level'];
	require_once($s_js['connector']);
	$Archiv->settings = $s_js;
	$Archiv->displaySettings();
}
# Else set the settings
else{
	$this->settings = $s;
}
?>