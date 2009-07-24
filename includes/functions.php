<?php

function get_adverts($article,$page,$section,$ad_type){

	if($article){ $table = 'articles'; $name = 'article'; $identifier = 'article_id'; $value = $article; }
	elseif($page){ $table = 'pages'; $name = 'page'; $identifier = 'page_title'; $value = $page; }
	elseif($section){ $table = 'sections'; $name = 'section'; $identifier = 'section_alias'; $value = $section; }
	/*elseif($course){ $table = 'courses'; $name = 'course'; $identifier = 'course_id'; $value = $course; }*/
	
	# AD_LAYOUT: 0=default, 1=none, 2=banner only, 3=banner+sky, 4=banner+squares, 5=sky only, 6=squares only
	
	if($ad_type=='banner')
	{
		$get_current_page = mysql_query("SELECT {$name}_ad_layout,{$name}_ad_banner FROM $table WHERE $identifier='$value'");
		
		$current_page_info = mysql_fetch_array($get_current_page);
		
		extract($current_page_info);
		
		if(${$name."_ad_layout"}=='2'||${$name."_ad_layout"}=='3'||${$name."_ad_layout"}=='4')
		{			
			$get_advert = mysql_query("SELECT * FROM adverts WHERE ad_id=${$name.'_ad_banner'}");

			$ad_info = mysql_fetch_array($get_advert);
			
			extract($ad_info);

			?>
			
			<div id="top-banner">
				<img src="<?php echo $ad_loc; ?>" target="_blank" width="<?php echo $ad_width; ?>" height="<?php echo $ad_height; ?>" />
			</div>
			
			<?php
			
		}elseif(${$name."_ad_layout"}=='0')
		{			
			$get_current_page = mysql_query("SELECT article_sector FROM $table WHERE $identifier='$value'");
			
			$current_page_info = mysql_fetch_array($get_current_page);
			
			extract($current_page_info);

			$get_section = mysql_query("SELECT section_ad_layout,section_ad_banner FROM sections WHERE section_alias='$article_sector'");
			
			$section_info = mysql_fetch_array($get_section);
			
			extract($section_info);
			
			if($section_ad_layout=='2'||$section_ad_layout=='3'||$section_ad_layout=='4')
			{
				$get_advert = mysql_query("SELECT * FROM adverts WHERE ad_id=$section_ad_banner");
	
				$ad_info = mysql_fetch_array($get_advert);
				
				extract($ad_info);
	
				?>
				
				<div id="top-banner">
					<img src="<?php echo $ad_loc; ?>" target="_blank" width="<?php echo $ad_width; ?>" height="<?php echo $ad_height; ?>" />
				</div>
				
				<?php
			
			}
			
		}
	
	}elseif($ad_type=='side')
	{		
		$get_current_page = mysql_query("SELECT {$name}_ad_layout,{$name}_ad_sky,{$name}_ad_square1,{$name}_ad_square2,{$name}_ad_square3 FROM $table WHERE $identifier='$value'");
		
		$current_page_info = mysql_fetch_array($get_current_page);
		
		extract($current_page_info);
		
		if(${$name."_ad_layout"}=='3'||${$name."_ad_layout"}=='5')
		{
			
			$get_advert = mysql_query("SELECT * FROM adverts WHERE ad_id=${$name.'_ad_sky'}");

			$ad_info = mysql_fetch_array($get_advert);
			
			extract($ad_info);

			?>
			
			<div class="advert">
				<img src="<?php echo $ad_loc; ?>" target="_blank" width="<?php echo $ad_width; ?>" height="<?php echo $ad_height; ?>" />
			</div>
			
			<?php
			
		}elseif(${$name."_ad_layout"}=='4'||${$name."_ad_layout"}=='6')
		{
			
			if(${$name.'_ad_square1'}!=0)
			{
				$get_advert = mysql_query("SELECT * FROM adverts WHERE ad_id=${$name.'_ad_square1'}");
	
				$ad_info = mysql_fetch_array($get_advert);
				
				extract($ad_info);
	
				?>
				
				<div class="advert">
					<img src="<?php echo $ad_loc; ?>" target="_blank" width="<?php echo $ad_width; ?>" height="<?php echo $ad_height; ?>" />
				</div>
			
			<?php
			
			}
			
			if(${$name.'_ad_square2'}!=0)
			{			
				$get_advert = mysql_query("SELECT * FROM adverts WHERE ad_id=${$name.'_ad_square2'}");

				$ad_info = mysql_fetch_array($get_advert);
				
				extract($ad_info);
	
				?>
				
				<div class="advert">
					<img src="<?php echo $ad_loc; ?>" target="_blank" width="<?php echo $ad_width; ?>" height="<?php echo $ad_height; ?>" />
				</div>
			
			<?php
			
			}
			
			if(${$name.'_ad_square3'}!=0)
			{			
				$get_advert = mysql_query("SELECT * FROM adverts WHERE ad_id=${$name.'_ad_square3'}");
	
				$ad_info = mysql_fetch_array($get_advert);
				
				extract($ad_info);
	
				?>
				
				<div class="advert">
					<img src="<?php echo $ad_loc; ?>" target="_blank" width="<?php echo $ad_width; ?>" height="<?php echo $ad_height; ?>" />
				</div>
			
			<?php
			
			}
			
		}elseif(${$name."_ad_layout"}=='0')
		{			
			
			$get_current_page = mysql_query("SELECT article_sector FROM $table WHERE $identifier='$value'");
			
			$current_page_info = mysql_fetch_array($get_current_page);
			
			extract($current_page_info);

			$get_section = mysql_query("SELECT section_ad_layout,section_ad_sky,section_ad_square1,section_ad_square2,section_ad_square3 FROM sections WHERE section_alias='$article_sector'");
			
			$section_info = mysql_fetch_array($get_section);
			
			extract($section_info);
			
			if($section_ad_layout=='3'||$section_ad_layout=='5')
			{
				$get_advert = mysql_query("SELECT * FROM adverts WHERE ad_id=$section_ad_sky");
	
				$ad_info = mysql_fetch_array($get_advert);
				
				extract($ad_info);
	
				?>
				
				<div class="advert">
					<img src="<?php echo $ad_loc; ?>" target="_blank" width="<?php echo $ad_width; ?>" height="<?php echo $ad_height; ?>" />
				</div>
				
				<?php
				
			}elseif($section_ad_layout=='4'||$section_ad_layout=='6')
			{	
				if($section_ad_square1!=0)
				{					
					$get_advert = mysql_query("SELECT * FROM adverts WHERE ad_id=$section_ad_square1");
		
					$ad_info = mysql_fetch_array($get_advert);
					
					extract($ad_info);
		
					?>
					
					<div class="advert">
						<img src="<?php echo $ad_loc; ?>" target="_blank" width="<?php echo $ad_width; ?>" height="<?php echo $ad_height; ?>" />
					</div>
				
				<?php
				
				}
				
				if($section_ad_square2!=0)
				{
					$get_advert = mysql_query("SELECT * FROM adverts WHERE ad_id=$section_ad_square2");
		
					$ad_info = mysql_fetch_array($get_advert);
					
					extract($ad_info);
		
					?>
					
					<div class="advert">
						<img src="<?php echo $ad_loc; ?>" target="_blank" width="<?php echo $ad_width; ?>" height="<?php echo $ad_height; ?>" />
					</div>
				
				<?php
				
				}
				
				if($section_ad_square3!=0)
				{				
					$get_advert = mysql_query("SELECT * FROM adverts WHERE ad_id=$section_ad_square3");
		
					$ad_info = mysql_fetch_array($get_advert);
					
					extract($ad_info);
		
					?>
					
					<div class="advert">
						<img src="<?php echo $ad_loc; ?>" target="_blank" width="<?php echo $ad_width; ?>" height="<?php echo $ad_height; ?>" />
					</div>
				
				<?php
				
				}
				
			}
			
		}
	
	}
	
	#$get_advert = mysql_query("SELECT * FROM adverts WHERE ad_id=$ad_id");
	
	#$ad_info = mysql_fetch_array($get_advert);
	
	#extract($ad_info);
	
	?>
	
	<!--<img src="<?php echo $ad_loc; ?>" target="_blank" width="<?php echo $ad_width; ?>" height="<?php echo $ad_height; ?>" />-->
	
	<?php
	
}

