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

<script type="text/javascript">
$(document).ready(function(){
	
	goto_feature(0,'','')
	start_interval('','');
	
 });
</script>

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
					
					<div id="editors-comments">
						<div id="editor-comments-container">
							<img src="http://fsn.co.uk/images/gary_simon/gary_two.jpg" alt="the editor" />
							<h3>EDITOR'S COMMENTS</h3>
							<h4>DD MMMM YYYY</h4>
							<p>Quisque aliquet ferment um arcu et mollis. Integer nisi justo, blandit sed rutrum eu, suscipit vel sem. Fusce facilisis, dui sed dignissim adipiscing, neque magna euismod orci, a eleifend libero ipsum nec leo. Sed est dolor, ultricies ut tempor in, ultrices tincidunt nisl. Proin in egestas justo. Maecenas aliquet, turpis sit amet facilisis sodales, nunc odio tincidunt sem, a gravida purus ligula eu arcu. Proin eget nunc non sem vulputate ultricies. Suspendisse potenti. Nulla facilisi. Sed non mi ut est scelerisque viverra mollis in nulla. Cras sodales faucibus placerat. In nec porttitor mi. Donec et turpis a justo tempor mattis. Duis ac molestie lectus. Nam congue, urna a rutrum scelerisque, nisl lectus ultrices diam, eu gravida nulla purus ut purus. Duis imperdiet ultrices lacus sed tristique. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse potenti. Duis sed elit ligula.</p>
						</div>
						<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
					</div>
					
					<div id="advertisements">
					
						<?php
						
						# article_id, page_name, section_name, ad_type
						
						get_adverts('',$page,'','side');
						
						?>
					
					</div>
					
					<div style="clear:both;"></div>
					
				</div>
					
				<div id="upper-content">
					
					<?php
					
					# article_id, page_name, section_name, ad_type
					
					get_adverts('',$page,'','banner');
					
					?>
					
					<div id="latest-articles">
						<div id="latest-feature">
							<div id="feature-keeper">
								<div id="feature-holder"><!-- ROTATING FEATURES LOADS INTO HERE VIA AJAX --></div>
							</div>
							<div id="feature-scroller">
								<a id="scroll-prev" href="">&laquo;</a>
								<a id="scroll-0" name="scroll-button" href="" class="active">&bull;</a>
								<a id="scroll-1" name="scroll-button" href="">&bull;</a>
								<a id="scroll-2" name="scroll-button" href="">&bull;</a>
								<a id="scroll-3" name="scroll-button" href="">&bull;</a>
								<a id="scroll-4" name="scroll-button" href="">&bull;</a>
								<a id="scroll-next" href="">&raquo;</a>
							</div>
							<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
						</div>
						
						<div id="right-column">
							<div id="latest-news">
								<div class="news-header">
									<h2>LATEST NEWS</h2><div class="title-right"><a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_news">view more &raquo;</a></div>
									<div style="clear:both;"></div>
								</div>
								<div class="news-content">
									<ul>
									
										<?php
										
										/* GETS LATEST 6 NEWS ARTICLES */
										
										get_news('','');
										
										?>
										
									</ul>
								</div>
							</div>
						</div>
					</div>
					
					<div style="display:inline-block;width:500px;height:1px;line-height:1px;font-size:1px;"></div>
					
				</div>
	
				<div id="main-content">
				
					<?php include_once("includes/channel_preview.php"); ?>
					
				</div>
			<div style="clear:both;"></div>
			</div>
			
		</div>

		</div>
		
		<div class="bottom-round"><div class="bottom-left"></div></div>
	
		<?php include("includes/footer.php"); ?>

</body>
</html>