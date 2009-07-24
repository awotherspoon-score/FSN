<?php

	@$filter = $_GET['filter'];
	@$section = $_GET['section'];

	header("Content-Type: text/xml"); 
	
	include("../includes/connect.php"); 
	mysql_select_db('fsn', $connect) or die ( mysql_error());
	
	if($filter&&$section){
		
		if($filter=='special'){
			
			$get_articles = mysql_query("SELECT * FROM articles WHERE article_ma='1' AND article_hide!=1 ORDER BY article_date DESC LIMIT 10");
			
		}else{
		
			$get_articles = mysql_query("SELECT * FROM articles WHERE article_$filter='$section' AND article_hide!=1 ORDER BY article_date DESC LIMIT 10");
		
		}
	
	}else{
		
		$get_articles = mysql_query("SELECT * FROM articles ORDER BY article_date DESC LIMIT 10");
		
	}
	
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';

							
	$get_section_title = mysql_query("SELECT section_plural,section_singular FROM sections WHERE section_alias='$section'");
	
	$section_info = mysql_fetch_array($get_section_title);
	
	extract($section_info);
	
?>

<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">

	<channel>
	
		<atom:link href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/feeds/fsn-rss.php" rel="self" type="application/rss+xml" />

		<title><![CDATA[FSN - <?php echo html_entity_decode($section_plural); ?> ]]></title>
		<description><![CDATA[Latest <?php echo html_entity_decode($section_singular); ?> articles on FSN]]></description>
		<link><![CDATA[<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_<?php echo $section; ?>]]></link>
		
<?php

		while ($article_info = mysql_fetch_array($get_articles)){
			
			extract($article_info);
			
			#$replace = array('\"',' & ','\'','&rsquo;','&pound;');
			#$with = array('&quot;','&amp;','&apos;','&apos;','&#163;');
			
			#$mainText = substr(strip_tags($newsRow['mainText']),0,160);
			#$description_text = str_replace($replace,$with,$mainText);
			/*$mainText = preg_replace("§\<(IMG|img).*?\>§i", "",$mainText);*/
			
			$search = array('&quot;','&apos;','&rsquo;','&lsquo;','&rdquo;','&ldquo;','&ndash;','&pound;');
			$replace = array('"','\'','\'','\'','"','"','-','£');
			
?>
			<item>
			<title><![CDATA[<?php echo str_replace($search,$replace,html_entity_decode($article_title)); ?>]]></title>
			<link><?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_<?php echo $article_sector; ?>/<?php echo $article_slug; ?></link>
			<guid><?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_<?php echo $article_sector; ?>/<?php echo $article_slug; ?></guid>
			<!--<description><?php echo $article_intro; ?>...</description>-->
			</item>
			
<?php
			
		}
		
?>

	</channel>
</rss>