<?php

/*if($connect = mysql_connect("localhost","root","")){
	mysql_select_db("fsn",$connect);
}else{
	echo "There was an error connecting to the database, please contact the administrator";	
}*/

if($connect = mysql_connect("77.68.45.36","fsn","Ged4tuwR")){
	mysql_select_db("fsn",$connect);
}else{
	echo "<div class=\"major-error\">There was an error connecting to the database, please contact the administrator</div>";	
}

$_SERVER['DOCUMENT_ROOT'] = 'http://www.scorecomms.com/fsn';

?>