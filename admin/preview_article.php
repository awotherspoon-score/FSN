<?php

session_start();

if(!$_SESSION['logged_in']=='798hJR31')
{
	header("Location: http://www.scorecomms.com/fsn/admin/index.php");
}

error_reporting(0);

include_once("../includes/connect.php");
include_once("../includes/functions.php");

/*$filter = $_GET['filter'];
$section = $_GET['section'];
$article_id = $_GET['article_id'];*/
		
/*$get_article = mysql_query("SELECT * from articles WHERE article_id='$article'");
$article_info = mysql_fetch_array($get_article);

extract($article_info);

$section = $article_sector;*/

$article_title = $_POST['article_title'];
$article_meta_desc = $_POST['article_meta_desc'];
$article_meta_keyw = $_POST['article_meta_keyw'];
$article_day = $_POST['article_day'];
$article_month = $_POST['article_month'];
$article_year = $_POST['article_year'];
$article_date = mktime(0,0,0,$article_month,$article_day,$article_year);
$article_intro = $_POST['article_intro'];
$article_content = $_POST['article_content'];
$article_type = $_POST['article_category'];
$article_sector = $_POST['article_sector'];
$article_ma = $_POST['article_ma'];
$article_hide = $_POST['article_hide'];

$article_img_s = $_FILES['article_img_s']['name'];
$article_img_l = $_FILES['article_img_l']['name'];

$article_ad_banner = $_POST['article_ad_banner'];
$article_ad_skyscraper = $_POST['article_ad_skyscraper'];
$article_ad_square1 = $_POST['article_ad_square1'];
$article_ad_square2 = $_POST['article_ad_square2'];
$article_ad_square3 = $_POST['article_ad_square3'];

$section = $_POST['article_sector'];

$get_section_title = mysql_query("SELECT section_plural,section_singular from sections WHERE section_alias='$section'");
							
$section_info = mysql_fetch_array($get_section_title);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FSN ~ <?php echo $section_info['section_plural']; ?> ~ <?php echo $article_title; ?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/style/layout.css" />

<script type="text/javascript" src="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/includes/jquery.js"></script>

</head>

<body>

<form action="add_new_article.php" method="post" enctype="multipart/form-data" id="article_form" name="article_form">

	<input type="hidden" name="preview" id="preview" value="1" />

	<input type="hidden" name="article_title" id="article_title" value="<?php echo $article_title; ?>" />
		
	<input type="hidden" name="article_meta_desc" id="article_meta_desc" value="<?php echo $article_meta_desc;?>" />
		
	<input type="hidden" name="article_meta_keyw" id="article_meta_keyw" value="<?php echo $article_meta_keyw; ?>" />
		
	<input type="hidden" name="article_day" id="article_day" value="<?php echo $article_day;?>" />
		
	<input type="hidden" name="article_month" id="article_month" value="<?php echo $article_month;?>" />
		
	<input type="hidden" name="article_year" id="article_year" value="<?php echo $article_year;?>" />
		
	<input type="hidden" name="article_sector" id="article_sector" value="<?php echo $article_sector;?>" />
			
	<input type="hidden" name="article_category" id="article_category" value="<?php echo $article_type;?>" />
			
	<input type="hidden" name="article_ma" id="article_ma" value="<?php echo $article_ma; ?>" />
		
	<input type="hidden" name="article_img_s" id="article_img_s" value="<?php echo $_FILES['article_img_s']['name']; ?>"/>
	<input type="hidden" name="article_img_l" id="article_img_l" value="<?php echo $_FILES['article_img_l']['name']; ?>"/>
		
	<input type="hidden" name="article_intro" id="article_intro" value="<?php echo $article_intro; ?>" />
		
	<input type="hidden" name="article_content" id="article_content" value="<?php echo addslashes($article_content); ?>" />
		
	<input type="hidden" name="article_hide" id="article_hide" value="<?php echo $article_hide; ?>" />
	
	<input type="hidden" name="article_ad_banner" id="article_ad_banner" value="<?php echo $article_ad_banner; ?>" />
	<input type="hidden" name="article_ad_skyscraper" id="article_ad_skyscraper" value="<?php echo $article_ad_skyscraper; ?>" />
	<input type="hidden" name="article_ad_square1" id="article_ad_square1" value="<?php echo $article_ad_square1; ?>" />
	<input type="hidden" name="article_ad_square2" id="article_ad_square2" value="<?php echo $article_ad_square2; ?>" />
	<input type="hidden" name="article_ad_square3" id="article_ad_square3" value="<?php echo $article_ad_square3; ?>" />

