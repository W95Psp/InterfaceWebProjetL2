var app = angular.module('ProjetsL2', ['ui.sortable']);

app.filter('getLinkFromTitle', function() {
    return function(input) {
        return input.nomProj.replace(/ /g, "-").replace(/[^a-z\-]/gi, "").toLowerCase();
    }
});
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
	SC.importStuff = importStuff;
	$scope.stateConfirm = 'already';
	SC.$watch('importStuff', function(newval){
		if(!newval.projects)
			return 0;
		while(newval.projects.length>0){
			var o = newval.projects.shift();
			o.author = o.prenomEns+" "+o.nomEns;
			o.authorLink = '?les-encadrants/'+o.idEns+'/';
			o.languages = [];
			$scope.languages.forEach(function(lang){
				if(Math.random()>0.5)
					o.languages.push(lang);
			});
			$scope.projects.push(o);
		}
	}, true);

	
	var authors;
	$scope.languages = [
		'any', 			'dot-net',	'html5',	'java',
		'javascript',	'mysql',	'nodejs',	'php',
		'postgresql',	'python'
	];

	$scope.confirmChoices = function(){
		$.post( "ajax.php", {action: "confirm-choices"}).done(function(data) {
			if(data!=''){
				$scope.errorSpotted = [true, "La requête a échouée. Message d'erreur : "+data];
				$scope.$apply();
			}
		});
		$scope.stateConfirm = $scope.textHowToStudent = 'already';
		$scope.highlight = true;
		$scope.draggable = false;
	};

	$scope.errorSpotted = [false];
	$scope.search = {nomProj: "", languages: "", author: ""};
	$scope.projects = [];
	$scope.draggable = false;
	$scope.highlight = false;
	$scope.textHowToStudent = 'no';

	$scope.dragControlListeners = {
	    accept: function (sourceItemHandleScope, destSortableScope) {return true;},
	    itemMoved: function (event){return true;},
	    orderChanged: function(event){
	    	var order = '';
	    	for(var i in $scope.projects)
	    		order += ';'+$scope.projects[i].idProj;
	    	$.post( "ajax.php", {action: "update-order", order: order.substr(1)}).done(function(data) {
				if(data!=''){
					$scope.errorSpotted = [true, "La synchronisation a échouée. Message d'erreur : "+data];
					$scope.$apply();
				}
			});
	    	return true;
	   	}
	};

	$scope.putThisFirst = function(position){
		var elem = $scope.projects.splice(position, 1)[0];
		console.log(elem);
		$scope.projects.unshift(elem);
	};
});