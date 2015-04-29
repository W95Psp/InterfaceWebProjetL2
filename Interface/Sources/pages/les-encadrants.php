
<div class="page les-encadrants">
	<h1>Liste des encadrants</h1><?php $res = $db->query('SELECT * FROM Enseignant') or die(mysqli_error($db));

while (NULL !== ($row = $res->fetch_array())){ ?><a href="/?les-encadrants/&lt;?php echo $row[&quot;idEns&quot;]; ?&gt;" style="color: black; text-decoration: none; padding: 8px; display: inline-block; width: 40%;" class="encadrant">
		<div class="surname"><?php echo $row['prenomEns']; ?>
		</div>
		<div class="name"><?php echo strtoupper($row['nomEns']); ?>
		</div></a><?php } ?>
</div>