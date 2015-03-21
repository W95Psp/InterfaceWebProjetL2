<?php
	include("php_functions/mysql.php");
	include("php_functions/connect.php");

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
		$db->query('DELETE FROM ChoixGroupe WHERE `index` > 6 AND idG='.$_SESSION['groupId']) or die(mysqli_error($db));;
		$db->query('UPDATE Groupe SET EtatCandidature=2 WHERE idG='.$_SESSION['groupId']) or die(mysqli_error($db));;
	}else{
		echo 'invalid request';
	}
?>