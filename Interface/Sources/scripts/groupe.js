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
app.controller('groupe', function($scope, $http) {
	SC = $scope;

	$scope.listStudents = new Array();
	$scope.syncFinished = false;
	$scope.errorSpotted = [false, ''];
	$scope.group = new Array({id: false},{id: false},{id: false});

	function getIndexOfStudent(student){
		for(var i in $scope.listStudents)
			if(student.id==$scope.listStudents[i].id)
				return i;
	}

	$scope.chooseThisStudent = function(student, groupPosition){
		console.log("choose=",student);
		$scope.group[groupPosition] = $scope.listStudents.splice(getIndexOfStudent(student), 1)[0];
		$scope.group[groupPosition].temp = true;
	}

	var lastUpdate = '!';
	setInterval($scope.refresh = function(){
		$.ajax({
			type: "GET",
			url: 'ajax.php?action=getState',
			success: function(result){
				if(lastUpdate!=result){
					$scope.syncFinished = true;
					lastUpdate = result;
					try{
						result = JSON.parse(result);
					}catch(err){
						$scope.errorSpotted = [true, result];
						$scope.$apply();
						return;
					}

					console.log('success', result);

					$scope.groupId = result.groupId;
					$scope.myName = result.myName;
					
					while(result.inGroup.length<3)
						result.inGroup.push({id: 0});
					for(var i in result.inGroup)
						$scope.group[i] = result.inGroup[i];

					while($scope.listStudents.length)
						$scope.listStudents.pop();
					for(var i in result.listStudents)
						$scope.listStudents.push(result.listStudents[i]);
					
					$scope.$apply();
				}
			}
		});
	}, 2000);


	function error(res){
		$scope.errorSpotted = [true, res];
	}
	defaultCallback = function(res){
			if(res.length>0)
				error(res);
			$scope.refresh();
		};
	$scope.createGroup = function(sId){
		$http.get("ajax.php?action=createGroup").success(defaultCallback);
	};
	$scope.acceptInvitation = function(sId){
		$http.get("ajax.php?action=manageInvitation&accept=1").success(defaultCallback);
	};
	$scope.declineInvitation = function(sId){
		$http.get("ajax.php?action=manageInvitation&accept=0").success(defaultCallback);
	};
	$scope.addToGroup = function(sId){
		$http.get('ajax.php?action=addToGroup&id='+(+sId)).success(defaultCallback);
	}
	$scope.refresh();
});