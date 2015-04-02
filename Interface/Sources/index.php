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
		<!--<start stuff to delete>-->
		<script>
			function loadThisUserProfile(v){	//To delete, when login (CAS) will be ok
				var href = window.location.href;
				console.log(href.match(/\/\@force\-user\-type\=[0-9]^/));
				if(href.match(/\/\@force\-user\-type\=[0-9]$/g)){
					href=href.substr(0, href.lastIndexOf('/?/@force'));
				}
				window.location = (href + "/?/@force-user-type=" + v).replace(/\/\/\?/g, '/?');
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
		<!--<end stuff to delete>-->
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
		</header><?php $wantToEndANotice = array(false, 0);
if(@$urlParams[0]=="delete-action-to-do"&&is_numeric($urlParams[1])){
	$wantToEndANotice[0] = true;
	$wantToEndANotice[1] = intval($urlParams[1]);
}
$notices = getNoticesForMe();
foreach($notices as $notice){
	if($wantToEndANotice[0] && intval($wantToEndANotice[1])==intval($notice['id'])){
		if($notice['idPersonInCharge'].''!=getUserId().'')
			break;
		$db->query('DELETE FROM Action_sous_confirmation WHERE id='.intval($notice['id']));
	}else{
		$listConcernedPeople = explode(',',$notice['concernedPeople']);
		$becauseOf = '';
		while($item = array_pop($listConcernedPeople)){
			if($item[0]=='-'){
				$id = substr($item, 1);
				$type = ELEVE;
				if($id[0]=='p'){
					$id = substr($id, 1);
					$type = ENCADRANT;
				}
				$id = intval($id);
				if($type==ELEVE)
					$res = $db->query('SELECT nomEtu as nom, prenomEtu as prenom, idEtu FROM Etudiant WHERE idEtu='.$id) or die(mysqli_error($db));
				else
					$res = $db->query('SELECT nomEns as nom, prenomEns as prenom, idEns FROM Enseignent WHERE idEns='.$id) or die(mysqli_error($db));
				while (NULL !== ($row = $res->fetch_array()))
					$becauseOf .= $row['prenom'].' '.$row['nom'].' ; ';
			}
		}
	} ?>
		<div class="notice"><b>Attention : </b><?php echo $becauseOf; ?>
			a refusé de<i><?php echo @$notice['dataJson']['explain']; ?>.</i><br/><br/><?php echo '<a href="/?delete-action-to-do/'.$notice['id'].'"><button>Je comprends</button></a>'; ?>
		</div><?php } ?><?php //Basic route :
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