function get_news($filter,$section){
	
	if($filter&&$section)
	{
		if($filter=='special')
		{
			/*$section_sector = str_replace('-','_',$section);
			$section_type = str_replace('_','-',$section);*/
			
			$get_news = mysql_query("SELECT article_sector,article_slug,article_title,article_date FROM articles WHERE article_type='news' AND article_hide!='1' AND article_ma='1' ORDER BY article_date DESC LIMIT 6");
			
		}else
		{
		
			$get_news = mysql_query("SELECT article_sector,article_slug,article_title,article_date FROM articles WHERE article_type='news' AND article_hide!='1' AND article_$filter='$section' ORDER BY article_date DESC LIMIT 6");
		
		}
		
	}else{

		$get_news = mysql_query("SELECT article_sector,article_slug,article_title,article_date FROM articles WHERE article_type='news' AND article_hide!='1' ORDER BY article_date DESC LIMIT 6");
	
	}

	while($news_info = mysql_fetch_array($get_news))
	{
		extract($news_info);
		
			if($article_date!=@$prev_date){
			?>
			
			<li class="news-date"><?php echo date("d M y",$article_date); ?></li>
		
		<?php
		}
		
		$get_sector = mysql_query("SELECT * FROM sections WHERE section_alias='$article_sector'");
	
		$sectors = mysql_fetch_array($get_sector);
	
		extract($sectors);
		
		?>									

		<li>
		<?php
		
		if(!$filter||$filter=="special"){
		?>
			<span class="sector-tag-container">
			<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/channel_".$article_sector;?>">
				<div class="sector-tag">
					<div class="tag-top-corners"><div class="tag-corner-top-left"></div></div>
					<div class="sector-tag-content"><?php echo $section_plural;?></div>
					<div class="tag-bottom-corners"><div class="tag-corner-bottom-left"></div></div>
				</div>
			</a>
		</span>
		<?php } ?><a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/channel_".$article_sector."/news/".$article_slug; ?>"><?php echo $article_title; ?></a>
		</li>
	
	<?php
	
		$prev_date = $article_date;
	
	}
	
}


