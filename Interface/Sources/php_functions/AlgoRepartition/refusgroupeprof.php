<?php
include("connexion.php");
$dateact=date("Y-m-d");
$heureact=date("H:i");

/*on caulcul un delai pour que le groupe ne puisse jamais etre choisit ( c'est sale mais ça marche)*/
$delaiFinal=date("Y-m-d", strtotime("+".100." day",strtotime($dateact)));

$affect="update Candidature set dateC=$delaiFinal where idProj=$_SESSION['idProj'] and idGrC=$_SESSION['legroupecliqué']";
$execaffect=mysqli_query($link,$affect);

/*pop-up de demande de motif de refus*/
/*prevenir le groupe du refus avec le motif de refus du prof*/

/*on test si il reste des projets au groupe*/
$reste="Select count(*) from Candidature where idGrC=$_SESSION['legroupecliqué']";
$execreste=mysqli_query($link,$reste);

if($execreste==0){
/*envoit de mail pour indiquer au groupe qu'il n'as plus de candidature*/
$debloquage="update Groupe set EstBloque=false where idG=$_SESSION['legroupecliqué']";
$execdebloquage=mysqli_query($link,$debloquage);

/*le groupe pourra de nouveau candidater*/

}


?>
