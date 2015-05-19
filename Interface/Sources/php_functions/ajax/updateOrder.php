<?php
	$ajaxFunctions['update-order'] = function($group, $order){
		global $db;

		if($group['EtatCandidature']==2)
			die("La candidature est déjà validée, il est impossible de modifier l'ordre des choix.");
		
		$order = explode(';', $order);
		$db->query('DELETE FROM ChoixGroupe WHERE idG='.getGroupId()) or die(mysqli_error($db));;
		$values = '';
		$count = 0;

		foreach ($order as $idProj)
			$values .= ($count?',':'').'('.$idProj.', '.getGroupId().', '.(++$count).')';
		
		// var_dump($values);
		
		$db->query('INSERT INTO ChoixGroupe (idProj, idG, `index`) VALUES '.$values) or die(mysqli_error($db));
	};
?>