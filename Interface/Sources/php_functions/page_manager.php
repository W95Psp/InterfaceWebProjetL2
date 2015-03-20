<?php
	$params = $_SERVER['REQUEST_URI'];
	$params = (substr($params, 1, 9)=='index.php') ? substr($params, 11) : substr($params, 2);
	$parseParam = explode('/', $params);

	$page = $parseParam[0];

	$pages = array(
		'les-encadrants' => 'Les encadrants',
		'presentation' => 'Présentation',
		'liste-des-projets' => 'Liste des projets',
		'connexion' => 'Connexion'
	);

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