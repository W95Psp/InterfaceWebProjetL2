
<style>
	.details-project img{
		width: 20px;
	}
</style>
<div ng-init="project = 0" class="page validate-project">
	<?php
	include "php_functions/mail-project.php";
	$retour = "<p><a href='/?liste-des-projets'>Retour à la liste des projets</a></p>";
	if (getUserType() == ADMIN) {
		if ((!isset($_POST['idReponse'])) || (trim($_POST['idReponse'])=="")) {
			$idReponse = "";
			$sortie = "Une erreur s'est produite lors de la suppression du projet.";
			echo "<h1>Erreur</h1>";
			echo "<p>".$sortie."</p>".$retour;
			exit();
		} else {
			$idReponse = trim($_POST['idReponse']);
			$idReponse = addslashes($idReponse);
		}
		if ((!isset($_POST['idProj'])) || (trim($_POST['idProj'])=="")) {
			$idProj = "";
			$sortie = "Une erreur s'est produite lors de la suppression du projet.";
			echo "<h1>Erreur</h1>";
			echo "<p>".$sortie."</p>".$retour;
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
			$sortie = "Le projet a bien été validé.";
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
			$sortie = "Le projet a été refusé et supprimé.";
		}
		echo "<h1>Validation d'un projet</h1>";
		echo "<p>".$sortie."</p>".$retour;	
	} else {
		echo "<h1>Désolé</h1>";
		echo "<p>Vous ne disposez pas des permissions pour accéder à cette page.</p>".$retour;
	}
	?>
</div>