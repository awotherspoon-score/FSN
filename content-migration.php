<?php

@$folder = $_POST['folder_name'];

$results=0;
$skipped=array();
$s=0;

/////////////////////////////////////////////////////////////////////////////////////
// FORM TO ALLOW FOR FOLDER SELECTION AND TO STOP ACCIDENTAL RUNNING OF THE SCRIPT // /////////////////////////////////////////////////////////////////////////////////////


?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">

	<label for="folder_name"><strong>folder name:</strong> channel_</label><input type="text" value="<?php echo @$folder; ?>" name="folder_name"/>
	
	<label for="mysql">Send to DB: </label><input type="checkbox" name="mysql" />

	<input type="submit" value="run" name="run" />

</form>

<div><strong>number of results:</strong> <span id="results"></span></div>
<div><strong>skipped:</strong> <span id="skipped"></span></div>
<div><strong>total:</strong> <span id="total"></span></div>

<?php


///////////////////////////////////////////////////////////////////////////////
// CHECK TO SEE IF RUN HAS BEEN CLICKED THEN RUN SCRIPT FOR SPECIFIED FOLDER //
///////////////////////////////////////////////////////////////////////////////


if(@$_POST['run'])
{

	#$folder = "bi_bpm_cpm";

	$open_folder = opendir("../../../../fsn/public/channel_$folder/");
	
	$file_array = array();
	$u=0;
	
	while ($name = readdir($open_folder))
	{
		
		if($name == '.' || $name == '..' || $name == '...' || $name == '_notes')
		{
			continue;
		}
		
		$file_array[$u] = $name;
		
		$u++;
	}
	
	#var_dump($file_array);
	
	$w = 0;
	$flimit = count($file_array);
	
	while($w<$flimit)
	{
			
		if(is_file("../../../../fsn/public/channel_$folder/$file_array[$w]"))
		{
			echo "<hr />";
			echo "<strong>filename:</strong> <a href=\"../../../../fsn/public/channel_$folder/$file_array[$w]\" target=\"_blank\">".$file_array[$w]."</a><br /><br />";

			if(substr_count($file_array[$w],"archive")==0&&substr_count($file_array[$w],"home.htm")==0&&substr_count($file_array[$w],"homeone.htm")==0&&substr_count($file_array[$w],"wp_")==0&&substr_count($file_array[$w],"pr_")==0&&substr_count($file_array[$w],'conf_')==0)
			{
				$output = write_to_db("../../../../fsn/public/channel_$folder/$file_array[$w]",$folder,'feature');
				
			}elseif(substr_count($file_array[$w],"wp_")!=0){
				
				$output = write_to_db("../../../../fsn/public/channel_$folder/$file_array[$w]",$folder,'white-paper');
			}else{
				global $skipped;
				global $s;
				$s++;
				$skipped[$s] = $file_array[$w];

			}
			
		}elseif(is_dir("../../../../fsn/public/channel_$folder/$file_array[$w]"))
		{
			$inner_folder = $file_array[$w];
	
			$open_inner_folder = opendir("../../../../fsn/public/channel_$folder/$inner_folder");
			
			$inner_file_array = array();
			$t=0;
			
			while ($inner_name = readdir($open_inner_folder))
			{
				
				if($inner_name == '.' || $inner_name == '..' || $inner_name == '...' || $inner_name == '_notes')
				{
					continue;
				}
				
				$inner_file_array[$t] = $inner_name;
				
				
			
				$t++;
			}
			
			$v = 0;
			$iflimit = count($inner_file_array);
			
			while($v<=$iflimit)
			{
		
				if(is_file("../../../../fsn/public/channel_$folder/$inner_folder/$inner_file_array[$v]"))
				{
					
				echo "<hr />";
				echo "<strong>filename:</strong> <a href=\"../../../../fsn/public/channel_$folder/$inner_folder/$inner_file_array[$v]\" target=\"_blank\">".$inner_file_array[$v]."</a><br /><br />";
			
				echo "NEWS";
				
					$output = write_to_db("../../../../fsn/public/channel_$folder/$inner_folder/$inner_file_array[$v]",$folder,'news');
						
				}
				
				$v++;
				
			}
		
		}
		   
		$w++;
	}

}


  ///////////////////////////////////////////////////////////////////////////////////
 // FUNCTION THAT PROCESSES PAGES WITHING FOLDER AND OUTPUTS THE VARIOUS SECTIONS //
