<?php
$idProject = -1;
if(count($urlParams)>2 && $urlParams[1]=='delete' && is_numeric($idProject = $urlParams[2])){
	if(count($urlParams)>3 && $urlParams[3]=='confirm'){
?>
	<style>
		#notice{
			background-color: #2ecc71;
			border: 1px dotted #DDD;
			padding: 14px;
			text-align: center;
			margin-right: 260px;
			margin-left: 240px;
			border: 2px solid #19A655;
		}
		#notice img{
			float: left;
		}
	</style>
	<script>
	setTimeout(function(){
		document.getElementById('notice').style.display = 'none';
	}, 3000);
	</script>

	<div id='notice'>
		<img src='images/icons/check.png'/><b>Suppression effectué !</b>
	</div>
<?php
	}else{
		$project = $db->query('SELECT * FROM Projet WHERE idProj='.$idProject)->fetch_array();
?>
		<style>
			#notice{
				background-color: #EEE;
				border: 1px dotted #DDD;
				padding: 14px;
				text-align: center;
				margin-right: 50px;
				margin-left: 50px;
			}
		</style>
		<div id='notice'>
			<div style='margin-bottom: 10px;'>
				Voulez vous supprimer le projet "<i><?= $project["nomProj"] ?></i>" ?<br/>
				<b>Cette opération est définitive.</b>
			</div>
			<a href='/?liste-des-projets/delete/<?= $idProject ?>/confirm'><button class='red'>Supprimer définitivement</button></a>
			<a href='/?liste-des-projets'><button class='green'>Annuler</button></a>
		</div>
<?php
	}
}
?>