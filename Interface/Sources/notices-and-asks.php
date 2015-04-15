<?php
	refreshGroupId();
	$asks = ConfirmModule::getAsks();
	foreach($asks as $ask){
		if(@$urlParams[0]=="accept-action" && intval($urlParams[1])==intval($ask['id'])){
			ConfirmModule::confirmOrDecline($ask['id'], true);
		}else if(@$urlParams[0]=="decline-action" && intval($urlParams[1])==intval($ask['id'])){
			ConfirmModule::confirmOrDecline($ask['id'], false);
		}else{
?>
		<div class="notice neutral">
<?php
			if($ask['dataJson']['action']=='joinGroup'){
				$res = $db->query('SELECT CONCAT(prenomEtu, " ", nomEtu) as nom FROM V_EtudiantPromo WHERE idGrEtu='.$ask['dataJson']['idGroup']);
				$listNames = array();
				while($row=$res->fetch_array())
					$listNames[] = $row['nom'];
?>
				Voulez vous rejoindre le groupe de <?php echo implode(', ', $listNames); ?> ? Cette opération est définitive.
<?php
			}else if($ask['dataJson']['action']=='validChoices'){
?>
				<?php echo str_replace("\n", "<br/>", $ask['dataJson']['message']); ?>
<?php
			}else{
				echo 'Pas de message prévu.';
			}
?>
			<br/>
			<a href='?accept-action/<?php echo $ask['id']; ?>'><button>Oui</button></a>
			<a href='?decline-action/<?php echo $ask['id']; ?>'><button>Non</button></a>
		</div>
<?php }
}
$notices = ConfirmModule::getNotices();
foreach($notices as $notice){
	if(@$urlParams[0]=="delete-action-to-do" && intval($urlParams[1])==intval($notice['id'])){
		ConfirmModule::delete($notice['id']);
	}else if(@$urlParams[0]=="force-action-to-do" && intval($urlParams[1])==intval($notice['id'])){
		ConfirmModule::forceAction($notice['id']);
	}else if($notice['expired']==true){ ?>
<div class="notice neutral"><b>Personne </b><span>n'a confirmé ni infirmé </span><i><?php echo ' "'.@$notice['dataJson']['explain'].'" '; ?></i><span>dans le temps imparti. </span><br/><br/><?php echo '<a href="/?force-action-to-do/'.$notice['id'].'"><button>Force la décision</button></a>'; ?>
</div><?php }else if($notice['canceled']==true){ ?>
<div class="notice red"><b>Attention : </b><?php echo implode(',', array_map('ConfirmModule::getUserByArray', $notice['concernedPeople']['list-'])); ?>
	<?php echo (count($notice['concernedPeople']['list-'])==1)?'a':'ont' ?> refusé de<i><?php echo ' '.@$notice['dataJson']['explain']; ?>.</i><br/><br/><?php echo '<a href="/?delete-action-to-do/'.$notice['id'].'"><button>Je comprends</button></a>'; ?>
</div><?php }
} ?>