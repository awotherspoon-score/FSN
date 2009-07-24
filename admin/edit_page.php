<?php

session_start();

if(!$_SESSION['logged_in']=='798hJR31')
{
	header("Location: http://www.scorecomms.com/fsn/admin/index.php");
}

error_reporting(0);

$admin=1;
$admin_page='pages';

include_once("../includes/connect.php");
include_once("../includes/functions.php");

$page_id = $_GET['page_id'];

$get_page = mysql_query("SELECT * FROM pages WHERE page_id=$page_id");

$page_info = mysql_fetch_array($get_page);

extract($page_info);

$page_category=$page_type;

if(@$_POST['submit']){
	
	if(!$page_title = htmlspecialchars($_POST['page_title'],ENT_QUOTES)){
		$error['title']=1;
	}else{
		$search = array('&amp;','&quot;','&#039;','&lt;','&gt;',',','.','<','>','\'','"','&',';',':','?','!','\\','/','|','£','¬','$','%','^','*','(',')','+','=','`','¦','#','~','@','[',']','{','}');
		$replace = '';
		$page_slug = str_replace(' ','_',preg_replace('/\s\s+/', ' ',trim(str_replace(array('_','-'),' ',str_replace($search,$replace,strip_tags($page_title))))));
	}
	/*if(!$page_meta_desc = $_POST['page_meta_desc']){
		$error['meta_desc']=1;	
	}
	if(!$page_meta_keyw = $_POST['page_meta_keyw']){
		$error['meta_keyw']=1;	
	}*/
	/*if(!$page_date = $_POST['page_date']){
		$error['date']=1;	
	}
	if(!$page_content = $_POST['page_content']){
		$error['content']=1;	
	}*/
	/*if(!$page_sector = $_POST['page_sector']){
		$error['sector']=1;	
	}
	if(!$page_category = $_POST['page_category']){
		$error['category']=1;	
	}*/
	
	$page_meta_desc = $_POST['page_meta_desc'];
	$page_meta_keyw = $_POST['page_meta_keyw'];
	$page_content = $_POST['page_content'];
	
	/*$page_img = $_FILES['page_img']['name'];
	$page_intro = $_POST['page_intro'];
	$page_hide = $_POST['page_hide'];*/
	
	if(!$error){
		
		$insert_page_meta_desc = mysql_escape_string(strip_tags($page_meta_desc));
		$insert_page_meta_keyw = mysql_escape_string(strip_tags($page_meta_keyw));
		$insert_page_title = mysql_escape_string(strip_tags($page_title));
		$insert_page_date = mysql_escape_string($page_date);
		$insert_page_intro = mysql_escape_string(strip_tags($page_intro,'<p><a><img><h1><h2><h3><h4><strong><ul><ol><li>'));
		$insert_page_content = mysql_escape_string(strip_tags($page_content,'<p><em><a><img><h1><h2><h3><h4><strong><ul><ol><li>'));
		$insert_page_sector = mysql_escape_string($page_sector);
		$insert_page_category = mysql_escape_string($page_category);
		$insert_page_img = mysql_escape_string($page_img);
		/*$insert_page_slug = mysql_escape_string($page_slug);
		$insert_page_hide = mysql_escape_string($page_hide);*/
		
		/*echo $insert_page_meta_desc;
		echo "<br />";
		echo $insert_page_meta_keyw;
		echo "<br />";
		echo $insert_page_title;
		echo "<br />";
		echo $insert_page_date;
		echo "<br />";
		echo $insert_page_intro;
		echo "<br />";
		echo $insert_page_content;
		echo "<br />";
		echo $insert_page_sector;
		echo "<br />";
		echo $insert_page_category;
		echo "<br />";
		echo $insert_page_img;
		echo "<br />";
		echo $insert_page_slug;
		echo "<br />";
		echo $insert_page_hide;*/
		
		$update_page = mysql_query("UPDATE pages SET page_meta_desc='$insert_page_meta_desc', page_meta_keyw='$insert_page_meta_keyw', page_title='$insert_page_title', page_content='$insert_page_content' WHERE page_id='$page_id' ");
		
		if($update_page)
		{
			$status['good']="the page '$page_title' has been updated";
			
		}else
		{			
			if(mysql_error())
			{
				$status['bad'] = "mysql_error()";
			}else
			{
				$status['bad'] = "You need to fill out all the data highlighted";
			}
		}
	
	}
	
}/*else{
	
	$page_date = time();
}*/

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FSN ~ Admin Panel ~ Edit Page</title>

<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/style/layout.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/style/admin.css" />

<script type="text/javascript" src="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/admin/jscripts/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript">
/*tinyMCE_GZ.init({
	plugins : 'spellchecker,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,'+ 
        'searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras',
	languages : 'en',
	disk_cache : true,
	debug : false
});*/
</script>

<script type="text/javascript">
tinyMCE.init({
	theme : 'fsn',
	plugins : "spellchecker,table,paste,Archiv",
	//theme_advanced_buttons3_add : "spellchecker",
	Archiv_settings_file : "config.php",
	theme_fsn_buttons1 : "code,|,bold,italic,underline,|,formatselect,|,justifyleft,justifycenter,justifyright,|,bullist,numlist,|,outdent,indent,|,link,unlink,Archiv_files,Archiv_images,image,anchor,charmap,|,undo,redo,cut,copy,paste,pasteword",
	theme_fsn_buttons2 : "tablecontrols",
	theme_fsn_blockformats : "p,h2,h4",
	spellchecker_languages : "+English=en",
	mode : "exact",
	elements : "page_content"
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
			
			<form action="<?php echo $_SERVER['PHP_SELF']."?page_id=$page_id"; ?>" method="post" enctype="multipart/form-data">
			
			<?php
				if($error['title']==1){
					
				}
			?>
			<div class="form-container<?php if($error['title']==1){ echo " error";	}?>">
			<label for="page_title">Page Title: </label><input type="text" value="<?php echo $page_title; ?>" name="page_title" id="page_title" class="title" />
			</div>
			<div class="form-container<?php if($error['meta_desc']==1){ echo " error";	}?>">
			<label for="page_meta_desc">Page Meta Description: </label><textarea type="text" name="page_meta_desc" id="page_meta_desc" class="description"><?php echo $page_meta_desc; ?></textarea>
			</div>
			<div class="form-container<?php if($error['meta_keyw']==1){ echo " error";	}?>">
			<label for="page_meta_keyw">Page Meta Keywords: </label><input type="text" value="<?php echo $page_meta_keyw; ?>" name="page_meta_keyw" id="page_meta_keyw" class="keywords" />
			</div>
			
			<div class="form-container<?php if($error['content']==1){ echo " error";	}?>">
			<label for="page_content">Page Content: </label><textarea name="page_content" id="page_content" class="content"><?php echo $page_content; ?></textarea>
			</div>
			
			<div class="form-container">
			<input type="submit" value="edit page" name="submit" id="page_submit" />
			</div>
			</form>
		
				<div style="clear:both;"></div>
		
			</div>
		
		</div>
		
		</div>
		
		<div class="bottom-round"><div class="bottom-left"></div></div>

</body>
</html>