
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