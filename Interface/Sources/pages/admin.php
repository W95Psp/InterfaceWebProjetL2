
<script src="/scripts/admin.js"></script>
<style>
	h1{
		display: inline-block;
		float: left;
		font-size: 24px;
		padding: 10px;
		color: #bdc3c7;
		transition: color 100ms linear;
		position: relative;
		top: 0px;
		cursor: default;
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
		width: 4000px;
	}
	.panels[state="0"]{left: 0px;		transition: left 400ms ease-out;}
	.panels[state="1"]{left: -760px;	transition: left 400ms ease-out;}
	.panels[state="2"]{left: -1520px;	transition: left 400ms ease-out;}
	.panels[state="3"]{left: -2280px;	transition: left 400ms ease-out;}
	
	.panel{
		float: left;
		width: 760px;
		height: 500px;
	}
</style>
<div ng-controller="admin" ng-init="currentPage = 0; pages = [&quot;Encadrants&quot;, &quot;Groupes&quot;, &quot;Présentation&quot;, &quot;Modalité notes&quot;];" class="page interface-admin">
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
				<h2>[Page à inclure ici] ~T3</h2>
			</div>
			<div class="panel"> 
				<h2>[Page à inclure ici] ~T4</h2>
			</div>
		</div>
	</div>
</div>