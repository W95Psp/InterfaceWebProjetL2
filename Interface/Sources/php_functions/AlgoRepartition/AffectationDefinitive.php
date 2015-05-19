<?php
    
    include("../mysql.php");
    include("../connect.php");

    $sql="select * from Candidature where Date < NOW()";
    $exec=mysqli_query($db,$sql) or die('Erreur de selection'.$sql);
    /*on recupere les candidatures a valider*/
    while($ligne=mysqli_fetch_assoc($exec)){
        $sqlbloque="SELECT * FROM Groupe as g
                    LEFT JOIN Candidature as c ON c.idGroupe_C=g.idG
                    WHERE c.idPro_C=".$ligne['idPro_C'];
       $execbloque=mysqli_query($db,$sqlbloque) or die('Hey'.mysqli_error($db));
    
        $nbresult=0;

        while($val=mysqli_fetch_assoc($execbloque) and $nbresult==0){
            $nbresult=1;
            // $ajoutCvalide="insert into CandidatureValide values(".$val['idC'].")";
            $ajoutCvalide="UPDATE Groupe SET idProjetDefinitif=".$val['idPro_C']." WHERE idG=".$val['idGroupe_C'];
            $db->query($ajoutCvalide) or die('Erreur ajout. '.ysqli_error($db));

            $db->query("DELETE FROM Candidature WHERE idGroupe_C=".$val['idGroupe_C']);
            
            $suppautre="select idPro_C, idGroupe_C from Candidature where idPro_C=".$val['idPro_C'];/* pk pas select */
            $execsuppautre=mysqli_query($db,$suppautre);
    
            while($lignesupp=mysqli_fetch_assoc($execsuppautre)){
                $reqdel="Delete from Candidature and idPro_C=".$lignesupp['idPro_C'];//suppressions des autre personnes du groupe postulant sur ce projet
                $execreqdel=mysqli_query($db,$reqdel);

                $plusdevoeux="SELECT COUNT(*) as nb FROM Candidature WHERE idGroupe_C=".$lignesupp['idPro_C'];
                $nbrestant = intval($execplusdevoeux->fetch_row()[0]);

                if($nbrestant==0 && $val['idGroupe_C']!=$lignesupp['idGroupe_C']){
                    $debloquage="update Groupe set EtatCandidature=1 where idG=".$lignesupp['idGroupe_C'];
                    $execdebloquage=mysqli_query($db,$debloquage); 
                        /*envoyer un mail signalant que la personne n’as plsu de voeux*/
                }
            }
        }
   }



//      if($val['taillegroupe']=2){ /*pas encore implémenté*/
//              $tailleG="select nbEtud from Projet where idProj=".$val['idProj'];
//              $execT=mysqli_query($db,$tailleG);
//              $dejaAffecte=mysqli_result($execT,0);
//              if($dejaAffecte <2){
//                  $ajoutTailleProj="update Projet set nbEtudAffecte=2";/*pas encore implémenté*/
//                  $execajoutTailleProj=mysqli_query($db,$ajoutTailleProj);
            // }
//      }
//      else{
            
    // }
?>