<?php
	session_start();

	define("ANONYME", 0);
	define("ELEVE", 1);
	define("ENCADRANT", 2);
	define("ADMIN", 3);

	function setUser($id, $name, $type){
		$_SESSION["userType"] = $type;
		$_SESSION["userId"] = $id;
		$_SESSION["userName"] = $name;
	}

	function getUserType(){
		return (isset($_SESSION["userType"]))?$_SESSION["userType"] : ANONYME;
	}
?>