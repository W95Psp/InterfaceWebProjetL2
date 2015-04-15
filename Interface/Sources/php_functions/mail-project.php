<?php
function mailValidation($idProj,$db){	
	$from = "From:projet@univ-montp2.fr\n";
	$from .= "MIME-version: 1.0\n";
	$from .= "Content-type: text/html; charset= iso-8859-1\n";
	$adresseMail="SELECT * FROM Enseignant WHERE isAdmin=1";
	$result = $db->query($adresseMail);
	$donnee = $result->fetch_array();
	$to = $donnee['emailEns'];
	$sujet = "Proposition d'un projet";
	$message = "<html> <body>";
	$message .= "<p>Bonjour,</p>";
	$message .= "<p>Un enseignant a soumis un sujet. Pour l'accepter ou le refuser, cliquez sur le lien ci-dessous : </p>";
	$lien = $_SERVER['SERVER_NAME']."/?liste-des-projets/".$idProj."/validate";
	$message .= "<p> <a href='".$lien."'>".$lien."</a> </p>";
	$message .= "<p>Cordialement,</p>";
	$message .= "<p>Site des projets</p>";
	$message .= "</body> </html>";
	mail($to, $sujet, $message, $from);
}

function projetAccepte($emailEns,$nomProj){	
	$from = "From:projet@univ-montp2.fr\n";
	$from .= "MIME-version: 1.0\n";
	$from .= "Content-type: text/html; charset= iso-8859-1\n";
	$to = $emailEns;
	$sujet = "Acceptation de votre projet par l'administrateur";
	$message = "<html> <body>";
	$message .= "<p>Bonjour,</p>";
	$message .= "<p>L'administrateur a validé votre projet <strong>".$nomProj."</strong>. </p>";
	$message .= "<p>Cordialement,</p>";
	$message .= "<p>Site des projets</p>";
	$message .= "</body> </html>";
	mail($to, $sujet, $message, $from);
}


function projetRefuse($emailEns,$nomProj){	
	$from = "From:projet@univ-montp2.fr\n";
	$from .= "MIME-version: 1.0\n";
	$from .= "Content-type: text/html; charset= iso-8859-1\n";
	$to = $emailEns;
	$sujet = "Refus de votre projet par l'administrateur";
	$message = "<html> <body>";
	$message .= "<p>Bonjour,</p>";
	$message .= "<p>L'administrateur a refusé votre projet <strong>".$nomProj."</strong>. </p>";
	$message .= "<p>Cordialement,</p>";
	$message .= "<p>Site des projets</p>";
	$message .= "</body> </html>";
	mail($to, $sujet, $message, $from);
}
?>