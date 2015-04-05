<?php
	include("php_functions/mysql.php");
	include("php_functions/connect.php");
	include("php_functions/ask_module.php");

	if(
			isset($_POST['action'])				&&
			isset($_POST['order'])				&&
			$_POST['action']=='update-order'	&&
			$_SESSION['groupId']
		){
		protect(ELEVE);
		$group = getGroupFromGroupId($_SESSION['groupId']);
		if($group['EtatCandidature']!=1)
			die("La candidature est déjà validée, il est impossible de modifier l'ordre des choix.");
		$order = explode(';', $_POST['order']);
		$db->query('DELETE FROM ChoixGroupe WHERE idG='.$_SESSION['groupId']) or die(mysqli_error($db));;
		$values = '';
		$count = 0;
		foreach ($order as $idProj)
			$values .= ($count?',':'').'('.$idProj.', '.$_SESSION['groupId'].', '.(++$count).')';
		
		$db->query('INSERT INTO ChoixGroupe (idProj, idG, `index`) VALUES '.$values) or die(mysqli_error($db));;
	}else if(isset($_POST['action']) && $_POST['action']=='confirm-choices' && $_SESSION['groupId']){
		$group = getGroupFromGroupId($_SESSION['groupId']);
		if($group['EtatCandidature']!=1)
			die("La candidature est déjà validée (ou en attente).");
		$db->query('DELETE FROM ChoixGroupe WHERE `index` > 6 AND idG='.$_SESSION['groupId']) or die(mysqli_error($db));
		$db->query('UPDATE Groupe SET EtatCandidature=3 WHERE idG='.$_SESSION['groupId']) or die(mysqli_error($db));
		
		$result = $db->query('SELECT proj.nomProj as name, proj.idProj as id, chxGrp.index as `index` FROM `ChoixGroupe` as chxGrp
		LEFT JOIN Projet AS proj
			ON proj.idProj=chxGrp.idProj
		WHERE `index` <= 6 AND idG='.$_SESSION['groupId'].' ORDER BY chxGrp.index') or die(mysqli_error($db));

		$message = "Bonjour, êtes-vous d'accord avec les choix suivants, pour votre groupe : \r\n";
		while (NULL !== ($proj = $result->fetch_array()))
			$message .= ' '.$proj['index'].') '.$proj['name']."\r\n";

		$result = $db->query('
(
    SELECT GROUP_CONCAT(result.id) as ids FROM
    (
        SELECT idEtu as id FROM Etudiant WHERE idG_E='.$_SESSION['groupId'].'
    ) result
)
UNION ALL
(
    SELECT GROUP_CONCAT(result.id) as ids FROM
    (
        SELECT ens.idEns as id FROM Responsable as resp
        LEFT JOIN Enseignent AS ens
            ON ens.idEns=resp.Enseignant_idEns
        WHERE resp.ProjectL2_idPro='.$_SESSION['groupId'].'
    ) result
)');	
		$ids_eleves = explode(',',$result->fetch_array()['ids']);
		$ids_profs  = explode(',',$result->fetch_array()['ids']);
		ConfirmModule::registerAction(
			$ids_eleves,
			$ids_profs,
			array(
				"action" => "validChoices",
				"groupId"=> $_SESSION['groupId'],
				"explain"=> "validation des choix du groupe",
				"message"=> $message
			)
		);
	}else if(
			isset($_GET['action'])			&&
			$_GET['action']=='fetchMyState'	&&
			getUserType()==ELEVE
		){
		$result = array();
		//If current student own a group
		if($db->query('SELECT count(*) FROM Groupe WHERE idEtuCreator='.intval(getUserId()))->fetch_row()[0]==0){//no
			$result['state'] = '?';//Well, nothing in DB
		}else{//Student own a group
			if(!$_SESSION['groupId'])
				die('Erreur de cohérence. Déconnectez vous puis reconnectez vous.');
			$gId = intval($_SESSION['groupId']);

			$notices = ConfirmModule::getNotices();
			//Sorry for the final "s" at peoples :S
			$peoples = array();
			//Liste de toutes les personnes ayant refusé ou n'ayant pas encore répondu
			foreach($notices as $notice){
				if($notice["dataJson"]["action"]=="joinGroup"){
					$peoples[] = array(
						"state" => (count($notice["concernedPeople"]['list-'])==0)?0:2,
						"id" => $notice["concernedPeople"]['all-values'][0]
					);
				}
			}
			//Liste de toutes les personnes déjà dans le groupe sauf l'étudiant créateur
			$etuInG = $db->query('SELECT idEtu FROM `Etudiant` WHERE idG_E='.$gId.' AND idEtu!='.intval(getUserId()));
			$result['state'] = 'compose';
			$result['fixed'] = true;
			
			while($etu = $etuInG->fetch_row()){
				$peoples[] = array(
					"state" => 1,
					"id" => $etu['idEtu']
				);
			}

			$result['peoples'] = $peoples;
		}
		echo json_encode($result);
	}else if(
			isset($_GET['action'])			&&
			isset($_GET['persons'])		&&
			$_GET['action']=='createGroup'	&&
			$_GET['persons']!=''			&&
			getUserType()==ELEVE
		){
		$persons = explode(',', $_GET['persons']);
		if(!doesTheseUsersExistAndHaveNoGroup($persons))
			die('Some student ID were not found ('.$_GET['persons'].').');
		if($_SESSION['groupId']==null)
			die('Error: the student ['.getUserName().'] can\'t create a group while he is already in another one.');
		$number = $db->query('SELECT count(*) FROM Groupe WHERE idEtuCreator='.intval(getUserId()))->fetch_row()[0];
		if($number!=0)
			die('Error: the student ['.getUserName().'] own already a group.');

		$db->query('INSERT INTO Groupe(idEtuCreator) VALUES ('.intval(getUserId()).')');
		foreach ($persons as $person) {
			echo '<br/> Demande à '.$person.' :';
			ConfirmModule::registerAction(array(intval($person)), array(), array(
				"action" => "joinGroup",
				"explain" => 'rejoindre votre groupe'
			));
		}
	}else{
		echo 'invalid request';
	}
?>