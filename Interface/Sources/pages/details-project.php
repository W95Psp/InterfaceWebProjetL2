
<style>
	.details-project img{
		width: 20px;
	}
</style>
<div ng-init="project = 0" class="page details-project">
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
	echo "<p><a href='" . $donnee['lien'] . "' target='_blank'>Télécharger le sujet</a> (document PDF)</a>";
	echo "<h2>Responsable du projet</h2>";
	$sql = "SELECT Enseignant.idEns AS idEns, Enseignant.prenomEns AS prenomEns, Enseignant.nomEns AS nomEns, Enseignant.emailEns AS emailEns FROM Enseignant,Responsable WHERE Responsable.idEns=Enseignant.idEns AND Responsable.idPro=" . $idProject;
	$res = $db->query($sql);
	while ($don = $res->fetch_array()) {
		echo $don['prenomEns']." ".strtoupper($don['nomEns'])." (<a href='mailto:".$don['emailEns']."'>".$don['emailEns']."</a>)<br>";
	}
	?>
</div>