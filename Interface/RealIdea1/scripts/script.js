var app = angular.module('ProjetsL2', ['ui.sortable']);

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
			languages: ['javascript', 'dot-net', 'html5', 'java', 'php', 'any']
		},
		{
			title: 'Retrogaming: Arkanoid',
			author: authors[1],
			languages: ['any', 'php', 'cpp']
		},
		{
			title: 'Implémentation et évaluation d’un prouveur en logique des propositions',
			author: authors[9],
			languages: ['any', 'cpp']
		},
		{
			title: 'Bubble Shooter',
			author: authors[2],
			languages: ['any', 'cpp', 'java']
		},
		{
			title: 'Le AA',
			author: authors[3],
			languages: ['any', 'java']
		},
		{
			title: 'Le BB',
			author: authors[3],
			languages: ['any', 'java']
		},
		{
			title: 'Le CC',
			author: authors[3],
			languages: ['any', 'java']
		},
		{
			title: 'Le DD',
			author: authors[3],
			languages: ['any', 'java']
		},
		{
			title: 'Le EE',
			author: authors[3],
			languages: ['any', 'java']
		},
		{
			title: 'Le FF',
			author: authors[3],
			languages: ['any', 'java']
		},
		{
			title: 'Le GG',
			author: authors[3],
			languages: ['any', 'java']
		},
		{
			title: 'Editeur SKOS et application aux paysages urbains',
			author: authors[4],
			languages: ['any', 'java']
		}
	];

	$scope.dragControlListeners = {
	    accept: function (sourceItemHandleScope, destSortableScope) {return true;},
	    itemMoved: function (event){return true;},
	    orderChanged: function(event){return true;}
	};
});