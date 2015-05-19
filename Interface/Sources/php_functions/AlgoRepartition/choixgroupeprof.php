
<?php
include("connexion.php");
/*$prof=$_SESSION['idprof'];

$reqpro="Select * from Responsable where EnseignantidEns=$prof ";
$execreqpro=mysql_query($reqpro);

	
facultatif si le prof a deja selectionné le projet via interface graphique	*/

$affect="update Candidature set dateC=Datetime(NOW()) where idProj=$_SESSION['idProj'] and idGrC=$_SESSION['legroupecliqué']";
$execaffect=mysqli_query($link,$affect);

/* on crée un delai sur les autres groupe pour ne pas avoir de conflit sur celui choisit par le prof*/
$dateact=date("Y-m-d");
$heureact=date("H:i");
$delaiJFinal=date("Y-m-d", strtotime("+".1." day",strtotime($dateact)));

$decalageg="update Candidature set dateC=$delaiJFinal where idProj=$_SESSION['idProj'] and idGrC in (Select distinct idGrC from Candidature where idGrc <> $_SESSION['legroupecliqué'];) ";
$exedecalageg=mysql_query($link,$decalageg);

?>
