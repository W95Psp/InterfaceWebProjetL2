
<div class="page"><?php if(@$urlParams[1]=='do' && @$_POST['user']!=NULL){
	$data = explode('|', $_POST['user']);
	setUser(intval($data[0]), 'none', ($data[1]==ELEVE)+1);
	echo '<script>window.location = "?";</script>';
} ?><b>Module de connection temporaire sans mot de passe</b><br/><br/>
	<form method="POST" action="/?connexion/do"><select name="user" onchange='this.parentNode.submit();'>
		<option value="!" selected="selected">Sélectionner un profil</option><?php $res = $db->query('
	SELECT idEtu as id, emailEtu as email, "student" as type FROM Etudiant
	UNION ALL
	SELECT idEns as id, emailEns as email, "teacher" as type FROM Enseignent
');
while($row = $res->fetch_array()){
	echo '<option value="'.$row['id'].'|'.$row['type'].'">'.$row['email'].'</option>';
} ?></select>
	</form>
</div>