<?php
	$params = $_SERVER['REQUEST_URI'];
	$params = (substr($params, 1, 9)=='index.php') ? substr($params, 11) : substr($params, 2);
	$parseParam = explode('/', $params);

	$page = $parseParam[0];

	tempFunction_toDelete_enableForceUserTypeStuff();

	$pagesByMode = array(
		ANONYME => array(
			'les-encadrants' => 'Les encadrants',
			'presentation' => 'Présentation',
			'liste-des-projets' => 'Liste des projets',
			'connexion' => 'Connexion'
		),
		ELEVE => array(
			'les-encadrants' => 'Les encadrants',
			'liste-des-projets' => 'Liste des projets',
			'groupe' => 'Groupe',
			'deconnexion' => 'Déconnexion',
			'presentation' => '####'
		),
		ENCADRANT => array(
			'les-encadrants' => 'Les encadrants',
			'mes-projets' => 'Mes projets',
			'liste-des-projets' => 'Liste des projets',
			'deconnexion' => 'Déconnexion',
			'presentation' => '####'
		),
		ADMIN => array(
			'admin' => 'Administration',
			'mes-projets' => 'Mes projets',
			'liste-des-projets' => 'Liste des projets',
			'deconnexion' => 'Déconnexion',
			'presentation' => '####'
		)
	);

	$pages = $pagesByMode[getUserType()];

	if(!isset($pages[$page]))
		$page = array_keys($pages)[0];

	function displayPages($part, $currentPage){
		global $pages;
		$count = 0;
		foreach ($pages as $link => $name) {
			if($count>=$part*2 && ($count)<$part*2+2){
				echo '<a class="item';
				if($link==$currentPage)
					echo ' active';
				echo '" href=\'?'.$link.'\'>'.$name.'</a>';
			}
			$count++;
		}
	}
?>
