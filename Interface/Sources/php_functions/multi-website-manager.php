<?php
	$versionWebsite = 'none';
	$versionWebsiteUrl = 'none';
	@array_walk(json_decode(file_get_contents('config/versions-website.json')),function($version, $url){
		global $versionWebsite;
		if($_SERVER['HTTP_HOST']==$url){
			$versionWebsiteUrl = $url;
			$versionWebsite = $version;
		}
	});

	if(preg_match_all("/^<redirect-to\:(.*)>$/", $versionWebsiteUrl, $r)){
		die('Erreur, la ressource à été déplacée. <a href="'.$r[1][0].'">Cliquez ici pour être redirigé</a>');
	}

	if($versionWebsite=='none')
		die("Erreur 404 [multi-website-manager error]");
?>