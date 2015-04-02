<?php

function execThisAction($action){
	if($action['type']=='delete'){
		// if($action['subject']=='')
	}
}

function askPeoples($listOfStudentsId, $listOfTeachersId, $objectJson){
	global $db;
	$sql = '
SELECT  `idEtu` as id, `nomEtu` as nom, TRUE as isEleve, `prenomEtu` as prenom,
		`emailEtu` as email FROM `Etudiant`
	WHERE idEtu IN ('.implode(',', array_map('intval', $listOfStudentsId)).')

UNION ALL

SELECT  `idEns` as id, `nomEns` as nom, FALSE as isEleve, `prenomEns` as prenom,
		`emailEns` as email FROM `Enseignent`
	WHERE idEns IN ('.implode(',', array_map('intval', $listOfTeachersId)).');';

	$listPeople = array();
	foreach ($listOfStudentsId as $id)
		$listPeople[] = intval($id);
	foreach ($listOfTeachersId as $id)
		$listPeople[] = 'p'.intval($id);

	echo json_encode($listPeople);

	$listPeople = implode(',', $listPeople);


	$res = $db->query('INSERT INTO Action_sous_confirmation (concernedPeople, dataJson, expiration, idPersonInCharge, isPersonInChargeAStudent) VALUES ("'.$listPeople.'", "'.$db->real_escape_string(json_encode($objectJson)).'", DATE_ADD( utc_timestamp( ) , INTERVAL 4 DAY), '.intval(getUserId()).', '.intval(getUserType()==ELEVE).')') or die(mysqli_error($db));
	
	$res = $db->query($sql) or die(mysqli_error($db));

	while (NULL !== ($someone = $res->fetch_array())){
		echo '</hr>';
		echo 'Envoyer un mail à : '.$someone['prenom'].' '.$someone['nom'];
		echo '<br/>';
		echo '<br/>';
		$subject = 'Something';
		$message = '<h1></h1>';
	}
}

function getNoticesForMe(){
	global $db;
	$notices = array();
	if(getUserType()==ANONYME)
		return $notices;
	$res = $db->query('SELECT * FROM Action_sous_confirmation WHERE isPersonInChargeAStudent='.intval(getUserType()==ELEVE).' AND idPersonInCharge='.intval(getUserId())) or die(mysqli_error($db));

	while (NULL !== ($row = $res->fetch_array())){
		$row['dataJson'] = json_decode($row['dataJson'], true);
		$notices[] = $row;
	}
	return $notices;
}

function confirmOrDeclineLink($idToConfirm, $confirmOrNot = true){
	global $db;
	$type = getUserType();
	if($type>ANONYME){
		$id = (($type==ELEVE)?'':'p').intval(getUserId());
		$res = $db->query('SELECT dataJson, concernedPeople FROM Action_sous_confirmation WHERE id='.intval($idToConfirm).' AND FIND_IN_SET("'.$id.'", concernedPeople)') or die(mysqli_error($db));
		$rows = array();
		while (NULL !== ($row = $res->fetch_array()))
			$rows[] = array(
				'dataJson' => $row['dataJson'],
				'concernedPeople' => explode(',', $row['concernedPeople'])
				);
		if(count($rows)==0)
			return false;
		$row = $rows[0];
		$concernedPeople = '';
		$numberOfAgree = 0;
		$numberOfDisagree = 0;
		$numberOfNothing = 0;
		while($concernedSomeone = array_pop($row['concernedPeople'])){
			if($concernedPeople!='')
				$concernedPeople .= ',';
			if($concernedSomeone.''==$id.'')
				$concernedSomeone = ($confirmOrNot?'+':'-').$concernedSomeone;
			$numberOfAgree   +=($concernedSomeone[0]=='+');
			$numberOfDisagree+=($concernedSomeone[0]=='-');
			$numberOfNothing +=($concernedSomeone[0]!='-' && $concernedSomeone[0]!='+');
			$concernedPeople .= $concernedSomeone;
		}
		if($numberOfNothing==0 && $numberOfDisagree==0){//Tout le monde il est content
			$db->query('DELETE FROM Action_sous_confirmation WHERE id='.intval($idToConfirm)) or die(mysqli_error($db));
			execThisAction(json_decode($row['dataJson']));
		}else{
			if(!$confirmOrNot){

			}
			//On mets à jour, quand même !
			$db->query('UPDATE Action_sous_confirmation SET concernedPeople="'.$db->real_escape_string($concernedPeople).'" WHERE id='.intval($idToConfirm)) or die(mysqli_error($db));
		}
		return true;
	}
}

//To delete
// define("ANONYME", 0);
// define("ELEVE", 1);
// define("ENCADRANT", 2);
// define("ADMIN", 3);
// $fakeAccount = array(
// 	'type'=> ENCADRANT,
// 	'id'=>	1002
// );
// function getUserType(){
// 	global $fakeAccount;
// 	return $fakeAccount['type'];
// }function getUserId(){
// 	global $fakeAccount;
// 	return $fakeAccount['id'];
// }
//Stop to delete

// echo 'Result : '.(confirmOrDeclineLink(1, false)?'True':'False');

// askPeoples([2007, 2002, 2012, 2014], [1001, 1002, 1008], array("test" => 123));
?>