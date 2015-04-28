<?php
	session_start();
	include "../php_functions/mysql.php";
	include "../php_functions/connect.php";
	include "../php_functions/mail-project.php";
	if (getUserType() >= ENCADRANT) {
		if ((!isset($_POST['nomProj'])) || (trim($_POST['nomProj'])=="")) {
			$nomProj = "";
			header("Location: /?liste-des-projets");
			exit();
		} else {
			$nomProj = trim($_POST['nomProj']);
			$nomProj = addslashes($nomProj);
		}
		if (!isset($_POST['estValide'])){
			$estValide = 0;
		}
		else{
			$estValide = 1;
		}
		$idProject = trim($_POST['idProject']);
		$descProj = trim($_POST['descProj']);
		$descProj = addslashes($descProj);
		$allowedLanguages = trim($_POST['allowedLanguages']);
		$allowedLanguages = addslashes($allowedLanguages);
		if ($idProject == "N"){
			$sql = "SET @promo=(SELECT * FROM LAST_PROMO_ID);INSERT INTO Projet (nomProj,descProj,allowedLanguages,lien,nbMini,nbMax,estValide,idPromo) VALUES ('".$nomProj."','".$descProj."','".$allowedLanguages."','',2,4,'".$estValide."', @promo)";
			$db->query($sql);
			$idProject = $db->insert_id;
			$sql2 = "INSERT INTO Responsable (idPro,idEns) VALUES (".$idProject.",".getUserId().")";
			$db->query($sql2);
			mailValidation($idProject, $db);
		}
		else{
			$sql = "UPDATE Projet SET nomProj='".$nomProj."',descProj='".$descProj."',allowedLanguages='".$allowedLanguages."',estValide=".$estValide." WHERE idProj=".$idProject;
			$db->query($sql);
		}
		if(!file_exists("pdfs")){
			mkdir("pdfs");	
		}
		$pdfvalid = 1;
		$pdf = basename($_FILES['uploadedfile']['name']);
		$tabext = explode('.', $pdf);
		$tabexttaille = sizeof($tabext);
		if ($tabext[$tabexttaille-1] != "pdf") {
			$pdfvalid = 0;
		}
		if ((basename($_FILES['uploadedfile']['name']) != "") && ($pdfvalid == 1)) {
			$target_path = "../pdfs/" . $idProject . ".pdf";
			move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);
		}
		
		header("Location: /?liste-des-projets");
		exit();
	} else {
		header("Location: /?liste-des-projets");
		exit();	
	}
?>