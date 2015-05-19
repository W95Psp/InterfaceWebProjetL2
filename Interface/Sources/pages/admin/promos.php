
<h2>Promos</h2><?php $res = $db->query('SELECT `idPromo`,`descPromo`, CONCAT(ens.nomEns, " ", ens.prenomEns) as responsable,`dateOpen`,`dateClose`, (NOW()>=dateOpen AND NOW()<dateClose) as active FROM `Promo` as promo LEFT JOIN Enseignant as ens ON ens.idEns=promo.idRespoPromo'); ?>
<table>
	<tr>
		<th>ID</th>
		<th>Description</th>
		<th>Responsable</th>
		<th>Ouverture</th>
		<th>Fermeture</th>
		<th>Active ?</th>
		<th>Autre</th>
	</tr><?php $maxDate = new DateTime('2000-01-01');//Old date
foreach($res as $item){
	$dateOpen = new DateTime($item['dateOpen']);
	$dateClose = new DateTime($item['dateClose']);
	echo "<tr>";
		echo "<td>".$item['idPromo']."</td>";
		echo "<td>".$item['descPromo']."</td>";
		echo "<td>".$item['responsable']."</td>";
		echo "<td>".$dateOpen->format('d-m-Y')."</td>";
		echo "<td>".$dateClose->format('d-m-Y')."</td>";
		echo "<td>".($item['active']?'Oui':'Non')."</td>";
		echo "<td><a href='/static-view/show.php?promoId=".$item['idPromo']."'>Voir</a></td>";
	echo "</tr>";
	echo "</tr>";
	if($dateClose > $maxDate)
		$maxDate = $dateClose;
}
 ?>
</table>
<h3>Ajouter une promo</h3><?php if($maxDate >= new DateTime() && false){ ?>
<div>Ajouter une promo n'est possible que lorsqu'aucune promotion n'est active.</div>
<div>Ce sera le cas après le <?php echo '<b>'.$maxDate->format('d-m-Y').'</b>.'; ?>
</div><?php }else{
$res = $db->query('SELECT CONCAT(nomEns, " ", prenomEns) as name, idEns as id FROM Enseignant'); ?>
<table>
	<tr>
		<td style="width: 160px;">Description :</td>
		<td>
			<textarea style="width: 100%; height: 80px;"></textarea>
		</td>
	</tr>
	<tr>
		<td>Responsable :</td>
		<td>
			<select><?php foreach($res as $item){
	echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
} ?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Ouverture :</td>
		<td>
			<input id="pickDateOpen" placeholder="Choisir une date"/>
		</td>
	</tr>
	<tr>
		<td>Fermeture :</td>
		<td>
			<input id="pickDateClose" placeholder="Choisir une date"/>
		</td>
	</tr>
</table><?php } ?>