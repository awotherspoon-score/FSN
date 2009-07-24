<?php

include_once("includes/connect.php");
include_once("includes/functions.php");

$search_terms = $_REQUEST['search_terms'];

$search_terms = trim(str_replace('+',' ',$search_terms));

$send_search = str_replace(' ','+',$search_terms);

if(@!$_GET['offset']){
	$offset = 1;
}else{
	$offset = $_GET['offset'];
}

/*function get_search_results($offset){

	$offset = ($offset-1)*20;
	
	$search_db = mysql_query("SELECT * FROM articles WHERE MATCH(article_title,article_intro,article_content,article_meta_keyw,article_meta_desc) AGAINST ('$search_terms') AND article_hide!=1 LIMIT 20 OFFSET $offset");
	
	while($results = mysql_fetch_array($search_db))
	{?>
		
			<li><a href="channel_<?php echo $results['article_sector']; ?>/<?php echo $results['article_slug']; ?>"><?php echo $results['article_title']; ?></a></li>
	
	<?php
	}
	
}*/

$page = 'search';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>FSN ~ <?php echo $page; ?></title>
	
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
					
					<div id="current-channel-container">
					
						<div class="channel-section channel-col1 show-full">
							<div class="channel-header <?php echo $section; ?>">
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div class="channel-header-content">
									<h3>SEARCH RESULTS</h3>
									<div class="title-right"><?php
									
									$search_db = mysql_query("SELECT * FROM articles WHERE MATCH(article_title,article_intro,article_content,article_meta_keyw,article_meta_desc) AGAINST ('$search_terms') AND article_hide!=1");
									
									$num_articles = mysql_num_rows($search_db);
									
									if($num_articles>20)
									{
										$num_offsets = ceil($num_articles/20);
									
										?>
										<?php if($offset>1){ ?><a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/search/$send_search/1"; ?>" name="first page" title="first page">&laquo;</a><?php }else{ ?><div class="disabled">&laquo;</div><?php } ?>
										<?php if($offset>1){ ?><a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/search/$send_search/".($offset-1); ?>" name="previous page" title="previous page">&lsaquo;</a><?php }else{ ?><div class="disabled">&lsaquo;</div><?php } ?>
										<?php if($offset==1)
										{ ?>
											<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/search/$send_search/".$offset; ?>" style="text-decoration:underline;"><?php echo $offset; ?></a>
											<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/search/$send_search/".($offset+1); ?>"><?php echo $offset+1; ?></a>
											<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/search/$send_search/".($offset+2); ?>"><?php echo $offset+2; ?></a>
										<?php }elseif($offset==$num_offsets)
										{ ?>
											<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/search/$send_search/".($offset-2); ?>"><?php echo $offset-2; ?></a>
											<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/search/$send_search/".($offset-1); ?>"><?php echo $offset-1; ?></a>
											<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/search/$send_search/".$offset; ?>" style="text-decoration:underline;"><?php echo $offset; ?></a>
										<?php }else{ ?>
											<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/search/$send_search/".($offset-1); ?>"><?php echo $offset-1; ?></a>
											<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/search/$send_search/".$offset; ?>" style="text-decoration:underline;"><?php echo $offset; ?></a>
											<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/search/$send_search/".($offset+1); ?>"><?php echo $offset+1; ?></a>
										<?php } ?>
										<?php if($offset<$num_offsets){ ?><a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/search/$send_search/".($offset+1); ?>" name="next page" title="next page">&rsaquo;</a><?php }else{ ?><div class="disabled">&rsaquo;</div><?php } ?>
										<?php if($offset<$num_offsets){ ?><a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/search/$send_search/".$num_offsets; ?>" name="last page" title="last page">&raquo;</a><?php }else{ ?><div class="disabled">&raquo;</div><?php } ?>
									<?php } ?>
									</div>
									<div style="clear:both;"></div>
								</div>
							</div>
							<div class="channel-content">
								<ul>
									<?php
					
									get_search_results($search_terms,$offset);
									
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
		
		</div>
	
		<?php include("includes/footer.php"); ?>

</body>
</html>