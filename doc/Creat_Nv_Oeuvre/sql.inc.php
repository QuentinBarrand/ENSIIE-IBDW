<?php
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=ensiie-ibdw-2', 'root', '');
}
catch (Exception $e)
{
    echo "Erreur : " . $e->getMessage();
}
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// retourne l'id de la saison actuelle
function getSaison($bdd, $year = null){
	if($year == null || !preg_match('#^20[0-9]{2}$#', $year)){
		$year = date('Y');
	}
	$idSaison = null;
	
	$sql = "SELECT * 
			FROM Evenement
			NATURAL JOIN TypeEvt
			WHERE typeEvt LIKE 'Saison'
			AND EXTRACT(YEAR from heureDate) = :annee";
	$requeteSaison = $bdd->prepare($sql);
	$requeteSaison->execute(array(':annee' => $year));
	if($requeteSaison->rowCount()>0)
	{
		$id = $requeteSaison->fetchAll();
		$idSaison = $id[0]['idEvenement'];
	}
	$requeteSaison->closeCursor();
	return $idSaison;
}

// retourne un tableau de toutes les oeuvres
function getTypeEvenements($bdd){
	$sql = "SELECT * FROM typeevt";
	return $bdd->query($sql);
}

// retourne un tableau de toutes les oeuvres
function getOeuvres($bdd){
	$sql = "SELECT * FROM Oeuvre";
	return $bdd->query($sql);
}

// retourne un tableau des oeuvres du programme actuel
function getProgramme($bdd){
	$sql = "SELECT * 
			FROM est_au_programme 
			NATURAL JOIN Oeuvre 
			WHERE idEvenement = :idSaison
			ORDER BY titre";
	$lesOeuvres = $bdd->prepare($sql);
	$lesOeuvres->execute(array(':idSaison' => getSaison($bdd)));
	return $lesOeuvres;
}

// retourne l'id max de la table donnee en parametre
function maxIdEvenement($bdd){
	$sql = "SELECT MAX(idEvenement) as maxId 
			FROM Evenement";
	$requeteEvt = $bdd->query($sql);
	$idEvt = $requeteEvt->fetchAll();
	$requeteEvt->closeCursor();
	return $idEvt[0]['maxId'];
}

// retourne l'id max de la table donnee en parametre
function maxIdOeuvre($bdd){
	$sql = "SELECT MAX(idOeuvre) as maxId 
			FROM Oeuvre";
	$requeteOeuvre = $bdd->query($sql);
	$idOeuvre = $requeteOeuvre->fetchAll();
	$requeteOeuvre->closeCursor();
	return $idOeuvre[0]['maxId'];
}

// ajoute un evenement
function addEvenement($data, $bdd){
	$idEvt = maxIdEvenement($bdd)+1;
	$sql = "INSERT INTO evenement(idEvenement, idType, heureDate, lieu, nom) 
			VALUES (:idEvenement, :idType, :heureDate, :lieu, :nom);";
	$addEvt = $bdd->prepare($sql);
	$addEvt->execute(array(
				':idEvenement' => $idEvt, 
				':idType' => $data['idType'],
				':heureDate' => $data['heureDate'],
				':lieu' => $data['lieu'],
				':nom' => $data['nom']
			));
	$addEvt->closeCursor();
	return $idEvt;
}

// ajoute une oeuvre au programme d'un evenement
function addElementProgramme($idEvt, $idOeuvre, $bdd){
	$sql = "INSERT INTO est_au_programme(idOeuvre, idEvenement) 
			VALUES (:idOeuvre, :idEvenement)";
	$addElmtPgm = $bdd->prepare($sql);
	$addElmtPgm->execute(array(
					':idOeuvre' => $idOeuvre,
					':idEvenement' => $idEvt
				));
	$addElmtPgm->closeCursor();
}
// ajoute une oeuvre
function addOeuvre($data, $bdd){
	$idOeuvre = maxIdOeuvre($bdd)+1;
	$sql = "INSERT INTO oeuvre(idOeuvre, titre, auteur, partition1, duree, style) 
			VALUES (:idOeuvre, :titre, :auteur, :partition1, :duree, :style);";
	$addOeuv = $bdd->prepare($sql);
	$addOeuv->execute(array(
				':idOeuvre' => $idOeuvre, 
				':titre' => $data['titre'],
				':auteur' => $data['auteur'],
				':partition1' => $data['partition'],
				':duree' => $data['duree'],
				':style' => $data['style']
			));
	$addOeuv->closeCursor();
	return $idOeuvre;
}

?>