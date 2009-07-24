<?php

include_once("includes/connect.php");
include_once("includes/functions.php");

/*$filter = $_GET['filter'];
$section = $_GET['section'];*/
$page_id = $_GET['page'];
		
$get_page = mysql_query("SELECT * from pages WHERE page_id='$page_id'");
$page_info = mysql_fetch_array($get_page);

extract($page_info);

$page = $page_title;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FSN ~ <?php echo $page_title; ?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/style/layout.css" />

<script type="text/javascript" src="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/includes/jquery.js"></script>

</head>

<body>

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
	
				</div>
	
				<div id="main-content">
				
					<div id="page-header">
						<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
						<div id="page-header-content"><?php echo strtoupper($page_title); ?></div>
						<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
					</div>
						
					<div id="page-container">
						
						<?php echo $page_content; ?>
					
					</div>
					
					<div style="clear:both;"></div>
					
				</div>
		
			</div>
			
		</div>
		
		</div>
		
		<div class="bottom-round"><div class="bottom-left"></div></div>
	
		<?php include("includes/footer.php"); ?>

</body>
</html>