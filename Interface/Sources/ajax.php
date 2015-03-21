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
		$order = explode(';', $_POST['order']);
		$db->query('DELETE FROM ChoixGroupe WHERE idG='.$_SESSION['groupId']) or die(mysqli_error($db));;
		$values = '';
		$count = 0;
		foreach ($order as $idProj)
			$values .= ($count?',':'').'('.$idProj.', '.$_SESSION['groupId'].', '.(++$count).')';
		
		$db->query('INSERT INTO ChoixGroupe (idProj, idG, `index`) VALUES '.$values) or die(mysqli_error($db));;
	}
?>