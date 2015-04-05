
<script src="scripts/groupe.js"></script><link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'><?php $ngInit = '';
$ngInit.= 'groupId='.intval(getGroupId()).';';
$ngInit.= 'myName="'.getUsername().'";';
$res = $db->query('SELECT idEtu as id, idG_E, CONCAT(`nomEtu`, " ", `prenomEtu`) as name FROM Etudiant WHERE idEtu!='.getUserId()) or die(mysqli_error($db));
$ngInit.= 'listStudents=[';
while($row = $res->fetch_array()){
	$ngInit.= '{';
		$ngInit.= 'id: '.$row['id'].',';
		$ngInit.= 'available: '.intval($row['idG_E']==0).',';
		$ngInit.= 'name: "'.$row['name'].'"';
	$ngInit.= '},';
}
$ngInit.= '];';
 ?><div class='page presentation' ng-controller='groupe' ng-init='<?php echo $ngInit; ?>'>
<div ng-show="!canShow">
	<h1>Chargement...</h1>
</div>
<div ng-show="canShow">
	<div ng-show="mode==&quot;?&quot; || mode==&quot;wait&quot;">
		<h1>Vous n'êtes affecté à aucun groupe pour l'instant.</h1>
		<p>Vous pouvez choisir de créer un groupe puis d'inviter des personnes à le rejoindre. Mettez vous d'accord avec vos amis à propos de qui crée le groupe et qui invite les autres.</p>
		<button ng-show="mode==&quot;?&quot;" ng-click="mode=&quot;wait&quot;">J'attends que l'on me propose</button>
		<button ng-show="mode==&quot;?&quot;" ng-click="mode=&quot;compose&quot;">Je crée mon groupe</button>
		<p ng-show="mode==&quot;wait&quot;">Bien, si quelqu'un vous ajoute à un groupe, nous vous en informerons par e-mail (<a href='mailto:<?php echo getUserMail(); ?>'><?php echo getUserMail(); ?></a>) et sur cette page. Si vous décidez finalement de créer votre propre groupe, pas de problème, rechargez simplement la page.</p>
	</div>
	<div ng-show="mode==&quot;compose&quot;">
		<h1 class="compose">Composer mon groupe</h1>
		<div style="margin: auto; display: block;" class="case">{{myName}}</div>
		<div class="plus">et inviter les personnes suivantes :</div>
		<div id="cases">
			<div class="caseParent">
				<div ng-repeat="(k,place) in GroupComposedBy track by $index" greenAround="{{place!=-1 &amp;&amp; !fixed}}" class="case"><span ng-show="place!=-1" class="done">{{place | getUsernameById:this}}<img ng-show="!fixed" src="images/icons/cancel.png" ng-click="recoverToList(place);GroupComposedBy[k]=-1;"/></span>
					<input ng-show="place==-1" ng-model="test"/>
					<div ng-show="place==-1" forceThat="{{test.length&gt;=1}}" class="autoCompletion">
						<div ng-show="test.length">
							<div class="title">Résultat(s) :</div>
							<div ng-click="student.available &amp;&amp; deleteFromList(student.id) &amp;&amp; ($parent.GroupComposedBy[k] = student.id)" ng-repeat="student in results = (listStudents | filter:{name: test} | limitTo:6)" selectable="{{student.available?&quot;true&quot;:&quot;took&quot;}}" class="item"><span>{{student.name}} </span><span ng-if="!student.available">[Déjà dans un groupe]</span></div>
							<div ng-show="results.length==0" class="item"><br/><i style="font-size: 13px;">Aucun étudiant dont le nom ou prénom ressemblant à "{{test}}" n'a été trouvé !</i><br/><br/>
								<button>Signaler</button>
							</div>
						</div>
						<div ng-show="!test.length">
							<div class="title">Tapez quelque chose.</div>
						</div>
					</div>
					<div ng-show="fixed" class="state"><span ng-show="GroupComposedByState[k]==0" class="wait">L'invitation a été envoyée, pas de réponse pour l'instant.</span><span ng-show="GroupComposedByState[k]==1" class="confirmed">Validé !</span><span ng-show="GroupComposedByState[k]==2" class="declined">Décliné !</span>
						<div><a href="#" style="text-decoration: none; font-size: 12px; color: #2980b9;" ng-click="$parent.fixed=false;recoverToList(place);GroupComposedBy[k]=-1;">Choisir une autre personne</a></div>
					</div>
				</div>
			</div><br/><br/><br/><br/>
			<div ng-show="!fixed">
				<button ng-show="countFilled()==3" ng-click="ask();fixed=true;">Envoyer les invitations !</button>
				<button ng-show="countFilled()!=3 &amp;&amp; countFilled()!=0" class="disabled">Il reste {{3-countFilled()}} personnes à choisir.</button>
				<button ng-show="countFilled()==0" class="disabled">Choisissez 3 personnes.</button>
				<button ng-click="mode=&quot;?&quot;" class="red">Annuler</button>
			</div><br/><br/><br/><br/><br/><br/><br/>
			<button ng-click="tempFun_to_delete__()">[Pour tester :] réintialiser idG de tout le monde</button><br/><br/><br/><br/>
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
</div></div>