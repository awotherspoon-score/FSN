<?php

include_once("includes/connect.php");
include_once("includes/functions.php");

if(@!$_GET['offset']){
	$offset = 1;
}else{
	$offset = $_GET['offset'];
}

$filter = $_GET['filter'];
$section = $_GET['section'];

$get_section_title = mysql_query("SELECT section_plural,section_singular from sections WHERE section_alias='$section'");
							
$section_info = mysql_fetch_array($get_section_title);

$page='list';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FSN ~ <?php echo $section_info['section_plural']; ?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/style/layout.css" media="screen" />
<!--<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/style/layout2.css" media="screen" />-->
<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/style/print.css" media="print" />

<script type="text/javascript" src="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/includes/jquery.js"></script>

<script type="text/javascript" src="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/includes/feature_scroller.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	
	goto_feature(0,'<?php echo $filter; ?>','<?php echo $section; ?>')
	start_interval('<?php echo $filter; ?>','<?php echo $section; ?>');
	
 });
</script>

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
						
						get_adverts('','',$section,'side');
						
						?>	
					
					</div>
					
				</div>
					
				<div id="upper-content">
					
					<?php
					
					# article_id, page_name, section_name, ad_type
					
					get_adverts('','',$section,'banner');
					
					?>					
					
					
					<div id="latest-articles">
						<div id="section-header"<?php if($filter=='type'||$filter=='special'){echo " class=\"section-$section\""; }?>>
							<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
							
							<?php
							
								$get_section_title = mysql_query("SELECT section_plural,section_singular FROM sections WHERE section_alias='$section'");
								
								$section_info = mysql_fetch_array($get_section_title);
								
								extract($section_info);
								
								if($filter=='type'||$filter=='special'){
								
									$rss_section = strtolower(str_replace(" ","_",$section_plural));
									
								}else{
									
									$rss_section = $section;
									
								}

							?>
							
							<div id="section-header-content"><span style="float:right;margin-top:2px;"><a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/feeds/<?php echo $rss_section; ?>.rss"><img src="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/images/feed.gif" alt="rss" /></a></span>
							
							<span><?php
							
								echo $section_info['section_plural'];
							
							?></span>

							<div style="clear:both;"></div>
							</div>
							
							
							
							<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
						</div>
						
						<?php if($section=='feature'||$section=='news'){}else{ ?>
						
						<div id="latest-feature"<?php if($section=='ceo-interview'||$section=='product-review'||$section=='white-paper'||$section=='webinar'){echo ' class="show-full"';} ?>>
							<div id="feature-keeper">
								<div id="feature-holder"></div>
							</div>
							<div id="feature-scroller">
								<a id="scroll-prev" href="www.google.com">&laquo;</a>
								<a id="scroll-0" name="scroll-button" href="" class="active">&bull;</a>
								<a id="scroll-1" name="scroll-button" href="">&bull;</a>
								<a id="scroll-2" name="scroll-button" href="">&bull;</a>
								<a id="scroll-3" name="scroll-button" href="">&bull;</a>
								<a id="scroll-4" name="scroll-button" href="">&bull;</a>
								<a id="scroll-next" href="">&raquo;</a>
							</div>
							<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
						</div>
						
						<?php
						if($section=='ceo-interview'||$section=='product-review'||$section=='white-paper'||$section=='webinar')
						{
						}else
						{?>
						
						<div id="right-column">
							<div id="latest-news">
								<div class="news-header">
									<h2>LATEST NEWS</h2><div class="title-right"><a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_news">view more &raquo;</a></div>
									<div style="clear:both;"></div>
								</div>
								<div class="news-content">
									<ul>
									
										<?php
										
										/* GETS NEWS FILTERED BY SECTION BEING VIEWED */
										
										get_news($filter,$section);
										
										?>
										
									</ul>
								</div>
							</div>
						</div>
						
						<?php } ?>
					</div>
					<?php } ?>
					
					<div style="display:inline-block;width:500px;height:1px;line-height:1px;font-size:1px;"></div>
					
				</div>
	
				<div id="main-content">
				
					<div id="current-channel-container">
					
						<div class="channel-section show-full">
							<div class="channel-header <?php echo $section; ?>">
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div class="channel-header-content">
									<h3>ALL <?php echo strtoupper(str_replace(array('_','-'),array(' ',' '),$section)); ?> ARTICLES</h3>
									<div class="title-right"><?php
									
									$num_articles = get_offset($filter,$section);
									
									if($num_articles>20)
									{
										$num_offsets = ceil($num_articles/20);
									
										?>
										<?php if($offset>1){ ?><a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/channel_".$section."/1"; ?>" name="first page" title="first page">&laquo;</a><?php }else{ ?><div class="disabled">&laquo;</div><?php } ?>
										<?php if($offset>1){ ?><a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/channel_".$section."/".($offset-1); ?>" name="previous page" title="previous page">&lsaquo;</a><?php }else{ ?><div class="disabled">&lsaquo;</div><?php } ?>
										<?php if($offset==1)
										{ ?>
											<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/channel_".$section."/".$offset; ?>" style="text-decoration:underline;"><?php echo $offset; ?></a>
											<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/channel_".$section."/".($offset+1); ?>"><?php echo $offset+1; ?></a>
											<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/channel_".$section."/".($offset+2); ?>"><?php echo $offset+2; ?></a>
										<?php }elseif($offset==$num_offsets)
										{ ?>
											<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/channel_".$section."/".($offset-2); ?>"><?php echo $offset-2; ?></a>
											<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/channel_".$section."/".($offset-1); ?>"><?php echo $offset-1; ?></a>
											<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/channel_".$section."/".$offset; ?>" style="text-decoration:underline;"><?php echo $offset; ?></a>
										<?php }else{ ?>
											<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/channel_".$section."/".($offset-1); ?>"><?php echo $offset-1; ?></a>
											<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/channel_".$section."/".$offset; ?>" style="text-decoration:underline;"><?php echo $offset; ?></a>
											<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/channel_".$section."/".($offset+1); ?>"><?php echo $offset+1; ?></a>
										<?php } ?>
										<?php if($offset<$num_offsets){ ?><a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/channel_".$section."/".($offset+1); ?>" name="next page" title="next page">&rsaquo;</a><?php }else{ ?><div class="disabled">&rsaquo;</div><?php } ?>
										<?php if($offset<$num_offsets){ ?><a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/channel_".$section."/".$num_offsets; ?>" name="last page" title="last page">&raquo;</a><?php }else{ ?><div class="disabled">&raquo;</div><?php } ?>
									<?php } ?>
									</div>
									<div style="clear:both;"></div>
								</div>
							</div>
							<div class="channel-content">
								<ul>
									<?php
									
									get_filtered_articles($filter,$section,$offset);
									
									?>
								</ul>					
							</div>
						</div>
						
					</div>
						
					<?php include_once("includes/channel_preview.php"); ?>
					
				</div>
		
			</div>
			
		</div>
		
		</div>
		
		<div class="bottom-round"><div class="bottom-left"></div></div>
	
		<?php include("includes/footer.php"); ?>

</body>
</html>