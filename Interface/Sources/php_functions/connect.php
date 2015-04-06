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
		$result = $db->query('SELECT idGrEtu FROM Etudiant WHERE idEtu='.intval($studentId)) or die(mysqli_error($db));
	    $result = $result->fetch_array();
	    return $result['idGrEtu'];
	}
	function getGroupFromGroupId($groupId){
		global $db;
		if($groupId==0)
			throw new Exception("groupId null", 1);
		$result = $db->query('SELECT * FROM Groupe WHERE idG='.intval($groupId)) or die(mysqli_error($db));;
		$result = $result->fetch_array();
		return $result;
	}

	function doesTheseUsersExistAndHaveNoGroup($arrUsersId){
		global $db;
		return $db->query('SELECT count(*) FROM Etudiant WHERE idEtu IN ('.implode(',', array_map('intval', $arrUsersId)).') AND idGrEtu IS NULL')->fetch_row()[0]==count($arrUsersId);
	}

	function setUser($id, $name, $type = ANONYME){	//Type {0: ANONYME, 1: ELEVE, 2or3: PROF, gonna see whether admin or not}
		global $db;
		session_unset();
		$id = intval($id);

		if($type>ANONYME)
			if($type==ELEVE)
				$res = $db->query('SELECT nomEtu as nom, prenomEtu as prenom, emailEtu as mail, false as isAdmin FROM Etudiant WHERE idEtu='.$id)->fetch_array();
			else
				$res = $db->query('SELECT nomEns as nom, prenomEns as prenom, emailEns as mail, isAdmin FROM Enseignant WHERE idEns='.$id)->fetch_array();
		$_SESSION["userType"] = $type;
		if($type==ENCADRANT && $res['isAdmin'])
			$_SESSION["userType"] = ADMIN;
		$_SESSION["userId"] = $id;
		if(@$res){
			$_SESSION["userName"] = $res['prenom'].' '.$res['nom'];
			$_SESSION["prenom"] = $res['prenom'];
			$_SESSION["nom"] = $res['nom'];
			$_SESSION["mail"] = $res['mail'];
		}
	}

	function getUserName(){
		return @$_SESSION["userName"];
	}
	$cache_group_id = 'empty';
	function getGroupId(){
		global $cache_group_id;
		if(getUserType()==ELEVE){
			if($cache_group_id=='empty')
				$cache_group_id = intval(getGroupIdFromStudentId(getUserId()));
			return $cache_group_id;
		}else
			return 0;
	}
	function getUserPrenom(){
		return @$_SESSION["prenom"];
	}
	function getUserMail(){
		return @$_SESSION["mail"];
	}
	function getUserNom(){
		return @$_SESSION["nom"];
	}

	function getUserType(){
		return (isset($_SESSION["userType"]))?$_SESSION["userType"] : ANONYME;
	}

	function getUserId(){
		//userId ne peut pas être nul
		return intval((isset($_SESSION["userId"]) && $_SESSION["userId"]) ? $_SESSION["userId"] : -1);
	}
?>