
<style>
	.details-project img{
		width: 20px;
	}
</style>
<div ng-init="project = 0" class="page edit-project">
	<?php
	include "php_functions/mail-project.php";
	$retour = "<p><a href='/?liste-des-projets'>Retour à la liste des projets</a></p>";
	if (getUserType() >= ENCADRANT) {
		if ((!isset($_POST['nomProj'])) || (trim($_POST['nomProj'])=="")) {
			$nomProj = "";
			$sortie = "Une erreur s'est produite lors de l'édition du projet.";
			echo "<h1>Erreur</h1>";
			echo "<p>".$sortie."</p>".$retour;
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
			$sortie="Le sujet a été proposé à l'administrateur.";
		}
		else{
			$sql = "UPDATE Projet SET nomProj='".$nomProj."',descProj='".$descProj."',allowedLanguages='".$allowedLanguages."',estValide=".$estValide." WHERE idProj=".$idProject;
			$db->query($sql);
			$sortie="La modification a bien été enregistrée.";
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
			$target_path = "pdfs/" . $idProject . ".pdf";
			move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);
		}
		
		echo "<h1>".$nomProj."</h1>";
		echo "<p>".$sortie."</p>".$retour;
	} else {
		echo "<h1>Désolé</h1>";
		echo "<p>Vous ne disposez pas des permissions pour accéder à cette page.</p>".$retour;	
	}
	?>
</div>