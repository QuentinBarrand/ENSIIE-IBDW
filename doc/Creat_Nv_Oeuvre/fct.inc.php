<?php
/* Fonctions pour la creation d'evenement */

function formaterDate($date, $format = 'fr'){
	if($format=='en')
	{
		$dateRetour = '';
		$dateRetour .= substr($date, 6, 4).'-'.substr($date, 3, 2).'-'.substr($date, 0, 2);
		$dateRetour .= substr($date, 10);
	}
	else
	{
		$dateRetour = '';
		$dateRetour .= substr($date, 8, 2).'-'.substr($date, 5, 2).'-'.substr($date, 0, 4);
		$dateRetour .= substr($date, 10);
	}
	return $dateRetour;
}



/* Fonctions qui controle la validite */

function checkDateHeure($dateHeure){
	/* Validitי -> dateHeure */
	return (preg_match('#^((([0-2][0-9])|3[0-2])-0[1-9]|1[0-2])-20[0-9]{2} (([01][0-9])|(2[0-3])):([0-5][0-9]):([0-5][0-9])$#', $dateHeure) 
			&& formaterDate($dateHeure, 'en')>date('Y-m-d H:i:s'));
}

function checkNomLieu($nom, $lieu){
	/* Validitי -> Nom & Lieu */
	return (preg_match('#^[יטגûüאךפמןצװײ־ֿÛÜa-zA-z ]{4,45}$#', $nom) && 
			preg_match('#^[יטגûüאךפמןצװײ־ֿÛÜa-zA-z ]{4,45}$#', $lieu));
}

function checkIdEvt($idEvt, $bdd){
	/* Validitי -> idEvt */
	$sql1 = "SELECT * FROM typeevt WHERE idtype = :id";
	$requete = $bdd->prepare($sql1);
	$requete->execute(array(':id' => $idEvt));
	$evenement = $requete->fetchAll();
	if($requete->rowCount()==1){
		$requete->closeCursor();
		return $evenement[0]['typeEvt'];
	}
	else{
		$requete->closeCursor();
		return 0;
	}
}

function checkOeuvres($oeuvres, $bdd, $saison){
	/* Validitי -> oeuvres */
	$array = array();
	if($saison)	$lesOeuvres = getOeuvres($bdd);
	else  $lesOeuvres = getProgramme($bdd);
	
	while($oeuvre = $lesOeuvres->fetch()){
		if(in_array($oeuvre['idOeuvre'], $oeuvres)){
			$array[$oeuvre['idOeuvre']] = $oeuvre['titre'];
		}
	}
	$lesOeuvres->closeCursor();
	return $array;
}

/* Fonctions pour la creation d'oeuvres */

/* Fonctions qui controle la validite */
function checkTitreAuteur($titre, $auteur){
	/* Validitי -> Titre & Auteur */
	return (preg_match('#^[יטגûüאךפמןצװײ־ֿÛÜa-zA-z ]{4,45}$#', $titre) && 
			preg_match('#^[יטגûüאךפמןצװײ־ֿÛÜa-zA-z ]{4,45}$#', $auteur));
}

function checkPartitionStyle($partition, $style){
	/* Validitי -> Partition & Style */
	return (preg_match('#^[\/יטגûüאךפמןצװײ־ֿÛ\:Üa-zA-z ]{4,45}$#', $partition) && 
			preg_match('#^[יטגûüאךפמןצװײ־ֿÛÜa-zA-z ]{4,45}$#', $style));
}
function checkDuree($duree){
	/* Validitי -> Duree */
	return (preg_match('#^[0-9]{1,6}$#', $duree));
}

?>