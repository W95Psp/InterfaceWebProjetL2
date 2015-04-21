<?php
	$ajaxFunctions['decision-with-choices'] = function($agree){
		global $db;

		$db->query('UPDATE Etudiant SET accordChoixGroupe='.$agree.' WHERE idEtu'.getUserId());
		$numberDisagreeOrDontKnow = $db->query('SELECT count(*) FROM V_EtudiantPromo WHERE `accordChoixGroupe`!=1 AND `idGrEtu`=5')->fetch_row()[0];
		if($numberDisagreeOrDontKnow==0){
			$db->query('DELETE FROM ChoixGroupe WHERE `index` > 6 AND idG='.getGroupId()) or die(mysqli_error($db));
			$db->query('UPDATE Groupe SET EtatCandidature=2 WHERE idG='.getGroupId()) or die(mysqli_error($db));
		}
	};
?>