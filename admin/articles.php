<?php

session_start();

if(!$_SESSION['logged_in']=='798hJR31')
{
	header("Location: http://www.scorecomms.com/fsn/admin/index.php");
}

$admin=1;
$admin_page='articles';

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
<title>FSN ~ home</title>

<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/style/layout.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/style/admin.css" />

<script type="text/javascript" src="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/includes/jquery.js"></script>

<script type="text/javascript">
$(function()
{
	$('#article-list li .sector-tag-container a').click(function(e){
		e.preventDefault();
		var check = confirm("Are you sure you want to delete this article?");
		var article_id =  $(this).attr("class");
		if(check){
			$.post("delete_item.php",
				{
					type:  'article',
					id:  article_id
				},
				function(data)
				{
					if(data['done']=='true'){
						$('#article_'+article_id).hide();
						if(data['date']){
							$('#'+data['date']).hide();
						}
					}else{
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
			
				<div id="left">
			
					<?php include("../includes/channel_nav.php"); ?>
					
				</div>
					
				<div id="main-content">
				
					<div id="current-channel-container">
					
						<div class="channel-section channel-col1 show-full">
							<div class="channel-header">
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div class="channel-header-content">
									<h3>ALL ARTICLES</h3><div class="title-right"><a href="add_new_article">add new article &raquo;</a></div>
									<div style="clear:both;"></div>
								</div>
							</div>
							<div class="channel-content">
								<ul id="article-list">
									<?php
									
									get_admin_articles($filter,$section);
									
									?>
								</ul>					
							</div>
						</div>
						
					</div>
					
				</div>
		
			</div>
			
		</div>
		
		</div>
		
		<div class="bottom-round"><div class="bottom-left"></div></div>
		
</body>
</html>