function get_articles($filter,$section){

	if($filter=='special')
	{
		$section_sector = str_replace('-','_',$section);
		$section_type = str_replace('_','-',$section);
		
		$get_articles = mysql_query("SELECT article_sector,article_slug,article_date, article_title, article_type FROM articles WHERE article_ma='1' AND article_hide!=1 ORDER BY article_date DESC LIMIT 3");
				
	}else{
	
		$get_articles = mysql_query("SELECT article_sector,article_slug,article_date, article_title, article_type FROM articles WHERE article_$filter='$section' AND article_hide!=1 ORDER BY article_date DESC LIMIT 3");
		
	}

	while($article_info = mysql_fetch_array($get_articles))
	{
	extract($article_info);
	
	if($article_date!=@$prev_date){
		?>
		
		<li class="article-date"><?php echo date("d M y",$article_date); ?></li>
		
		<?php
	}
				
	$get_sector = mysql_query("SELECT * FROM sections WHERE section_alias='$article_sector'");
	
	$sectors = mysql_fetch_array($get_sector);
	
	extract($sectors);

	?>
	
	<li class="<?php echo $article_type; ?>">
		<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/channel_".$article_sector;?>/<?php if($article_type=='news'){echo "news/";}?><?php echo $article_slug; ?>"><?php echo $article_title; ?></a>
	</li>
<?php

	$prev_date = $article_date;
	
	}
	
}

