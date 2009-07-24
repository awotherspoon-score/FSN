<?php

include_once("includes/connect.php");
include_once("includes/functions.php");

$page = 'home';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FSN ~ home</title>

<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/style/layout.css" media="screen" />
<!--<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/style/layout2.css" media="screen" />-->
<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/style/print.css" media="print" />

<script type="text/javascript" src="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/includes/jquery.js"></script>

<script type="text/javascript" src="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/includes/feature_scroller.js"></script>

</head>

<body>

	<div id="background-wrapper">
	
		<div class="container">
		
			<div id="header">
				<?php include("includes/header.php"); ?>
			</div>
			
			<?php #include("includes/main_nav.php"); ?>	
		
			<div id="main-holder">
			
				<div id="left">
				
					<?php include("includes/channel_nav.php"); ?>
					
				</div>
					
				<div id="upper-content">
					
					<div id="top-banner"><img src="https://www.google.com/adsense/static/en_GB/images/leaderboard_img.jpg" width="728" height="90"/></div>
					
					<object width="400" height="320"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=5680113&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00adef&amp;fullscreen=1" /><embed src="http://vimeo.com/moogaloop.swf?clip_id=5680113&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00adef&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="400" height="320"></embed></object>
					
				</div>
	
				<div id="main-content">
				
					<?php include_once("includes/channel_preview.php"); ?>
					
				</div>
		
			</div>
			
		</div>
		
		</div>
		
		<div class="bottom-round"><div class="bottom-left"></div></div>
	
		<?php include("includes/footer.php"); ?>

</body>
</html>