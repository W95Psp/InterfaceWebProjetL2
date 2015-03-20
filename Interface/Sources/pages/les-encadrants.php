
<div class="page les-encadrants">
	<h1>Liste des encadrants</h1><?php $res = $db->query('SELECT * FROM Enseignent') or die(mysqli_error($db));

while (NULL !== ($row = $res->fetch_array())){ ?><a href="&lt;?php echo $row[&quot;webEns&quot;]; ?&gt;" target="_blank" style="color: black; text-decoration: none; padding: 8px; display: inline-block; width: 40%;" class="encadrant">
		<div class="surname"><?php echo $row['nomEns']; ?>
		</div>
		<div class="name"><?php echo $row['prenomEns']; ?>
		</div></a><?php } ?>
</div>