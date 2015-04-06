<?php if(!@$hadRunNodeAlready){
	system("node jade.js");
	$hadRunNodeAlready = true;
	include("index.php");
	exit();
}
include("php_functions/multi-website-manager.php");

//Connect to db (variable : $db)
include("php_functions/mysql.php");

//Connection related functions
include("php_functions/connect.php");

//Include mail stuff
include("php_functions/ask_module.php");

//Parse url to array ($parseParam, i.e. "/page1/cat2/blurp" => $parseParam = new Array("/page1", "cat2", "blurp"))
include("php_functions/page_manager.php");

//Function for project2js
require("php_functions/projectsToJS.php");
 ?>
<html ng-app="ProjetsL2">
	<head><?php echo '<title>Projets '.$versionWebsite.'</title>'; ?>
		<meta charset="UTF-8"/>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet" type="text/css"/>
		<script src="scripts/ng-sortable/ng-sortable.js"></script>
		<script src="scripts/jquery.js"></script>
		<link rel="stylesheet" type="text/css" href="scripts/ng-sortable/ng-sortable.min.css"/>
		<link rel="stylesheet" type="text/css" href="style/main.css"/><?php echo '<link rel="stylesheet" type="text/css" href="style/website-'.$versionWebsite.'.css"/>';
if(file_exists('style/'.$page.'.css'))
	echo '<link rel="stylesheet" type="text/css" href="style/'.$page.'.css"/>';
if($route=='details-project')
	echo '<link rel="stylesheet" type="text/css" href="style/details-project.css"/>';
 ?><!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body>
		<header>
			<div class="ban">
				<div class="content">
					<div class="left">
						<div class="imageBox"><?php if($versionWebsite=='L2'){ ?><img src="images/head/title-l2.png" class="title"/><?php }elseif($versionWebsite=='L3'){ ?><img src="images/head/title-l3.png" class="title"/><?php } ?>
						</div>
						<div class="menu"><?php displayPages(0, $page); ?>
						</div>
					</div>
					<div class="right">
						<div class="imageBox"><?php if($versionWebsite=='L2'){ ?><img src="images/head/description-l2.png" class="description"/><?php }elseif($versionWebsite=='L3'){ ?><img src="images/head/description-l3.png" class="description"/><?php } ?>
						</div>
						<div class="menu"><?php displayPages(1, $page); ?>
						</div>
					</div><img src="images/head/logo_UM2.png" class="um2"/>
				</div>
			</div>
		</header><?php if(getUserType()!=ANONYME){ ?>
		<div style="width: 740px; margin: auto; text-align: right; font-size: 11px; position: relative; top: -10px;"><i>Connecté en tant que <b><?php echo getUserName(); ?></b></i></div><?php }
 ?><?php //Basic route :
//  if url is like "/page/numeric-id-of-4-characters"
//  else

if($route=='!stop-here'){

}elseif($route=='details-project'){
	include('pages/details-project.php');
}else
	include('pages/'.$page.'.php');
 ?>
	</body>
</html><?php //Close db connection
$db->close(); ?>