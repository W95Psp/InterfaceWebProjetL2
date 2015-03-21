<?php
function getOrderProjects($db){
    $r = array();
    if(getUserType()==ELEVE && $_SESSION['groupId']!=0){
        $group = getGroupFromGroupId($_SESSION['groupId']);
        if($group['EtatCandidature']==0){
            $res = $db->query('SELECT idProj FROM Projet');
            $values = '';
            $count = 0;
            while (NULL !== ($row = $res->fetch_array()))
                $values .= ($count?', ':'').'('.$row['idProj'].', '.$_SESSION['groupId'].', '.(++$count).')';
            $db->query('INSERT INTO ChoixGroupe (idProj, idG, `index`) VALUES '.$values);
            $db->query('UPDATE Groupe SET EtatCandidature=1 WHERE idG='.$_SESSION['groupId']);
        }
        $res = $db->query('SELECT idProj, `index` FROM ChoixGroupe WHERE idG = '.$_SESSION['groupId']) or die(mysqli_error($db));;
        while (NULL !== ($row = $res->fetch_array()))
            array_push($r, array($row['idProj'], $row['index']));
    }
    return $r;
}

function sortOrder($a, $b){
    return $b[1] - $a[1];
}

function exportProjectsToJS($db, $filter){
    $str = '<script>';
    $str.= 'importStuff.projects = [';
    $sql = '
SELECT proj.nomProj, proj.descProj, proj.lien, proj.idProj, proj.nbMini, proj.nbMax, proj.nbInscri, ens.idEns, ens.nomEns, ens.prenomEns
FROM Projet AS proj
LEFT JOIN Responsable AS resp
    ON proj.idProj=resp.ProjectL2_idPro
LEFT JOIN Enseignent AS ens
    ON resp.Enseignant_idEns=ens.idEns
';
    if($filter=='encadrant'){
        $sql .= ' WHERE ens.idEns='.getUserId();
    }

    $res = $db->query($sql) or die(mysqli_error($db));

    $start = true;

    $order = getOrderProjects($db);
    usort($order, "sortOrder");

    $projects = array();

    while (NULL !== ($row = $res->fetch_array()))
        array_push($projects, $row);

    while(count($order)){
        $id = array_shift($order)[0];
        $foundKey = -1;
        foreach ($projects as $key => $project) {
            if($project['idProj']==$id){
                $foundKey = $key;
                break;
            }
        }
        if($foundKey!=-1){
            $found = array_splice($projects, $foundKey, 1);
            array_unshift($projects, $found[0]);
        }
    }

    foreach ($projects as $key => $project) {
        $name = '"'.addslashes((string)$project['nomProj']).'"';
        $desc = '"'.addslashes((string)$project['descProj']).'"';
        $link = '"'.addslashes((string)$project['lien']).'"';
        $idEns = intval($project['idEns']);
        $prenomEns = '"'.addslashes((string)$project['prenomEns']).'"';
        $nomEns = '"'.addslashes((string)$project['nomEns']).'"';
        $idProj = intval($project['idProj']);
        $nbMini = intval($project['nbMini']);
        $nbMax = intval($project['nbMax']);
        $nbInscrits = intval($project['nbInscri']);

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

    $str.= '];';
    $str.= '</script>';

    return $str;
}
?>