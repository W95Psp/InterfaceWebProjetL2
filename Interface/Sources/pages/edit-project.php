
<style>
	.details-project img{
		width: 20px;
	}
</style>
<div ng-init="project = 0" class="page edit-project">
	<?php
	$retour = "<p><a href='/?liste-des-projets'>Retour à la liste des projets</a></p>";
	if (getUserType() >= ENCADRANT) {
	?>
		<script type="text/javascript">
		function Valider(){
			if (document.getElementById("nomProj").value != ""){
				form1.submit();
			}
		}	
		function Annuler(){
			window.history.back();
		}
		</script>
		<?php
		if ((!isset($idProject)) || (intval($idProject)==0)) {
			$idProject = "N";
			$descProj = "";
			$nomProj = "";
			$allowedLanguages = "";
			$estValide = 0;
		} else {
			$sql = "SELECT * FROM Projet WHERE idProj=" . $idProject;
			$result = $db->query($sql);
			$donnee = $result->fetch_array();
			$idProject = $donnee['idProj'];
			$descProj = $donnee['descProj'];
			$nomProj = $donnee['nomProj'];
			$allowedLanguages = $donnee['allowedLanguages'];
			$estValide = $donnee['estValide'];
		}
		if ($idProject == "N") {
			echo '<h1> Ajout d\'un projet </h1>';
		}
		else {
			echo '<h1> Modification d\'un projet </h1>';
		}
		?>
		
		<form name="form1" action="edit-project-db.php" method="post" enctype="multipart/form-data">
			<input type="hidden" id="idProject" name="idProject" value="<?php echo $idProject; ?>">
			<h2> Nom du projet </h2>
			<input type="text" id="nomProj" name="nomProj" value="<?php echo $nomProj; ?>" size="50">
			<h2> Description du projet </h2>
			<textarea id="descProj" name="descProj" rows="15" cols="70"> <?php echo $descProj; ?> </textarea>
			<h2> Langages du projet </h2>
			<input type="text" id="allowedLanguages" name="allowedLanguages" value="<?php echo $allowedLanguages; ?>">
			<h2> Document du projet </h2>
			<input type="hidden" name="MAX_FILE_SIZE" value="10000000">
			<input name="uploadedfile" id="uploadedfile" type="file">
			<?php
			if (getUserType() == ADMIN) {
				echo "<h2> Visibilité du projet </h2>";
				if ($estValide == 0) {
					 echo '<input id="estValide" name="estValide" value="'.$estValide.'"
					 type="checkbox"> Mettre le projet disponible';
				}
				else {
					 echo '<input id="estValide" name="estValide" value="'.$estValide.'"
					 type="checkbox" checked> Mettre le projet disponible';
				 }
			 } else {
				 echo '<input id="estValide" name="estValide" value="'.$estValide.'"
				 type="hidden">';
			 }
			?>
			<p> <input id="btnValide" class='green' name="btnValide" value="Enregistrer" type="button" onclick="Valider()">
			<input id="annuler" class='red' name="annuler" value="Annuler" type="button" onclick="Annuler()"> </p>
		</form>
	<?php
	} else {
		echo "<h1>Désolé</h1>";
		echo "<p>Vous ne disposez pas des permissions pour accéder à cette page.</p>".$retour;	
	}
	?>
</div>