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
SELECT  proj.nomProj, proj.descProj, proj.allowedLanguages, proj.lien,
            proj.idProj, proj.nbMini, proj.nbMax, proj.nbInscri,
        ens.idEns, ens.nomEns, ens.prenomEns,
        GROUP_CONCAT(ens.idEns SEPARATOR "|") AS ens_id_list,
        GROUP_CONCAT(ens.nomEns SEPARATOR "|") AS ens_nom_list,
        GROUP_CONCAT(ens.prenomEns SEPARATOR "|") AS ens_prenom_list,
        GROUP_CONCAT(ens.prenomEns SEPARATOR "|") AS ens_prenom_list,
        (
            SELECT  count(*) 
            FROM    ChoixGroupe as chxGrp
            WHERE   proj.idProj = chxGrp.idProj
        ) as nbStudents
FROM Projet AS proj
LEFT JOIN Responsable AS resp
    ON proj.idProj=resp.ProjectL2_idPro
LEFT JOIN Enseignent AS ens
    ON resp.Enseignant_idEns=ens.idEns
LEFT JOIN ChoixGroupe AS chxGrp
    ON chxGrp.idProj=proj.idProj
GROUP BY proj.idProj
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
        foreach ($projects as $key => $project)
            if($project['idProj']==$id){
                array_unshift($projects, array_splice($projects, $key, 1)[0]);
                break;
            }
    }
    define('NUMBER', 0);
    define('STR', 1);
    $keys = array(
        'idProj'=> NUMBER,       'nomProj'=> STR,    'ens_id_list'=> STR,   'ens_nom_list'=> STR,
        'ens_prenom_list'=> STR, 'descProj'=> STR,   'lien'=> STR,          'nbMini'=> NUMBER,
        'nbMax'=> NUMBER,        'nbStudents'=> NUMBER
    );

    $count = 0;
    foreach ($projects as $key => $project) {
        if($count++!=0)
            $str.= ',';
        $str.= '{';
        foreach ($keys as $key => $type)
            if($type==NUMBER)
                $str.= $key.':'.intval($project[$key]).',';
            else
                $str.= $key.':"'.addslashes((string)$project[$key]).'",';
        $str.= '}';
    }
    return $str.'];</script>';
}
?>