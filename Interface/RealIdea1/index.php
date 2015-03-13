<?php
	system('node jade.js');
	$params = $_SERVER['REQUEST_URI'];
	$params = (substr($params, 1, 9)=='index.php') ? substr($params, 11) : substr($params, 2);
	$parseParam = explode('/', $params);

	$page = $parseParam[0];

	$pages = ['presentation', 'liste-des-projets', 'les-encadrants'];
	if(!in_array($page, $pages))
		$page = $pages[0];
	
	include("views/index.php");
?>