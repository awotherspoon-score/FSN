<?php

error_reporting(0);

include("connect.php");

$x = $_GET['f'];

$filter = $_GET['filter'];
$section = $_GET['section'];

if($filter&&$section){
	
	if($filter=='special')
	{
		#$section_sector = str_replace('-','_',$section);
		#$section_type = str_replace('_','-',$section);
		
		$get_showcase = mysql_query("SELECT * from articles WHERE article_type!='news' AND article_ma='1' AND article_hide!=1 ORDER BY article_date DESC LIMIT 1 OFFSET $x");
			
	}else{

		$get_showcase = mysql_query("SELECT * from articles WHERE article_type!='news' AND article_$filter='$section' AND article_hide!=1 ORDER BY article_date DESC LIMIT 1 OFFSET $x");
		
	}

}else{

	$get_showcase = mysql_query("SELECT * from articles WHERE article_type!='news' AND article_hide!=1 ORDER BY article_date DESC LIMIT 1 OFFSET $x");

}

$showcase_info = mysql_fetch_array($get_showcase);

extract($showcase_info);

$search = array(" ", "&amp;", ",", "--");
$replace = array("-", "", "", "-");
								
$get_section_title = mysql_query("SELECT section_plural,section_singular from sections WHERE section_alias='$article_type'");

$section_info = mysql_fetch_array($get_section_title);

?>

<div class="feature-header <?php echo $article_type; ?>">
	<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
	<div class="header-content">
		<h2><?php echo strtoupper(str_replace(array('_','-'),array(' ',' '),$article_type)); ?><?php if($filter&&$section){}elseif($article_sector){ ?> - <a href="channel_<?php echo strtolower(str_replace($search,$replace,$article_sector)); ?>"><?php echo str_replace("_"," ",$article_sector); ?></a><?php } ?></h2><div class="title-right"><a href="channel_<?php echo strtolower(str_replace(' ','_',$section_info['section_plural'])); ?>">view more &raquo;</a></div>
		<div style="clear:both;"></div>
	</div>
</div>
<div class="feature-content">
	<img src="<?php echo $article_img; ?>" alt="sponsor logo"/>
	<h3><a href="<?php echo "channel_".$article_sector."/".$article_slug; ?>"><?php echo $article_title; ?></a></h3>
	<h4><?php echo date("jS F Y", $article_date); ?></h4>
	<p><?php echo str_replace(array("<em>","</em>"),array("",""),$article_intro); ?></p>
	<p><a href="<?php echo "channel_".$article_sector."/".$article_slug; ?>"><?php if($article_type=="webinar"){ echo "view now"; }else{ echo "read more"; } ?> &raquo;</a></p>
</div>