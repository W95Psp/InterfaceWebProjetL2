
<!--On charge le script client qui gère la liste des projets-->
<script src="/scripts/listProjects.js"></script>
<!--On déclare un contrôleur AngularJS-->
<div ng-controller="listeProjets" class="page liste-des-projets"><?php //Inclusion du système de suppression de page
include("php_functions/deleteProjet.php"); ?>
	<div ng-show="choicesProposition" class="choicesProposition">
		<div><b>Êtes-vous d'accord avec les choix établis dans la liste ci-dessous ?</b></div><br/>
		<button ng-click="manageChoicesProposition(true)" class="green">Oui</button>
		<button ng-click="manageChoicesProposition(false)" class="red">Non</button>
	</div>
	<h1><?php if(getUserType()==ELEVE && getGroupId()){ ?>
		<button id="save" ng-if="stateConfirm.substr(0, 7)!=&quot;already&quot;" ng-click="isThereAnyModificationsYet &amp;&amp; sendOrder()" class="{{isThereAnyModificationsYet ? &quot;green&quot; : &quot;disabled&quot;}}">
			<div></div>
		</button><?php } ?><span>Liste des projets</span>
	</h1><?php if(getUserType()==ELEVE && getGroupId()){
	$group = getGroupFromGroupId(getGroupId());
	echo '<div class="confirmation" state="{{stateConfirm}}" ng-init="';
	echo 'stateConfirm = ';
	if($group['EtatCandidature']==2)
		echo "'already'";
	else if($group['EtatCandidature']==3)
		echo "'already'";
	else
		echo "'no'";
	echo '">'; ?>
	<!--Formulaire de validation en haut à droite de la page-->
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
DisplayListProjects();
 ?>
	<!--Affichage des erreurs (ne devrait jamais se produire)-->
	<div id="disp-error" ng-if="errorSpotted[0]" ng-init="refresh()">
		<div class="content">
			<div class="title">
				Erreur !
				<button onclick="this.parentNode.parentNode.innerHTML = SC.errorSpotted[1];" class="red">Afficher en HTML (peut-être dangeureux!)</button>
			</div><span>{{errorSpotted[1]}}</span>
		</div>
	</div>
</div>