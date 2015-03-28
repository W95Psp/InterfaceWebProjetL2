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
	$scope.etudiantsDataFinal = [];
	$scope.separator = 'none';
	$scope.firstLineHeader = true;
	$scope.columnsOptions = ['Ignorer', 'Mail', 'Nom', 'Prenom'];
	$scope.columns = {};
	for(var i=0; i<30; i++)
		$scope.columns[i] = $scope.columnsOptions[0];
	$scope.columnsOptions_sum = {};
	$scope.twoSameInfo = false;
	$scope.twoSameInfoDetails = [];
	$scope.completed = false;
	$scope.filterEtDatFin = {};
	for(var i=1; i<$scope.columnsOptions.length; i++)
		$scope.filterEtDatFin[$scope.columnsOptions[i]] = '';

	function lookFor(arr, opt){
		for(var i in arr)
			if(arr[i]==opt)
				return i;
		return -1;
	}

	$scope.convertCSV = function(){
		if($scope.firstLineHeader)
			$scope.etudiantsData.shift();
		var indexes = {};
		for(var j=1; j<$scope.columnsOptions.length; j++)
			indexes[$scope.columnsOptions[j]] = lookFor($scope.columns, $scope.columnsOptions[j]);
		for(var i in $scope.etudiantsData){
			var o = $scope.etudiantsData[i].split($scope.separator);
			var d = {};
			for(var j in indexes)
				d[j] = o[indexes[j]];
			$scope.etudiantsDataFinal.push(d);
		}
		$scope.etudiantsMode=2;
	};

	$scope.$watch('columns', function(newVal){
		for(var i in $scope.columnsOptions)
			$scope.columnsOptions_sum[$scope.columnsOptions[i]] = 0;
		for(var i in newVal)
			$scope.columnsOptions_sum[newVal[i]] += 1;
		$scope.columnsOptions_sum['Ignorer'] = 0;
		$scope.twoSameInfo = false;
		while($scope.twoSameInfoDetails.length)
			$scope.twoSameInfoDetails.pop();
		var numberValid = 0;
		for(var i in $scope.columnsOptions_sum)
			if($scope.columnsOptions_sum[i]>1){
				$scope.twoSameInfoDetails.push(i);
				$scope.twoSameInfo = true;
			}else if($scope.columnsOptions_sum[i]==1){
				numberValid++;
			}
		$scope.completed = numberValid==$scope.columnsOptions.length-1;
	}, true);
});

function confirmAndSent(o){
	var obj = SC.etudiantsDataFinal;
	var data = [];
	for(var i in obj)
		data.push([obj[i].Nom, obj[i].Prenom, obj[i].Mail]);
	o.parentElement.getElementsByTagName('input')[0].value = JSON.stringify(data);
	o.parentElement.submit();
}

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