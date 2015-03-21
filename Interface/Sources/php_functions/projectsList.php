<?php
function DisplayListProjects($filter = 'none'){
	global $db;
	echo exportProjectsToJS($db, $filter);
	$draggable = getUserType()%2==1;
	if($draggable){ ?>
		<div style="font-style: italic; width: 70%; margin: auto; text-align: center; margin-bottom: 8px;">
			Pour choisir établir votre liste de sujets préférés, 
			glissez les sujets dans l'ordre de votre choix.
		</div>
	<?php } ?>
	<div ng-init="nbChoice = 6;" class="projectList">
		<div class="head">
			<div class="row">
				<div class="titleColumn"><img src="images/icons/title.png" class="icon"/><span>Intitulé</span></div>
				<div class="teacherColumn"><img src="images/icons/teacher.png" class="icon"/><span>Encadrant</span></div>
				<div class="langColumn"><img src="images/icons/languages.png" class="icon"/><span>Langages</span></div>
				<div class="studentsColumn"><img src="images/icons/students.png" class="icon"/><span>Affecté(s)</span></div>
			</div>
			<?php if(!$draggable){ ?>
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
			<?php } ?>
		</div>
		<?php
		if($draggable){
			echo '<div class="body" data-as-sortable="dragControlListeners" data-ng-model="projects">';
			echo '<div data-as-sortable-item data-ng-repeat="(k,project) in projects | filter:search">';
			echo '<div class="row" data-as-sortable-item-handle included="{{k<nbChoice}}">';
		}else{
			echo '<div class="body">';
			echo '<div ng-repeat="(k,project) in projects | filter:search">';
			echo '<div class="row">';
		}
		?>
		<?php
			echo '<div ';
			if($draggable){
				echo 'style="background-image: url(\'images/icons/order/{{k}}.png\')" ';}
				echo 'class="titleColumn" ng-init="';
				echo 'uType = '.getUserType().';';
				echo 'uId = '.getUserId();
				echo '">';
				if(getUserType()>=2){
					echo '<div class="tools" ng-if="uType+(project.idEns==uId)>=3" >';
			?>
						<img src="images/icons/edit.png"/>
						<img src="images/icons/delete.png"/>
			<?php 	echo '</div>';
				}
			?>
			<?php if($draggable){ ?>
				<span class="arrow-up" ng-click='putThisFirst(k);'>
					<img src="images/icons/arrow-up.png"/>
				</span>
			<?php } ?>
			<span>
			{{project.nomProj}}
			</span>
		</div>
		<div class="teacherColumn">
			{{project.author}}
		</div>
		<div class="langColumn">
			<img ng-repeat="lang in project.languages" src="images/languages/{{lang}}.svg" class="language"/>
		</div>
		<div class="studentsColumn empty">
			Aucun étudiant pour le moment
		</div>
		<?php echo '</div></div></div>'; ?>
		<div ng-repeat="a in filtredProjects = (projects | filter:search)" class="span"></div>
		<div ng-show="filtredProjects.length==0" class="row noRowToDisplay">Aucun résultat.</div>
	</div>
<?php
}
?>