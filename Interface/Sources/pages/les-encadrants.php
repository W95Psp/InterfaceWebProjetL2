<?php
if (NULL !== @$urlParams[1]){
	if (@$urlParams[2]=='edit'){
		include("pages/edit-encadrant.php");
	} else {
		include("pages/details-encadrant.php");
	}
} else {
?>
<div class="page les-encadrants">
	<h1>Liste des encadrants</h1>
	<?php
	$res = $db->query('SELECT * FROM Enseignant') or die(mysqli_error($db));
	while (NULL !== ($row = $res->fetch_array())){
		echo "<a href='/?les-encadrants/".$row['idEns']."' style='color: black; text-decoration: none; padding: 8px; display: inline-block; width: 40%;' class='encadrant'>";
		echo "<div class='surname'>".$row['prenomEns']."</div>";
		echo "<div class='name'>".strtoupper($row['nomEns'])."</div>";
		echo "</a>";
	}
	?>
</div>
<?php
}
?>