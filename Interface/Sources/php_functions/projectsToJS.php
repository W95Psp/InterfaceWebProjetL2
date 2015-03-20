<?php
function exportProjectsToJS($db){
    $str = "";
    $str.= '<script>';
    $str.= 'importStuff.projects = [';

    $res = $db->query('SELECT * FROM Projet') or die(mysqli_error($db));

    $start = true;
    while (NULL !== ($row = $res->fetch_array())) {
        $name = '"'.addslashes((string)$row['nomProj']).'"';
        $desc = '"'.addslashes((string)$row['descProj']).'"';
        $link = '"'.addslashes((string)$row['lien']).'"';
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