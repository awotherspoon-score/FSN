<div id="header"><?php include("../includes/header.php"); ?></div>

<?php $_SERVER['DOCUMENT_ROOT'] = 'http://www.scorecomms.com/fsn/admin'; ?>

<div id="primary-nav">
	<ul>
		<li class="separator"></li>
		<li<?php if($admin_page=='articles'){ ?> class="nav-active"<?php } ?>><a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/articles">add/edit articles</a></li>
		<li class="separator"></li>
		<li<?php if($admin_page=='pages'){ ?> class="nav-active"<?php } ?>><a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/pages">edit pages</a></li>
		<li class="separator"></li>
		<li<?php if($admin_page=='courses'){ ?> class="nav-active"<?php } ?>><a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/courses">add/edit courses</a></li>
		<li class="separator"></li>
		<li<?php if($admin_page=='adverts'){ ?> class="nav-active"<?php } ?>><!--<a href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/adverts">--><span style="font-weight:bold;color:#999999;padding-top:8px;display:block;">advert suite</span><!--</a>--></li>
		<li class="end"></li>
	</ul>
	
	<div style="clear:both;height:10px;"></div>
	
</div>