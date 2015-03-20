<?php //Connect to db (variable : $db)
include("php_functions/mysql.php");

//Parse url to array ($parseParam, i.e. "/page1/cat2/blurp" => $parseParam = new Array("/page1", "cat2", "blurp"))
include("php_functions/page_manager.php");

//Connection related functions
include("php_functions/connect.php");

//Function for project2js
require("php_functions/projectsToJS.php");


//Compile jade files to php ones
if(gethostname()=="SurfaceLucas"){
	system('node jade.js');
}
 ?>
<html ng-app="ProjetsL2">
	<head>
		<title>Projets L2</title>
		<meta charset="UTF-8"/>
		<script src="http://cdn.jsdelivr.net/g/jquery@1,jquery.ui@1.10%28jquery.ui.core.min.js+jquery.ui.widget.min.js+jquery.ui.mouse.min.js+jquery.ui.sortable.min.js%29,angularjs@1.2,angular.ui-sortable"></script>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet" type="text/css"/>
		<script src="scripts/ng-sortable/ng-sortable.js"></script>
		<link rel="stylesheet" type="text/css" href="scripts/ng-sortable/ng-sortable.min.css"/>
		<script src="scripts/script.js"></script>
		<link rel="stylesheet" type="text/css" href="style/main.css"/><!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body ng-controller="main">
		<header>
			<div class="ban">
				<div class="content">
					<div class="left">
						<div class="imageBox"><img src="images/head/title.png" class="title"/></div>
						<div class="menu"><?php $A = ($page=='les-encadrants') ? 'active':'';
$B = ($page=='presentation') ? 'active':'';
$C = ($page=='liste-des-projets') ? 'active':'';
$D = ($page=='connexion') ? 'active':'';
echo '<a class="item '.$A.'" href=\'?les-encadrants\'>Les encadrants</a>';
echo '<a class="item '.$B.'" href=\'?presentation\'>Présentation</a>'; ?>
						</div>
					</div>
					<div class="right">
						<div class="imageBox"><img src="images/head/description.png" class="description"/></div>
						<div class="menu"><?php echo '<a class="item '.$C.'" href=\'?liste-des-projets\'>Liste des projets</a>';
echo '<a class="item '.$D.'" href=\'?connexion\'>Connexion</a>'; ?>
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