///////////////////////////////////////////////////////////////////////////////////


function write_to_db($file,$folder,$type){
	
	global $results;

	if($connect = mysql_connect("localhost","root",""))
	{
		mysql_select_db("fsn",$connect);
	}else
	{
		echo "There was an error connecting to the database, please contact the administrator";	
	}	
	
	$page = file($file);
	
	$y=0;
	
	$limit = count($page);
	while($y<$limit)
	{
		
		if(substr_count($page[$y],'<title>')!=0)
		{
	
			$comp_title = $page[$y];
			
			$pre_title = trim(str_replace(array("FSN","White Paper",":"),'',strip_tags($comp_title)));
			
		}
		
		if(@!$pre_title){
			
			if(substr_count($page[$y],'class="headlines14"')!=0)
			{
	
			$comp_title = $page[$y];
			
			$pre_title = trim(strip_tags($comp_title));
			
			}
				
			}
		
		/*if(substr_count($page[$y],'name="main"')!=0||substr_count($page[$y],'name="mainnews"')!=0||substr_count($page[$y],'name="title"')!=0)
		{*/
			
		if(substr_count($page[$y],'<body')!=0)
		{
		
			$x = $y-1;
		
		}elseif(substr_count($page[$y],'<!-- Start of StatCounter Code -->')!=0||substr_count($page[$y],'http://www.statcounter.com/counter/counter.js'))
		{
			$end = $y;
		}
		
		$y++;
	}
	
	if(!$end){
		$end = 	$limit;
	}
	
	$content = '';
	$orig_content = '';
	$links = '';
	$intro = '';
	$img = array();
	$z = 0;
	
	while($x<$end)
	{
		
		unset($comp_img,$comp_date,$comp_content,$comp_intro,$comp_links);
		
		  ////////////
		 // IMAGES //
		////////////
		
		if(substr_count($page[$x],'<img')!=0&&substr_count($page[$x],'<a')==0&&substr_count($page[$x],'printer.jpg')==0&&substr_count($page[$x],'/navigation/')==0)
		{
			$pos = strpos(trim(strip_tags($page[$x],'<img>')),'>')+1;
			$comp_img = substr_replace(trim(strip_tags($page[$x],'<img>')),'',$pos);
		}
		
		  //////////
		 // DATE //
		//////////
		
		if(substr_count($page[$x],'class="date"')!=0)
		{
			$comp_date = $page[$x];
		
		  ///////////
		 // INTRO //
		///////////
		
		}elseif(substr_count($page[$x],'<em>')!=0||substr_count($page[$x],'</em>')!=0)
		{
			
			if(trim(strip_tags($page[$x]))){
			
				$comp_intro = $page[$x];
				
			}
			
		  //////////////////
		 // MAIN CONTENT //
		//////////////////
		
		}elseif(substr_count($page[$x],'<tr')==0&&substr_count($page[$x],'<td')==0&&substr_count($page[$x],'</tr')==0&&substr_count($page[$x],'<em>')==0&&substr_count($page[$x],'</em>')==0&&substr_count($page[$x],'Other related FSN articles')==0&&substr_count($page[$x],$pre_title)==0&&substr_count($page[$x],'var ')==0)
		{
			
			if(trim(strip_tags($page[$x])))
			{
				$comp_content = $page[$x];
			}
		
		}elseif(substr_count($page[$x],'<td')!=0&&substr_count($page[$x],'class="bodytext12"')!=0)
		{
			
			if(trim(strip_tags($page[$x])))
			{
				$comp_content = $page[$x];
			}
			
		  ////////////	
		 // IMAGES //
		////////////
		
		}elseif(substr_count($page[$x],'<img')!=0&&substr_count($page[$x],'<a')==0&&substr_count($page[$x],'printer.jpg')==0&&substr_count($page[$x],'/navigation/')==0)
		{
			
			if(trim(strip_tags($page[$x],'<img>')))
			{
				$comp_content = $page[$x];
			}
	
			#$pos = strpos(trim(strip_tags($page[$x],'<img>')),'>')+1;
			#$comp_img = substr_replace(trim(strip_tags($page[$x],'<img>')),'',$pos);
			
		  ///////////	
		 // LINKS //
		///////////
		
		}
		
		if(substr_count($page[$x],'<a href')!=0)
		{
			$comp_links = $page[$x];
		}
		
		  //////////
		 // DATE //
		//////////
		
		if(@$comp_date)
		{
			if(substr_count($comp_date,'Januaray')!=0){
				$comp_date = str_replace('Januaray','January',$comp_date);
			}elseif(substr_count($comp_date,'Februray')!=0){
				$comp_date = str_replace('Februray','February',$comp_date);
			}
			
			$check_len  = trim(str_replace("&nbsp;","",strip_tags($comp_date)));
			
			if(strlen($check_len)>19&&substr_count($page[$x],'<em>')!=0)
			{		
				$giblets = explode("<br>",$comp_date);
				
				$date = strtotime(trim(strip_tags($giblets[0])));
				$intro = trim(mysql_escape_string(strip_tags(str_replace(array('‘','’','“','”'),array('\'','\'','"','"'),$giblets[1]))));
				
			}elseif(strlen($check_len)>19&&substr_count($page[$x],'<em>')==0)
			{		
				$giblets = explode("<br>",$comp_date);
				
				$date = strtotime(trim(strip_tags($giblets[0])));
				$content .= "<p>".trim(mysql_escape_string(strip_tags(str_replace(array('‘','’','“','”'),array('\'','\'','"','"'),$comp_content),'<a><img>')))."</p>";
				
			}elseif(!$check_len){
				
				$date = 0;
				
			}else{
				
				$date = strtotime(trim(str_replace("&nbsp;","",strip_tags($comp_date))));
			}
			
		}elseif(@$comp_intro)
		{
			$intro = trim(mysql_escape_string(strip_tags(str_replace(array('‘','’','“','”'),array('\'','\'','"','"'),$comp_intro),'<a>')));
			
		}elseif(@$comp_content)
		{

			if(substr_count($page[$x],'class="headlines12"')!=0)
			{
				/*$content .= "<p><strong>".trim(mysql_escape_string(strip_tags(str_replace(array('‘','’','“','”'),array('\'','\'','"','"'),$comp_content),'<a><img>')))."</strong></p>";*/
				
				if(substr_count($comp_content,'<img')!=0)
				{
					
					$content .= "<p><strong>".trim(mysql_escape_string(str_replace(array('‘','’','“','”','../'),array('\'','\'','"','"','http://www.fsn.co.uk/'),strip_tags($comp_content,'<a><img>'))))."</strong></p>";
								
				}else
				{
					
					$content .= "<p><strong>".trim(mysql_escape_string(strip_tags(str_replace(array('‘','’','“','”'),array('\'','\'','"','"'),$comp_content),'<a>')))."</strong></p>";
					
				}
				
			}else
			{
				
				if(substr_count($comp_content,'<img')!=0)
				{	
					$content .= "<p>".trim(mysql_escape_string(str_replace(array('‘','’','“','”','../'),array('\'','\'','"','"','http://www.fsn.co.uk/'),strip_tags($comp_content,'<a><img>'))))."</p>";
								
				}else
				{
					$content .= "<p>".trim(mysql_escape_string(strip_tags(str_replace(array('‘','’','“','”'),array('\'','\'','"','"'),$comp_content),'<a>')))."</p>";
					
				}
				
			}
			
		}elseif(@$comp_links)
		{
			if(trim(strip_tags($comp_links))){
				$links .= trim(mysql_escape_string(strip_tags($comp_links,'<a>').","));
			}
		}
		
		if(@$comp_img)
		{
			$img[$z] = trim($comp_img);
			$a = $z;
			$z++;
		}
		
		$x++;
	
	}
	
	$slug = str_replace(array("channel_$folder/",'.html','.htm','news/'),'',$file);
	$alias = $file;
			
	if(@$comp_title)
	{
		$title = mysql_escape_string(trim(str_replace(array("FSN","White Paper",":",".co.uk"),'',strip_tags($comp_title))));
	}
	
	echo "<h1>";
	if($img){ echo "IMAGE: <span style='color:green;'>YES</span>"; }else{ echo "IMAGE: <span style='color:red;'>NO</span>"; }
	if($title){ echo " | TITLE: <span style='color:green;'>YES</span>"; }else{ echo " | TITLE: <span style='color:red;'>NO</span>"; }
	if($date){ echo " | DATE: <span style='color:green;'>YES</span>"; }else{ echo " | DATE: <span style='color:red;'>NO</span>"; }
	if($intro){ echo " | INTRO: <span style='color:green;'>YES</span>"; }else{ echo " | INTRO: <span style='color:red;'>NO</span>"; }
	if($content){ echo " | CONTENT: <span style='color:green;'>YES</span>"; }else{ echo " | CONTENT: <span style='color:red;'>NO</span>"; }
	if($links){ echo " | LINKS: <span style='color:green;'>YES</span>"; }else{ echo " | LINKS: <span style='color:red;'>NO</span>"; }
	echo "</h1>";
	
	if($date)
	{
		$echo_date = date("d F Y",$date);
	}else
	{
		$echo_date = 'N/A';
	}
	echo ($x-1)."<br />";
	
	if($x-1==215)
	{
		#echo var_dump($page);
	}
	
	echo /*var_dump(str_replace('..','http://www.fsn.co.uk',$img)).*/"<h1>".$title."</h1><h2>".$echo_date."</h2><em>".$intro."</em>".$content."<br />";
	echo "\n\n\n";
		
	#echo var_dump($page);
	
	$results++;
	
	if(@$_POST['mysql']){
	
		$insert = mysql_query("INSERT INTO articles (article_id,article_title,article_date,article_intro,article_content,article_sector,article_type,article_img,article_link,article_showcase,article_slug,article_alias) VALUES ('','$title','$date','$intro','$content','$folder','$type','$img','','','$slug','$alias')");
		
		if($insert)
		{
			$page_id = mysql_insert_id();
			
			$htaccess = $_SERVER['DOCUMENT_ROOT']."/score/scorecomms.com/htdocs/fsn/.htaccess";
		
			$newLink = "RewriteRule ^http://www.fsn.co.uk/$alias$ /page.php?id=$page_id \r\n";
			
			$fh = fopen($htaccess, 'a+');
			fwrite($fh, $newLink);
			fclose($fh);
			
		}else{die(mysql_error()); }
	
	}

}

