<?php
	$ajaxFunctions['opinion-needed-choices'] = function(){
		global $db;

		if(getGroupId()>0 && $db->query('SELECT (EtatCandidature=3) as need FROM Groupe WHERE idG='.getGroupId())->fetch_array()['need'] && $db->query('SELECT (accordChoixGroupe=0) as need FROM V_EtudiantPromo WHERE idEtu='.getUserId())->fetch_array()['need'])
			echo 'true';
		else
			echo 'false';
	};
?>