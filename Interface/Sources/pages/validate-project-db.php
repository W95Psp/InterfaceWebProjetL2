<?php
	session_start();
	include "php_functions/mysql.php";
	include "php_functions/connect.php";
	include "php_functions/mail-project.php";
	if (getUserType() == ADMIN) {
		if ((!isset($_POST['idReponse'])) || (trim($_POST['idReponse'])=="")) {
			$idReponse = "";
			header("Location: /?liste-des-projets");
			exit();
		} else {
			$idReponse = trim($_POST['idReponse']);
			$idReponse = addslashes($idReponse);
		}
		if ((!isset($_POST['idProj'])) || (trim($_POST['idProj'])=="")) {
			$idProj = "";
			header("Location: /?liste-des-projets");
			exit();
		} else {
			$idProj = trim($_POST['idProj']);
			$idProj = addslashes($idProj);
		}
		$sql = "SELECT Enseignant.emailEns AS emailEns FROM Enseignant,Responsable WHERE Responsable.idEns=Enseignant.idEns AND Responsable.idPro=" . $idProj;
		$res = $db->query($sql);
		$donnee = $res->fetch_array();
		$emailEns = $donnee['emailEns'];
		$sql = "SELECT * FROM Projet WHERE idProj=" . $idProj;
		$res = $db->query($sql);
		$donnee = $res->fetch_array();
		$nomProj = $donnee['nomProj'];
		if($idReponse == 1){
			$sql = "UPDATE Projet SET estValide=".$idReponse." WHERE idProj=".$idProj;
			$db->query($sql);
			projetAccepte($emailEns,$nomProj);
		}
		else{
			$sql = "DELETE FROM Projet WHERE idProj=".$idProj;
			$db->query($sql);
			$sql2 = "DELETE FROM Responsable WHERE idPro=".$idProj;
			$db->query($sql2);
			if(file_exists("pdfs/".$idProj.".pdf")){
				unlink("pdfs/".$idProj.".pdf");
			}
			projetRefuse($emailEns,$nomProj);
		}
		header("Location: /?liste-des-projets");
		exit();	
	} else {
		header("Location: /?liste-des-projets");
		exit();
	}
?>