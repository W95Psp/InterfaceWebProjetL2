<?php
if (@$urlParams[2]=='edit'){
	include("pages/edit-encadrant.php");
} else {
?>
<style>
	.details-project img{
		width: 20px;
	}
</style>
<div ng-init="project = 0" class="page details-encadrant">
	<?php
	$sql = "SELECT * FROM Enseignant WHERE idEns=" . $idEns;
	$result = $db->query($sql);
	$donnee = $result->fetch_array();
	echo "<h1>" . $donnee['prenomEns'] ." " .strtoupper($donnee['nomEns']) . "</h1>";
	if (getUserId()==$idEns){
		echo "<p><a href='/?les-encadrants/".$donnee['idEns']."/edit'>Modifier vos informations</a></p>";
	}
	echo "<h2>Site web</h2>";
	echo "<p><a href='http://".$donnee['webEns']."'>http://".$donnee['webEns']."</a></p>";
	echo "<h2>Email</h2>";
	echo "<p><a href='mailto:".$donnee['emailEns']."'>".$donnee['emailEns']."</a></p>";
	?>
</div>
<?php
}
?>
