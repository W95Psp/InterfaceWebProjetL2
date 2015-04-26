<?php
	include('_mysql.php');
	$db = new MySQLi($bdHost, $bdPwd, $bdUser, $bdName) or die(mysqli_error($db));
	$db->query("SET NAMES 'utf8'");
?>