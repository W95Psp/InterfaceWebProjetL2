
<style>
	.details-project img{
		width: 20px;
	}
</style>
<div ng-init="project = 0" class="page delete-project">
	<?php
	$retour = "<p><a href='/?liste-des-projets'>Retour à la liste des projets</a></p>";
	if (getUserType() == ADMIN) {
	?>
	<script type="text/javascript">
		function Valider(){
			form1.submit();
		}	
		function Annuler(){
			window.history.back();
		}
		</script>
	
	<?php
	$sql = "SELECT * FROM Projet WHERE idProj=" . $idProject;
	$result = $db->query($sql);
	$donnee = $result->fetch_array();
	?>
	<h1>Suppression d'un projet </h1>
	<p> Etes-vous sûr de vouloir supprimer le projet <strong><?php echo $donnee['nomProj']; ?></strong> ? </p>
	<form name="form1" action="delete-project-db.php" method="post">
	<input type="hidden" id="idProj" name="idProj" value="<?php echo $donnee['idProj']; ?>">
	
	<p> <input id="btnValide" name="btnValide" value="Supprimer le projet" type="button" onclick="Valider()">
		<input id="annuler" name="annuler" value="Annuler" type="button" onclick="Annuler()"> </p>
	
	</form>
	<?php
	} else {
		echo "<h1>Désolé</h1>";
		echo "<p>Vous ne disposez pas des permissions pour accéder à cette page.</p>".$retour;	
	}
	?>
</div>