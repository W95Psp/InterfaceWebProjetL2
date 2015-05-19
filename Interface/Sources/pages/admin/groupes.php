
<h2>Groupes</h2>
<div id="groups" ng-controller="groupes">
	<div ng-if="isLoading">Chargement en cours...</div>
	<div ng-if="!isLoading">
		<div ng-repeat="group in groups" class="group">
			<div class="header">
				<div></div>
			</div>
			<div ng-repeat="student in group.list" class="person">{{student.prenomEtu.substr(0, 1)}}. {{student.nomEtu}}</div>
		</div>
	</div>
</div>