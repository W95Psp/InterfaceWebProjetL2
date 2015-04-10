
<style>
	.details-project img{
		width: 20px;
	}
</style>
<div ng-init="project = 0" class="page delete-project">
	<?php
	$retour = "<p><a href='/?liste-des-projets'>Retour à la liste des projets</a></p>";
	if (getUserType() == ADMIN) {
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
		$sortie = "Le projet a bien été supprimé.";
		echo "<h1>".$nomProj."</h1>";
		echo "<p>".$sortie."</p>".$retour;	
	} else {
		echo "<h1>Désolé</h1>";
		echo "<p>Vous ne disposez pas des permissions pour accéder à cette page.</p>".$retour;
	}
	?>
</div>