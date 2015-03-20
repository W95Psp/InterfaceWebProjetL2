<?php
function exportProjectsToJS($db){
    $str = "";
    $str.= '<script>';
    $str.= 'importStuff.projects = [';

    $sql = '
SELECT proj.nomProj, proj.descProj, proj.lien, proj.idProj, proj.nbMini, proj.nbMax, proj.nbInscri, ens.idEns, ens.nomEns, ens.prenomEns
FROM Projet AS proj
LEFT JOIN Responsable AS resp
    ON proj.idProj=resp.ProjectL2_idPro
LEFT JOIN Enseignent AS ens
    ON resp.Enseignant_idEns=ens.idEns';

    $res = $db->query($sql) or die(mysqli_error($db));

    $start = true;

    while (NULL !== ($row = $res->fetch_array())) {
        $name = '"'.addslashes((string)$row['nomProj']).'"';
        $desc = '"'.addslashes((string)$row['descProj']).'"';
        $link = '"'.addslashes((string)$row['lien']).'"';
        $idEns = intval($row['idEns']);
        $prenomEns = '"'.addslashes((string)$row['prenomEns']).'"';
        $nomEns = '"'.addslashes((string)$row['nomEns']).'"';
        $idProj = intval($row['idProj']);
        $nbMini = intval($row['nbMini']);
        $nbMax = intval($row['nbMax']);
        $nbInscrits = intval($row['nbInscri']);

        if($start)
            $start = false;
        else
            $str.= ',';
        $str.= '{idProj:'.$idProj.',';
        $str.= 'nomProj:'.$name.',';
        $str.= 'idEns:'.$idEns.',';
        $str.= 'nomEns:'.$nomEns.',';
        $str.= 'prenomEns:'.$prenomEns.',';
        $str.= 'descProj:'.$desc.',';
        $str.= 'lien:'.$link.',';
        $str.= 'nbMini:'.$nbMini.',';
        $str.= 'nbMax:'.$nbMax.',';
        $str.= 'nbInscri:'.$nbInscrits.'}';
    }

    $str.= ']';
    $str.= '</script>';

    return $str;
}
?>