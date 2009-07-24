<?php

session_start();

if(!$_SESSION['logged_in']=='798hJR31')
{
	header("Location: http://www.scorecomms.com/fsn/admin/index.php");
}

error_reporting(0);

$admin=1;
$admin_page='articles';

include_once("../includes/connect.php");
include_once("../includes/functions.php");

if(@$_POST['preview']){
	
	$article_title = $_POST['article_title'];
	$article_meta_desc = $_POST['article_meta_desc'];
	$article_meta_keyw = $_POST['article_meta_keyw'];
	$article_day = $_POST['article_day'];
	$article_month = $_POST['article_month'];
	$article_year = $_POST['article_year'];
	$article_date = mktime(0,0,0,$article_month,$article_day,$article_year);
	$article_intro = $_POST['article_intro'];
	$article_content = $_POST['article_content'];
	$article_category = $_POST['article_category'];
	$article_sector = $_POST['article_sector'];
	$article_ma = $_POST['article_ma'];
	$article_hide = $_POST['article_hide'];
	
	$article_img_s = $_POST['article_img_s'];
	$article_img_l = $_POST['article_img_l'];
	
	$article_ad_banner = $_POST['article_ad_banner'];
	$article_ad_skyscraper = $_POST['article_ad_skyscraper'];
	$article_ad_square1 = $_POST['article_ad_square1'];
	$article_ad_square2 = $_POST['article_ad_square2'];
	$article_ad_square3 = $_POST['article_ad_square3'];
	
}elseif(@$_POST['submit']){
	
	# CHECK FOR MISSING DATA #
	
	if(!$article_title = htmlspecialchars($_POST['article_title'],ENT_QUOTES))
	{
		$error['title']=1;
	}else
	{
		
		# GENERATES SLUG FOR ARTICEL FROM TITLE STRIPPING ALL SPECIAL CHARACTERS #
		
		$search = array('&amp;','&quot;','&#039;','&lt;','&gt;',',','.','<','>','\'','"','&',';',':','?','!','\\','/','|','£','¬','$','%','^','*','(',')','+','=','`','¦','#','~','@','[',']','{','}');
		$replace = '';
		$article_slug = strtolower(str_replace(' ','_',preg_replace('/\s\s+/', ' ',trim(str_replace(array('_','-'),' ',str_replace($search,$replace,strip_tags($article_title)))))));
	}
	
	if(!$article_meta_desc = $_POST['article_meta_desc'])
	{
		$error['meta_desc']=1;	
	}
	
	if(!$article_meta_keyw = $_POST['article_meta_keyw'])
	{
		$error['meta_keyw']=1;	
	}
	
	if(!$article_content = $_POST['article_content'])
	{
		$error['content']=1;	
	}
	
	if(!$article_sector = $_POST['article_sector'])
	{
		$error['sector']=1;	
	}
	
	if(!$article_category = $_POST['article_category'])
	{
		$error['category']=1;	
	}
	
	# PULL ALL INFO INTO VARIABLES #
	
	$article_img_s = $_FILES['article_img_s']['name'];
	$article_img_l = $_FILES['article_img_l']['name'];
	$article_intro = $_POST['article_intro'];
	$article_hide = $_POST['article_hide'];
	
	$article_ad_banner = $_POST['article_ad_banner'];
	$article_ad_skyscraper = $_POST['article_ad_skyscraper'];
	$article_ad_square1 = $_POST['article_ad_square1'];
	$article_ad_square2 = $_POST['article_ad_square2'];
	$article_ad_square3 = $_POST['article_ad_square3'];
	
	$article_day = $_POST['article_day'];
	$article_month = $_POST['article_month'];
	$article_year = $_POST['article_year'];
	$article_date = mktime(0,0,0,$article_month,$article_day,$article_year);
	
	# IF NO ERRORS PULL DATA INTO VARIABLES AND PROCESS TO BE INSERTED INTO DATABASE #
	
	if(!$error){
		
		$insert_article_meta_desc = mysql_escape_string(strip_tags($article_meta_desc));
		$insert_article_meta_keyw = mysql_escape_string(strip_tags($article_meta_keyw));
		$insert_article_title = mysql_escape_string(strip_tags($article_title));
		$insert_article_date = mysql_escape_string($article_date);
		$insert_article_intro = mysql_escape_string(strip_tags($article_intro,'<p><a><img><h1><h2><h3><h4><strong><ul><ol><li><table><td><tr><tbody>'));
		$insert_article_content = mysql_escape_string(strip_tags($article_content,'<p><em><a><img><h1><h2><h3><h4><strong><ul><ol><li><table><td><tr><tbody>'));
		$insert_article_sector = mysql_escape_string($article_sector);
		$insert_article_category = mysql_escape_string($article_category);
		$insert_article_img = mysql_escape_string($article_img);
		
		# CHECK SLUG FOR ARTICLE IS UNIQUE #
		
		$new_article_slug = $article_slug;

		function check_unique($article_slug){
				
			$get_slugs = mysql_query("SELECT article_slug FROM articles WHERE article_slug='$article_slug'");
			return mysql_num_rows($get_slugs);

		}
		
		$x=2;
		
		do{
			$is_unique = check_unique($new_article_slug);
			
			if($is_unique!=0){
				$new_article_slug = $article_slug."_".$x;
				$x++;
			}
			
		}while($is_unique!=0);
		
		$insert_article_slug = mysql_escape_string($new_article_slug);
		$insert_article_hide = mysql_escape_string($article_hide);
		
		/*echo $insert_article_meta_desc;
		echo "<br />";
		echo $insert_article_meta_keyw;
		echo "<br />";
		echo $insert_article_title;
		echo "<br />";
		echo date('dmy',$insert_article_date);
		echo "<br />";
		echo $insert_article_intro;
		echo "<br />";
		echo $insert_article_content;
		echo "<br />";
		echo $insert_article_sector;
		echo "<br />";
		echo $insert_article_category;
		echo "<br />";
		echo $insert_article_img;
		echo "<br />";
		echo $insert_article_slug;
		echo "<br />";
		echo $insert_article_hide;*/
		
		$add_article = mysql_query("INSERT INTO articles (article_id, article_meta_desc, article_meta_keyw, article_title, article_date, article_intro, article_content, article_sector, article_type, article_img, article_link, article_showcase, article_slug, article_alias, article_hide) VALUES ('','$insert_article_meta_desc','$insert_article_meta_keyw','$insert_article_title','$insert_article_date','$insert_article_intro','$insert_article_content','$insert_article_sector','$insert_article_category','$insert_article_img','','','$insert_article_slug','','$insert_article_hide')");
		
		if($add_article)
		{
			
			$article_id = mysql_insert_id();
			
			$htaccess = "../.htaccess";
		
			$newLink = "RewriteRule ^channel_$insert_article_sector/$insert_article_slug$ article.php?article_id=$article_id \r\n";
			
			$fh = fopen($htaccess, 'a+');
			$fr = fread($fh,filesize($htaccess));
			if(substr_count($fr,$newLink)!=0)
			{
				"HTACCESS SKIP";
			}else{
				fwrite($fh, $newLink);
				"HTACCESS WRITE";
			}
			fclose($fh);
			
			header ('Location: http://www.scorecomms.com/fsn/admin/articles');
			
			$status['good']="the article '$article_title' has been updated";
			
		}else
		{			
			if(mysql_error())
			{
				$status['bad'] = "mysql_error()";
			}else
			{
				$status['bad'] = "You need to fill out all the data highlighted";
			}
		}
		
	}else
	{
		echo mysql_error();
	}
	
}else{
	
	$article_date = time();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FSN ~ Admin Panel ~ Add Article</title>

<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/style/layout.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/style/admin.css" />

<script type="text/javascript" src="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/admin/jscripts/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript">
/*tinyMCE_GZ.init({
	plugins : 'spellchecker,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,'+ 
        'searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras',
	languages : 'en',
	disk_cache : true,
	debug : false
});*/
</script>

<script type="text/javascript">
tinyMCE.init({
	theme : 'fsn',
	plugins : "spellchecker,table,paste,Archiv",
	//theme_advanced_buttons3_add : "spellchecker",
	Archiv_settings_file : "config.php",
	theme_fsn_buttons1 : "code,|,bold,italic,underline,|,formatselect,|,justifyleft,justifycenter,justifyright,|,bullist,numlist,|,outdent,indent,|,link,unlink,Archiv_files,Archiv_images,image,anchor,charmap,|,undo,redo,cut,copy,paste,pasteword",
	theme_fsn_buttons2 : "tablecontrols",
	theme_fsn_blockformats : "p,h2,h4",
	spellchecker_languages : "+English=en",
	mode : "exact",
	elements : "article_content,article_intro"
});
</script>

<script type="text/javascript" src="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/includes/jquery.js"></script>

<script type="text/javascript">
function temp_image_upload(image_id)
{
var xmlhttp

upload_temp(image_id);

function upload_temp(image_id)
{
	xmlhttp=GetXmlHttpObject();
	if (xmlhttp==null)
	  {
	  alert ("Your browser does not support AJAX!");
	  return;
	  }
	var url = "temp_image.php";
	var params = "image="+document.getElementById(image_id).files;
	xmlhttp.open("POST",url,true);
	//Send the proper header information along with the request
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length", params.length);
	xmlhttp.setRequestHeader("Connection", "close");
	
	/*url=url+"?image="+document.getElementById(image_id).value;
	url=url+"&sid="+Math.random();*/
	
	xmlhttp.onreadystatechange=stateChanged;
	
	xmlhttp.send(params);
	}
	
	function stateChanged()
	{
	if (xmlhttp.readyState==4)
	{
	document.getElementById("thumbnail_s").innerHTML=xmlhttp.responseText;
	}
	}
	
	function GetXmlHttpObject()
	{
	if (window.XMLHttpRequest)
	  {
	  // code for IE7+, Firefox, Chrome, Opera, Safari
	  return new XMLHttpRequest();
	  }
	if (window.ActiveXObject)
	  {
	  // code for IE6, IE5
	  return new ActiveXObject("Microsoft.XMLHTTP");
	  }
	return null;
	}
}
</script>

</head>

<body>

	<div id="background-wrapper">
	
		<div class="container">
		
			<?php include("includes/admin_nav.php"); ?>	
		
			<div id="main-holder">
			
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" id="article_form" name="article_form">
			
			<?php
				if($error['title']==1){
					
				}
			?>
			<div class="form-container<?php if($error['title']==1){ echo " error";	}?>">
				<label for="article_title">Article Title: </label><input type="text" value="<?php echo $article_title; ?>" name="article_title" id="article_title" class="title" />
			</div>
			<div class="form-container<?php if($error['meta_desc']==1){ echo " error";	}?>">
				<label for="article_meta_desc">Article Meta Description: </label><textarea type="text" name="article_meta_desc" id="article_meta_desc" class="description"><?php echo $article_meta_desc; ?></textarea>
			</div>
			<div class="form-container<?php if($error['meta_keyw']==1){ echo " error";	}?>">
				<label for="article_meta_keyw">Article Meta Keywords: </label><input type="text" value="<?php echo $article_meta_keyw; ?>" name="article_meta_keyw" id="article_meta_keyw" class="keywords" />
			</div>
			<div class="form-container<?php if($error['date']==1){ echo " error";	}?>">
				<label for="article_day">Article Date: </label>
				<select name="article_day" id="article_day" class="date">
				<?php
				$x=1;
				while($x<=31)
				{
				?>
					<option value="<?php echo $x; ?>" <?php if(date('d',$article_date)==$x){ echo 'selected="selected"'; } ?>><?php echo $x; ?></option>
				<?php
				$x++;
				}
				?>
				</select>
				<select name="article_month" id="article_month" class="month">
				<?php
				$x=1;
				while($x<=12)
				{
				?>
					<option value="<?php echo $x; ?>" <?php if(date('n',$article_date)==$x){ echo 'selected="selected"'; } ?>><?php echo date('F',mktime(0,0,0,$x,1,2009)); ?></option>
				<?php
				$x++;
				}
				?>
				</select>
				<select name="article_year" id="article_year" class="date">
				<?php
				$x=2000;
				while($x<=2020)
				{
				?>
					<option value="<?php echo $x; ?>" <?php if(date('Y',$article_date)==$x){ echo 'selected="selected"'; } ?>><?php echo $x; ?></option>
				<?php
				$x++;
				}
				?>
				</select>
			</div>
			<div class="form-container<?php if($error['sector']==1){ echo " error";	}?>">
				<label for="article_sector">Article Sector: </label>
				<select name="article_sector" id="article_sector">
					<option value=""<?php if(!$article_sector){ echo ' selected="selected"'; } ?>>please select</option>
					<?php
					
					$get_sector = mysql_query("SELECT * FROM sections WHERE section_type='sector'");
					
					
					while($sectors = mysql_fetch_array($get_sector)){
					
						extract($sectors);
						
					?>
					<option value="<?php echo $section_alias; ?>"<?php if($article_sector==$section_alias){ echo ' selected="selected"'; } ?>><?php echo $section_plural; ?></option>
					<?php
					
					}
					
					?>	
				</select>
			</div>
			<div class="form-container<?php if($error['category']==1){ echo " error";	}?>">
				<label for="article_category">Article Category: </label>
				<select name="article_category" id="article_category">
					<option value=""<?php if(!$article_category){ echo ' selected="selected"'; } ?>>please select</option>
			
				<?php
				
				$get_categories = mysql_query("SELECT * FROM sections WHERE section_type='category'");
				
				
				while($categories = mysql_fetch_array($get_categories)){
				
					extract($categories);
					
				?>
					<option value="<?php echo $section_alias; ?>"<?php if($article_category==$section_alias){ echo ' selected="selected"'; } ?>><?php echo $section_singular; ?></option>
				<?php
				
				}
				
				?>				
				
				</select>
			</div>
			<div class="form-container">
				<label for="article_category">Market Analysis: </label>
				<input type="checkbox" name="article_ma" id="article_ma"<?php if($article_hide=='1'){ echo ' checked="checked"'; } ?> value="1" />
			</div>
			<div class="form-container<?php if($error['imgs']==1){ echo " error";	}?>">
				<label for="article_img_s">Article Small Image: </label><input type="file" name="article_img_s" id="article_img_s" />
			</div>
			<div id="thumbnail_s" style="width:50px;height:50px;"></div>
			<div class="form-container<?php if($error['imgl']==1){ echo " error";	}?>">
				<label for="article_img_l">Article Large Image: </label><input type="file" name="article_img_l" id="article_img_l" />
			</div>
			
			<div class="form-container<?php if($error['intro']==1){ echo " error";	}?>">
				<label for="article_intro">Article Introduction: </label><textarea name="article_intro" id="article_intro" class="intro"><?php echo $article_intro; ?></textarea>
			</div>
			
			<div class="form-container<?php if($error['content']==1){ echo " error";	}?>">
				<label for="article_content">Article Content: </label><textarea name="article_content" id="article_content" class="content"><?php echo $article_content; ?></textarea>
			</div>
			<div class="form-container">
				<label for="article_hide">Hide Article: </label><input type="checkbox" name="article_hide" id="article_hide"<?php if($article_hide=='1'){ echo ' checked="checked"'; } ?> value="1" />
			</div>
			
			<!--<div id="advert_container">
			
				<div class="form-container">
					<label for="article_ad_layout">Adverts Layout: </label>
					<select name="article_ad_layout" id="article_ad_layout">
						<option value="0">Use Channel Defaults</option>
						<option value="1">No Adverts</option>
						<option value="2">Banner Only</option>
						<option value="3">Banner &amp; Skyscraper</option>
						<option value="4">Banner &amp; 3x Square</option>
						<option value="5">Skyscraper Only</option>
						<option value="6">3x Square Only</option>
					</select>
					
				</div>
			
				<div class="form-container">
					<label for="article_ad_banner">Banner Advert: </label>
					<select name="article_ad_banner" id="article_ad_banner"><?php populate_ads('banner','',$article_ad_banner); ?></select>
				</div>
				
				<div class="form-container">
					<label for="article_ad_sky">Skyscraper Advert: </label>
					<select name="article_ad_skyscraper" id="article_ad_skyscraper"><?php populate_ads('skyscraper','',$article_ad_skyscraper); ?></select>
				</div>
				<div class="form-container">
					<label for="article_ad_square1">Square Advert 1: </label>
					<select name="article_ad_square1" id="article_ad_square1"><?php populate_ads('square1','',$article_ad_square1); ?></select>
				</div>
				<div class="form-container">
					<label for="article_ad_square2">Square Advert 2: </label>
					<select name="article_ad_square2" id="article_ad_square2"><?php populate_ads('square2','',$article_ad_square2); ?></select>
				</div>
				<div class="form-container">
					<label for="article_ad_square3">Square Advert 3: </label>
					<select name="article_ad_square3" id="article_ad_square3"><?php populate_ads('square3','',$article_ad_square3); ?></select>
				</div>
				
			</div>-->
				
			<div class="form-container">
			<input type="submit" value="preview article" name="preview" id="article_preview" onclick="article_form.action='preview_article.php'" />
			<input type="submit" value="add article" name="submit" id="article_submit" />
			</div>
			</form>	
		
				<div style="clear:both;"></div>
		
			</div>
		
		</div>
		
		</div>
		
		<div class="bottom-round"><div class="bottom-left"></div></div>

</body>
</html>