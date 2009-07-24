<?php if(@$page=='home'){ ?>
	
<div id="channel-container">
	
<?php }else{ ?>

	

<div id="channel-container" class="channel-full">
	
	<div class="back-to-top"><a href="#top">back to top</a></div>
	
	<div id="section-header" class="section-full">
		<div class="box-top-corners"><div class="box-corner-top-left"></div></div>
		<div id="section-header-content"><h1>OTHER NEWS</h1></div>
		<div class="box-bottom-corners"><div class="box-corner-bottom-left"></div></div>
	</div>
	
<?php }?>

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
				
				get_articles('sector','bi_bpm_cpm');
				
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
				
				get_articles('sector','document_management');
				
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
				
				get_articles('sector','enterprise_financials');
				
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
				
				get_articles('sector','human_resources');
				
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
				
				get_articles('sector','kpi_environment');
				
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
				
				get_articles('sector','mid_range_accounting');
				
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
				
				get_articles('sector','outsourcing');
				
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
				
				get_articles('sector','sme-accounting');
				
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
				
				get_articles('type','ceo-interview');
				
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
				
				get_articles('special','market-analysis');
				
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
				
				get_articles('type','product-review');
				
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
				
				get_articles('type','webinar');
				
				?>
			</ul>					
		</div>
	</div>
	
	<div style="clear:both;"></div>	
			
	<div class="channel-section">
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
				
				get_articles('type','white-paper');
				
				?>
			</ul>					
		</div>
	</div>
	
	<div style="clear:both;"></div>
	
</div>

</div>