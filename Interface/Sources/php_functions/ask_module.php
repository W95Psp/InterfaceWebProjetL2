<?php
class ConfirmModule{
	private static function exec($action){
		global $db;
		if($action['action']=='delete-projet'){
			$db->query('DELETE Projet WHERE idProj='.$action['id']) or die(mysqli_error($db));
		}else if($action['action']=='joinGroup'){
			$db->query('UPDATE Etudiant SET idGrEtu='.$action['idGroup'].' WHERE idEtu='.intval(getUserId())) or die(mysqli_error($db));
		}else if($action['action']=='validChoices'){
			$db->query('UPDATE Groupe SET EtatCandidature=2 WHERE idG='.$action['groupId']) or die(mysqli_error($db));
		}
	}

	private static function sendEmail($profile, $actionId, $subject){

	}

	public static function registerAction($listOfStudentsId, $listOfTeachersId, $objectJson){
		global $db;
		$prefixSQL1 = (count($listOfStudentsId)==0)?'-5':'';
		$prefixSQL2 = (count($listOfTeachersId)==0)?'-5':'';
		// SQL Querty to select emails of every peoples involved
		$sql = '
	SELECT  `idEtu` as id, `nomEtu` as nom, TRUE as isEleve, `prenomEtu` as prenom,
			`emailEtu` as email FROM `Etudiant`
		WHERE idEtu IN ('.$prefixSQL1.implode(',', array_map('intval', $listOfStudentsId)).')

	UNION ALL

	SELECT  `idEns` as id, `nomEns` as nom, FALSE as isEleve, `prenomEns` as prenom,
			`emailEns` as email FROM `Enseignant`
		WHERE idEns IN ('.$prefixSQL2.implode(',', array_map('intval', $listOfTeachersId)).');';

		//Let's build the list (teacher prefixed by "p")
		$listPeople = array();
		foreach ($listOfStudentsId as $id)
			$listPeople[] = intval($id);
		foreach ($listOfTeachersId as $id)
			$listPeople[] = 'p'.intval($id);

		$listPeople = implode(',', $listPeople);

		$res = $db->query('INSERT INTO Action_sous_confirmation (concernedPeople, dataJson, expiration, idPersonInCharge, isPersonInChargeAStudent) VALUES ("'.$listPeople.'", "'.$db->real_escape_string(json_encode($objectJson)).'", DATE_ADD( utc_timestamp( ) , INTERVAL 4 DAY), '.intval(getUserId()).', '.intval(getUserType()==ELEVE).')') or die(mysqli_error($db));
		
		$res = $db->query($sql) or die(mysqli_error($db));

		while (NULL !== ($someone = $res->fetch_array()))
			self::sendEmail($someone, $db->insert_id, @json_decode($objectJson, true)['explain']);
	}

	public static function getUserByArray($arr){
		$id = intval($arr['value']);
		global $db;
		if($arr['isStudent'])
			$r=$db->query('SELECT nomEtu as nom, prenomEtu as prenom FROM Etudiant WHERE idEtu='.$id)->fetch_array();
		else
			$r=$db->query('SELECT nomEns as nom, prenomEns as prenom FROM Enseignant WHERE idEns='.$id)->fetch_array();
		return $r["prenom"].' '.$r["nom"];
	}

