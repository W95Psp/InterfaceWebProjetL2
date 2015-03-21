
<script src="/scripts/listProjects.js"></script>
<div ng-controller="listeProjets" class="page mes-projets">
	<h1>Mes projets</h1>
	<button class="add">Ajouter</button><?php include('php_functions/projectsList.php');
DisplayListProjects('encadrant'); ?>
	<div id="disp-error" ng-if="errorSpotted[0]">
		<div class="content">
			<div class="title">Erreur !</div><span>{{errorSpotted[1]}}</span>
		</div>
	</div>
</div>