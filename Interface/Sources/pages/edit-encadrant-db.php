<?php
	session_start();
	include "../php_functions/mysql.php";
	include "../php_functions/connect.php";
	include "../php_functions/mail-project.php";
	if (getUserType() >= ENCADRANT) {
		if ((!isset($_POST['nomEns'])) || (trim($_POST['nomEns'])=="")) {
			$nomEns = "";
			header("Location: /?les-encadrants");
			exit();
		} else {
			$nomEns = trim($_POST['nomEns']);
			$nomEns = addslashes($nomEns);
		}
		if ((!isset($_POST['prenomEns'])) || (trim($_POST['prenomEns'])=="")) {
			$prenomEns = "";
			header("Location: /?les-encadrants");
			exit();
		} else {
			$prenomEns = trim($_POST['prenomEns']);
			$prenomEns = addslashes($prenomEns);
		}
		$idEns = trim($_POST['idEns']);
		$webEns = trim($_POST['webEns']);
		$emailEns = trim($_POST['emailEns']);
		$sql = "UPDATE Enseignant SET nomEns='".$nomEns."',prenomEns='".$prenomEns."',emailEns='".$emailEns."',webEns='".$webEns."' WHERE idEns=".$idEns;
		$db->query($sql);
		
		header("Location: /?les-encadrants");
		exit();
	} else {
		header("Location: /?les-encadrants");
		exit();	
	}
?>