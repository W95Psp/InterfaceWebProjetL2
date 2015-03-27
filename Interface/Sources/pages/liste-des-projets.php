
<script src="/scripts/listProjects.js"></script>
<div ng-controller="listeProjets" class="page liste-des-projets">
	<h1><?php if(getUserType()==ELEVE && $_SESSION['groupId']){ ?>
		<button id="save" ng-if="stateConfirm!=&quot;already&quot;" ng-click="isThereAnyModificationsYet &amp;&amp; sendOrder()" class="{{isThereAnyModificationsYet ? &quot;green&quot; : &quot;disabled&quot;}}">
			<div></div>
		</button><?php } ?><span>Liste des projets</span>
	</h1><?php if(getUserType()==ELEVE && $_SESSION['groupId']){
	$group = getGroupFromGroupId($_SESSION['groupId']);
	echo '<div class="confirmation" state="{{stateConfirm}}" ng-init="';
	echo 'stateConfirm = ';
	if($group['EtatCandidature']==2)
		echo "'already'";
	else
		echo "'no'";
	echo '">'; ?>
	<div class="validationForm">
		<div class="partValid">
			<button ng-click="stateConfirm = &quot;active&quot;" class="valid">Valider la candidature</button>
		</div>
		<div style="text-align: center;" class="partConfirm"><b>Voulez-vous valider vos 6 choix ? Cette opération est irréversible.</b>
			<button ng-click="confirmChoices()" class="red">Confirmer</button>
			<button ng-click="stateConfirm = &quot;no&quot;">Annuler</button>
		</div>
		<div class="partValid">
			<button class="disabled">Choix déjà effectués</button>
		</div>
	</div><?php echo '</div>';
}
include('php_functions/template-liste-projets.php');
DisplayListProjects(); ?>
	<div id="disp-error" ng-if="errorSpotted[0]">
		<div class="content">
			<div class="title">Erreur !</div><span>{{errorSpotted[1]}}</span>
		</div>
	</div>
</div>