	public static function getAsks(){
		global $db;
		$res = $db->query('SELECT `id`, `idPersonInCharge`, `isPersonInChargeAStudent`, `concernedPeople`, `dataJson` FROM `Action_sous_confirmation` WHERE FIND_IN_SET("'.getUserId().'", concernedPeople)') or die(mysqli_error($db));
		$asks = array();
		while($row=$res->fetch_array())
			$asks[] = array(
				'id' => $row['id'],
				'idPersonInCharge' => $row['idPersonInCharge'],
				'isPersonInChargeAStudent' => $row['isPersonInChargeAStudent'],
				'concernedPeople' => $row['concernedPeople'],
				'dataJson' => json_decode($row['dataJson'], true)
			);
		return $asks;
	}
	public static function getNotices(){
		global $db;
		$notices = array();
		$id = intval(getUserId());
		$isStudent = intval(getUserType()==ELEVE);
		//We take only 
		$res = $db->query('SELECT `id`, `idPersonInCharge`, `isPersonInChargeAStudent`, `concernedPeople`, `dataJson`, (concernedPeople LIKE "%-%") as canceled, (expiration < NOW() && expiration!=0) as expired FROM `Action_sous_confirmation` WHERE `idPersonInCharge`='.$id.' AND `isPersonInChargeAStudent`='.$isStudent) or die(mysqli_error($db));


		while (NULL !== ($row = $res->fetch_array())){
			$row['dataJson'] = json_decode($row['dataJson'], true);
			$row['concernedPeople'] = self::countAndOrder($row['concernedPeople']);
			$notices[] = array(
				'id' => $row['id'],
				'idPersonInCharge' => $row['idPersonInCharge'],
				'isPersonInChargeAStudent' => $row['isPersonInChargeAStudent'],
				'concernedPeople' => $row['concernedPeople'],
				'dataJson' => $row['dataJson'],
				'canceled' => $row['canceled'],
				'expired' => $row['expired']
			);
		}
		return $notices;
	}

	private static function countAndOrder($concernedPeople, $confirmOrNot = 'nothing'){
		$ids = array('list+'=>array(), 'list-'=>array(), 'list'=>array(), 'all'=>array());
		foreach (explode(',', $concernedPeople) as $current){
			if(!$current)continue;
			$prefix = ($current[0]=='+'||$current[0]=='-')?$current[0]:'';
			$value = ($current[0]=='+'||$current[0]=='-')?substr($current, 1):$current;
			if($confirmOrNot!='nothing')
				if(!$prefix && $current.''==getUserId().'')
					$prefix = $confirmOrNot?'+':'-';
			$ids['list'.$prefix][] = array(
				'isStudent' => $value[0]!='p',
				'value' => ($value[0]=='p')?substr($value, 1):$value
			);
			$ids['all'][] = $prefix.$value;
			$ids['all-values'][] = $value;
		}
		$ids['list?'] = $ids['list'];
		return $ids;
	}

	public static function delete($idToConfirm){
		global $db;
		$db->query('DELETE FROM Action_sous_confirmation WHERE id='.intval($idToConfirm).' AND idPersonInCharge='.intval(getUserId()).' AND isPersonInChargeAStudent='.intval(getUserType()==ELEVE));
	}

	public static function forceAction($idToConfirm){
		global $db;
		$res = $db->query('SELECT * FROM Action_sous_confirmation WHERE id='.intval($idToConfirm).' AND idPersonInCharge='.intval(getUserId()).' AND isPersonInChargeAStudent='.intval(getUserType()==ELEVE))->fetch_array();
		self::exec(json_decode($res['dataJson'], true));
		self::delete($idToConfirm);
	}

	public static function confirmOrDecline($idToConfirm, $confirmOrNot = true){
		global $db;
		$type = getUserType();
		if($type>ANONYME){
			$id = (($type==ELEVE)?'':'p').intval(getUserId());
			$res = $db->query('SELECT dataJson, concernedPeople FROM Action_sous_confirmation WHERE id='.intval($idToConfirm).' AND FIND_IN_SET("'.$id.'", concernedPeople)')->fetch_array();

			$ids = self::countAndOrder($res['concernedPeople'], $confirmOrNot);

			//Si tout le monde a confirmé (aucun refus et aucun indécis, donc)
			if(count($ids['list?'])==0 && count($ids['list-'])==0){
				$db->query('DELETE FROM Action_sous_confirmation WHERE id='.intval($idToConfirm)) or die(mysqli_error($db));
				self::exec(json_decode($res['dataJson'], true));
			}else
				$db->query('UPDATE Action_sous_confirmation SET concernedPeople="'.$db->real_escape_string(implode(',', $ids['all'])).'" WHERE id='.intval($idToConfirm)) or die(mysqli_error($db));
			return true;
		}
	}
	
}

// echo 'Result : '.(confirmOrDeclineLink(1, false)?'True':'False');

// askPeoples([2007, 2002, 2012, 2014], [1001, 1002, 1008], array("test" => 123));
?>