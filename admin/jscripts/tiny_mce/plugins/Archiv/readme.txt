Archiv TinyMCE File & Image manager version 0.4


=[ Created by ]===========================================================
	Wouter van Kuipers (archiv@pwnd.nl)
	Professional Webdesign & Development
	http://archiv.pwnd.nl

	
=[ About ]================================================================
	Archiv is a free file & image management plug-in for TinyMCE. 
	It is based on PHP (4/5) and uses AJAX & Flash to manage files. 
	It comes with security levels (passphrase, ip, password or cookie based), language files and is easy configurable.

	
=[ Requirements ]=========================================================
	To use Archiv you need to meet the following requirements:

	Server
		* TinyMCE version 3.x
		* PHP version 4.x or 5.x
		
	Client
		* JavaScript
		* Flash version > 8
		* Browser version IE 7, Firefox > 2.x


=[ Installation instructions ]============================================
	To install the Archiv plug-in into a new TinyMCE instance you can follow this guide. 
	If you already have an instance of TinyMCE running and you wish to add the plug-in you can advance to step 3.

	Step 1:
	Download the latest version of TinyMCE here

	Step 2:
	Follow the installation instructions as described here

	Step 3:
	Download the latest version of the Archiv plug-in here

	Step 4:
	Add the map 'Archiv' to the 'tiny_mce\plugins' directory.

	Step 5:
	Edit the page where you added the TinyMCE instance, change

	<script language="javascript" type="text/javascript">
	tinyMCE.init({
	    mode : "textareas"
	});
	</script>

	into

	<script language="javascript" type="text/javascript">
	tinyMCE.init({
	    mode : "textareas",
	    theme : "advanced",
	    plugins : "Archiv",
	    Archiv_settings_file : "config.php",
	    theme_advanced_buttons1_add : "Archiv_files,Archiv_images"
	});
	</script>

	Step 6:
	Edit the config.php file so it will fit your needs.

	Step 7:
	Launch the page you have the TinyMCE instance loaded on, you should see an instance of TinyMCE with the two icons of Archiv. 

	*note, for a complete guide to all the configuration options please refer to http://archiv.wiki.sourceforge.net/

=[ To do ]================================================================
	- integrate jQuery framework for AJAX & displaying
	- test browser support (IE 6~8, FF 2~3, Opera, Safari, Chrome)
	- change pathing so non relative paths can be used
	- add otion to remove md5/directory creating/upload/remove directory functionality
	
=[ Important known problems ]=============================================
	- IE 7 sometimes require a refresh before uploaded files are shown


=[ Version history ]======================================================
	- 0.4 : * Added French translation
		* Updated SWFUpload (now supports Flash 10)
		* Changed overal Licence type (LGPL)
		* Small bug fixes
		* Added French translation
		* Fixed a bug in image resizing (thanks to linuxjuggler)
		* Fixed a bug in PNG creation on PHP 5.1.2 & 5.1.3 (thanks to glebushka)
	
	- 0.3 : * Added debug for PHP errors in config file
		* Changed the way XML is created so if no valid function is availeable it will be corrected
		* Fixed a problem with getDirContent() (PHP) returning a error
	
	- 0.2 : * Added readme
		* Added Dutch translation
		* Added German translation
	
	- 0.1 : * Created the plug-in


=[ Special Thanks to ]====================================================
	Joost "Korp_hi" Altena
	Florian Woehrl (German translation)
	Laurent Nunenthal ( French translation)


© 2008 Wouter van Kuipers - Professional Webdesign & Development
Last update: 17/03/2009
