<?php
	//Connect to db (variable : $db)
	include("php_functions/mysql.php");

	//Parse url to array ($parseParam, i.e. "/page1/cat2/blurp" => $parseParam = new Array("/page1", "cat2", "blurp"))
	include("php_functions/page_manager.php");

	//Connection related functions
	include("php_functions/connect.php");

	//Compile jade files to php ones
	if(gethostname()=="SurfaceLucas"){
		system('node jade.js');
	}
	
	//Include main view
	include("views/index.php");

	//Close db connection
	$db->close();
?>