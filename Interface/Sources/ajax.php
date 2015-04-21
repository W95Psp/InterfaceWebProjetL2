<?php
	include("php_functions/mysql.php");
	include("php_functions/connect.php");

	function getPeopleInGroup($gId){
		global $db;
		return $db->query('SELECT idEtu as id, (idGrEtu>0) as agree, CONCAT(prenomEtu, " ", nomEtu) as name FROM V_EtudiantPromo WHERE idGrEtu='.$gId.' OR idGrEtu='.(-intval($gId)));
	}

	$ajaxFunctions = array();
	include("php_functions/ajax/updateOrder.php");
	include("php_functions/ajax/opinionNeededChoices.php");
	include("php_functions/ajax/decisionWithChoices.php");
	include("php_functions/ajax/confirmChoices.php");

	if(isset($_POST['order']) && @$_POST['action']=='update-order' && getGroupId() && $isWebsiteOpen && getUserType()==ELEVE){

		$ajaxFunctions['update-order'](getGroupFromGroupId(getGroupId()), $_POST['order']);

	}else if(@$_GET['action']=='opinion-needed-choices' && getGroupId()){
		
		$ajax['opinion-needed-choices']();

	}else if(@$_GET['action']=='decision-with-choices' && $isWebsiteOpen && @$_GET['agree'] && getGroupId()){
		
		$ajax['decision-with-choices'](intval($_GET['agree']=='true')+1, );

	}else if(@$_POST['action']=='confirm-choices' && $isWebsiteOpen && getGroupId()){

		$ajax['confirm-choices']();
		
	}else if(@$_GET['action']=='getState'	&&	getUserType()==ELEVE){
		$result = array(
			'groupId' => getGroupId(),
			'inGroup' => array(),
			'listStudents' => array(),
			'myName' => getUserName()
		);

		$res = $db->query('SELECT idEtu as id, idGrEtu, CONCAT(`nomEtu`, " ", `prenomEtu`) as name FROM V_EtudiantPromo WHERE idEtu!='.getUserId()) or die(mysqli_error($db));

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
	}else if(@$_GET['action']=='switchVisility'	&& @$_GET['id'] &&	getUserType()==ADMIN){
		$db->query('UPDATE Projet SET estValide=(1-estValide) WHERE idProj='.intval($_GET['id']));
		$res = $db->query('SELECT estValide FROM Projet WHERE idProj='.intval($_GET['id']))->fetch_array();
		echo (intval($res['estValide'])==1)?'true':'false';
	}else if(@$_GET['action']=='manageInvitation' && $isWebsiteOpen	&&	getUserType()==ELEVE){
		if(getGroupId()>=0)
			die('Aucune invitation trouvée.');

		$finalIdG = (intval($_GET['accept'])==1)?(-getGroupId()):'NULL';

		$db->query('UPDATE Etudiant SET idGrEtu='.$finalIdG.' WHERE idEtu='.getUserId());
	}else if(
			isset($_GET['action'])			&&
			isset($_GET['id'])		&&
			$_GET['action']=='addToGroup'	&&
			$_GET['id']!=''			&&
			getUserType()==ELEVE && $isWebsiteOpen
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
			getUserType()==ELEVE	&& $isWebsiteOpen
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