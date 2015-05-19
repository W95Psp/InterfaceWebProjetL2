<?php
	/*Creation du delai a ajouer au timer du groupe*/	
	/*Delai du prof a choisir avant implementation finale*/

	function choixVoeux($link){
		$delaiJ=1;
		$delaiH=1;
		$dateact=date("Y-m-d hh:mm:ss");
		$heureact=date("H:i");
		$delaiJFinal=date("Y-m-d H:i:s", strtotime("+".$delaiJ." day",strtotime($dateact)));
		
		$choixGroupe = $link->query('SELECT idProj, idG FROM ChoixGroupe WHERE idG='.getGroupId().' ORDER BY `index` LIMIT 6');

		$tab = array();

		while($v = $choixGroupe->fetch_array()){
			$v = $v['idProj'];
			$tab[] = $v;
			$rq="SELECT (number>=nbMini AND number<=nbMax) as dispo FROM Projet, (SELECT COUNT(*) as number FROM Etudiant as etu WHERE idGrEtu=".getGroupId().") as _ WHERE idProj=".$v;

			$nbdisp=$link->query($rq) or die("Erreur de requette nbMax(table Projet)");
			
			if(!intval($nbdisp->fetch_assoc()['dispo']))
				return false;
		}
		
		/* Remplissage de la table Candidature */
		$cptTemp=0;
		$cptGroupe=0.5;

		$time = new DateTime();
		$cpt = $time->getTimestamp() + ($delaiJ * (3600*24));

		/*On inclus les candidatures*/
		foreach($tab as $v){
			/*Decalage en fonction de l'ordre des choix*/
			$cpt=$cpt+$delaiH*3600;
			/*on met le delai*/
			/*concatenation de la date (date+heure)*/
	
			$sql="insert into Candidature (Date, idPro_C, IdGroupe_C) values('".date("Y-m-d H:i:s", $cpt)."', $v,".getGroupId().")";
			$execc=mysqli_query($link,$sql) or die('Erreur d\'insertion');
		}

		// $sql="update Groupe set EstBloque=1 where idG=".getGroupId();
		// $exec=mysqli_query($link,$sql) or die('Erreur de bloquage');

		return true;
	}
?>
