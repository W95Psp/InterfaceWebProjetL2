<?php
	session_start();

	define("ANONYME", 0);
	define("ELEVE", 1);
	define("ENCADRANT", 2);
	define("ADMIN", 3);

	function protect(){
		$okay = false;
		foreach (func_get_args() as $param) {
	        if($param==getUserType())
	        	$okay = true;
	    }
	    if(!$okay)
	    	die("[error]");
		return $okay;
	}

	function getGroupIdFromStudentId($studentId){
		global $db;
	    $result = $db->query('SELECT idG_E FROM Etudiant WHERE idEtu='.intval($studentId)) or die(mysqli_error($db));
	    $result = $result->fetch_array();
	    return $result['idG_E'];
	}
	function getGroupFromGroupId($groupId){
		global $db;
		if($groupId==0)
			throw new Exception("groupId null", 1);
		$result = $db->query('SELECT * FROM Groupe WHERE idG='.intval($groupId)) or die(mysqli_error($db));;
		$result = $result->fetch_array();
		return $result;
	}

	function setUser($id, $name, $type){
		session_unset();
		$_SESSION["userType"] = $type;
		$_SESSION["userId"] = $id;
		$_SESSION["userName"] = $name;
		if($type==ELEVE){
			$_SESSION['groupId'] = getGroupIdFromStudentId($id);
		}
	}

	function getUserType(){
		return (isset($_SESSION["userType"]))?$_SESSION["userType"] : ANONYME;
	}

	function getUserId(){
		return @$_SESSION["userId"] || -1;
	}

	function tempFunction_toDelete_enableForceUserTypeStuff(){
		global $urlParams;
		if(@substr($urlParams[count($urlParams)-1], 0, 17)=='@force-user-type='){
			$idUserType = intval(substr($urlParams[count($urlParams)-1], 17));
			$preDefinedIds = array(
				ANONYME		=> 'none',
				ELEVE		=> 2065, 
				ENCADRANT	=> 1009, 
				ADMIN		=> 1012, 
				);
			setUser($preDefinedIds[$idUserType], "TEST", $idUserType);
		}
	}
?>