function get_admin_articles($filter,$section){

	if(!$filter)
	{
		$section_sector = str_replace('-','_',$section);
		$section_type = str_replace('_','-',$section);
		
		$get_articles = mysql_query("SELECT article_id,article_sector,article_slug,article_date, article_title, article_type FROM articles ORDER BY article_date DESC");
				
	}elseif($filter=='special')
	{
		$section_sector = str_replace('-','_',$section);
		$section_type = str_replace('_','-',$section);
		
		$get_articles = mysql_query("SELECT article_id,article_sector,article_slug,article_date, article_title, article_type FROM articles WHERE article_ma='1' AND article_hide!=1 ORDER BY article_date DESC");
				
	}else{
	
		$get_articles = mysql_query("SELECT article_id,article_sector,article_slug,article_date, article_title, article_type FROM articles WHERE article_$filter='$section' AND article_hide!=1 ORDER BY article_date DESC");
		
	}

	while($article_info = mysql_fetch_array($get_articles))
	{
	extract($article_info);
	
	if($article_date!=@$prev_date){
		?>
		
		<li id="<?php echo date("dmy",$article_date); ?>" class="article-date"><?php echo date("d M y",$article_date); ?></li>
		
		<?php
	}
	
	?>
	
	<li id="article_<?php echo $article_id; ?>" class="<?php echo $article_type; ?>">
		<a href="edit_article.php?article_id=<?php echo $article_id; ?>" style="display:inline-block;width:640px;*width:635px;"><?php echo $article_title; ?></a>
	
		<span class="sector-tag-container" style="width:52px !important;">
			<a style="display:inline-block;" class="<?php echo $article_id; ?>" href="#">
				<div class="sector-tag" style="width:52px;">
					<div class="tag-top-corners"><div class="tag-corner-top-left"></div></div>
					<div class="sector-tag-content">delete</div>
					<div class="tag-bottom-corners"><div class="tag-corner-bottom-left"></div></div>
				</div>
			</a>
		</span>
	
	</li>
<?php

	$prev_date = $article_date;
	
	}
	
}

function get_dummy_articles($filter,$section){

	if($filter=='both')
	{
		$section_sector = str_replace('-','_',$section);
		$section_type = str_replace('_','-',$section);
		
		$get_articles = mysql_query("SELECT article_sector,article_slug,article_date, article_title, article_type FROM articles WHERE article_sector='$section_sector' OR article_type='$section_type' AND article_hide!=1 ORDER BY article_date DESC LIMIT 3");
				
	}else{
	
		$get_articles = mysql_query("SELECT article_sector,article_slug,article_date, article_title, article_type FROM articles WHERE article_$filter='$section' AND article_hide!=1 ORDER BY article_date DESC LIMIT 3");
		
	}

	while($article_info = mysql_fetch_array($get_articles))
	{
	extract($article_info);
	
	if($article_date!=@$prev_date){
		?>
		
		<li class="article-date"><?php echo date("d M y",$article_date); ?></li>
		
		<?php
	}
				
	$get_sector = mysql_query("SELECT * FROM sections WHERE section_alias='$article_sector'");
	
	$sectors = mysql_fetch_array($get_sector);
	
	extract($sectors);

	?>
	
	<li class="<?php echo $article_type; ?>">
		<a href="javascript:void()"><?php echo $article_title; ?></a>
	</li>
<?php

	$prev_date = $article_date;
	
	}
	
}