</form>

<div id="preview_bar">PREVIEW ONLY - <a href="javascript: document.article_form.submit()">BACK TO EDITOR</a></div>

	<div id="background-wrapper">
	
		<div class="container">
		
			<div id="header">
				<a href="javascript:void(0)" title="home"><img src="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/images/logo.gif" alt="logo" /></a>
				<div id="text-holder">
					<div class="text-top">Article Preview</div>
					<div class="text-bottom"></div>
				</div>
				<div id="border"></div>
			</div>
			
			<div id="primary-nav">
				<ul>
					<li class="separator"></li>
					<li class="nav-active"><a href="javascript:void(0)">articles</a></li>
					<li><a href="javascript:void(0)">about us</a></li>
					<li><a href="javascript:void(0)">contact us</a></li>
					<li class="separator"></li>
					<li><a href="javascript:void(0)">courses</a></li>
					<li><a href="javascript:void(0)" target="_blank">bookstore</a></li>
					<li class="end">
					</li>
				</ul>
				
				<div style="clear:both;"></div>
				
			</div>
	
		
			<div id="main-holder">
			
				<div id="left">
			
					<div id="secondary-nav">
		<h2>CHANNELS:</h2>
		<h3>SECTORS:</h3>
		<ul>
			<?php if($section=='bi_bpm_cpm')
			{ ?>
			<li class="sec-nav-active">
				<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
				<a href="javascript:void(0)">BI, BPM &amp; CPM</a>
				<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
			</li>
			<?php }else
			{ ?>
			<li class="default">
				<a href="javascript:void(0)">BI, BPM &amp; CPM</a>
			</li>
			<?php
			}
			
			if($section=='document_management')
			{ ?>
			<li class="sec-nav-active">
				<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
				<a href="javascript:void(0)">Document Management</a>
				<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
			</li>
			<?php }else
			{ ?>
			<li class="default">
				<a href="javascript:void(0)">Document Management</a>
			</li>
			<?php
			}
			
			if($section=='enterprise_financials')
			{ ?>
			<li class="sec-nav-active">
				<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
				<a href="javascript:void(0)">Enterprise Financials</a>
				<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
			</li>
			<?php }else
			{ ?>
			<li class="default">
				<a href="javascript:void(0)">Enterprise Financials</a>
			</li>
			<?php
			}
			
			if($section=='financial_reporting')
			{ ?>
			<li class="sec-nav-active">
				<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
				<a href="javascript:void(0)">Financial Reporting</a>
				<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
			</li>
			<?php }else
			{ ?>
			<li class="default">
				<a href="javascript:void(0)">Financial Reporting</a>
			</li>
			<?php
			}
			
			if($section=='human_resources')
			{ ?>
			<li class="sec-nav-active">
				<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
				<a href="javascript:void(0)">Human Resources</a>
				<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
			</li>
			<?php }else
			{ ?>
			<li class="default">
				<a href="javascript:void(0)">Human Resources</a>
			</li>
			<?php
			}
			
			if($section=='kpi_environment')
			{ ?>
			<li class="sec-nav-active">
				<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
				<a href="javascript:void(0)">KPI & Environment</a>
				<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
			</li>
			<?php }else
			{ ?>
			<li class="default">
				<a href="javascript:void(0)">KPI & Environment</a>
			</li>
			<?php
			}
			
			if($section=='mid_range_accounting')
			{ ?>
			<li class="sec-nav-active">
				<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
				<a href="javascript:void(0)">Mid-Range Accounting</a>
				<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
			</li>
			<?php }else
			{ ?>
			<li class="default">
				<a href="javascript:void(0)">Mid-Range Accounting</a>
			</li>
			<?php
			}
			
			if($section=='outsourcing')
			{ ?>
			<li class="sec-nav-active">
				<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
				<a href="javascript:void(0)">Outsourcing</a>
				<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
			</li>
			<?php }else
			{ ?>
			<li class="default">
				<a href="javascript:void(0)">Outsourcing</a>
			</li>
			<?php
			}
			
			if($section=='sme_accounting')
			{ ?>
			<li class="sec-nav-active">
				<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
				<a href="javascript:void(0)">SME Accounting</a>
				<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
			</li>
			<?php }else
			{ ?>
			<li class="default">
				<a href="javascript:void(0)">SME Accounting</a>
			</li>
			<?php
			}
			?>
		</ul>
		<h3>CATEGORIES:</h3>
		<ul>
			<?php
			if($section=='ceo-interview')
			{ ?>
				<li class="ceo-interview-active">
					<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
					<a href="javascript:void(0)">CEO Interviews</a>
					<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
				</li>
			<?php }else
			{ ?>
				<li class="ceo-interview">
					<a href="javascript:void(0)">CEO Interviews</a>
				</li>
			<?php
			}
			
			if($section=='market-analysis')
			{ ?>
				<li class="market-analysis-active">
					<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
					<a href="javascript:void(0)">Market Analysis</a>
					<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
				</li>
			<?php }else
			{ ?>
				<li class="market-analysis">
					<a href="javascript:void(0)">Market Analysis</a>
				</li>
			<?php
			}
			
			if($section=='product-review')
			{ ?>
				<li class="product-review-active">
					<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
					<a href="javascript:void(0)">Product Reviews</a>
					<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
				</li>
			<?php }else
			{ ?>
				<li class="product-review">
					<a href="javascript:void(0)">Product Reviews</a>
				</li>
			<?php
			}
			
			if($section=='webinar')
			{ ?>
				<li class="webinar-active">
					<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
					<a href="javascript:void(0)">Webinars</a>
					<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
				</li>
			<?php }else
			{ ?>
				<li class="webinar">
					<a href="javascript:void(0)">Webinars</a>
				</li>
			<?php
			}
			
			if($section=='white-paper')
			{ ?>
				<li class="white-paper-active">
					<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
					<a href="javascript:void(0)">White Papers</a>
					<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
				</li>
			<?php }else
			{ ?>
				<li class="white-paper">
					<a href="javascript:void(0)">White Papers</a>
				</li>
			<?php
			}
			?>
			
		</ul>
		<h3>FEEDS:</h3>
	<ul>
	<?php
		if($section=='feeds')
		{ ?>
			<li class="feeds-active">
				<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
				<a href="javascript:void(0)">View All Feeds</a>
				<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
			</li>
		<?php }else
		{ ?>
			<li class="feeds">
				<a href="javascript:void(0)">View All Feeds</a>
			</li>
		<?php
		}
		?>
	</ul>
	</div>
					
					<div id="advertisements">

						<div class="advert"><img src="http://www.google.com/images/adsense/en_us/200x200.jpg" width="200" height="200"/></div>
						<div class="advert"><img src="http://www.google.com/images/adsense/en_us/200x200.jpg" width="200" height="200"/></div>
						<div class="advert"><img src="http://www.google.com/images/adsense/en_us/200x200.jpg" width="200" height="200"/></div>
					
					</div>
					
				</div>
					
				<div id="upper-content">
					
					<div id="top-banner"><img src="https://www.google.com/adsense/static/en_GB/images/leaderboard_img.jpg" width="728" height="90"/></div>
					<div id="latest-articles">
						<div id="section-header-half"<?php if($article_sector=="market_analysis"){echo ' class="section-'.str_replace('_','-',$article_sector).'"';} ?>>
						
							<a href="javascript:void(0)">
							
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div id="section-header-content"><?php
								
									$get_section_title = mysql_query("SELECT section_plural,section_singular from sections WHERE section_alias='$article_sector'");
									
									$section_info = mysql_fetch_array($get_section_title);
								
									echo $section_info['section_singular'];
								
								?></div>
								<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
							
							</a>
							
						</div>
						
						<div style="width:10px;height:10px;float:left;"></div>
						
						<div id="section-header-half"<?php echo " class=\"section-$article_type\""; ?>>
							<?php
								
									$get_section_title = mysql_query("SELECT section_plural,section_singular from sections WHERE section_alias='$article_type'");
									
									$section_info = mysql_fetch_array($get_section_title);
								
								?>
								
							<a href="javascript:void(0)">
							
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div id="section-header-content"><?php echo $section_info['section_singular']; ?></div>
								<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
								
							</a>
							
						</div>
					</div>
					
					<div id="article-container">
					
					
					
						<h1><?php echo $article_title; ?></h1>
						
						<h3><?php echo date("jS F Y",$article_date); ?></h3>
						
						<em><?php echo strip_tags($article_intro,'<p><img><ol><ul><li><strong><h1><h2><h3><h4>'); ?></em>
						
						<?php echo $article_content; ?>
					
					</div>
					
					<div style="display:inline-block;width:500px;height:1px;line-height:1px;font-size:1px;"></div>
					
				</div>
	
				<div id="main-content">
				
					<div id="channel-container" class="channel-full">
					
						<!--<div class="channel-section channel-col1 show-full">
							<div class="channel-header <?php #echo $section; ?>">
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div class="channel-header-content">
									<h2>ALL <?php #echo strtoupper(str_replace(array('_','-'),array(' ',' '),$section)); ?> ARTICLES</h2>
									<div style="clear:both;"></div>
								</div>
							</div>
							<div class="channel-content">
								<ul>
									<?php
									
									#get_filtered_articles($filter,$section);
									
									?>
								</ul>					
							</div>
						</div>-->
						
						<div id="section-header" class="section-full">
							<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
							<div id="section-header-content"><h1>OTHER NEWS</h1></div>
							<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
						</div>
					
						<h2>SECTORS</h2>
					
						<div class="channel-section channel-col1">
							<div class="channel-header">
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div class="channel-header-content">
									<h3>BI, BPM & CPM</h3><div class="title-right"><a href="">view all &raquo;</a></div>
									<div style="clear:both;"></div>
								</div>
							</div>
							<div class="channel-content">
								<ul>
								
									<?php
									
									get_dummy_articles('sector','bi_bpm_cpm');
									
									?>

								</ul>					
							</div>
						</div>
						
						<div class="channel-section">
							<div class="channel-header">
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div class="channel-header-content">
									<h3>DOCUMENT MANAGEMENT</h3><div class="title-right"><a href="">view all &raquo;</a></div>
									<div style="clear:both;"></div>
								</div>
							</div>
							<div class="channel-content">
								<ul>
									<?php
									
									get_dummy_articles('sector','document_management');
									
									?>
								</ul>					
							</div>
						</div>
						
						<div style="clear:both;"></div>
						
						<div class="channel-section channel-col1">
							<div class="channel-header">
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div class="channel-header-content">
									<h3>ENTERPRISE FINANCIALS</h3><div class="title-right"><a href="">view all &raquo;</a></div>
									<div style="clear:both;"></div>
								</div>
							</div>
							<div class="channel-content">
								<ul>
									<?php
									
									get_dummy_articles('sector','enterprise_financials');
									
									?>
								</ul>					
							</div>
						</div>
						
						<div class="channel-section">
							<div class="channel-header">
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div class="channel-header-content">
									<h3>HUMAN RESOURCES</h3><div class="title-right"><a href="">view all &raquo;</a></div>
									<div style="clear:both;"></div>
								</div>
							</div>
							<div class="channel-content">
								<ul>
									<?php
									
									get_dummy_articles('sector','human_resources');
									
									?>
								</ul>					
							</div>
						</div>
						
						<div style="clear:both;"></div>
						
						<div class="channel-section channel-col1">
							<div class="channel-header">
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div class="channel-header-content">
									<h3>KPI & ENVIRONMENT</h3><div class="title-right"><a href="">view all &raquo;</a></div>
									<div style="clear:both;"></div>
								</div>
							</div>
							<div class="channel-content">
								<ul>
									<?php
									
									get_dummy_articles('sector','kpi_environment');
									
									?>
								</ul>					
							</div>
						</div>
						
						<div class="channel-section">
							<div class="channel-header">
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div class="channel-header-content">
									<h3>MID-RANGE ACCOUNTING</h3><div class="title-right"><a href="">view all &raquo;</a></div>
									<div style="clear:both;"></div>
								</div>
							</div>
							<div class="channel-content">
								<ul>
									<?php
									
									get_dummy_articles('sector','mid_range_accounting');
									
									?>
								</ul>					
							</div>
						</div>
						
						<div style="clear:both;"></div>
						
						<div class="channel-section channel-col1">
							<div class="channel-header">
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div class="channel-header-content">
									<h3>OUTSOURCING</h3><div class="title-right"><a href="">view all &raquo;</a></div>
									<div style="clear:both;"></div>
								</div>
							</div>
							<div class="channel-content">
								<ul>
									<?php
									
									get_dummy_articles('sector','outsourcing');
									
									?>
								</ul>					
							</div>
						</div>
						
						<div class="channel-section">
							<div class="channel-header">
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div class="channel-header-content">
									<h3>SME ACCOUNTING</h3><div class="title-right"><a href="">view all &raquo;</a></div>
									<div style="clear:both;"></div>
								</div>
							</div>
							<div class="channel-content">
								<ul>
									<?php
									
									get_dummy_articles('sector','sme-accounting');
									
									?>
								</ul>					
							</div>
						</div>
						
						<div style="clear:both;"></div>
						
						<h2>CATEGORIES</h2>
											
						<div class="channel-section channel-col1">
							<div class="channel-header ceo-interview">
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div class="channel-header-content">
									<h3>CEO INTERVIEWS</h3><div class="title-right"><a href="">view all &raquo;</a></div>
									<div style="clear:both;"></div>
								</div>
							</div>
							<div class="channel-content">
								<ul class="ceo-interview">
									<?php
									
									get_dummy_articles('type','ceo-interview');
									
									?>
								</ul>					
							</div>
						</div>
											
						<div class="channel-section">
							<div class="channel-header market-analysis">
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div class="channel-header-content">
									<h3>MARKET ANALYSIS</h3><div class="title-right"><a href="">view all &raquo;</a></div>
									<div style="clear:both;"></div>
								</div>
							</div>
							<div class="channel-content">
								<ul class="market-analysis">
									<?php
									
									get_dummy_articles('both','market-analysis');
									
									?>
								</ul>					
							</div>
						</div>
						
						<div style="clear:both;"></div>
						
						<div class="channel-section channel-col1">
							<div class="channel-header product-review">
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div class="channel-header-content">
									<h3>PRODUCT REVIEWS</h3><div class="title-right"><a href="">view all &raquo;</a></div>
									<div style="clear:both;"></div>
								</div>
							</div>
							<div class="channel-content">
								<ul class="product-review">
									<?php
									
									get_dummy_articles('type','product-review');
									
									?>
								</ul>					
							</div>
						</div>
						
						<div class="channel-section">
							<div class="channel-header webinar">
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div class="channel-header-content">
									<h3>WEBINARS</h3><div class="title-right"><a href="">view all &raquo;</a></div>
									<div style="clear:both;"></div>
								</div>
							</div>
							<div class="channel-content">
								<ul class="webinars">
									<?php
									
									get_dummy_articles('type','webinar');
									
									?>
								</ul>					
							</div>
						</div>	
						
						<div style="clear:both;"></div>	
								
						<div class="channel-section channel-col1">
							<div class="channel-header white-paper">
								<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
								<div class="channel-header-content">
									<h3>WHITE PAPERS</h3><div class="title-right"><a href="">view all &raquo;</a></div>
									<div style="clear:both;"></div>
								</div>
							</div>
							<div class="channel-content">
								<ul class="white-papers">
									<?php
									
									get_dummy_articles('type','white-paper');
									
									?>
								</ul>					
							</div>
						</div>
						
						<div style="clear:both;"></div>
						
					</div>
					
				</div>
		
			</div>
			
		</div>
		
		</div>
		
		<div class="bottom-round"><div class="bottom-left"></div></div>

		<?php include("../includes/footer.php"); ?>

</body>
</html>