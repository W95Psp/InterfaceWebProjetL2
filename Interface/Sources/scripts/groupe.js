var app = angular.module('ProjetsL2', []);

app.filter('getUsernameById', function() {
    return function(inputId, $scope) {
    	for(var i in $scope.alreadySelectedStudents)
    		if($scope.alreadySelectedStudents[i].id==inputId)
    			return $scope.alreadySelectedStudents[i].name;
    	for(var i in $scope.listStudents)
    		if($scope.listStudents[i].id==inputId)
    			return $scope.listStudents[i].name;
    	return '[error-user-not-found]';
    }
});
var SC;
app.controller('groupe', function($scope, $parse) {
	$scope.GroupComposedBy = new Array(2003, 2009, 2005);
	$scope.fixed = true;
	SC = $scope;
	$scope.alreadySelectedStudents = [];
	$scope.deleteFromList = function(id){
		for(var i in $scope.listStudents)
			if($scope.listStudents[i].id==id)
				$scope.alreadySelectedStudents.push($scope.listStudents.splice(i, 1)[0]);
		return true;
	}
	$scope.recoverToList = function(id){
		for(var i in $scope.alreadySelectedStudents)
			if($scope.alreadySelectedStudents[i].id==id)
				$scope.listStudents.push($scope.alreadySelectedStudents.splice(i, 1)[0]);
	}
	$scope.countFilled = function(){
		return ($scope.GroupComposedBy[0]!=-1)+($scope.GroupComposedBy[1]!=-1)+($scope.GroupComposedBy[2]!=-1);
	}
	$scope.tempFun_to_delete__ = function(){
		for(var i in $scope.listStudents)
			$scope.listStudents[i].available = true;
	}
	for(var i in [200, 600, 3000])
		setTimeout(function(){
			for(var i in $scope.GroupComposedBy)
				$scope.deleteFromList($scope.GroupComposedBy[i]);
		}, i);
});