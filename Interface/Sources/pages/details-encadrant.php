
<style>
	.details-project img{
		width: 20px;
	}
</style>
<div ng-init="project = 0" class="page details-encadrant">
	<?php
	$idEns = intval(@$urlParams[1]);
	$sql = "SELECT * FROM Enseignant WHERE idEns=" . $idEns;
	$result = $db->query($sql);
	$donnee = $result->fetch_array();
	echo "<h1>" . $donnee['prenomEns'] ." " .strtoupper($donnee['nomEns']) . "</h1>";
	if (getUserId()==$idEns){
		echo "<p><img src='images/icons/edit.png' width='16px' height='16px'> <a href='/?les-encadrants/".$donnee['idEns']."/edit'>Modifier vos informations</a></p>";
	}
	echo "<h2>Site web</h2>";
	if (strpos($donnee['webEns'], 'http;//')===false){
		echo "<p><a href='http://".$donnee['webEns']."' target='_blank'>http://".$donnee['webEns']."</a></p>";
	} else {
		echo "<p><a href='".$donnee['webEns']."' target='_blank'>".$donnee['webEns']."</a></p>";
	}
	echo "<h2>Email</h2>";
	echo "<p><a href='mailto:".$donnee['emailEns']."'>".$donnee['emailEns']."</a></p>";
	echo "<p>&nbsp;</p>";
	echo "<p><img src='images/icons/arrow-left.png' width='16px' height='16px'> <a href='/?les-encadrants'>Retour à la liste des encadrants</a></p>";
	?>
</div>
