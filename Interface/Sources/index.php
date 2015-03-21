<?php system("node jade.js");

//Connect to db (variable : $db)
include("php_functions/mysql.php");

//Connection related functions
include("php_functions/connect.php");

//Parse url to array ($parseParam, i.e. "/page1/cat2/blurp" => $parseParam = new Array("/page1", "cat2", "blurp"))
include("php_functions/page_manager.php");

//Function for project2js
require("php_functions/projectsToJS.php");
 ?>
<html ng-app="ProjetsL2">
	<head>
		<title>Projets L2</title>
		<meta charset="UTF-8"/>
		<script src="http://cdn.jsdelivr.net/g/jquery@1,jquery.ui@1.10%28jquery.ui.core.min.js+jquery.ui.widget.min.js+jquery.ui.mouse.min.js+jquery.ui.sortable.min.js%29,angularjs@1.2,angular.ui-sortable"></script>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet" type="text/css"/>
		<script src="scripts/ng-sortable/ng-sortable.js"></script>
		<link rel="stylesheet" type="text/css" href="scripts/ng-sortable/ng-sortable.min.css"/>
		<link rel="stylesheet" type="text/css" href="style/main.css"/><!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body>
		<script>
			function loadThisUserProfile(v){	//To delete, when login (CAS) will be ok
				var href = window.location.href;
				console.log(href.match(/\/\@force\-user\-type\=[0-9]^/));
				if(href.match(/\/\@force\-user\-type\=[0-9]$/g)){
					href=href.substr(0, href.lastIndexOf('/@force'));
				}
				window.location = href + "/@force-user-type=" + v;
			}
		</script>
		<div style="text-align: center; width: 90px;position: absolute; padding: 4px; top: 10px; left: 10px; font-size: 8px; border-radius: 4px; background-color: rgba(0,0,0,0.2); opacity: 0.8;">
			<div style=" padding-bottom: 3px;">Profil utilisateur</div>
			<select style="font-size: 8px;" onchange="loadThisUserProfile(this.value)"><option value=0 <?php if(getUserType()==ANONYME)
	echo ' selected'; ?>> Anonyme</option>
				<option value=1 <?php if(getUserType()==ELEVE)
	echo ' selected'; ?>> Etudiant</option>
				<option value=2 <?php if(getUserType()==ENCADRANT)
	echo ' selected'; ?>> Encadrant</option>
				<option value=3 <?php if(getUserType()==ADMIN)
	echo ' selected'; ?>> Administrateur</option>
			</select>
			<div style="font-size: 7px;">[Module temporaire pour essayer différents profils utilisateur]</div>
		</div>
		<header>
			<div class="ban">
				<div class="content">
					<div class="left">
						<div class="imageBox"><img src="images/head/title.png" class="title"/></div>
						<div class="menu"><?php displayPages(0, $page); ?>
						</div>
					</div>
					<div class="right">
						<div class="imageBox"><img src="images/head/description.png" class="description"/></div>
						<div class="menu"><?php displayPages(1, $page); ?>
						</div>
					</div><img src="images/head/logo_UM2.png" class="um2"/>
				</div>
			</div>
		</header><?php //Basic route :
//  if url is like "/page/numeric-id-of-4-characters"
//  else

if(isset($parseParam[0]) && isset($parseParam[1]) &&
	$parseParam[0]=="liste-des-projets" && is_numeric(substr($parseParam[1], 0, 4))
){
	$idProject = intval(substr($parseParam[1], 0, 4));
	include('pages/details-project.php');
}else
	include('pages/'.$page.'.php');
 ?>
	</body>
</html><?php //Close db connection
$db->close(); ?>