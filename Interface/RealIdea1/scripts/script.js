var app = angular.module('ProjetsL2', ['ui.sortable']);

app.filter('getLinkFromTitle', function() {
    return function(input) {
        return input.title.replace(/ /g, "-").replace(/[^a-z\-]/gi, "").toLowerCase();
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

app.controller('main', function($scope, $parse) {
	window.SC = $scope;
	var authors;
	$scope.languages = [
		'any', 			'dot-net',	'html5',	'java',
		'javascript',	'mysql',	'nodejs',	'php',
		'postgresql',	'python'
	];
	$scope.authors = authors = [
		'Hervé Dicky',				// 0
		'Mickael Montassier',		// 1
		'Stéphane Bessy',			// 2
		'Nicolas Briot',			// 3
		'Isabelle Mougenot',		// 4
		'Vincent Boudet',			// 5
		'Lionel Ramadier',			// 6
		'Philippe Janssen',			// 7
		'Abdelhak-Damel Seriai',	// 8
		'Michel Leclère'			// 9
	];

	$scope.search = {title: "", author:"", languages:""};

	$scope.projects = [
		{
			title: 'Le carré empoisonné de la tablette de chocolat',
			author: authors[0],
			languages: ['javascript', 'dot-net', 'html5', 'java', 'php', 'any'], id: 0
		},
		{
			title: 'Retrogaming: Arkanoid',
			author: authors[1],
			languages: ['any', 'php', 'cpp'], id: 1
		},
		{
			title: 'Implémentation et évaluation d’un prouveur en logique des propositions',
			author: authors[9],
			languages: ['any', 'cpp'], id: 2
		},
		{
			title: 'Bubble Shooter',
			author: authors[2],
			languages: ['any', 'cpp', 'java'], id: 3
		},
		{
			title: 'Le AA',
			author: authors[3],
			languages: ['any', 'java'], id:4
		},
		{
			title: 'Le BB',
			author: authors[3],
			languages: ['any', 'java'], id: 5
		},
		{
			title: 'Le CC',
			author: authors[3],
			languages: ['any', 'java'], id: 6
		},
		{
			title: 'Le DD',
			author: authors[3],
			languages: ['any', 'java'], id: 7
		},
		{
			title: 'Le EE',
			author: authors[3],
			languages: ['any', 'java'], id: 8
		},
		{
			title: 'Le FF',
			author: authors[3],
			languages: ['any', 'java'], id: 9
		},
		{
			title: 'Le GG',
			author: authors[3],
			languages: ['any', 'java'], id: 10
		},
		{
			title: 'Editeur SKOS et application aux paysages urbains',
			author: authors[4],
			languages: ['any', 'java'], id: 11
		}
	];

	$scope.dragControlListeners = {
	    accept: function (sourceItemHandleScope, destSortableScope) {return true;},
	    itemMoved: function (event){return true;},
	    orderChanged: function(event){return true;}
	};
});