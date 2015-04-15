
<style>
	.details-project img{
		width: 20px;
	}
</style>
<div ng-init="project = 0" class="page validate-project">
	<?php
	if (getUserType() >= ADMIN) {
	?>
		<h1>Projets en attent</h1>
		<p>Liste des projets en attente de validation ou de refus.</p>
		<?php
		$sql = "SELECT * FROM V_ProjetPromo WHERE estValide=0";
		$result = $db->query($sql);
		while (NULL !== ($donnee = $result->fetch_array())) {
			echo "<a href='validate-project.php?id=".$donnee['idProj']."'>".$donnee['nomProj']."</a><br>";
		}
	} else {
		echo "<h1>Désolé</h1>";
		echo "<p>Vous ne disposez pas des permissions pour accéder à cette page.</p>".$retour;	
	}	
	?>
</div>