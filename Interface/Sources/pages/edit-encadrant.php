
<style>
	.details-project img{
		width: 20px;
	}
</style>
<div ng-init="project = 0" class="page edit-project">
	<?php
	$retour = "<p><a href='/?les-encadrants'>Retour à la liste des encadrants</a></p>";
	if (getUserType() >= ENCADRANT) {
	?>
		<script type="text/javascript">
		function Valider(){
			if ((document.getElementById("nomEns").value != "") && (document.getElementById("prenomEns").value != "")){
				form1.submit();
			}
		}	
		function Annuler(){
			window.history.back();
		}
		</script>
		<?php
		if ((!isset($idEns)) || (trim($idEns)==0)) {
			header("Location: /?les-encadrants");
		} else {
			$sql = "SELECT * FROM Enseignant WHERE idEns=" . $idEns;
			$result = $db->query($sql);
			$donnee = $result->fetch_array();
			$idEns = $donnee['idEns'];
			$prenomEns = $donnee['prenomEns'];
			$nomEns = $donnee['nomEns'];
			$webEns = $donnee['webEns'];
			$emailEns = $donnee['emailEns'];
		}
		echo '<h1> Modification de la fiche encadrant </h1>';
		?>
		
		<form name="form1" action="edit-encadrant-db.php" method="post" enctype="multipart/form-data">
			<input type="hidden" id="idEns" name="idEns" value="<?php echo $idEns; ?>">
			<h2> Prénom </h2>
			<input type="text" id="prenomEns" name="prenomEns" value="<?php echo $prenomEns; ?>" size="50">
			<h2> Nom </h2>
			<input type="text" id="nomEns" name="nomEns" value="<?php echo $nomEns; ?>" size="50">
			<h2> Site web </h2>
			<input type="text" id="webEns" name="webEns" value="<?php echo $webEns; ?>" size="50">
			<h2> Email </h2>
			<input type="text" id="emailEns" name="emailEns" value="<?php echo $emailEns; ?>" size="50">
			<p> <input id="btnValide" name="btnValide" value="Enregistrer" type="button" onclick="Valider()">
			<input id="annuler" name="annuler" value="Annuler" type="button" onclick="Annuler()"> </p>
		</form>
	<?php
	} else {
		echo "<h1>Désolé</h1>";
		echo "<p>Vous ne disposez pas des permissions pour accéder à cette page.</p>".$retour;	
	}
	?>
</div>