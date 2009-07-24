<?php

session_start();

if(!$_SESSION['logged_in']=='798hJR31')
{
	header("Location: http://www.scorecomms.com/fsn/admin/index.php");
}

$admin=1;
$admin_page='courses';

include_once("../includes/connect.php");
include_once("../includes/functions.php");

if(@$_GET['filter']){
	$filter = $_GET['filter'];
}else{
	$filter='';	
}
if(@$_GET['section']){
	$section = $_GET['section'];
}else{
	$section='';	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FSN ~ edit pages</title>

<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/style/layout.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/style/admin.css" />

<script type="text/javascript" src="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/includes/jquery.js"></script>

<script type="text/javascript">

$(document).ready(function(){
						   
	$('#course-list li .sector-tag-container a').click(function(e){
		e.preventDefault();
		var check = confirm("Are you sure you want to delete this article?");
		var course_id =  $(this).attr("class");
		if(check)
		{
			$.post("delete_item.php",
				{
					type:  'course',
					id:  course_id
				},
				function(data)
				{
					if(data['done']=='true')
					{
						$('#course_'+course_id).hide();
					}else
					{
						alert("couldn't delete, try again");
					}
				},"json"
			
			);
		}
	});
	
	$('#course-date-list li .sector-tag-container a').click(function(e){
		e.preventDefault();
		var check = confirm("Are you sure you want to delete this article?");
		var course_date_id =  $(this).attr("class");
		if(check)
		{
			$.post("delete_item.php",
				{
					type:  'course_date',
					id:  course_date_id
				},
				function(data)
				{
					if(data['done']=='true')
					{
						$('#course_date_'+course_date_id).hide();
						if(data['date']){
							$('#'+data['date']).hide();
						}
					}else
					{
						alert("couldn't delete, try again");
					}
				},"json"
			
			);
		}
	});
	
});

</script>

</head>

<body>

	<div id="background-wrapper">
	
		<div class="container">
		
			<?php include("includes/admin_nav.php"); ?>	
		
			<div id="main-holder">
	
				<div id="main-content">
				
				<div class="admin-full" id="channel-container">
					
						<div class="channel-section section-full">
							<div class="channel-header <?php echo $section; ?>">
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div class="channel-header-content">
									<h3>ALL COURSES</h3>
									<div class="title-right">
										<a href="add_course.php">add new course &raquo;</a><span style="float:left;"> | </span><a href="add_course_date.php">add course date &raquo;</a>
									</div>
									<div style="clear:both;"></div>
								</div>
							</div>
							<div class="channel-content">
								<div class="current_courses">
									<h2>CURRENT COURSES</h2>
									<ul id="course-list">
					
									<?php
									
									$get_courses = mysql_query("SELECT * FROM courses ORDER BY course_title ASC");
									
									while($course_info = mysql_fetch_array($get_courses)){
										
										extract($course_info);
										
									?>
									
										<li id="course_<?php echo $course_id; ?>" class="<?php echo $course_id; ?>">
										<a href="edit_course.php?course_id=<?php echo $course_id; ?>" style="display:inline-block;width:400px;*width:395px;vertical-align:top;"><?php echo $course_title; ?></a>
										<span class="sector-tag-container" style="width:52px !important;">
											<a style="display:inline-block;" class="<?php echo $course_id; ?>" href="#">
												<div class="sector-tag" style="width:52px;">
													<div class="tag-top-corners"><div class="tag-corner-top-left"></div></div>
													<div class="sector-tag-content">delete</div>
													<div class="tag-bottom-corners"><div class="tag-corner-bottom-left"></div></div>
												</div>
											</a>
										</span>
										
										</li>
									
									<?php
										
									}
									
									?>
									
									</ul>
																		
								</div>
								
								<div class="course_dates">
									<h2>CURRENT DATES</h2>
									<ul id="course-date-list">
									<?php
									
									$current_date = mktime(0,0,0,date('m'),date('d'),date('Y'));
		
																
									$get_courses = mysql_query("SELECT * FROM course_dates WHERE course_date>=$current_date ORDER BY course_date ASC");
									
									while($course_info = mysql_fetch_array($get_courses))
									{
									extract($course_info);
									
									if($course_date!=@$prev_date){
										?>
										
										<li id="<?php echo date("dmy",$course_date); ?>" class="article-date"><?php echo date("d M y",$course_date); ?></li>
										
										<?php
									}
									
									$get_course_details = mysql_query("SELECT * FROM courses WHERE course_code='$course_code'");
									
									$course_details = mysql_fetch_array($get_course_details);
									
									$course_title = $course_details['course_title'];
									
									?>
									
									<li id="course_date_<?php echo $course_date_id; ?>" class="<?php echo $course_date_id; ?>">
									
										<strong style="display:inline-block;width:350px;*width:345px;vertical-align:top;"><?php echo $course_code; ?> - <?php echo $course_title; ?></strong>
										
										<span class="sector-tag-container" style="width:52px !important;">
												<a style="display:inline-block;" class="<?php echo $course_date_id; ?>" href="#">
													<div class="sector-tag" style="width:52px;">
														<div class="tag-top-corners"><div class="tag-corner-top-left"></div></div>
														<div class="sector-tag-content">delete</div>
														<div class="tag-bottom-corners"><div class="tag-corner-bottom-left"></div></div>
													</div>
												</a>
											</span>
										
									</li>
								<?php
								
									$prev_date = $course_date;
									
									}
									
									?>
									</ul>
								</div>
								
								<div style="clear:both;"></div>
												
							</div>
						</div>
						
					</div>
				
					
				
					<!--<div id="current-channel-container">
					
						<div class="channel-section channel-col1 show-full">
							<div class="channel-header">
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div class="channel-header-content">
									<h3>ALL PAGES</h3><div class="title-right"></div>
									<div style="clear:both;"></div>
								</div>
							</div>
							<div class="channel-content">
								<ul>
									<?php
									
									#get_admin_articles($filter,$section);
									
																		
									
									?>
								</ul>					
							</div>
						</div>
						
					</div>-->
					
				</div>
		
			</div>
			
		</div>
		
		</div>
		
		<div class="bottom-round"><div class="bottom-left"></div></div>
		
</body>
</html>