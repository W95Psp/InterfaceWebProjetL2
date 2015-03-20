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

app.controller('main', function($scope, $parse) {
	window.SC = $scope;
	SC.importStuff = importStuff;
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
	
	$scope.search = {nomProj: "", languages: "", author: ""};

	$scope.projects = [];

	$scope.dragControlListeners = {
	    accept: function (sourceItemHandleScope, destSortableScope) {return true;},
	    itemMoved: function (event){return true;},
	    orderChanged: function(event){return true;}
	};
});