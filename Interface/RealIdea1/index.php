<?php
	$params = $_SERVER['REQUEST_URI'];
	$params = (substr($params, 1, 9)=='index.php') ? substr($params, 11) : substr($params, 2);
	$parseParam = explode('/', $params);

	$page = $parseParam[0];
	
	include("views/index.php");
?>