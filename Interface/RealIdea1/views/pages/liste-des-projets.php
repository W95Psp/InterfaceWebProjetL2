
<div class="page liste-des-projets">
	<h1>Liste des projets</h1>
	<div style="font-style: italic; width: 70%; margin: auto; text-align: center; margin-bottom: 8px;">Pour choisir établir votre liste de sujets préférés, glissez les sujet au devant de la liste.</div>
	<table class="projectList">
		<thead>
			<tr>
				<th></th>
				<th class="titleColumn"><img src="images/icons/title.png" class="icon"/><span>Intitulé</span></th>
				<th class="teacherColumn"><img src="images/icons/teacher.png" class="icon"/><span>Encadrant</span></th>
				<th class="langColumn"><img src="images/icons/languages.png" class="icon"/><span>Langages</span></th>
				<th class="studentsColumn"><img src="images/icons/students.png" class="icon"/><span>Affecté(s)</span></th>
			</tr>
		</thead>
		<tbody data-as-sortable="dragControlListeners" data-ng-model="projects" class="content">
			<tr data-ng-repeat="project in projects" data-as-sortable-item="data-as-sortable-item">
				<td>
					<div data-as-sortable-item-handle="data-as-sortable-item-handle">OO</div>
				</td>
				<td>{{project.title}}</td>
				<td>{{project.author}}</td>
				<td><img ng-repeat="lang in project.languages" src="images/languages/{{lang}}.svg" class="language"/></td>
				<td class="empty">Aucun étudiant pour le moment</td>
			</tr>
		</tbody>
	</table>
</div>