<?php
	include('php_functions/AlgoRepartition/ChoixVoeux.php');
	
	$ajaxFunctions['confirm-choices'] = function(){
		global $db;
		$group = getGroupFromGroupId(getGroupId());
		if($group['EtatCandidature']==2)
			die("La candidature est déjà validée (ou en attente).");
		if(choixVoeux($db)){
			echo 'true';
			$db->query('UPDATE Groupe SET EtatCandidature=3 WHERE idG='.getGroupId()) or die(mysqli_error($db));
		}else
			echo 'false';

	};
?>