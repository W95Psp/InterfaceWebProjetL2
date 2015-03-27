<?php
	//On applique une regex sur $_SERVER['REQUEST_URI']
	//On ne prend pas en compte tout ce qui précède le premier "?" rencontré
	//Puis on transforme la chaine en tableau en la découpant à chaque slash
	preg_match_all("/^.*\?|\/?([^\/]*)|/", $_SERVER['REQUEST_URI'], $parsedParam);
	array_shift($parsedParam[1]);	//Le premier élément n'est pas utile
	while(count($parsedParam[1]) && $parsedParam[1][count($parsedParam[1])-1]=="")
		array_pop($parsedParam[1]);
	//Définition d'un tableau de paramètres
	$urlParams = $parsedParam[1];
	//Sélection de la page courante
	$page = isset($urlParams[0]) ? $urlParams[0] : 'not-defined';
	//A supprimer :
	tempFunction_toDelete_enableForceUserTypeStuff();//Pour le truc en haut à gauche ;)

	//Chargement des configurations des pages / menu
	$pagesData = array(
		"allowed" => json_decode(file_get_contents("config/allowed-pages.json"), true),
		"menus" => array(
				ANONYME => json_decode(file_get_contents("config/anonyme-menu.json"), true),
				ELEVE => json_decode(file_get_contents("config/eleve-menu.json"), true),
				ENCADRANT => json_decode(file_get_contents("config/encadrant-menu.json"), true),
				ADMIN => json_decode(file_get_contents("config/admin-menu.json"), true)
			)
	);
	//Sélection du "bon" menu
	$menu = $pagesData["menus"][getUserType()];
	//Vérifie que la page est autorisée, si ce n'est pas le cas, $page = default one 
	if(!in_array($page, $pagesData["allowed"]))
		$page = array_keys($menu)[0];	//On prend la première page déclarée dans le menu
	function displayPages($part){
		global $menu, $page;
		$count = 0;
		foreach ($menu as $link => $name){
			if($count>=$part*2 && ($count)<$part*2+2)
				echo '<a class="item'.(($link==$page)?' active':'').'" href=\'?'.$link.'\'>'.$name.'</a>';
			$count++;
		}
	}

	if(isset($urlParams[0]) && isset($urlParams[1]) && $urlParams[0]=="liste-des-projets" && is_numeric(substr($urlParams[1], 0, 4)))
		$route = 'details-project';
	else
		$route = 'normal';
?>