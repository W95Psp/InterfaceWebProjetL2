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
	$scope.mode = '?';
	$scope.errorSpotted = [false, ''];
	$scope.GroupComposedBy = new Array(-1, -1, -1);
	$scope.GroupComposedByState = new Array(0, 0, 0);
	$scope.fixed = false;
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
	$scope.ask = function(){
		$.ajax({
			type: "GET",
			url: 'ajax.php?action=createGroup&persons='+($scope.GroupComposedBy.join(',')),
			success: function(result){
				if(result.length>0){
					$scope.errorSpotted = [true, result];
					$scope.$apply();
				}
			}
		});
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
	var lastUpdate = '!';
	setInterval($scope.refesh = function(){
		$.ajax({
			type: "GET",
			url: 'ajax.php?action=fetchMyState',
			success: function(result){
				if(lastUpdate!=result){
					$scope.canShow = true;
					lastUpdate = result;
					try{
						result = JSON.parse(result);
					}catch(err){
						$scope.errorSpotted = [true, result];
						$scope.$apply();
						return;
					}
					console.log(result);
					$scope.mode = result.state;
					$scope.fixed = result.fixed;
					
					if($scope.fixed){
						for(var i in result.peoples){//Sorry for the final "s" at peoples :S
							var one = result.peoples[i];
							$scope.GroupComposedBy[i] = +one.id;
							$scope.GroupComposedByState[i] = +one.state;
						}
					}
					$scope.$apply();
				}
			}
		});
	}, 2000);

	$scope.refesh();
});