function get_offset($filter,$section){
	if($filter=='special')
	{
		$section_sector = str_replace('-','_',$section);
		$section_type = str_replace('_','-',$section);
		
		/*$get_news = mysql_query("SELECT article_sector,article_slug,article_title,article_date FROM articles WHERE article_type='news' AND article_hide!='1' AND article_ma='1' ORDER BY article_date DESC LIMIT 6");*/
		
		$get_articles = mysql_query("SELECT article_sector,article_slug,article_date, article_title, article_type FROM articles WHERE article_ma='1' AND article_hide!='1'");
		
		return $total_articles = mysql_num_rows($get_articles);
		
	}else
	{
								
		$get_articles = mysql_query("SELECT article_sector,article_slug,article_date, article_title, article_type FROM articles WHERE article_$filter='$section' AND article_hide!=1");
		
		return $total_articles = mysql_num_rows($get_articles);

	}
}

function get_filtered_articles($filter,$section,$offset){
	
	$offset = ($offset-1)*20;
	
	if($filter=='special')
	{
		$section_sector = str_replace('-','_',$section);
		$section_type = str_replace('_','-',$section);
		
		/*$get_news = mysql_query("SELECT article_sector,article_slug,article_title,article_date FROM articles WHERE article_type='news' AND article_hide!='1' AND article_ma='1' ORDER BY article_date DESC LIMIT 6");*/
		
		$get_articles = mysql_query("SELECT article_sector,article_slug,article_date, article_title, article_type FROM articles WHERE article_ma='1' AND article_hide!='1' ORDER BY article_date DESC LIMIT 20 OFFSET $offset");
		
	}else
	{
								
		$get_articles = mysql_query("SELECT article_sector,article_slug,article_date, article_title, article_type FROM articles WHERE article_$filter='$section' AND article_hide!=1 ORDER BY article_date DESC LIMIT 20 OFFSET $offset");

	}
	
	while($article_info = mysql_fetch_array($get_articles))
	{
	extract($article_info);
	
	if($article_date!=@$prev_date){
		?>
		
		<li class="article-date"><?php echo date("d M y",$article_date); ?></li>
		
		<?php
	}
	
	$get_sector = mysql_query("SELECT * FROM sections WHERE section_alias='$article_sector'");
	
	$sectors = mysql_fetch_array($get_sector);
	
	extract($sectors);
	
	?>
	
	<li class="<?php echo $article_type; ?>">
	
	<?php if($filter=="type"||$filter=="both"){?>
	
		<span class="sector-tag-container tag-large">
			<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/channel_".$article_sector;?>">
				<div class="sector-tag">
					<div class="tag-top-corners"><div class="tag-corner-top-left"></div></div>
					<div class="sector-tag-content"><?php echo $section_plural;?></div>
					<div class="tag-bottom-corners"><div class="tag-corner-bottom-left"></div></div>
				</div>
			</a>
		</span>
		
	<?php } ?>
	
		<a href="<?php echo $_SERVER['DOCUMENT_ROOT']."/channel_".$article_sector;?>/<?php if($article_type=='news'){echo "news/";}?><?php echo $article_slug; ?>"><?php echo $article_title; ?></a>
	</li>
<?php

	$prev_date = $article_date;
	
	}
	
}

function get_courses($offset){
	
	$current_date = mktime(0,0,0,date('m'),date('d'),date('Y'));
	
	$offset = ($offset-1)*20;
								
	$get_courses = mysql_query("SELECT * FROM course_dates WHERE course_date>=$current_date ORDER BY course_date ASC LIMIT 20 OFFSET $offset");
	
	while($course_info = mysql_fetch_array($get_courses))
	{
	extract($course_info);
	
	if($course_date!=@$prev_date){
		?>
		
		<li class="article-date"><?php echo date("d M y",$course_date); ?></li>
		
		<?php
	}
	
	$get_course_details = mysql_query("SELECT * FROM courses WHERE course_code='$course_code'");
	
	$course_details = mysql_fetch_array($get_course_details);
	
	$course_title = $course_details['course_title'];
	
	?>
	
	<li>
	
		<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/courses/<?php echo $course_code; ?>"><?php echo $course_code; ?> - <?php echo $course_title; ?></a>
		
	</li>
<?php

	$prev_date = $course_date;
	
	}
	
}

