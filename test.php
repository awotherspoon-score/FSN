<?php

$folder = "channel_bi_bpm_cpm";

$open_folder = file("d:\\wamp\\www\\fsn\\public\\$folder");

$w = 0;
$flimit = count($open_folder);

while($w<=$flimit){
	
	if(is_file($open_folder[$w])){
		
		write_to_db($folder);
		
	}elseif(is_dir($open_folder[$w])){
	
		$inner_folder = $open_folder[$w];
		
		$open_inner_folder = file("d:\\wamp\\www\\fsn\\public\\$folder\\$inner_folder");
		
		$v = 0;
		$iflimit = count($open_inner_folder);
		
		while($v<=$iflimit){
	
			if(is_file($ope_inner_folder[$v])){
				
				write_to_db($inner_folder);
				
			}
			
			$v++;
			
		}
	
	}
	   
	$w++;
}

function write_to_db($folder){

	if($connect = mysql_connect("localhost","root","")){
		mysql_select_db("fsn",$connect);
	}else{
		echo "There was an error connecting to the database, please contact the administrator";	
	}
	
	# http://fsn.co.uk/channel_financial_reporting/why_we_need_creative_accountants_not_creative_accounting.htm
	
	
	$page = file("http://fsn.co.uk/channel_bi_bpm_cpm/int_with_bernard_liautaud_ceo_business_objects.htm");
	
	$y=0;
	
	$limit = count($page);
	while($y<=$limit){
		
		if(substr_count($page[$y],'<title>')!=0){
	
			$comp_title = $page[$y];
			
			$pre_title = trim(str_replace(array("FSN","White Paper",":"),'',strip_tags($comp_title)));
			
		}
		
		if(substr_count($page[$y],'name="main"')!=0){
		
			$x = $y;
		
		}elseif(substr_count($page[$y],'<!-- Start of StatCounter Code -->')!=0){
			$end = $y;
		}
		$y++;
	}
	
	$content = '';
	$orig_content = '';
	$links = '';
	$intro = '';
	
	while($x<$end){
		
		unset($comp_date,$comp_content,$comp_intro,$comp_links);
		
		if(substr_count($page[$x],'<img')!=0&&substr_count($page[$x],'<a')==0){
			$pos = strpos(trim(strip_tags($page[$x],'<img>')),'>')+1;
			$comp_img = substr_replace(trim(strip_tags($page[$x],'<img>')),'',$pos);
		}
		
		if(substr_count($page[$x],'class="date"')!=0){
			
			$comp_date = $page[$x];
			
		/*}elseif(substr_count($page[$x],'class="mainheadline16"')!=0||substr_count($page[$x],'class="headlines14"')!=0&&!$comp_title){
	
			$comp_title = $page[$x];
			*/
		}elseif(substr_count($page[$x],'<tr')==0&&substr_count($page[$x],'<td')==0&&substr_count($page[$x],'</tr')==0&&substr_count($page[$x],'<em>')==0&&substr_count($page[$x],'Other related FSN articles')==0&&substr_count($page[$x],$pre_title)==0){
				
			
			#&&substr_count($page[$x],'<a hr')==0         &&substr_count($page[$x],'<img')==0
			/*$pre_para = trim($page[$x]);
			
			$orig_content .= "|".$pre_para;
	
			#$post_para = str_replace("<br><br>","</p><p>","$pre_para");
			#$br_start = strpos($pre_para,"<br>");
			$br_end = strrpos($pre_para,"<br>");
			
			if($pre_para=="<br>"){
				
				$post_para = "";
			
			}elseif(substr_count($pre_para,'<span class="bodytext12">')!=0){
				$post_para = str_replace(array('<span class="bodytext12">','</span>'),array('<p>',''),$pre_para);
			}else{
				#$post_para = substr_replace($post_para,"<p>",$br_start,4);
				$post_para = substr_replace($pre_para,"</p><p>",$br_end,4);
			}
			
			$content .= $post_para;*/
			
			if(trim(strip_tags($page[$x]))){
			
				$comp_content = $page[$x];
			
			}
		
		
		/*}elseif(substr_count($page[$x],'<img')!=0&&substr_count($page[$x],'<a')==0){
			
				$comp_img = $page[$x];
		*/
		}elseif(substr_count($page[$x],'<em>')!=0){
			
				$comp_intro = $page[$x];
		
		}elseif(substr_count($page[$x],'<a href')!=0){
			
				$comp_links = $page[$x];
		
		}
		
		if(@$comp_date){
			$date = trim(strtotime(strip_tags($comp_date)));
			if(strlen($date>19)){
				$giblets = explode("<br>",$comp_date);
				
				$date = trim(strtotime(strip_tags($giblets[0])));
				$intro = trim(mysql_escape_string(strip_tags($giblets[1])));		  
			}
		}elseif(@$comp_intro){
			$intro = trim(mysql_escape_string(strip_tags($comp_intro,'<a>')));
		}elseif(@$comp_content){
			if(substr_count($page[$x],'class="headlines12"')!=0){
				$content .= mysql_escape_string("<p><strong>".trim(strip_tags($comp_content),'<a>')."</strong></p>");
			}else{
				$content .= "<p>".trim(mysql_escape_string(strip_tags($comp_content,'<a>')))."</p>";
			}
		}elseif(@$comp_links){
			$links .= trim(mysql_escape_string(strip_tags($comp_links,'<a>').","));
		}
	
		$x++;
	
	}
	
	if(@$comp_title){
		#$title = strip_tags(trim($comp_title),'<a>');
		$title = mysql_escape_string(trim(str_replace(array("FSN","White Paper",":"),'',strip_tags($comp_title))));
	}
	
	if(@$comp_img){
		$img = trim($comp_img);
	}
	
	#echo $img ."\n<h1>".$title."</h1>\n<h2>".$date."</h2>\n".$intro."\n".$content."\n".$links."\n";
	
	$insert = mysql_query("INSERT INTO articles (article_id,article_title,article_date,article_intro,article_content,article_sector,article_type,article_img,article_link,article_showcase) VALUES ('','$title','$date','$intro','$content','test','feature','$img','','')");
	
	if(!$insert){ die(mysql_error()); }
	
	#echo "\n\n\n";
	
	#var_dump($test);

}

?>