<?php
function dispInside(){
	echo "\n".'<div ';
	echo 'style="background-image: url(\'images/icons/order/{{k+(!highlight*100)}}.png\')" ';
	echo 'class="titleColumn" ng-init="';
	echo 'uType = '.getUserType().';';
	echo 'uId = '.getUserId();
	echo '">'."\n";
		echo '<div class="tools" ng-if="uType+(project.idEns==uId)>=3" >'."\n";
	?>
			<a href='/?liste-des-projets/{{project.idProj | fillZero}}-{{project | getLinkFromTitle}}/edit'><img src="images/icons/edit.png"/></a>
			<a href='/?liste-des-projets/delete/{{project.idProj}}'><img src="images/icons/delete.png"/></a>
		<?php  echo '</div>'."\n"; ?>
		<span ng-if='draggable' class="arrow-up" ng-click='putThisFirst(k);'>
			<img src="images/icons/arrow-up.png"/>
		</span>
		<span><a href='/?liste-des-projets/{{project.idProj | fillZero}}-{{project | getLinkFromTitle}}'>{{project.nomProj}}</a></span>
	</div>
	<div class="teacherColumn">{{project.author}}</div>
	<div class="langColumn">
		<img ng-repeat="lang in project.languages" style='cursor:default;' src="images/languages/{{lang}}.svg" title="{{lang | getDescription}}" class="language"/>
	</div>
	<div class="studentsColumn empty">Aucun étudiant pour le moment</div>
<?php }


function DisplayListProjects($filter = 'none'){
	// dispInside();
	// die("...");
	global $db;
	echo exportProjectsToJS($db, $filter);
	$draggable = getUserType()==ELEVE || getUserType()==ADMIN;
	$highlight = getUserType()==ELEVE;
	$textHowToStudent = (getUserType()==ELEVE)?'normal':'no';

	if(isset($_SESSION['groupId']) && $_SESSION['groupId'] && getUserType()==ELEVE){
		$group = getGroupFromGroupId($_SESSION['groupId']);
		if($group['EtatCandidature']==2){
			$draggable = false;
			$textHowToStudent = 'already';
		}
	}else if(getUserType()==ELEVE){
		echo $_SESSION['groupId'].'///';
		$draggable = false;
		$highlight = false;
		$textHowToStudent = 'no-group';
	}
	echo '<div ng-init="';
	echo 'draggable = '.($draggable?'true':'false');
	echo ';highlight = '.($highlight?'true':'false');
	echo ';textHowToStudent = \''.$textHowToStudent.'\'';
	echo '">';
	?>
	<div ng-if='textHowToStudent=="normal"' style="font-style: italic; width: 70%; margin: auto; text-align: center; margin-bottom: 8px;">
		Pour choisir établir votre liste de sujets préférés, 
		glissez les sujets dans l'ordre de votre choix.
	</div>
	<div ng-if='textHowToStudent=="already"' style="font-style: italic; width: 70%; margin: auto; text-align: center; margin-bottom: 8px;">
		Vous avez confirmé vos choix, il n'est donc plus possible
		de les modifier.
	</div>
	<div ng-if='textHowToStudent=="no-group"' style="font-style: italic; width: 70%; margin: auto; text-align: center; margin-bottom: 8px;">
		Pour formuler des choix, il faut <b>appartenir à un groupe</b>.
		Cliquez sur le lien "Groupe" dans le menu horizontal.
	</div>
	<div ng-init="nbChoice = 6;" class="projectList">
		<div class="head">
			<div class="row">
				<div class="titleColumn"><img src="images/icons/title.png" class="icon"/><span>Intitulé</span></div>
				<div class="teacherColumn"><img src="images/icons/teacher.png" class="icon"/><span>Encadrant</span></div>
				<div class="langColumn"><img src="images/icons/languages.png" class="icon"/><span>Langages</span></div>
				<div class="studentsColumn"><img src="images/icons/students.png" class="icon"/><span>Affecté(s)</span></div>
			</div>
			<div ng-if='!draggable' class="row search">
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
		<div ng-if="draggable" class="body" data-as-sortable="dragControlListeners" data-ng-model="projects">
			<div data-as-sortable-item data-ng-repeat="(k,project) in projects | filter:search">
				<div class="row" data-as-sortable-item-handle included="{{highlight && k<nbChoice}}">
					<?php dispInside(); ?>
				</div>
			</div>
		</div>
		<div ng-if="!draggable" class="body">
			<div ng-repeat="(k,project) in projects | filter:search">
				<div class="row" included="{{highlight && k<nbChoice}}">
					<?php dispInside(); ?>
				</div>
			</div>
		</div>
		<div ng-repeat="a in filtredProjects = (projects | filter:search)" class="span"></div>
		<div ng-show="filtredProjects.length==0" class="row noRowToDisplay">Aucun résultat.</div>
	</div>
<?php
echo '</div>';
}
?>