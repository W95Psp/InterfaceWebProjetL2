
<style>
	.details-project img{
		width: 20px;
	}
</style>
<div ng-init="project = 0" class="page details-project"><?php echo '<span ng-init="project=projects[';
echo $idProject;
echo ']"></span>'; ?>
	<h1>{{project.title}}</h1>
	<div class="author">{{project.author}}</div>
	<h2 class="h2Lang">Langages authorisés</h2>
	<div class="languages"><a ng-repeat="lang in project.languages" target="_blank" href="http://fr.wikipedia.org/wiki/{{lang}}" class="lang"><img src="images/languages/{{lang}}.svg"/><span>{{lang}}</span></a></div>
	<h2 class="h2Desc">Description</h2>Lorem ipsum Magna amet veniam est labore ut aliqua nostrud eu culpa aliqua voluptate in ut quis esse mollit Ut pariatur fugiat.<br/><br/>
	<h2 class="h2Complete">Descriptif complet</h2><a href="/?liste-des-projets/{{project.id | fillZero}}-{{project | getLinkFromTitle}}/download-pdf">Télécharger en PDF</a>
	<h2 class="h2Contact">Contact</h2><a href="mailto:example@example.ext">Envoyer un e-mail</a>
</div>