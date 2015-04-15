<?php
	session_start();
	include "php_functions/mysql.php";
	include "php_functions/connect.php";
	if (getUserType() == ADMIN) {
		if ((!isset($_POST['idProj'])) || (trim($_POST['idProj'])=="")) {
			$idProj = "";
			header("Location: /?liste-des-projets");
			exit();
		} else {
			$idProj = trim($_POST['idProj']);
			$idProj = addslashes($idProj);
		}
		$sql = "SELECT * FROM Projet WHERE idProj=".$idProj;
		$res = $db->query($sql);
		$donnee = $res->fetch_array();
		$nomProj = $donnee['nomProj'];
		$sql = "DELETE FROM Projet WHERE idProj=".$idProj;
		$db->query($sql);
		$sql2 = "DELETE FROM Responsable WHERE idPro=".$idProj;
		$db->query($sql2);
		if(file_exists("pdfs/".$idProj.".pdf")){
			unlink("pdfs/".$idProj.".pdf");
		}
		header("Location: /?liste-des-projets");
		exit();	
	} else {
		header("Location: /?liste-des-projets");
		exit();
	}
?>