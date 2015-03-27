
<link rel="stylesheet" type="text/css" href="style/liste-des-projets.css"/>
<script src="/scripts/listProjects.js"></script>
<div ng-controller="listeProjets" class="page mes-projets">
	<h1>Mes projets</h1><a href="/?liste-des-projets/0000-nouveau-projet">
		<button class="add">Ajouter</button></a><?php include('php_functions/template-liste-projets.php');
DisplayListProjects('encadrant'); ?>
	<div id="disp-error" ng-if="errorSpotted[0]">
		<div class="content">
			<div class="title">Erreur !</div><span>{{errorSpotted[1]}}</span>
		</div>
	</div>
</div>