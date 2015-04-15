<?php if(@$urlParams[1]=='deleteNewEtudiants'){// A supprimer, c'est juste pour les tests
	$db->query('DELETE FROM Etudiant WHERE `telEtu` IS NULL;ALTER TABLE Etudiant AUTO_INCREMENT = 1;');
	die('DONE.');
}
if(count($urlParams)>2 && $urlParams[1]=='etudiants' && $urlParams[2]=='import' && isset($_POST['Data'])){
	$Data = json_decode($_POST['Data']);
	$str = "SET @promo=(SELECT * FROM LAST_PROMO_ID);INSERT INTO Etudiant (nomEtu, prenomEtu, emailEtu, idPromo) VALUES";
	$first = true;
	foreach($Data as $line){
		if(!$first)
			$str.=',';
		$str.='(';
		$str.='"'.$line[0].'",';
		$str.='"'.$line[1].'",';
		$str.='"'.$line[2].'"';
		$str.=',@promo)';
		$first = false;
	}
	$db->query($str.';'); ?>
<div style="text-align: center; padding: 40px;">Import effectué</div><?php }else{ ?>
<script src="/scripts/admin.js"></script>
<style>
	h1{
		display: inline-block;
		float: left;
		font-size: 24px;
		padding: 10px;
		padding-top: 0px;
		padding-bottom: 0px;
		color: #bdc3c7;
		transition: color 100ms linear;
		position: relative;
		top: 0px;
		cursor: default;
		margin: 0px;
	}
	h1[state='true']{
		color: black;
		transition: color 100ms linear;
	}
	h1:hover{
		top: -2px;
		transition: top 100ms ease-out;
	}
	.view{
		width: 760px;
		overflow: hidden;
	}
	.panels{
		position: relative;
		width: 4700px;
	}
	.panels[state="0"]{left: 0px;		transition: left 400ms ease-out;}
	.panels[state="1"]{left: -760px;	transition: left 400ms ease-out;}
	.panels[state="2"]{left: -1520px;	transition: left 400ms ease-out;}
	.panels[state="3"]{left: -2280px;	transition: left 400ms ease-out;}
	.panels[state="4"]{left: -3040px;	transition: left 400ms ease-out;}
	.panels[state="5"]{left: -3800px;	transition: left 400ms ease-out;}
	
	.panel{
		float: left;
		width: 760px;
	}
</style>
<script type="text/javascript" src="TinyEditor/packed.js"></script>
<link rel="stylesheet" href="TinyEditor/style.css"/><?php if(isset($parseParam[1], $parseParam[2], $_POST['content']) && $parseParam[1]=='presentation' && $parseParam[2]=='update'){
	$html = explode('<style>*{font-family: \'Open Sans\';}</style>', $_POST['content'], 2)[1];
	file_put_contents('pages/presentation-content.html', $html);
}
echo '<div class=\'page interface-admin\' ng-controller=\'admin\' ng-init=\'';
if(isset($parseParam[1]) && $parseParam[1]=='presentation')
	echo 'currentPage = 2;';
echo '\'>';
 ?>
<h1 ng-repeat="(k,page) in pages" state="{{currentPage==k}}" ng-click="$parent.currentPage=k">{{page}}</h1><br/>
<div class="view">
	<div state="{{currentPage}}" class="panels">
		<div class="panel">
			<h2>[Page à inclure ici] ~T1</h2>
		</div>
		<div class="panel"> 
			<h2>[Page à inclure ici] ~T2</h2>
		</div>
		<div class="panel"> 
			<h2>Page de présentation</h2>
			<form method="POST" action="/?admin/presentation/update">
				<textarea id="input" name="content" style="width:760px; height:400px; margin: auto;">
					<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300"/>
					<style>*{font-family: 'Open Sans';}</style><?php echo file_get_contents('pages/presentation-content.html'); ?>
				</textarea>
				<script>
					var editor = new TINY.editor.edit('editor',{
						id:'input',
						width:660,
						height:300,
						cssclass:'te',
						controlclass:'tecontrol',
						rowclass:'teheader',
						dividerclass:'tedivider',
						controls:['bold','italic','underline','strikethrough','|','subscript','superscript','|',
								  'orderedlist','unorderedlist','|','outdent','indent','|','leftalign',
								  'centeralign','rightalign','blockjustify','|','unformat','|','undo','redo','n',
								  'image','hr','link','unlink','|','cut','copy','paste','print'],
						footer:true,
						fonts:['Open Sans','Arial','Georgia','Trebuchet MS'],
						xhtml:true,
						cssfile:'style.css',
						bodyid:'editor',
						footerclass:'tefooter',
						resize:{cssclass:'resize'}
					});
				</script>
				<button onclick="editor.post();">Mettre à jour</button>
			</form>
		</div>
		<div class="panel"> 
			<h2>[Page à inclure ici] ~T4</h2>
		</div>
		<div class="panel">
			<h2>Etudiants</h2>
			<p>Chaque année, il est nécéssaire d'alimenter la base de donnée avec une liste des étudiants autorisés à se connecter. De cette façon, seuls les étudiants de L2/L3 qui ont une UE de projet peuvent utiliser le site.</p>
			<p>Importez ici un fichier csv de la liste des étuidants. Le fichier csv peut être sous n'importe quelle forme mais doit rensigner au moins : nom, prénom et email.</p>
			<div ng-show="etudiantsMode==0" class="part">
				<h3><img src="images/icons/upload.png" class="upImg"/><span>Uploadez votre document</span><a href="sample_data_to_delete.csv" style="font-size: 9px; padding-left: 10px;">[Télécharger un sample pour essayer]</a></h3>
				<div><b>Parcourir : </b>
					<input type="file" id="fichier_csv" name="fichier_csv" onchange="importData(this.files)" style="display: block; padding: 10px;"/>
				</div>
				<div><b>... Ou glissez le directement ici :</b>
					<div id="dragDropArea">Déposer votre CSV ici !</div>
				</div>
			</div>
			<div ng-show="etudiantsMode==1" style="width: 90% !important;" class="part">
				<h3><img src="images/icons/work.png" class="upImg"/><span>Choisir les données à importer</span>
					<button style="float: right;" ng-click="completed &amp;&amp; convertCSV()" class="{{(completed ? &quot;green&quot; : &quot;disabled&quot;)}}">Importer {{etudiantsData.length-firstLineHeader}} données</button>
				</h3>
				<div>
					<input type="checkbox" ng-model="firstLineHeader"/><span>La première ligne du fichier est une entête</span><br/><span>Séparateur : </span>
					<input type="text" ng-model="separator"/>
				</div>
				<div ng-if="twoSameInfo" class="errTwoSameInfo"><span class="title">Erreur : </span><span>Plusieurs colonnes ont le même rôle (</span><span ng-repeat="det in twoSameInfoDetails" class="detail">{{det}}</span><span>). Une seule colonne peut correspondre à une seule information.</span></div>
				<div style="width: 100%; overflow: auto;">
					<table class="preview">
						<tr ng-if="etudiantsData.length&gt;0" firstLine="true">
							<td ng-repeat="(k, columnName) in tmp = (etudiantsData[0] | parseCsv) track by $index"><span ng-show="!firstLineHeader">Col. n°{{k+1}}</span><span ng-show="firstLineHeader">{{columnName}}</span><br/>
								<select ng-model="columns[k]" ng-options="o as o for o in columnsOptions"></select>
							</td>
						</tr>
						<tr ng-repeat="(k, line) in etudiantsData | limitTo:15" ng-hide="firstLineHeader &amp;&amp; k==0">
							<td ng-repeat="(k, columnName) in tmp = (line | parseCsv) track by $index">{{columnName}}</td>
						</tr>
					</table>
				</div>
			</div>
			<div ng-show="etudiantsMode==2" style="width: 90% !important;" class="part">
				<h3><span>Résumé des données à importer</span><a href="/?admin/etudiants">
						<button style="float: right;" class="green">Annuler</button></a>
					<form style="display: inline;" method="POST" action="/?admin/etudiants/import">
						<input type="hidden" name="Data" value=""/>
						<button onclick="confirmAndSent(this)" style="float: right; margin-right: 18px;" class="red">Confirmer</button>
					</form>
				</h3>
				<p>Voilà les données que vous êtes sur le point d'importer. Vous pouvez parcourir le contenu à l'aide des filtres. Les filtres ne sont là que pour la visualisation, toutes les données seront au final importées.</p>
				<p>Seuls les premiers résultats sont affichés, pour ne pas surcharger votre navigateur.</p>
				<table class="sumup">
					<tr>
						<td ng-repeat="col in columnsOptions"><span ng-if="col==columnsOptions[0]">#</span><span ng-if="col!=columnsOptions[0]">{{col}}</span></td>
					</tr>
					<tr>
						<td ng-repeat="col in columnsOptions">
							<input ng-if="col!=columnsOptions[0]" ng-model="filterEtDatFin[col]" type="text"/>
						</td>
					</tr>
					<tr ng-repeat="(k,line) in etudiantsDataFinal | filter:filterEtDatFin | limitTo:20">
						<td ng-repeat="col in columnsOptions"><span ng-if="col==columnsOptions[0]">{{k}}</span><span ng-if="col!=columnsOptions[0]">{{line[col]}}</span></td>
					</tr>
				</table>
				<div style="text-align: center;">({{etudiantsDataFinal.length-20}} étudiants ne sont pas affichés)</div>
			</div>
		</div>
		<div class="panel">
			<h2>Promos</h2>
			<p>sqdsd</p>
		</div>
	</div>
</div><?php echo '</div>';
} ?>