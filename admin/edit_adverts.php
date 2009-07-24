<?php

session_start();

if(!$_SESSION['logged_in']=='798hJR31')
{
	header("Location: http://www.scorecomms.com/fsn/admin/index.php");
}

error_reporting(0);

$admin=1;
$admin_page='adverts';

include_once("../includes/connect.php");
include_once("../includes/functions.php");

$page_id = $_GET['page_id'];

$section_id = $_GET['section_id'];

$article_id = $_GET['article_id'];

if($page_id)
{
	$current_table="pages";
	
	$current_type="page";
	
	$current_id_type="page_id";
	
	$current_id=$page_id;
	
}elseif($section_id)
{
	$current_table="sections";
	
	$current_type="section";
	
	$current_id_type="section_id";
	
	$current_id=$section_id;
	
}

elseif($article_id)
{
	$current_table="articles";
	
	$current_type="article";
	
	$current_id_type="article_id";
	
	$current_id=$article_id;
	
}

if(@$_POST['submit']){
	
	$ad_layout_sel = $_POST['ad_layout_sel'];
	$ad_banner_sel = $_POST['ad_banner_sel'];
	$ad_sky_sel = $_POST['ad_sky_sel'];
	$ad_square1_sel = $_POST['ad_square1_sel'];
	$ad_square2_sel = $_POST['ad_square2_sel'];
	$ad_square3_sel = $_POST['ad_square3_sel'];
	
	if(!$error){
		
		if($ad_layout_sel==2&&$ad_banner_sel==0){
				$ad_layout_sel=1;
		}elseif($ad_layout_sel==3&&$ad_banner_sel==0){
				$ad_layout_sel=5;
		}elseif($ad_layout_sel==3&&$ad_sky_sel==0){
				$ad_layout_sel=2;
		}elseif($ad_layout_sel==4&&$ad_banner_sel==0){
				$ad_layout_sel=6;
		}elseif($ad_layout_sel==4&&$ad_square1_sel==0&&$ad_square2_sel==0&&$ad_square3_sel==0){
				$ad_layout_sel=2;
		}elseif($ad_layout_sel==5&&$ad_sky_sel==0){
				$ad_layout_sel=1;
		}elseif($ad_layout_sel==5&&$ad_square1_sel==0&&$ad_square2_sel==0&&$ad_square3_sel==0){
				$ad_layout_sel=1;
		}
		
		echo $ad_layout_sel;
		echo $ad_banner_sel;
		echo $ad_sky_sel;
		echo $ad_square1_sel;
		echo $ad_square2_sel;
		echo $ad_square3_sel;
		
		if($current_id_type=='page_id')
		{		
			$update_ads = mysql_query("UPDATE pages SET page_ad_layout='$ad_layout_sel', page_ad_banner='$ad_banner_sel', page_ad_sky='$ad_sky_sel', page_ad_square1='$ad_square1_sel', page_ad_square2='$ad_square2_sel', page_ad_square3='$ad_square3_sel' WHERE page_id='$page_id' ");
			
		}elseif($current_id_type=='section_id')
		{
			$update_ads = mysql_query("UPDATE sections SET section_ad_layout='$ad_layout_sel', section_ad_banner='$ad_banner_sel', section_ad_sky='$ad_sky_sel', section_ad_square1='$ad_square1_sel', section_ad_square2='$ad_square2_sel', section_ad_square3='$ad_square3_sel' WHERE section_id='$section_id' ");
		}elseif($current_id_type=='article_id')
		{
			$update_ads = mysql_query("UPDATE articles SET article_ad_layout='$ad_layout_sel', article_ad_banner='$ad_banner_sel', article_ad_sky='$ad_sky_sel', article_ad_square1='$ad_square1_sel', article_ad_square2='$ad_square2_sel', article_ad_square3='$ad_square3_sel' WHERE article_id='$article_id' ");
		}
		
		if($update_ads)
		{
			$status['good']="page adverts has been updated";
			
		}else
		{			
			if(mysql_error())
			{
				$status['bad'] = "mysql_error()";
			}else
			{
				$status['bad'] = "There was an error, please try again";
			}
		}
	
	}
	
}

$get_content = mysql_query("SELECT * FROM $current_table WHERE $current_id_type='$current_id'");

