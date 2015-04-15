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

//Get current state of the website
$isWebsiteOpen;
call_user_func(function(){
	global $db, $isWebsiteOpen;
	$lastPromo = $db->query('SELECT UNIX_TIMESTAMP(`dateOpen`) as dateOpen,UNIX_TIMESTAMP(`dateClose`) as dateClose FROM `Promo` ORDER BY idPromo DESC LIMIT 0,1')->fetch_array();
	$dStart  = intval($lastPromo["dateOpen"]);
	$dEnd = intval($lastPromo["dateClose"]);
	$isWebsiteOpen = (time()>$dStart && time()<$dEnd);
});

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
		<link rel="stylesheet" type="text/css" href="scripts/ng-sortable/ng-sortable.min.css"/><link rel="apple-touch-icon" sizes="57x57" href="favicon/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="favicon/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="favicon/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="favicon/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="favicon/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="favicon/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="favicon/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
		<link rel="manifest" href="favicon/manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="favicon/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">
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