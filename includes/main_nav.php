<div id="primary-nav">
	<ul>
		<li class="separator"></li>
		<li<?php if($page=='home'){ echo ' class="nav-active"';} ?>><a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/home">home</a></li>
		<li<?php if($page=='about us'){ echo ' class="nav-active"';} ?>><a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/about">about us</a></li>
		<li<?php if($page=='contact us'){ echo ' class="nav-active"';} ?>><a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/contact">contact us</a></li>
		<li class="separator"></li>
		<li<?php if($page=='course'){ echo ' class="nav-active"';} ?>><a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/courses">courses</a></li>
		<li><a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/bookstore" target="_blank">bookstore</a></li>
		<li class="end">
			<!--<ul id="feeds-nav">
				<li><a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/feeds">all feeds</a></li>
				<li><p>|</p></li>
				<li><a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/feeds"><img src="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/images/feed.gif" alt="rss" /></a></li>
			</ul>-->
		</li>
	</ul>
	
	<div style="clear:both;"></div>
	
</div>