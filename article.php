<?php

require("includes/connect.php");
require("includes/functions.php");

/*$filter = $_GET['filter'];
$section = $_GET['section'];*/
$slug = $_GET['slug'];
		
$get_article = mysql_query("SELECT * from articles WHERE article_slug='$slug'");
	
#$article = $_GET['article_id'];
	
#$get_article = mysql_query("SELECT * from articles WHERE article_id='$article'");
$article_info = mysql_fetch_array($get_article);

extract($article_info);

$section = $article_sector;

$get_section_title = mysql_query("SELECT section_plural,section_singular from sections WHERE section_alias='$section'");
							
$section_info = mysql_fetch_array($get_section_title);

$page = 'article';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FSN ~ <?php echo $section_info['section_plural']; ?> ~ <?php echo $article_title; ?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/style/layout.css" media="screen" />
<!--<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/style/layout2.css" media="screen" />-->
<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/style/print.css" media="print" />

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
					
						# article_id, page_name, section_name, ad_type (banner,side)
						
						get_adverts($article_id,'','','side');
						
						?>	
					
					</div>
					
				</div>
					
				<div id="upper-content">
					
					<?php
					
					# article_id, page_name, section_name, ad_type
					
					get_adverts($article_id,'','','banner');
					
					?>
					
					<div id="latest-articles">
					
						<div id="section-header-half"<?php if($article_sector=="market_analysis"){echo ' class="section-'.str_replace('_','-',$article_sector).'"';} ?>>
							<span style="float:right;margin:6px 5px 0 0;" class="ie-headers"><a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/feeds/<?php echo $section; ?>.rss"><img src="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/images/feed.gif" alt="rss" /></a></span>
						
							<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/channel_".$article_sector; ?>">
							
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div id="section-header-content">
								<?php
								
									$get_section_title = mysql_query("SELECT section_plural,section_singular from sections WHERE section_alias='$article_sector'");
									
									$section_info = mysql_fetch_array($get_section_title);
								
									echo $section_info['section_singular'];
								
								?>
								</div>
								<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
							
							</a>
							
						</div>
						
						<div style="width:10px;height:10px;float:left;"></div>
						
						<div id="section-header-half"<?php echo " class=\"section-$article_type\""; ?>>
							<?php
								
									$get_section_title = mysql_query("SELECT section_plural,section_singular from sections WHERE section_alias='$article_type'");
									
									$section_info = mysql_fetch_array($get_section_title);
								
								?>
								
							<span style="float:right;margin:6px 5px 0 0;" class="ie-headers"><a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/feeds/<?php echo $article_type; ?>.rss"><img src="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/images/feed.gif" alt="rss" /></a></span>
								
							<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/channel_".strtolower(str_replace(" ","_",$section_info['section_plural'])); ?>">
							
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div id="section-header-content"><?php echo $section_info['section_singular']; ?></div>
								<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
								
							</a>
							
						</div>
						
					
					
						<div id="article-container">
						
							<h1><?php echo $article_title; ?></h1>
							
							<h3><?php echo date("jS F Y",$article_date); ?></h3>
							
							<em><?php echo strip_tags($article_intro,'<p><img><ol><ul><li><strong><h1><h2><h3><h4>'); ?></em>
							
							<?php echo $article_content; ?>
						
						</div>
					
					</div>
					
					<div style="display:inline-block;width:500px;height:1px;line-height:1px;font-size:1px;"></div>
					
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