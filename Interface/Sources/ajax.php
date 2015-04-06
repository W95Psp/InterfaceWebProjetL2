<?php
	include("php_functions/mysql.php");
	include("php_functions/connect.php");
	include("php_functions/ask_module.php");

	function preventCoherenceBug(){
		if(!getGroupId())
			die('Erreur de cohérence. Déconnectez vous puis reconnectez vous.');
	}

	function getPeopleInGroup($gId){
		global $db;
		return $db->query('SELECT idEtu as id, (idGrEtu>0) as agree, CONCAT(prenomEtu, " ", nomEtu) as name FROM Etudiant WHERE idGrEtu='.$gId.' OR idGrEtu='.(-intval($gId)));
	}


	if(
			isset($_POST['action'])				&&
			isset($_POST['order'])				&&
			$_POST['action']=='update-order'	&&
			getGroupId()
		){
		protect(ELEVE);
		$group = getGroupFromGroupId(getGroupId());
		if($group['EtatCandidature']!=1)
			die("La candidature est déjà validée, il est impossible de modifier l'ordre des choix.");
		$order = explode(';', $_POST['order']);
		$db->query('DELETE FROM ChoixGroupe WHERE idG='.getGroupId()) or die(mysqli_error($db));;
		$values = '';
		$count = 0;
		foreach ($order as $idProj)
			$values .= ($count?',':'').'('.$idProj.', '.getGroupId().', '.(++$count).')';
		
		$db->query('INSERT INTO ChoixGroupe (idProj, idG, `index`) VALUES '.$values) or die(mysqli_error($db));;

	}else if(isset($_POST['action']) && $_POST['action']=='confirm-choices' && getGroupId()){

		$group = getGroupFromGroupId(getGroupId());
		if($group['EtatCandidature']!=1)
			die("La candidature est déjà validée (ou en attente).");
		// $db->query('DELETE FROM ChoixGroupe WHERE `index` > 6 AND idG='.getGroupId()) or die(mysqli_error($db));
		$db->query('UPDATE Groupe SET EtatCandidature=3 WHERE idG='.getGroupId()) or die(mysqli_error($db));
		
	}else if(@$_GET['action']=='getState'	&&	getUserType()==ELEVE){
		$result = array(
			'groupId' => getGroupId(),
			'inGroup' => array(),
			'listStudents' => array(),
			'myName' => getUserName()
		);

		$res = $db->query('SELECT idEtu as id, idGrEtu, CONCAT(`nomEtu`, " ", `prenomEtu`) as name FROM Etudiant WHERE idEtu!='.getUserId()) or die(mysqli_error($db));

		while($row = $res->fetch_array())
			$result['listStudents'][] = array(
				'id' => intval($row['id']),
				'available'=> intval($row['idGrEtu']==0),
				'name' => $row['name']
			);

		if(getGroupId()!=0){
			$listInGroupSQL = getPeopleInGroup(getGroupId());
			while($user = $listInGroupSQL->fetch_array())
				if(intval($user['id'])!=getUserId())
					$result['inGroup'][] = array(
						'id' => intval($user['id']),
						'agree' => intval($user['agree']),
						'name' => $user['name'],
					);
		}

		echo json_encode($result);
	}else if(@$_GET['action']=='manageInvitation'	&&	getUserType()==ELEVE){
		if(getGroupId()>=0)
			die('Aucune invitation trouvée.');

		$finalIdG = (intval($_GET['accept'])==1)?(-getGroupId()):'NULL';

		$db->query('UPDATE Etudiant SET idGrEtu='.$finalIdG.' WHERE idEtu='.getUserId());
	}else if(
			isset($_GET['action'])			&&
			isset($_GET['id'])		&&
			$_GET['action']=='addToGroup'	&&
			$_GET['id']!=''			&&
			getUserType()==ELEVE
		){

		$listInGroupSQL = getPeopleInGroup(getGroupId());
		$count = 0;
		while($row = $listInGroupSQL->fetch_array())
			$count++;

		if($count>=4) //3+le créateur
			die('Erreur : il ne peut y avoir que 3 personnes maximum par groupes.');

		if(!doesTheseUsersExistAndHaveNoGroup(array($_GET['id'])))
			die('[#'.$_GET['id'].'] student was not found.');

		$db->query('UPDATE Etudiant SET idGrEtu='.(-getGroupId()).' WHERE idEtu='.intval($_GET['id']));
	}else if(
			isset($_GET['action'])			&&
			$_GET['action']=='createGroup'	&&
			getUserType()==ELEVE
		){
		if(getGroupId()!=null)
			die('Error: the student ['.getUserName().'] can\'t create a group while he is already in another one.');

		$db->query('INSERT INTO Groupe(idEtuCreator) VALUES ('.intval(getUserId()).')');
		$idG = $db->insert_id;
		$db->query('UPDATE Etudiant SET idGrEtu='.$idG.' WHERE idEtu='.intval(getUserId()));
	}else{
		echo 'invalid request';
	}
?>