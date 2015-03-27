<?php
	$versionWebsite = 'none';
	@array_walk(json_decode(file_get_contents('config/versions-website.json')),function($version, $url){
		global $versionWebsite;
		if(substr($_SERVER['HTTP_HOST'], 0, strlen($url))==$url)
			$versionWebsite = $version;
	});

	if(preg_match_all("/^<redirect-to\:(.*)>$/", $versionWebsite, $r)){
		die('Erreur, la ressource &agrave; &eacute;t&eacute; d&eacute;plac&eacute;e. <a href="'.$r[1][0].'">Cliquez ici pour &ecirc;tre redirig&eacute</a>');
	}

	if($versionWebsite=='none')
		die("Erreur 404 [multi-website-manager error]");
?>