function update_htaccess($id, $oldname, $newname) {
	
	$htaccess = $_SERVER['DOCUMENT_ROOT']."/score/scorecomms.com/htdocs/fsn/.htaccess";
	$lines = file($htaccess);

	foreach($lines as &$line) {
		if (strpos($line, "^".$newname."$")) {
			$line = "";
		}elseif (strpos($line, "^".$oldname."$")) {
			$line = "RewriteRule ^{$oldname}$ /{$newname} [R=301] \r\n";
		}elseif (strpos($line, "/".$oldname)) {
			$line = preg_replace("*/{$oldname} *", "/$newname ", $line);
		}
		
	}
	
	file_put_contents($htaccess, implode('', $lines));
	
	$new_line = "ReWriteRule ^{$newname}$ /page.php?id=$id \r\n";
		
	$fh = fopen($htaccess, 'a+');
	fwrite($fh, $new_line);
	fclose($fh);

}
echo var_dump($skipped);
?>

<script type="text/javascript">

	function fire(){
		document.getElementById('results').innerHTML="<?php echo $results; ?>";
		document.getElementById('skipped').innerHTML="<?php echo $s; foreach($skipped as $filename){echo "<br />".$filename;} ?>";
		document.getElementById('total').innerHTML="<?php echo $s+$results; ?>";
	}
	
	window.onload = fire;

</script>