function get_search_results($search_terms,$offset){

	$offset = ($offset-1)*20;
	
	$search_db = mysql_query("SELECT * FROM articles WHERE MATCH(article_title,article_intro,article_content,article_meta_keyw,article_meta_desc) AGAINST ('$search_terms') AND article_hide!=1 ORDER BY article_date DESC LIMIT 20 OFFSET $offset");
	
	while($results = mysql_fetch_array($search_db))
	{
		
		extract($results);
	
	if($article_date!=@$prev_date)
	{
		?>
		
		<li class="article-date"><?php echo date("d M y",$article_date); ?></li>
		
		<?php
		
	}
	
	$bits = explode(" ", $search_terms);
	$firstpos = array();
	$x=0;
		
	foreach($bits as $term)
	{
		
		if($term!="a's"&&"able"&&"about"&&"above"&&"according"&&"accordingly"&&"across"&&"actually"&&"after"&&"afterwards"&&"again"&&"against"&&"ain't"&&"all"&&"allow"&&"allows"&&"almost"&&"alone"&&"along"&&"already"&&"also"&&"although"&&"always"&&"am"&&"among"&&"amongst"&&"an"&&"and"&&"another"&&"any"&&"anybody"&&"anyhow"&&"anyone"&&"anything"&&"anyway"&&"anyways"&&"anywhere"&&"apart"&&"appear"&&"appreciate"&&"appropriate"&&"are"&&"aren't"&&"around"&&"as"&&"aside"&&"ask"&&"asking"&&"associated"&&"at"&&"available"&&"away"&&"awfully"&&"be"&&"became"&&"because"&&"become"&&"becomes"&&"becoming"&&"been"&&"before"&&"beforehand"&&"behind"&&"being"&&"believe"&&"below"&&"beside"&&"besides"&&"best"&&"better"&&"between"&&"beyond"&&"both"&&"brief"&&"but"&&"by"&&"c'mon"&&"c's"&&"came"&&"can"&&"can't"&&"cannot"&&"cant"&&"cause"&&"causes"&&"certain"&&"certainly"&&"changes"&&"clearly"&&"co"&&"com"&&"come"&&"comes"&&"concerning"&&"consequently"&&"consider"&&"considering"&&"contain"&&"containing"&&"contains"&&"corresponding"&&"could"&&"couldn't"&&"course"&&"currently"&&"definitely"&&"described"&&"despite"&&"did"&&"didn't"&&"different"&&"do"&&"does"&&"doesn't"&&"doing"&&"don't"&&"done"&&"down"&&"downwards"&&"during"&&"each"&&"edu"&&"eg"&&"eight"&&"either"&&"else"&&"elsewhere"&&"enough"&&"entirely"&&"especially"&&"et"&&"etc"&&"even"&&"ever"&&"every"&&"everybody"&&"everyone"&&"everything"&&"everywhere"&&"ex"&&"exactly"&&"example"&&"except"&&"far"&&"few"&&"fifth"&&"first"&&"five"&&"followed"&&"following"&&"follows"&&"for"&&"former"&&"formerly"&&"forth"&&"four"&&"from"&&"further"&&"furthermore"&&"get"&&"gets"&&"getting"&&"given"&&"gives"&&"go"&&"goes"&&"going"&&"gone"&&"got"&&"gotten"&&"greetings"&&"had"&&"hadn't"&&"happens"&&"hardly"&&"has"&&"hasn't"&&"have"&&"haven't"&&"having"&&"he"&&"he's"&&"hello"&&"help"&&"hence"&&"her"&&"here"&&"here's"&&"hereafter"&&"hereby"&&"herein"&&"hereupon"&&"hers"&&"herself"&&"hi"&&"him"&&"himself"&&"his"&&"hither"&&"hopefully"&&"how"&&"howbeit"&&"however"&&"i'd"&&"i'll"&&"i'm"&&"i've"&&"ie"&&"if"&&"ignored"&&"immediate"&&"in"&&"inasmuch"&&"inc"&&"indeed"&&"indicate"&&"indicated"&&"indicates"&&"inner"&&"insofar"&&"instead"&&"into"&&"inward"&&"is"&&"isn't"&&"it"&&"it'd"&&"it'll"&&"it's"&&"its"&&"itself"&&"just"&&"keep"&&"keeps"&&"kept"&&"know"&&"knows"&&"known"&&"last"&&"lately"&&"later"&&"latter"&&"latterly"&&"least"&&"less"&&"lest"&&"let"&&"let's"&&"like"&&"liked"&&"likely"&&"little"&&"look"&&"looking"&&"looks"&&"ltd"&&"mainly"&&"many"&&"may"&&"maybe"&&"me"&&"mean"&&"meanwhile"&&"merely"&&"might"&&"more"&&"moreover"&&"most"&&"mostly"&&"much"&&"must"&&"my"&&"myself"&&"name"&&"namely"&&"nd"&&"near"&&"nearly"&&"necessary"&&"need"&&"needs"&&"neither"&&"never"&&"nevertheless"&&"new"&&"next"&&"nine"&&"no"&&"nobody"&&"non"&&"none"&&"noone"&&"nor"&&"normally"&&"not"&&"nothing"&&"novel"&&"now"&&"nowhere"&&"obviously"&&"of"&&"off"&&"often"&&"oh"&&"ok"&&"okay"&&"old"&&"on"&&"once"&&"one"&&"ones"&&"only"&&"onto"&&"or"&&"other"&&"others"&&"otherwise"&&"ought"&&"our"&&"ours"&&"ourselves"&&"out"&&"outside"&&"over"&&"overall"&&"own"&&"particular"&&"particularly"&&"per"&&"perhaps"&&"placed"&&"please"&&"plus"&&"possible"&&"presumably"&&"probably"&&"provides"&&"que"&&"quite"&&"qv"&&"rather"&&"rd"&&"re"&&"really"&&"reasonably"&&"regarding"&&"regardless"&&"regards"&&"relatively"&&"respectively"&&"right"&&"said"&&"same"&&"saw"&&"say"&&"saying"&&"says"&&"second"&&"secondly"&&"see"&&"seeing"&&"seem"&&"seemed"&&"seeming"&&"seems"&&"seen"&&"self"&&"selves"&&"sensible"&&"sent"&&"serious"&&"seriously"&&"seven"&&"several"&&"shall"&&"she"&&"should"&&"shouldn't"&&"since"&&"six"&&"so"&&"some"&&"somebody"&&"somehow"&&"someone"&&"something"&&"sometime"&&"sometimes"&&"somewhat"&&"somewhere"&&"soon"&&"sorry"&&"specified"&&"specify"&&"specifying"&&"still"&&"sub"&&"such"&&"sup"&&"sure"&&"t's"&&"take"&&"taken"&&"tell"&&"tends"&&"th"&&"than"&&"thank"&&"thanks"&&"thanx"&&"that"&&"that's"&&"thats"&&"the"&&"their"&&"theirs"&&"them"&&"themselves"&&"then"&&"thence"&&"there"&&"there's"&&"thereafter"&&"thereby"&&"therefore"&&"therein"&&"theres"&&"thereupon"&&"these"&&"they"&&"they'd"&&"they'll"&&"they're"&&"they've"&&"think"&&"third"&&"this"&&"thorough"&&"thoroughly"&&"those"&&"though"&&"three"&&"through"&&"throughout"&&"thru"&&"thus"&&"to"&&"together"&&"too"&&"took"&&"toward"&&"towards"&&"tried"&&"tries"&&"truly"&&"try"&&"trying"&&"twice"&&"two"&&"un"&&"under"&&"unfortunately"&&"unless"&&"unlikely"&&"until"&&"unto"&&"up"&&"upon"&&"us"&&"use"&&"used"&&"useful"&&"uses"&&"using"&&"usually"&&"value"&&"various"&&"very"&&"via"&&"viz"&&"vs"&&"want"&&"wants"&&"was"&&"wasn't"&&"way"&&"we"&&"we'd"&&"we'll"&&"we're"&&"we've"&&"welcome"&&"well"&&"went"&&"were"&&"weren't"&&"what"&&"what's"&&"whatever"&&"when"&&"whence"&&"whenever"&&"where"&&"where's"&&"whereafter"&&"whereas"&&"whereby"&&"wherein"&&"whereupon"&&"wherever"&&"whether"&&"which"&&"while"&&"whither"&&"who"&&"who's"&&"whoever"&&"whole"&&"whom"&&"whose"&&"why"&&"will"&&"willing"&&"wish"&&"with"&&"within"&&"without"&&"won't"&&"wonder"&&"would"&&"would"&&"wouldn't"&&"yes"&&"yet"&&"you"&&"you'd"&&"you'll"&&"you're"&&"you've"&&"your"&&"yours"&&"yourself"&&"yourselves"&&"zero")
		{
			if(strpos($article_intro,$term)){
				$firstpos[$x] = strpos($article_intro,$term);
			}elseif(strpos($article_content,$term)){
				$firstpos[$x] = strpos($article_content,$term);
			}
			$x++;
		}
			
		
		}
		
		$y=1;
		$prev = 10000000;
		while($y<=$x)
		{
			if(@$prev>$firstpos[$y]&&$firstpos[$y]!='')
			{
				$first = $firstpos[$y];
			}
			
			$prev = $firstpos[$y];
			
			$y++;
			
		}
		
		if($first-50>0){
			$startpos = $first-50;
		}else{
			$startpos = 0;
		}

		$find=$bits;
		$replace=$bits;

	?>
		
			<li>
				<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_<?php echo $article_sector; ?>/<?php echo $article_slug; ?>"><?php echo $article_title; ?></a>
				<p><?php if($article_intro){ echo strip_tags(substr($article_intro,0,200))."..."; } ?></p>
			</li>
	
	<?php
	
	$prev_date = $article_date;
	
	}
	
}

