<?php

session_start();

if(!$_SESSION['logged_in']=='798hJR31')
{
	header("Location: http://www.scorecomms.com/fsn/admin/index.php");
}

$admin=1;
$admin_page='pages';

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
									<h3>ALL PAGES</h3>
									<div style="clear:both;"></div>
								</div>
							</div>
							<div class="channel-content">
							
								<ul>
							
								<?php
								
								$get_pages = mysql_query("SELECT * FROM pages WHERE page_title!='courses'");
								
								while($page_info = mysql_fetch_array($get_pages)){
									
									extract($page_info);
									
									?>
								
									<li><a href="edit_page.php?page_id=<?php echo $page_id; ?>"><?php echo $page_title; ?></a></li>
									
									<?php
									
								}
								
								?>
								
								</ul>
								
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
		<div style="clear:both;"></div>
		</div>
		
		<div class="bottom-round"><div class="bottom-left"></div></div>
		
</body>
</html>