<?php
	

	$ajaxFunctions['confirm-choices'] = function($agree){
		global $db;

		$group = getGroupFromGroupId(getGroupId());
		if($group['EtatCandidature']!=1)
			die("La candidature est déjà validée (ou en attente).");
		$db->query('UPDATE Groupe SET EtatCandidature=3 WHERE idG='.getGroupId()) or die(mysqli_error($db));
	};
?>