function populate_ads($ad_desc,$article_id,$ad_id){
	
	if($article_id)
	{	
		$get_article = mysql_query("SELECT article_ad_banner,article_ad_sky,article_ad_square1,article_ad_square2,article_ad_square3 FROM articles WHERE article_id='$article_id'");
		
		$article_info = mysql_fetch_array($get_article);
		
		$selected_value = ${"article_ad_{$ad_desc}"};

	}elseif($ad_id)
	{		
		$selected_value = $ad_id;
		
	}else
	{
		$selected_value = 0;
	}
	
	?>
	
	<option value="0"<?php if($selected_value==0||$selected_value==''){ echo "selected=\"selected\""; } ?>>use channel defaults</option>
	
	<?php
	
	if($ad_desc=='square1'||$ad_desc=='square2'||$ad_desc=='square3'){
	
		$ad_filter = 'square';
	
	}else{
	
		$ad_filter = $ad_desc;
	
	}
	
	$get_ads = mysql_query("SELECT * FROM adverts WHERE ad_style='$ad_filter' ORDER BY ad_title ASC");
	
	while($ad_info = mysql_fetch_array($get_ads)){
		
		extract($ad_info);
		
	?>
		
		<option value="<?php echo $ad_id; ?>"<?php if($selected_value==$ad_id){ echo "selected=\"selected\""; } ?>><?php echo $ad_title; ?></option>

	<?php
		
	}
	
}

?>