var app = angular.module('ProjetsL2', ['ui.sortable']);

app.filter('parseCsv', function() {
    return function(input) {
        return (input||"").split(SC.separator);
    }
});

var SC;
app.controller('admin', function($scope, $parse) {
	SC = $scope;
	$scope.etudiantsMode = 0;
	$scope.pages = ["Encadrants", "Groupes", "Présentation", "Modalité notes", "Etudiants"];
	$scope.currentPage = 4;
	$scope.etudiantsData = '';
	$scope.separator = 'none';
});

function tryToFindSeparator(){
	var numberOf_total = {'|': 0, ':': 0, ',': 0, ';': 0, '\t': 0};

	var max = SC.etudiantsData.length;
	if(max>30)
		max = 30;

	for(var i=0; i<max; i++)
		for(var separator in numberOf_total)
			numberOf_total[separator]+=occurrences(SC.etudiantsData[i], separator);

	var best = ['none', -1];
	for(var i in numberOf_total)
		if(numberOf_total[i]>best[1])
			best = [i, numberOf_total[i]];

	return best[0];
}

function occurrences(string, subString, allowOverlapping){
    string+=""; subString+="";
    if(subString.length<=0) return string.length+1;

    var n=0, pos=0;
    var step=(allowOverlapping)?(1):(subString.length);

    while(true){
        pos=string.indexOf(subString,pos);
        if(pos>=0){ n++; pos+=step; } else break;
    }
    return(n);
}

function importData(files){
	var reader = new FileReader();
	reader.readAsText(files[0]);
	reader.onload = function(event) {
		var csvData = event.target.result;
		SC.etudiantsMode = 1;
		SC.etudiantsData = csvData.split(/\r|\n/);
		for(var i in SC.etudiantsData){
			if(SC.etudiantsData[i]=='')
				delete SC.etudiantsData[i];
			else
				SC.etudiantsData[i] = SC.etudiantsData[i].trim();
		}

		SC.separator = tryToFindSeparator();
		SC.$apply();
	};
	reader.onerror = function() {
		alert('Unable to read ' + file.fileName);
	};
}

function handleFileSelect(evt) {
    evt.stopPropagation();
    evt.preventDefault();

    importData(evt.dataTransfer.files);
	
    document.getElementById('dragDropArea').className = '';
}
function handleDragOver(evt) {
	evt.stopPropagation();
	evt.preventDefault();
	evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
}

$(function(){
	var dropZone = document.getElementById('dragDropArea');
	dropZone.addEventListener('dragover', handleDragOver, false);
	dropZone.addEventListener('drop', handleFileSelect, false);

	dropZone.addEventListener("dragenter", function (){this.className = 'hover'; return false;}, false);
	dropZone.addEventListener("dragleave",function (){this.className = ''; return false;},false);
	// dropZone.addEventListener("dragend",function (){this.className = ''; return false;},false);
})