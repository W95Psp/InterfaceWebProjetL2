
<script src="/scripts/listProjects.js"></script>
<div class="page liste-des-projets">
	<h1>Liste des projets</h1><?php include('php_functions/projectsList.php');
DisplayListProjects(); ?>
	<div id="disp-error" ng-if="errorSpotted[0]">
		<div class="content">
			<div class="title">Erreur !</div><span>{{errorSpotted[1]}}</span>
		</div>
	</div>
</div>