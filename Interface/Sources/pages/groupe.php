
<script src="scripts/groupe.js"></script>
<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>

<div class='page presentation' ng-controller='groupe'>
	<div ng-show="!syncFinished">
		<h1>Chargement...</h1>
	</div>
	<div ng-show="syncFinished">
		<div ng-show="groupId<0">
			<h1>Quelqu'un vous a invité !</h1>
			<p>
				Voulez-vous rejoindre le groupe de :
				<ul>
					<li ng-repeat='person in group track by $index' ng-show='person.id'>
						{{person.name}}
						<i style='color: gray;' ng-if='!person.agree'>(Il/elle n'a pas encore accepté)</i>
					</li>
				</ul>
				<button class='green' ng-click='acceptInvitation()'>Accepter définitivement</button>
				<button class='red' ng-click='declineInvitation()'>Décliner</button>
			</p>
		</div>
		<div ng-show="!groupId", ng-init='subMode=false;'>
			<h1>Vous n'êtes affecté à aucun groupe pour l'instant.</h1>
			<p>Vous pouvez choisir de créer un groupe puis d'inviter des personnes à le rejoindre. Mettez vous d'accord avec vos amis à propos de qui crée le groupe et qui invite les autres.</p>
			<div ng-show='!subMode'>
				<button ng-click="subMode=true;">
					J'attends que l'on me propose
				</button>
				<button ng-click="createGroup();">
					Créer mon groupe
				</button>
			</div>
			<div ng-show='subMode'>
				<p ng-show="mode==&quot;wait&quot;">Bien, si quelqu'un vous ajoute à un groupe, nous vous en informerons par e-mail (<a href='mailto:<?php echo getUserMail(); ?>'><?php echo getUserMail(); ?></a>). Si vous décidez finalement de créer votre propre groupe, pas de problème, rechargez simplement la page.</p>
			</div>
		</div>
		<div ng-show="groupId>0">
			<h1 class="compose">
				Composer mon groupe
			</h1>
			<div style="margin: auto; display: block;" class="case">
				{{myName}}
			</div>
			<div class="plus">
				et inviter les personnes suivantes :
			</div>
			<div id="cases">
				<div class="caseParent">
					<div ng-repeat="(k,person) in group track by $index" class="case">
						<span ng-show="person.id" class="done">
							{{person.name}}
						</span>
						<input ng-show="!person.id && !person.temp" ng-model="fp"/>
						<div ng-show="!person.id && !person.temp" forceThat="{{fp.length>=1}}" class="autoCompletion">
							<div ng-show="fp.length">
								<div class="title">
									Résultat(s) :
								</div>
								<div ng-click="chooseThisStudent(student, k);" ng-repeat="student in results = (listStudents | filter:{name: fp} | limitTo:6) track by $index" selectable="{{student.available?'true':'took'}}" class="item">
									<span>
										{{student.name}}
									</span>
									<span ng-if="!student.available">
										[Déjà dans un groupe]
									</span>
								</div>
								<div ng-show="results.length==0" class="item">
									<br/>
									<i style="font-size: 13px;">
										Aucun étudiant dont le nom ou prénom ressemblant à "{{fp}}" n'a été trouvé !
									</i>
									<br/>
									<br/>
									<button>
										Signaler
									</button>
								</div>
							</div>
							<div ng-show="!fp.length">
								<div class="title">Tapez quelque chose.</div>
							</div>
						</div>

						<div ng-show="person.id && person.temp" class="wait state">
							Voulez vous valider ce choix ?
							<br/>
							<button ng-click="addToGroup(person.id)" class="red">
								Oui
							</button>
							<button ng-click="retirerLeChoix(person)" class="green">
								Non
							</button>
						</div>

						<div ng-show="person.id && !person.temp" class="state">
							<span ng-show="!person.agree" class="wait">
								L'invitation a été envoyée, pas de réponse pour l'instant.
							</span>
							<span ng-show="person.agree" class="confirmed">
								Validé !
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--Affichage des erreurs (ne devrait jamais se produire)-->
	<div id="disp-error" ng-if="errorSpotted[0]">
		<div class="content">
			<div class="title">Erreur !
				<button onclick="this.parentNode.parentNode.innerHTML = SC.errorSpotted[1];" class="red">Afficher en HTML (peut-être dangeureux!)</button>
			</div><span>{{errorSpotted[1]}}</span>
		</div>
	</div>
</div>