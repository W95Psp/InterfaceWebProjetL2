
<style>
	.details-project img{
		width: 20px;
	}
</style>
<div ng-init="project = 0" class="page validate-project">
	<?php
	if (getUserType() == ADMIN) {
	?>
		<script type="text/javascript">
		function Valider(reponse){
			document.getElementById("idReponse").value = reponse;
			form1.submit();
		}	
		</script>
	
	<?php
		$sql = "SELECT * FROM Projet WHERE idProj=" . $idProject;
		$result = $db->query($sql);
		$donnee = $result->fetch_array();
		echo "<h1>" . $donnee['nomProj'] . "</h1>";
		echo "<h2>Description du projet</h2>";
		echo $donnee['descProj'];
		echo "<h2>Langages du projet</h2>";
		echo $donnee['allowedLanguages'];
		echo "<h2>Document du projet</h2>";
		if(file_exists("pdfs/".$idProject.".pdf")){
			echo "<p><a href='pdfs/".$idProject.".pdf' target='_blank'>Télécharger le sujet</a> (document PDF)</a>";
		}
		else{
			echo "<p>Aucun document disponible pour ce projet.</p>";
		}
		echo "<h2>Responsable du projet</h2>";
		$sql = "SELECT Enseignant.idEns AS idEns, Enseignant.prenomEns AS prenomEns, Enseignant.nomEns AS nomEns, Enseignant.emailEns AS emailEns FROM Enseignant,Responsable WHERE Responsable.idEns=Enseignant.idEns AND Responsable.idPro=" . $idProject;
		$res = $db->query($sql);
		while ($don = $res->fetch_array()) {
			echo $don['prenomEns']." ".strtoupper($don['nomEns'])." (<a href='mailto:".$don['emailEns']."'>".$don['emailEns']."</a>)<br>";
		}
		?>
		<form name="form1" action="validate-project-db.php" method="post">
			<input type="hidden" id="idProj" name="idProj" value="<?php echo $donnee['idProj']; ?>">
			<input type="hidden" id="idReponse" name="idReponse" value="">
		<p> <input id="btnValide" name="btnValide" value="Valider le projet" type="button" onclick="Valider(1)">
			<input id="annuler" name="annuler" value="Refuser le projet" type="button" onclick="Valider(0)"> </p>
		</form>
	<?php
	} else {
		echo "<h1>Désolé</h1>";
		echo "<p>Vous ne disposez pas des permissions pour accéder à cette page.</p>".$retour;	
	}	
	?>
</div>