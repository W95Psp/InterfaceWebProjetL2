
<div class="page liste-des-projets">
	<h1>Liste des projets</h1><?php if(isset($parseParam[1]) && $parseParam[1]=='drag-drop-enabled'){ ?><a href="/?liste-des-projets">[Se mettre en mode visiteur]</a><br/><br/><?php echo '<script>';
echo 'importStuff.projects = [';
$res = $db->query('SELECT * FROM Projet') or die(mysqli_error($db));
while (NULL !== ($row = $res->fetch_array())) {
    echo '{';
    echo 'idProj:'.$row['idProj'].',';
    echo 'nomProj:'.json_encode($row['nomProj']).',';
    echo 'descProj:'.json_encode($row['descProj']).',';
    echo 'lien:'.json_encode($row['lien']).',';
    echo 'nbMini:'.$row['nbMini'].',';
    echo 'nbMax:'.$row['nbMax'].',';
    echo 'nbInscri:'.$row['nbInscri'].'}';
    echo ',';
}
echo ']';
echo '</script>'; ?>
	<div style="font-style: italic; width: 70%; margin: auto; text-align: center; margin-bottom: 8px;">Pour choisir établir votre liste de sujets préférés, glissez les sujet au devant de la liste.</div>
	<div ng-init="nbChoice = 6;" class="projectList">
		<div class="head">
			<div class="row">
				<div class="titleColumn"><img src="images/icons/title.png" class="icon"/><span>Intitulé</span></div>
				<div class="teacherColumn"><img src="images/icons/teacher.png" class="icon"/><span>Encadrant</span></div>
				<div class="langColumn"><img src="images/icons/languages.png" class="icon"/><span>Langages</span></div>
				<div class="studentsColumn"><img src="images/icons/students.png" class="icon"/><span>Affecté(s)</span></div>
			</div>
		</div>
		<div data-as-sortable="dragControlListeners" data-ng-model="projects" class="body"><a href="/?liste-des-projets/{{project.idProj | fillZero}}-{{project | getLinkFromTitle}}" target="_blank" included="{{k&lt;nbChoice}}" data-ng-repeat="(k,project) in projects | filter:search" data-as-sortable-item="data-as-sortable-item" class="row">
				<div style="background-image: url(&quot;images/icons/order/{{k}}.png&quot;)" class="titleColumn"><span data-as-sortable-item-handle="data-as-sortable-item-handle" class="handle"><img src="images/grip.png"/></span><span>{{project.nomProj}}</span>
				</div>
				<div class="teacherColumn">{{project.author}}</div>
				<div class="langColumn"><img ng-repeat="lang in project.languages" src="images/languages/{{lang}}.svg" class="language"/></div>
				<div class="studentsColumn empty">Aucun étudiant pour le moment</div></a>
			<div ng-repeat="a in filtredProjects = (projects | filter:search)" class="span"></div>
			<div ng-show="filtredProjects.length==0" class="row noRowToDisplay">Aucun résultat.</div>
		</div>
	</div><?php }else{ ?><a href="/?liste-des-projets/drag-drop-enabled">[Se mettre en mode "Etudiant-qui-choisit-ses-sujets" (c'est la classe comme nom de mode !)]</a><br/><br/><?php echo '<script>';
echo 'importStuff.projects = [';
$res = $db->query('SELECT * FROM Projet') or die(mysqli_error($db));
while (NULL !== ($row = $res->fetch_array())) {
    echo '{';
    echo 'idProj:'.$row['idProj'].',';
    echo 'nomProj:'.json_encode($row['nomProj']).',';
    echo 'descProj:'.json_encode($row['descProj']).',';
    echo 'lien:'.json_encode($row['lien']).',';
    echo 'nbMini:'.$row['nbMini'].',';
    echo 'nbMax:'.$row['nbMax'].',';
    echo 'nbInscri:'.$row['nbInscri'].'}';
    echo ',';
}
echo ']';
echo '</script>'; ?>
	<div ng-init="nbChoice = 6;" class="projectList">
		<div class="head">
			<div class="row">
				<div class="titleColumn"><img src="images/icons/title.png" class="icon"/><span>Intitulé</span></div>
				<div class="teacherColumn"><img src="images/icons/teacher.png" class="icon"/><span>Encadrant</span></div>
				<div class="langColumn"><img src="images/icons/languages.png" class="icon"/><span>Langages</span></div>
				<div class="studentsColumn"><img src="images/icons/students.png" class="icon"/><span>Affecté(s)</span></div>
			</div>
			<div class="row search">
				<div class="titleColumn">
					<input ng-model="search.nomProj"/>
				</div>
				<div class="teacherColumn">
					<input ng-model="search.author"/>
				</div>
				<div class="langColumn">
					<input ng-model="search.languages"/>
				</div>
				<div class="studentsColumn">
					
				</div>
			</div>
		</div>
		<div data-as-sortable="dragControlListeners" data-ng-model="projects" class="body"><a href="/?liste-des-projets/{{project.idProj | fillZero}}-{{project | getLinkFromTitle}}" target="_blank" included="false" data-ng-repeat="(k,project) in projects | filter:search" data-as-sortable-item="data-as-sortable-item" class="row">
				<div style="background-image: url(&quot;images/icons/order/{{k}}.png&quot;)" class="titleColumn"><span>{{project.nomProj}}</span>
				</div>
				<div class="teacherColumn">{{project.author}}</div>
				<div class="langColumn"><img ng-repeat="lang in project.languages" src="images/languages/{{lang}}.svg" class="language"/></div>
				<div class="studentsColumn empty">Aucun étudiant pour le moment</div></a>
			<div ng-repeat="a in filtredProjects = (projects | filter:search)" class="span"></div>
			<div ng-show="filtredProjects.length==0" class="row noRowToDisplay">Aucun résultat.</div>
		</div>
	</div><?php } ?>
</div>