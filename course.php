<?php

include_once("includes/connect.php");
include_once("includes/functions.php");

if(@!$_GET['offset']){
	$offset = 1;
}else{
	$offset = $_GET['offset'];
}

if(@$course_code = $_GET['course_code']){

	$get_course = mysql_query("SELECT * from courses WHERE course_code='$course_code'");
	$course_info = mysql_fetch_array($get_course);
	
	extract($course_info);

}

$page = 'courses';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FSN ~ Courses <?php if(@$course_code){ echo " ~ ".$course_title; } ?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/style/layout.css" />

<script type="text/javascript" src="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/includes/jquery.js"></script>

</head>

<body>

	<a name="top"></a>

	<div id="background-wrapper">
	
		<div class="container">
		
			<div id="header">
				<?php include("includes/header.php"); ?>
			</div>
		
			<div id="main-holder">
			
				<div id="left">
			
					<?php include("includes/channel_nav.php"); ?>
					
					<div id="advertisements">

						<?php
					
					# article_id, page_name, section_name, ad_type
					
					get_adverts('',$page,'','side');
					
					?>
					
					</div>
					
				</div>
					
				<div id="upper-content">
					
					<?php
					
					# article_id, page_name, section_name, ad_type
					
					get_adverts('',$page,'','banner');
					
					?>
					
					<!--<div id="latest-articles">
						<div id="section-header-half"<?php if($article_sector=="market_analysis"){echo ' class="section-'.str_replace('_','-',$article_sector).'"';} ?>>
						
							<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/channel_".$article_sector; ?>">
							
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div id="section-header-content"><?php
								
									$get_section_title = mysql_query("SELECT section_plural,section_singular from sections WHERE section_alias='$article_sector'");
									
									$section_info = mysql_fetch_array($get_section_title);
								
									echo $section_info['section_singular'];
								
								?></div>
								<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
							
							</a>
							
						</div>
						
						<div style="width:10px;height:10px;float:left;"></div>
						
						<div id="section-header-half"<?php echo " class=\"section-$article_type\""; ?>>
							<?php
								
									$get_section_title = mysql_query("SELECT section_plural,section_singular from sections WHERE section_alias='$article_type'");
									
									$section_info = mysql_fetch_array($get_section_title);
								
								?>
								
							<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/channel_".strtolower(str_replace(" ","_",$section_info['section_plural'])); ?>">
							
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div id="section-header-content"><?php echo $section_info['section_singular']; ?></div>
								<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
								
							</a>
							
						</div>-->
						
					</div>
					
					<div id="current-channel-container">
					
						<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/courses">
							<div id="page-header">
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div id="page-header-content">COURSES</div>
								<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
							</div>
						</a>
												
						<?php if($course_code)
						{
						
							$get_course = mysql_query("SELECT * FROM courses WHERE course_code='$course_code'");
							$course_info = mysql_fetch_array($get_course);
							
							extract($course_info);
	
							?>
						
							<h1><?php echo $course_title; ?></h1>
							
							<div id="available-courses-container">
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
							
								<div id="available-courses-content">
														
									<p><strong>BOOK NOW: CALL 020 8445 2688</strong> quoting your desired course code from the list below</p>
									
									<h2>AVAILABLE COURSES</h2>							
									
									<?php
									
									$current_date = mktime(0,0,0,date('m'),date('d'),date('Y'));
									
									$get_course_dates = mysql_query("SELECT * FROM course_dates WHERE course_code='$course_code' AND course_date>=$current_date");
									
									while($course_dates_info = mysql_fetch_array($get_course_dates))
									{
									
									extract($course_dates_info,EXTR_PREFIX_ALL,"dates");
									
									?>
									
									<div id="course-date">Course Date: <strong><?php echo date("jS F Y",$dates_course_date); ?></strong></div>
									
									<div id="course-code">Course Code: <strong><?php echo $course_code."-".date('d',$dates_course_date)."-".date('m',$dates_course_date); ?></strong></div>
									
								<?php } ?>
								
								<div style="clear:both"></div>
								
								</div>
								
								
							
								<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
						
							</div>
							
							<h2>COURSE DETAILS</h2>		
											
							<div id="course-details"><?php echo $course_details; ?></div>
							<div id="course-content"><?php echo $course_content; ?></div>
							
							<div id="course-programme">
								<h2>DETAILED PROGRAMME</h2>
								<?php echo $course_programme; ?>
							</div>
						
						<?php
						
						}else
						{
							
						?>
						
						<div class="channel-section channel-col1 show-full">
							<div class="channel-content">
								<ul>
									<?php get_courses($offset); ?>			
								</ul>
							</div>
						</div>
						
					<?php } ?>

					</div>
					
					<div style="display:inline-block;width:500px;height:1px;line-height:1px;font-size:1px;"></div>
					
				</div>
	
				<div id="main-content">
				
					<?php include("includes/channel_preview.php"); ?>
					
				</div>
		
			</div>
			
		</div>
		
		</div>
		
		<div class="bottom-round"><div class="bottom-left"></div></div>
	
		<?php echo get_footer(); ?>

</body>
</html>