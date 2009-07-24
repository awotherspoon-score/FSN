<div id="secondary-nav">

	<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
	
	<div id="secondary-nav-content">

		<?php if(!$admin){ ?>
		
		<form id="search" action="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/search" method="post" style="margin:0;">
			<input type="text" name="search_terms" id="search_box" value="<?php if($search_terms){ echo $search_terms; }else{?>search...<?php } ?>" style="width:127px;color:<?php if($search_terms){ ?>#000000<?php }else{ ?>#999999<?php } ?>;" onclick="<?php if(!$search_terms){ ?>this.value='';this.style.color='#000000'<?php } ?>" />
			<input type="submit" value="search" id="search" />
		</form>
	</div>
	<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
	<div style="width:100%;height:5px;background:#ffffff;"></div>
	
	<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
	
	<div id="secondary-nav-content">
		<ul class="main-ul grey">
		<?php if($page=='home')
			{ ?>
			<li class="main-nav-active">
				<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
				<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/home">HOME</a>
				<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
			</li>
			<?php }else
			{ ?>
			<li class="main"><a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/home">HOME</a></li>
			<?php
			}
			if($page=='about us')
			{ ?>
			<li class="main-nav-active">
				<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
				<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/about">ABOUT US</a>
				<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
			</li>
			<?php }else
			{ ?>
			<li class="main"><a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/about">ABOUT US</a></li>
			<?php
			}
			if($page=='course')
			{ ?>
			<li class="main-nav-active">
				<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
				<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/courses">COURSES</a>
				<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
			</li>
			<?php }else
			{ ?>
			<li class="main"><a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/courses">COURSES</a></li>
			<?php
			}
			?>
			<li class="main"><a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/bookstore" target="_blank">BOOKSTORE</a></li>
		</ul>
	</div>
	<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
	<div style="width:100%;height:5px;background:#ffffff;"></div>
	
	<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
	<div id="secondary-nav-content">
		
		<?php } ?>
		
		<h2>CHANNELS:</h2>
		<h3>SECTORS:</h3>
		<ul class="grey">
			<?php if($section=='bi_bpm_cpm')
			{ ?>
			<li class="sec-nav-active">
				<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
				<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_bi_bpm_cpm">BI, BPM &amp; CPM</a>
				<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
			</li>
			<?php }else
			{ ?>
			<li class="default">
				<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_bi_bpm_cpm">BI, BPM &amp; CPM</a>
			</li>
			<?php
			}
			
			if($section=='document_management')
			{ ?>
			<li class="sec-nav-active">
				<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
				<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_document_management">Document Management</a>
				<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
			</li>
			<?php }else
			{ ?>
			<li class="default">
				<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_document_management">Document Management</a>
			</li>
			<?php
			}
			
			if($section=='enterprise_financials')
			{ ?>
			<li class="sec-nav-active">
				<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
				<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_enterprise_financials">Enterprise Financials</a>
				<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
			</li>
			<?php }else
			{ ?>
			<li class="default">
				<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_enterprise_financials">Enterprise Financials</a>
			</li>
			<?php
			}
			
			if($section=='financial_reporting')
			{ ?>
			<li class="sec-nav-active">
				<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
				<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_financial_reporting">Financial Reporting</a>
				<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
			</li>
			<?php }else
			{ ?>
			<li class="default">
				<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_financial_reporting">Financial Reporting</a>
			</li>
			<?php
			}
			
			if($section=='human_resources')
			{ ?>
			<li class="sec-nav-active">
				<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
				<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_human_resources">Human Resources</a>
				<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
			</li>
			<?php }else
			{ ?>
			<li class="default">
				<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_human_resources">Human Resources</a>
			</li>
			<?php
			}
			
			if($section=='kpi_environment')
			{ ?>
			<li class="sec-nav-active">
				<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
				<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_kpi_environment">KPI & Environment</a>
				<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
			</li>
			<?php }else
			{ ?>
			<li class="default">
				<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_kpi_environment">KPI & Environment</a>
			</li>
			<?php
			}
			
			if($section=='mid_range_accounting')
			{ ?>
			<li class="sec-nav-active">
				<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
				<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_mid_range_accounting">Mid-Range Accounting</a>
				<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
			</li>
			<?php }else
			{ ?>
			<li class="default">
				<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_mid_range_accounting">Mid-Range Accounting</a>
			</li>
			<?php
			}
			
			if($section=='outsourcing')
			{ ?>
			<li class="sec-nav-active">
				<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
				<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_outsourcing">Outsourcing</a>
				<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
			</li>
			<?php }else
			{ ?>
			<li class="default">
				<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_outsourcing">Outsourcing</a>
			</li>
			<?php
			}
			
			if($section=='sme_accounting')
			{ ?>
			<li class="sec-nav-active">
				<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
				<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_sme_accounting">SME Accounting</a>
				<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
			</li>
			<?php }else
			{ ?>
			<li class="default">
				<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_sme_accounting">SME Accounting</a>
			</li>
			<?php
			}
			?>
		</ul>
		<h3>CATEGORIES:</h3>
		<ul class="grey">
			<?php
			if($section=='ceo-interview')
			{ ?>
				<li class="ceo-interview-active">
					<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
					<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_ceo_interviews">CEO Interviews</a>
					<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
				</li>
			<?php }else
			{ ?>
				<li class="ceo-interview">
					<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_ceo_interviews">CEO Interviews</a>
				</li>
			<?php
			}
			
			if($section=='market-analysis')
			{ ?>
				<li class="market-analysis-active">
					<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
					<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_market_analysis">Market Analysis</a>
					<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
				</li>
			<?php }else
			{ ?>
				<li class="market-analysis">
					<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_market_analysis">Market Analysis</a>
				</li>
			<?php
			}
			
			if($section=='product-review')
			{ ?>
				<li class="product-review-active">
					<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
					<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_product_reviews">Product Reviews</a>
					<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
				</li>
			<?php }else
			{ ?>
				<li class="product-review">
					<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_product_reviews">Product Reviews</a>
				</li>
			<?php
			}
			
			if($section=='webinar')
			{ ?>
				<li class="webinar-active">
					<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
					<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_webinars">Webinars</a>
					<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
				</li>
			<?php }else
			{ ?>
				<li class="webinar">
					<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_webinars">Webinars</a>
				</li>
			<?php
			}
			
			if($section=='white-paper')
			{ ?>
				<li class="white-paper-active">
					<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
					<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_white_papers">White Papers</a>
					<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
				</li>
			<?php }else
			{ ?>
				<li class="white-paper">
					<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_white_papers">White Papers</a>
				</li>
			<?php
			}
			?>
			
		</ul>
		<h3>FEEDS:</h3>
		<ul class="grey">
		<?php
			if($section=='feeds')
			{ ?>
				<li class="feeds-active">
					<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
					<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_feeds">View All Feeds</a>
					<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
				</li>
			<?php }else
			{ ?>
				<li class="feeds">
					<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/channel_feeds">View All Feeds</a>
				</li>
			<?php
			}
			?>
		</ul>
		
	</div>
	
	<?php if($page=='home'){ ?>
	<div class="home-box-bottom-corners"><div class="home-box-corner-bottom-left"></div></div>
	<?php }else{ ?>
	<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
	<?php } ?>
	
</div>