$content_info = mysql_fetch_array($get_content);

extract($content_info);

$ad_layout = ${"{$current_type}_ad_layout"};
$ad_banner = ${"{$current_type}_ad_banner"};
$ad_sky = ${"{$current_type}_ad_sky"};
$ad_square1 = ${"{$current_type}_ad_square1"};
$ad_square2 = ${"{$current_type}_ad_square2"};
$ad_square3 = ${"{$current_type}_ad_square3"};

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FSN ~ Admin Panel ~ Edit Page</title>

<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/style/layout.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/style/admin.css" />

<script type="text/javascript" src="http://www.scorecomms.com/jquery/jquery.js"></script>
<script type="text/javascript" src="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/admin/jscripts/tiny_mce/tiny_mce_gzip.js"></script>

<script type="text/javascript">
tinyMCE_GZ.init({
	plugins : 'spellchecker,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,'+ 
        'searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras',
	languages : 'en',
	disk_cache : true,
	debug : false
});
</script>

<script type="text/javascript">
tinyMCE.init({
	theme : 'fsn',
	plugins : "spellchecker,table,paste",
	theme_advanced_buttons3_add : "spellchecker",
	spellchecker_languages : "+English=en",
	mode : "exact",
	elements : "page_content"
});

$(function()
{
	
	var prev_cont ='';
	
	$("option:not(#ad_layout_sel option)").hover(
		function () {
			
			var box = $(this).attr("class");
			var selector = "#"+box+"_prev";
			
			prev_cont = $(selector).html();

			$.post("showimage.php",
				{
				ad_id:  $(this).val()
				},
				function(data)
				{
					if(data['ad_type']!=0){
						var output = '<img src="' + data['ad_loc'] + '" width="' + (data['ad_width']/2) + '" height="' + (data['ad_height']/2) + '" alt="ad preview" />';
						//var box = that.attr("class");
						//var selector = "#"+box+"_prev";
						$(selector).html(output);
					}else{
						//var box = that.attr("class");
						//var selector = "#"+box+"_prev";
						$(selector).html('');	
					}
				},"json"
			
			);
		}, 
		function () {
			var box = $(this).attr("class");
			var selector = "#"+box+"_prev";
			
			$(selector).html(prev_cont);
		}
    );
	
	$("option:not(#ad_layout_sel option)").click(function ()
		{
       	var that = $(this);	
		$.post("showimage.php",
			{
			ad_id:  $(this).val()
			},
			function(data)
			{
				if(data['ad_type']!=0){
					var output = '<img src="' + data['ad_loc'] + '" width="' + (data['ad_width']/2) + '" height="' + (data['ad_height']/2) + '" alt="ad preview" />';
					var box = that.attr("class");
					var selector = "#"+box+"_prev";
					$(selector).html(output);
				}else{
					var box = that.attr("class");
					var selector = "#"+box+"_prev";
					$(selector).html('');
				}
			},"json"
			
			);
		}
    );

	$("#ad_layout_sel").change(function(){
		var ad_layout = $(this).val();
		
		switch(ad_layout)
		{
		case '0':
			$("#ad_banner").hide();
			$("#ad_sky").hide();
			$("#ad_square1").hide();
			$("#ad_square2").hide();
			$("#ad_square3").hide();
			break;
		case '1':
			$("#ad_banner").hide();
			$("#ad_sky").hide();
			$("#ad_square1").hide();
			$("#ad_square2").hide();
			$("#ad_square3").hide();
			break;
		case '2':
			$("#ad_banner").show();
			$("#ad_sky").hide();
			$("#ad_square1").hide();
			$("#ad_square2").hide();
			$("#ad_square3").hide();
			break;
		case '3':
			$("#ad_banner").show();
			$("#ad_sky").show();
			$("#ad_square1").hide();
			$("#ad_square2").hide();
			$("#ad_square3").hide();
			break;
		case '4':
			$("#ad_banner").show();
			$("#ad_sky").hide();
			$("#ad_square1").show();
			$("#ad_square2").show();
			$("#ad_square3").show();
			break;
		case '5':
			$("#ad_banner").hide();
			$("#ad_sky").show();
			$("#ad_square1").hide();
			$("#ad_square2").hide();
			$("#ad_square3").hide();
			break;
		case '6':
			$("#ad_banner").hide();
			$("#ad_sky").hide();
			$("#ad_square1").show();
			$("#ad_square2").show();
			$("#ad_square3").show();
			break;
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
			
				<div class="section-news" id="section-header" style="width:942px;margin:0 15px 15px;float:none;">
				
					<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
												
					<div id="section-header-content">
					
						<span><?php if($section_id){echo $section_plural;}elseif($page_id){echo ucwords($page_title);}elseif($article_id){echo $article_title;} ?></span>
			
						<div style="clear: both;"></div>
						
					</div>
		
					<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
					
				</div>
			
			<?php if($status['good']){
			?>
			<div class="status-good"><?php echo $status['good']; ?></div>
			<?php
			}elseif($status['bad']){
			?>
			<div class="status-bad"><?php echo $status['bad']; ?></div>
			<?php
			}?>
			
			<form action="<?php #echo $_SERVER['PHP_SELF']."?page_id=$page_id"; ?>" method="post" enctype="multipart/form-data">
			
				<div id="ad_layout" class="form-container" style="margin-bottom:15px;clear:both;">
					<label for="page_title" style="float:left;">Advert Layout: </label>
					<select id="ad_layout_sel" name="ad_layout_sel" style="float:left;">
						<?php if($current_type=="article"){?>
						<option value="0"<?php if($ad_layout==0){echo ' selected="selected"';}?>>Channel Defaults</option>
						<?php }?>
						<option value="1"<?php if($ad_layout==1){echo ' selected="selected"';}?>>No Adverts</option>
						<option value="2"<?php if($ad_layout==2){echo ' selected="selected"';}?>>Banner Only</option>
						<option value="3"<?php if($ad_layout==3){echo ' selected="selected"';}?>>Banner &amp; Skyscraper</option>
						<option value="4"<?php if($ad_layout==4){echo ' selected="selected"';}?>>Banner &amp; Squares</option>
						<option value="5"<?php if($ad_layout==5){echo ' selected="selected"';}?>>Skyscraper Only</option>
						<option value="6"<?php if($ad_layout==6){echo ' selected="selected"';}?>>Squares Only</option>
					</select>
					
					<div style="clear:both;"></div>
					
				</div>
				
				<div id="ad_banner" class="form-container" style="<?php if($ad_layout==2||$ad_layout==3||$ad_layout==4){echo 'display:block;';}else{echo 'display:none;';} ?>clear:both;">
					<label for="page_title" style="float:left;">Banner Advert: </label>
					<select id="ad_banner_sel" NAME="ad_banner_sel" style="float:left;">
						<option class="banner" value="0"<?php if($ad_sky==0){echo ' selected="selected"';}?>>Blank</option>
	
						<?php
						
						$get_banner_adverts = mysql_query("SELECT * FROM adverts WHERE ad_style='banner'");
	
						while($advert_info = mysql_fetch_array($get_banner_adverts)){
						
						extract($advert_info);
		
						?>
						
						<option class="banner" value="<?php echo $ad_id; ?>"<?php if($ad_banner==$ad_id){echo 'selected="selected"';}?>><?php echo $ad_title; ?><?php if($ad_banner==$ad_id){echo ' &laquo; current';} ?></option>
						
						<?php } ?>
						
					</select>
					
					<?php
					
						$get_banner_prev = mysql_query("SELECT * FROM adverts WHERE ad_id='$ad_banner'");
	
						$prev_info = mysql_fetch_array($get_banner_prev);
						
						extract($prev_info,EXTR_PREFIX_ALL,'prev');
						
					?>
					
					<div id="banner_prev" style="width:364px;height:45px;border:1px solid #000000;float:left;margin-left:70px;">
						<?php if($ad_banner){ ?><img src="<?php echo $prev_ad_loc; ?>" width="<?php echo $prev_ad_width/2; ?>" height="<?php echo $prev_ad_height/2; ?>" alt="ad preview" /><?php } ?>
					</div>
					
					<div style="clear:both;"></div>
					
				</div>
				
				<div id="ad_sky" class="form-container" style="<?php if($ad_layout==3||$ad_layout==5){echo 'display:block;';}else{echo 'display:none;';} ?>clear:both;">
					<label for="page_title" style="float:left;">Skyscraper Advert: </label>
					<select id="ad_sky_sel" name="ad_sky_sel" style="float:left;">
						<option class="sky" value="0"<?php if($ad_sky==0){echo ' selected="selected"';}?>>Blank</option>
	
						<?php
						
						$get_sky_adverts = mysql_query("SELECT * FROM adverts WHERE ad_style='skyscraper'");
	
						while($advert_info = mysql_fetch_array($get_sky_adverts)){
						
						extract($advert_info);
		
						?>
						<option class="sky" value="<?php echo $ad_id; ?>"<?php if($ad_sky==$ad_id){echo ' selected="selected"';}?>><?php echo $ad_title; ?><?php if($ad_sky==$ad_id){echo ' &laquo; current';} ?></option>
						
						<?php } ?>
						
					</select>
					
					<?php
					
						$get_sky_prev = mysql_query("SELECT * FROM adverts WHERE ad_id='$ad_sky'");
	
						$prev_info = mysql_fetch_array($get_sky_prev);
						
						extract($prev_info,EXTR_PREFIX_ALL,'prev');
						
					?>
					
					<div id="sky_prev" style="width:80px;height:300px;border:1px solid #000000;float:left;margin-left:70px;">
						<?php if($ad_sky){ ?><img src="<?php echo $prev_ad_loc; ?>" width="<?php echo $prev_ad_width/2; ?>" height="<?php echo $prev_ad_height/2; ?>" alt="ad preview" /><?php } ?>
					</div>
					
					<div style="clear:both;"></div>
					
				</div>
				
				<div id="ad_square1" class="form-container" style="<?php if($ad_layout==4||$ad_layout==6){echo 'display:block;';}else{echo 'display:none;';} ?>clear:both;">
					<label for="page_title" style="float:left;">Square 1 Advert: </label>
					<select id="ad_square1_sel" name="ad_square1_sel" style="float:left;">
						<option class="square1" class="square1" value="0"<?php if($ad_square1==0){echo ' selected="selected"';}?>>Blank</option>
					
						<?php
						
						$get_square1_adverts = mysql_query("SELECT * FROM adverts WHERE ad_style='square'");
	
						while($advert_info = mysql_fetch_array($get_square1_adverts)){
						
						extract($advert_info);
		
						?>
						<option class="square1" value="<?php echo $ad_id; ?>"<?php if($ad_square1==$ad_id){echo ' selected="selected"';}?>><?php echo $ad_title; ?><?php if($ad_square1==$ad_id){echo ' &laquo; current';} ?></option>
						
						<?php } ?>
						
					</select>
					
					<?php
					
						$get_square1_prev = mysql_query("SELECT * FROM adverts WHERE ad_id='$ad_square1'");
	
						$prev_info = mysql_fetch_array($get_square1_prev);
						
						extract($prev_info,EXTR_PREFIX_ALL,'prev');
						
					?>
					
					<div id="square1_prev" style="width:100px;height:100px;border:1px solid #000000;float:left;margin-left:70px;">
						<?php if($ad_square1){ ?><img src="<?php echo $prev_ad_loc; ?>" width="<?php echo $prev_ad_width/2; ?>" height="<?php echo $prev_ad_height/2; ?>" alt="ad preview" /><?php } ?>
					</div>
					
					<div style="clear:both;"></div>
					
				</div>
				
				<div id="ad_square2" class="form-container" style="<?php if($ad_layout==4||$ad_layout==6){echo 'display:block;';}else{echo 'display:none;';} ?>clear:both;">
					<label for="page_title" style="float:left;">Square 2 Advert: </label>
					<select id="ad_square2_sel" name="ad_square2_sel" style="float:left;">
						<option class="square2" value="0"<?php if($ad_square2==0){echo ' selected="selected"';}?>>Blank</option>
						<?php
						
						$get_square2_adverts = mysql_query("SELECT * FROM adverts WHERE ad_style='square'");
	
						while($advert_info = mysql_fetch_array($get_square2_adverts)){
						
						extract($advert_info);
						
						?><option class="square2" value="<?php echo $ad_id; ?>"<?php if($ad_square2==$ad_id){echo 'selected="selected"';}?>><?php echo $ad_title; ?><?php if($ad_square2==$ad_id){echo ' &laquo; current';} ?></option><?php } ?>
						
					</select>
					
					<?php
					
						$get_square2_prev = mysql_query("SELECT * FROM adverts WHERE ad_id='$ad_square2'");
	
						$prev_info = mysql_fetch_array($get_square2_prev);
						
						extract($prev_info,EXTR_PREFIX_ALL,'prev');
						
					?>
					
					<div id="square2_prev" style="width:100px;height:100px;border:1px solid #000000;float:left;margin-left:70px;">
						<?php if($ad_square2){ ?><img src="<?php echo $prev_ad_loc; ?>" width="<?php echo $prev_ad_width/2; ?>" height="<?php echo $prev_ad_height/2; ?>" alt="ad preview" /><?php } ?>
					</div>
					
					<div style="clear:both;"></div>
					
				</div>
				
				<div id="ad_square3" class="form-container" style="<?php if($ad_layout==4||$ad_layout==6){echo 'display:block;';}else{echo 'display:none;';} ?>clear:both;">
					<label for="page_title" style="float:left;">Square 3 Advert: </label>
					<select id="ad_square3_sel" name="ad_square3_sel" style="float:left;">
						<option class="square3" value="0"<?php if($ad_square3==0){echo 'selected="selected"';}?>>Blank</option>
						<?php
						
						$get_square3_adverts = mysql_query("SELECT * FROM adverts WHERE ad_style='square'");
	
						while($advert_info = mysql_fetch_array($get_square3_adverts)){
						
						extract($advert_info);
		
						?>
						<option class="square3" value="<?php echo $ad_id; ?>"<?php if($ad_square3==$ad_id){echo 'selected="selected"';}?>><?php echo $ad_title; ?><?php if($ad_square3==$ad_id){echo ' &laquo; current';} ?></option>
						
						<?php } ?>
						
					</select>
					
					<?php
					
						$get_square3_prev = mysql_query("SELECT * FROM adverts WHERE ad_id='$ad_square3'");
	
						$prev_info = mysql_fetch_array($get_square3_prev);
						
						extract($prev_info,EXTR_PREFIX_ALL,'prev');
						
					?>
					
					<div id="square3_prev" style="width:100px;height:100px;border:1px solid #000000;float:left;margin-left:70px;">
						<?php if($ad_square3){ ?><img src="<?php echo $prev_ad_loc; ?>" width="<?php echo $prev_ad_width/2; ?>" height="<?php echo $prev_ad_height/2; ?>" alt="ad preview" /><?php } ?>
					</div>
					
					<div style="clear:both;"></div>
					
				</div>
			
			
			
			<!--<div class="form-container<?php if($error['title']==1){ echo " error";	}?>">
			<label for="page_title">Page Title: </label><input type="text" value="<?php echo $page_title; ?>" name="page_title" id="page_title" class="title" />
			</div>
			<div class="form-container<?php if($error['meta_desc']==1){ echo " error";	}?>">
			<label for="page_meta_desc">Page Meta Description: </label><textarea type="text" name="page_meta_desc" id="page_meta_desc" class="description"><?php echo $page_meta_desc; ?></textarea>
			</div>
			<div class="form-container<?php if($error['meta_keyw']==1){ echo " error";	}?>">
			<label for="page_meta_keyw">Page Meta Keywords: </label><input type="text" value="<?php echo $page_meta_keyw; ?>" name="page_meta_keyw" id="page_meta_keyw" class="keywords" />
			</div>
			
			<div class="form-container<?php if($error['content']==1){ echo " error";	}?>">
			<label for="page_content">Page Content: </label><textarea name="page_content" id="page_content" class="content"><?php echo $page_content; ?></textarea>
			</div>-->
			
				<div class="form-container" style="clear:both;">
					<input type="submit" value="save adverts" name="submit" id="page_submit" />
				</div>
				
			</form>
		
				<div style="clear:both;"></div>
		
			</div>
		
		</div>
		
		</div>
		
		<div class="bottom-round"><div class="bottom-left"></div></div>

</body>
</html>