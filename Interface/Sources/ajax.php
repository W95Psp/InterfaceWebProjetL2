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
	}else{
		echo 'invalid request';
	}
?>