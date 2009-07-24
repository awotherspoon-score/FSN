<?php

session_start();

if($_SESSION['logged_in']=='798hJR31')
{
	
	header("Location: http://www.scorecomms.com/fsn/admin/articles.php");

}else
{
	$_SESSION['logged_in']='';
	session_destroy();
	session_start();
}

$error='';

if(@$_POST['login'])
{	
	$username = md5($_POST['username']);
	
	if($username=='21232f297a57a5a743894a0e4a801fc3')
	{
		$password = md5($_POST['password']);
		
		if($password=='bc99e9a37fa73bab0badc73a96a5f8ad')
		{				
			$_SESSION['logged_in']='798hJR31';
			header("Location: http://www.scorecomms.com/fsn/admin/articles.php");
		}else
		{
			$error=1;
		}
		
	}else
	{
		$error=1;
	}
	
}

$admin=1;
$admin_page='index';

include_once("../includes/connect.php");
include_once("../includes/functions.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FSN ~ home</title>

<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/style/layout.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/style/admin.css" />

<script type="text/javascript" src="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/includes/jquery.js"></script>

</head>

<body>

	<div id="background-wrapper">
	
		<div class="container">
		
			<div id="header"><?php include("../includes/header.php"); ?></div>
		
			<div id="main-holder">
					
				<div id="main-content">
				
					<div class="status-bad" style="text-align:center;width:400px;margin:0 auto !important;<?php if($error){ echo 'display:block;';}else{echo 'display:none';}?>">The Username or Password is incorrect, please try again</div>
				
					<form id="login-form" name="login-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					
						<div class="form-container">
							<label for="username">Username:</label><input type="text" id="username" name="username" value="" />
						</div>
						
						<div class="form-container">
							<label for="password">Password:</label><input type="password" id="password" name="password" value="" />
						</div>
						
						<div class="form-container">
							<input type="submit" id="login" name="login" value="login" />
						</div>
						
						<div style="clear:both;"></div>
					
					</form>
					
				</div>
		
			</div>
			
		</div>
		
		</div>
		
		<div class="bottom-round"><div class="bottom-left"></div></div>
		
</body>
</html>