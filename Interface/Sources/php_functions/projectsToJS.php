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

function exportProjectsToJS($db, $filter){
    $str = '<script>importStuff.projects = [';
    $sql = '
SELECT proj.nomProj, proj.descProj, proj.lien, proj.idProj, proj.nbMini, proj.nbMax, proj.nbInscri, ens.idEns, ens.nomEns, ens.prenomEns
FROM Projet AS proj
LEFT JOIN Responsable AS resp
    ON proj.idProj=resp.ProjectL2_idPro
LEFT JOIN Enseignent AS ens
    ON resp.Enseignant_idEns=ens.idEns
';
    if($filter=='encadrant')
        $sql .= ' WHERE ens.idEns='.getUserId();

    $res = $db->query($sql) or die(mysqli_error($db));
    
    $order = getOrderProjects($db);
    usort($order, function($a,$b){return $b[1]-$a[1];});

    $projects = array();
    while (NULL !== ($row = $res->fetch_array()))
        array_push($projects, $row);
    while(count($order)){
        $id = array_shift($order)[0];
        array_map(function($project){
            global $id;
            if($project['idProj']==$id)
                array_unshift($projects, array_splice($projects, $foundKey, 1)[0]);
        }, $projects);
    }

    $count = 0;
    foreach ($projects as $key => $project) {
        if($count++!=0)
            $str.= ',';
        $str.= '{idProj:'.intval($project['idProj']).',';
        $str.= 'nomProj:"'.addslashes((string)$project['nomProj']).'",';
        $str.= 'idEns:'.intval($project['idEns']).',';
        $str.= 'nomEns:"'.addslashes((string)$project['nomEns']).'",';
        $str.= 'prenomEns:"'.addslashes((string)$project['prenomEns']).'",';
        $str.= 'descProj:"'.addslashes((string)$project['descProj']).'",';
        $str.= 'lien:"'.addslashes((string)$project['lien']).'",';
        $str.= 'nbMini:'.intval($project['nbMini']).',';
        $str.= 'nbMax:'.intval($project['nbMax']).',';
        $str.= 'nbInscri:'.intval($project['nbInscri']).'}';
    }
    return $str.'];</script>';
}
?>