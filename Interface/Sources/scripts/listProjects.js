var app = angular.module('ProjetsL2', ['ui.sortable']);

//Descriptions des langages
var descriptionLanguages = {
	'any': 			'Tout les languages sont acceptés.',
	'dot-net': 		'Technologies .net',
	'html5': 		'Html 5',
	'java': 		'Java',
	'javascript': 	'JavaScript',
	'mysql': 		'MySQL',
	'nodejs': 		'NodeJS',
	'php': 			'PHP',
	'postgresql': 	'PostgreSQL',
	'python': 		'Python'
};

//Formate le title d'un projet en vue d'être passé en paramètre
app.filter('getLinkFromTitle', function() {
    return function(input) {
    	//Tous les caractère spéciaux (autre que des lettres non accentuées en fait) sont supprimé
    	//	tandis que les espaces sont replacés par des tirets.
        return input.nomProj.replace(/ /g, "-").replace(/[^a-z\-]/gi, "").toLowerCase();
    }
});

//Remplace le nom "brutal" d'un langage par une description, pour le tooltip
app.filter('getDescription', function() {
    return function(input) {
    	//Si le langage n'a pas de description, alors on renvoie simplement son nom "brutal"
        return descriptionLanguages[input] || input;
    }
});

//Pour constituer l'ID d'un projet
//(Attention: on admet qu'il n'y aura jamais plus de 999 projets)
app.filter('fillZero', function() {
    return function(r) {
        r = r+'';
		while(r.length<4)
			r='0'+r;
		return r;
    }
});

var importStuff = {};

app.controller('listeProjets', function($scope, $parse) {
	window.SC = $scope;

	//Pour le bouton de sauvegarde (sauvegarde possible que si nécéssaire)
	$scope.isThereAnyModificationsYet = false;

	//Import des données possible
	$scope.importStuff = importStuff;

	$scope.stateConfirm = 'already';

	//Dès qu'un lot de données doit être importé depuis l'environement extérieur,
	//	il est placé dans l'objet importStuff, qui sera ensuite traité.
	//	Ici, on peuple le tableau des projets avec une liste "brute" de projets
	//	généré par une requête MySQL. (cf "../php_functions/projectsToJS.php")
	$scope.$watch('importStuff', function(newval){
		if(!newval.projects)	//Rien à importer
			return 0;
		while(newval.projects.length>0){	//Sinon, on importe tous les projets que l'on trouve
			var o = newval.projects.shift();//On prend le premier de la liste (Liste *ordonneé* ici !)
			o.author = o.prenomEns+" "+o.nomEns;//On construit le champ author
			o.authorLink = '?les-encadrants/'+o.idEns+'/';
			//[à implémenter : champ language dans la BDD]
			/*|*/	o.languages = [];
			/*|*/	$scope.languages.forEach(function(lang){
			/*|*/		if(Math.random()>0.5)
			/*|*/			o.languages.push(lang);
			/*|*/	});
			//[Fin-à implémenter]
			$scope.projects.push(o);
		}
	}, true);

	//Languages possibles : bientôt useless [voir quelques lignes au-dessus dans la fonction lié à la surveillance de la variable $scope.importStuff]
	$scope.languages = [
		'any', 			'dot-net',	'html5',	'java',
		'javascript',	'mysql',	'nodejs',	'php',
		'postgresql',	'python'
	];

	//Fonction à appeller pour confirmer les choix effectués
	//	Prérequis : choix déjà sauvegardés
	$scope.confirmChoices = function(){
		//Seul un ordre est donné, aucune donnée ne transite
		$.post( "ajax.php", {action: "confirm-choices"}).done(function(data) {
			if(data!=''){
				$scope.errorSpotted = [true, "La requête a échouée. Message d'erreur : "+data];
				$scope.$apply();
			}
		});
		//Si la requête POST échoue, il y a une erreur non gérée, donc
		//	la page affiche une erreur bloquante (= aucune action possible)
		//	donc on peut afficher sur l'interface que tout a été confirmé.
		//	[A voir : c'est un peu mal]
		$scope.stateConfirm = $scope.textHowToStudent = 'already';
		$scope.highlight = true;
		$scope.draggable = false;
	};

	//Gestion des erreurs ; à priori pas d'erreur
	$scope.errorSpotted = [false];

	//Mise en place du filtre de recherche
	$scope.search = {nomProj: "", languages: "", author: ""};
	
	//Liste des projets à afficher
	$scope.projects = [];

	//Différentes propriétés d'affichage [! il ne faut pas compter sur ces propriétés niveau sécurité]
	$scope.draggable = false;
	$scope.highlight = false;
	$scope.textHowToStudent = 'no';

	//Fonction pour sauvegarder l'état actuel des choix
	$scope.sendOrder = function(){
		var order = '';
    	for(var i in $scope.projects)
    		order += ';'+$scope.projects[i].idProj;
    	$.post( "ajax.php", {action: "update-order", order: order.substr(1)}).done(function(data) {
			if(data!=''){
				$scope.errorSpotted = [true, "La synchronisation a échouée. Message d'erreur : "+data];
				$scope.$apply();
			}
		});
		$scope.isThereAnyModificationsYet = false;
	}

	$scope.dragControlListeners = {
	    accept: function (sourceItemHandleScope, destSortableScope) {return true;},
	    itemMoved: function (event){return true;},
	    orderChanged: function(event){	//Quand l'ordre des projets a été modifié par l'utilisateur
	    	$scope.isThereAnyModificationsYet = true;
	    	//sendOrder();
	    	return true;
	   	}
	};

	//Action pour la petite flèche à droite
	$scope.putThisFirst = function(position){	//Quand l'ordre des projets a été modifié par l'utilisateur
		var elem = $scope.projects.splice(position, 1)[0];
		$scope.isThereAnyModificationsYet = true;
		$scope.projects.unshift(elem);
	};
});