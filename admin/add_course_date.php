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
	
	$course_code = $_POST['course_code'];
	
	$course_day = $_POST['course_day'];
	$course_month = $_POST['course_month'];
	$course_year = $_POST['course_year'];
	$course_date = mktime(0,0,0,$course_month,$course_day,$course_year);
	
	if(!$error){
		
		$insert_course_code = mysql_escape_string(strip_tags($course_code));
		$insert_course_date = $course_date;
		
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
		
		$add_course = mysql_query("INSERT INTO course_dates (course_date_id, course_code, course_date) VALUES ('','$insert_course_code','$insert_course_date')");
		
		if($add_course)
		{
			$status['good']="new date for '$course_code' has been added";
			
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
			<label for="course">Course: </label>
			<select name="course_code" id="course_code" class="course">
			<?php
			$get_courses = mysql_query("SELECT course_code,course_title FROM courses ORDER BY course_code ASC");
			
			while($course_details=mysql_fetch_array($get_courses))
			{
				
			extract($course_details);
			?>
				<option value="<?php echo $course_code; ?>" <?php if($course==$course_code){ echo 'selected="selected"'; } ?>><?php echo $course_code." - ".$course_title; ?></option>
			<?php
			
			}
			?>
			</select>
			</div>
			<div class="form-container<?php if($error['date']==1){ echo " error";	}?>">
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
			</div>

			<div class="form-container">
			
			<input type="submit" value="add course date" name="submit" id="course_submit" />
			</div>
			</form>
		
				<div style="clear:both;"></div>
		
			</div>
		
		</div>
		
		</div>
		
		<div class="bottom-round"><div class="bottom-left"></div></div>

</body>
</html>