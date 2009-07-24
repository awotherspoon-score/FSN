<?php

session_start();

if(!$_SESSION['logged_in']=='798hJR31')
{
	header("Location: http://www.scorecomms.com/fsn/admin/index.php");
}

error_reporting(0);

$admin=1;
$admin_page='courses';

include_once("../includes/connect.php");
include_once("../includes/functions.php");

$course_id = $_GET['course_id'];

$get_course = mysql_query("SELECT * FROM courses WHERE course_id=$course_id");

$course_info = mysql_fetch_array($get_course);

extract($course_info);

$course_category=$course_type;

if(@$_POST['preview']){
	
	$course_title = $_POST['course_title'];
	$course_meta_desc = $_POST['course_meta_desc'];
	$course_meta_keyw = $_POST['course_meta_keyw'];
	$course_day = $_POST['course_day'];
	$course_month = $_POST['course_month'];
	$course_year = $_POST['course_year'];
	$course_date = mktime(0,0,0,$course_month,$course_day,$course_year);
	$course_details = $_POST['course_details'];
	$course_content = $_POST['course_content'];
	$course_programme = $_POST['course_programme'];
	$course_code = $_POST['course_code'];
	/*$course_category = $_POST['course_category'];
	$course_sector = $_POST['course_sector'];
	$course_ma = $_POST['course_ma'];
	$course_hide = $_POST['course_hide'];
	
	$course_img_s = $_POST['course_img_s'];
	$course_img_l = $_POST['course_img_l'];*/
	
}elseif(@$_POST['submit']){
	
	if(!$course_title = htmlspecialchars($_POST['course_title'],ENT_QUOTES)){
		$error['title']=1;
	}else{
		$search = array('&amp;','&quot;','&#039;','&lt;','&gt;',',','.','<','>','\'','"','&',';',':','?','!','\\','/','|','£','¬','$','%','^','*','(',')','+','=','`','¦','#','~','@','[',']','{','}');
		$replace = '';
		$course_slug = str_replace(' ','_',preg_replace('/\s\s+/', ' ',trim(str_replace(array('_','-'),' ',str_replace($search,$replace,strip_tags($course_title))))));
	}
	/*if(!$course_meta_desc = $_POST['course_meta_desc']){
		$error['meta_desc']=1;	
	}
	if(!$course_meta_keyw = $_POST['course_meta_keyw']){
		$error['meta_keyw']=1;	
	}
	if(!$course_date = $_POST['course_date']){
		$error['date']=1;	
	}*/
	if(!$course_content = $_POST['course_content']){
		$error['content']=1;	
	}
	/*if(!$course_sector = $_POST['course_sector']){
		$error['sector']=1;	
	}
	if(!$course_category = $_POST['course_category']){
		$error['category']=1;	
	}*/
	
	/*$course_img = $_FILES['course_img']['name'];*/
	$course_meta_desc = $_POST['course_meta_desc'];
	$course_meta_keyw = $_POST['course_meta_keyw'];
	$course_code = $_POST['course_code'];
	$course_details = $_POST['course_details'];
	$course_programme = $_POST['course_programme'];
	$course_hide = $_POST['course_hide'];
	
	if(!$error){
		
		$insert_course_meta_desc = mysql_escape_string(strip_tags($course_meta_desc));
		$insert_course_meta_keyw = mysql_escape_string(strip_tags($course_meta_keyw));
		$insert_course_title = mysql_escape_string(strip_tags($course_title));
		$insert_course_code = mysql_escape_string(strip_tags($course_code));
		$insert_course_date = mysql_escape_string($course_date);
		$insert_course_details = mysql_escape_string(strip_tags($course_details,'<p><a><h1><h2><h3><h4><strong><ul><ol><li><table><tbody><td><tr><br>'));
		$insert_course_content = mysql_escape_string(strip_tags($course_content,'<p><em><a><img><h1><h2><h3><h4><strong><ul><ol><li><table><tbody><td><tr><br>'));
		$insert_course_programme = mysql_escape_string(strip_tags($course_programme,'<p><em><a><img><h1><h2><h3><h4><strong><ul><ol><li><table><tbody><td><tr><br>'));
		/*$insert_course_sector = mysql_escape_string($course_sector);
		$insert_course_category = mysql_escape_string($course_category);
		$insert_course_img = mysql_escape_string($course_img);*/
		/*$insert_course_slug = mysql_escape_string($course_slug);
		$insert_course_hide = mysql_escape_string($course_hide);*/
		
		/*echo $insert_course_meta_desc;
		echo "<br />";
		echo $insert_course_meta_keyw;
		echo "<br />";
		echo $insert_course_title;
		echo "<br />";
		echo $insert_course_date;
		echo "<br />";
		echo $insert_course_intro;
		echo "<br />";
		echo $insert_course_content;
		echo "<br />";
		echo $insert_course_sector;
		echo "<br />";
		echo $insert_course_category;
		echo "<br />";
		echo $insert_course_img;
		echo "<br />";
		echo $insert_course_slug;
		echo "<br />";
		echo $insert_course_hide;*/
		
		$update_course = mysql_query("UPDATE courses SET course_meta_desc='$insert_course_meta_desc', course_meta_keyw='$insert_course_meta_keyw', course_title='$insert_course_title', course_date='$insert_course_date', course_code='$insert_course_code', course_details='$insert_course_details', course_content='$insert_course_content', course_programme='$insert_course_programme' WHERE course_id='$course_id' ");
		
		if($update_course)
		{
			$status['good']="the course '$course_title' has been updated";
			
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
	
	$course_date = time();
}*/

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FSN ~ Admin Panel ~ Add course</title>

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
	plugins : "spellchecker,table,paste,Archiv",
	//theme_advanced_buttons3_add : "spellchecker",
	Archiv_settings_file : "config.php",
	theme_fsn_buttons1 : "code,|,bold,italic,underline,|,formatselect,|,justifyleft,justifycenter,justifyright,|,bullist,numlist,|,outdent,indent,|,link,unlink,Archiv_files,Archiv_images,image,anchor,charmap,|,undo,redo,cut,copy,paste,pasteword",
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
			
			<form action="<?php echo $_SERVER['PHP_SELF']."?course_id=$course_id"; ?>" method="post" enctype="multipart/form-data" name="course_form">
			
			<?php
				if($error['title']==1){
					
				}
			?>
			<div class="form-container<?php if($error['title']==1){ echo " error";	}?>">
			<label for="course_title">Course Title: </label><input type="text" value="<?php echo $course_title; ?>" name="course_title" id="course_title" class="title" />
			</div>
			<div class="form-container<?php if($error['code']==1){ echo " error";	}?>">
			<label for="course_code">Course Code: </label><input type="text" value="<?php echo $course_code; ?>" name="course_code" id="course_code" class="code" />
			</div>
			<div class="form-container<?php if($error['meta_desc']==1){ echo " error";	}?>">
			<label for="course_meta_desc">Course Meta Description: </label><textarea type="text" name="course_meta_desc" id="course_meta_desc" class="description"><?php echo $course_meta_desc; ?></textarea>
			</div>
			<div class="form-container<?php if($error['meta_keyw']==1){ echo " error";	}?>">
			<label for="course_meta_keyw">Course Meta Keywords: </label><input type="text" value="<?php echo $course_meta_keyw; ?>" name="course_meta_keyw" id="course_meta_keyw" class="keywords" />
			</div>
			<!--<div class="form-container<?php if($error['date']==1){ echo " error";	}?>">
			<label for="course_day">Course Date: </label>
			<select name="course_day" id="course_day" class="date">
			<?php
			$x=1;
			while($x<=31)
			{
			?>
				<option value="<?php echo $x; ?>" <?php if(date('d',$course_date)==$x){ echo 'selected="selected"'; } ?>><?php echo $x; ?></option>
			<?php
			$x++;
			}
			?>
			</select>
			<select name="course_month" id="course_month" class="month">
			<?php
			$x=1;
			while($x<=12)
			{
			?>
				<option value="<?php echo $x; ?>" <?php if(date('n',$course_date)==$x){ echo 'selected="selected"'; } ?>><?php echo date('F',mktime(0,0,0,$x,1,2009)); ?></option>
			<?php
			$x++;
			}
			?>
			</select>
			<select name="course_year" id="course_year" class="date">
			<?php
			$x=2000;
			while($x<=2020)
			{
			?>
				<option value="<?php echo $x; ?>" <?php if(date('Y',$course_date)==$x){ echo 'selected="selected"'; } ?>><?php echo $x; ?></option>
			<?php
			$x++;
			}
			?>
			</select>
			</div>-->

			<div class="form-container<?php if($error['intro']==1){ echo " error";	}?>">
			<label for="course_intro">Course Details: </label><textarea name="course_details" id="course_details" class="intro"><?php echo $course_details; ?></textarea>
			</div>
			<div class="form-container<?php if($error['content']==1){ echo " error";	}?>">
			<label for="course_content">Course Content: </label><textarea name="course_content" id="course_content" class="content"><?php echo $course_content; ?></textarea>
			</div>
			<div class="form-container<?php if($error['content']==1){ echo " error";	}?>">
			<label for="course_content">Course Programme: </label><textarea name="course_programme" id="course_programme" class="prog"><?php echo $course_programme; ?></textarea>
			</div>
			<div class="form-container">
			<input type="submit" value="preview course" name="preview" id="course_preview" onclick="course_form.action='preview_course.php'" />
			<input type="submit" value="edit course" name="submit" id="course_submit" />
			</div>
			</form>
		
				<div style="clear:both;"></div>
		
			</div>
		
		</div>
		
		</div>
		
		<div class="bottom-round"><div class="bottom-left"></div></div>

</body>
</html>