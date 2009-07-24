<?php

session_start();

if(!$_SESSION['logged_in']=='798hJR31')
{
	header("Location: http://www.scorecomms.com/fsn/admin/index.php");
}

$admin=1;
$admin_page='adverts';

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
<script type="text/javascript" src="jscripts/jquery.qtip.js"></script>

<script type="text/javascript">
	
$(function()
{	
	$('#available_ads li .sector-tag-container a').click(function(e){
		e.preventDefault();
		var check = confirm("Are you sure you want to delete this advert?");
		var advert_id =  $(this).attr("class");
		if(check){
			$.post("delete_item.php",
				{
					type: 'advert',
					id:  advert_id
				},
				function(data)
				{
					if(data=='true'){
						$('#advert_'+advert_id).hide();
					}
				}
			
			);
		}
	});

	$('#available_ads li').qtip({				
		api: {
			beforeShow: function() {
				var show_ad = this.elements.target.attr("class");
				//alert(show_ad);
				if(show_ad!=''){
					this.loadContent('showimage2.php',{ad_id: show_ad},'post');	
				}
			},
			onRender: function() {
					this.updateWidth();
			}		  
		},
		content: {
			text: 'Loading...'
		},
		position: {
			corner: {
				target: 'leftMiddle',
				tooltip: 'rightMiddle'
			},
			adjust: { x: -25, y: 0 }
		},
		style: {
			width: {
				max: 260
			}
		},
		show: 'mouseover',
		hide: 'mouseout'
		

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
				
					<div class="admin-full channel-full" id="channel-container">
					
						<div class="channel-section channel-col1">
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
								
								$get_pages = mysql_query("SELECT * FROM pages");
								
								while($page_info = mysql_fetch_array($get_pages)){
									
									extract($page_info);
									
									?>
								
									<li><a href="edit_adverts.php?page_id=<?php echo $page_id; ?>"><?php echo $page_title; ?></a></li>
									
									<?php
									
								}
								
								?>
								
								</ul>
								
							</div>
							
							<div style="height:10px;"></div>
							
							<div class="channel-header <?php echo $section; ?>">
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div class="channel-header-content">
									<h3>ALL SECTIONS</h3>
									<div style="clear:both;"></div>
								</div>
							</div>
							<div class="channel-content">
							
								<ul>
							
								<?php
								
								$get_pages = mysql_query("SELECT * FROM sections WHERE section_id!='17' AND section_type!='category'");
								
								while($page_info = mysql_fetch_array($get_pages)){
									
									extract($page_info);
									
									?>
								
									<li><a href="edit_adverts.php?section_id=<?php echo $section_id; ?>"><?php echo $section_plural; ?></a></li>
									
									<?php
									
								}
								
								?>
								
								</ul>
								
							</div>
							
						</div>
						
						<div id="ad_prev" style="position:fixed;top:25px;right:25px;"></div>
						
						<div class="channel-section">
							<div class="channel-header <?php echo $section; ?>">
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div class="channel-header-content">
									<h3>ADVERTS</h3><div class="title-right"><a href="add_new_advert.php">add new advert &raquo;</a></div>
									<div style="clear:both;"></div>
								</div>
							</div>
							<div class="channel-content">
								
								
							
								<ul id="available_ads" >
							
								<?php
								
								$get_ads = mysql_query("SELECT * FROM adverts");
								
								while($ad_info = mysql_fetch_array($get_ads)){
									
									extract($ad_info);
									
									?>
								
									<li id="advert_<?php echo $ad_id; ?>" class="<?php echo $ad_id; ?>"><a style="display:inline-block;width:380px;" href="manage_adverts.php?ad_id=<?php echo $ad_id; ?>" alt="<?php echo $ad_id; ?>"><?php echo $ad_title; ?></a>
										<span class="sector-tag-container" style="width:52px !important;">
											<a class="<?php echo $ad_id; ?>" href="#">
												<div class="sector-tag" style="width:52px;">
													<div class="tag-top-corners"><div class="tag-corner-top-left"></div></div>
													<div class="sector-tag-content">delete</div>
													<div class="tag-bottom-corners"><div class="tag-corner-bottom-left"></div></div>
												</div>
											</a>
										</span>
										<div style="clear:both"></div>
									</li>
									
									<?php
									
								}
								
								?>
								
								</ul>
								
								<div style="clear:both;"></div>
								
						</div>
						
					</div>
					
				</div>
		
			</div>
			
		</div>
		<div style="clear:both;"></div>
		</div>
		
		<div class="bottom-round"><div class="bottom-left"></div></div>
		
</body>
</html>