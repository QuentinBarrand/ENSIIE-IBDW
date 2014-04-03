<?php

// $request est l'objet qui contient les attributs de la requête

// Table choriste
$nom = $request->post('nom');
$prenom  = $request->post('prenom');
$idVoix = $request->post('idVoix');
$ville = $request->post('ville');
$telephone = $request->post('telephone');
$login = $request->post('login');

// Table utilisateur
$motdepasse = $request->post('motdepasse');
// idInscription smallint,

// Table inscription



$data = array();

try {
	$db = new PDO('pgsql:host=localhost;dbname=nom_db', 'nom_utilisateur', 'mot_de_passe');
}
catch(PDOException $e) {
	$db = null;
	$data['success'] = false;
	$data['error'] = 'Connexion à la base de données impossible (' . $e->getMessage() . ').';
}

if($db) {
	// Création de l'utilisateur
	try {
		// $sql5 : requête	
		$query = $db->prepare($sql5);
		
		$result = $query->execute(array(
			':login' => $login,
			':motdepasse' => $motdepasse
		));

		$data['success'] = true;
	}
	catch(PDOException $e) {
		$data['success'] = false;
	 	$data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
	}

	// création de l'inscription
	try {
		// $sql6 : requête	
		$query = $db->prepare($sql6);
		
		/* Requête pour insérer une inscription
		$result = $query->execute(array(
			':' => $,
		));
		*/

		$data['success'] = true;
	}
	catch(PDOException $e) {
		$data['success'] = false;
	 	$data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
	}

	// création du choriste
	try {
		// $sql7 : requête	
		$query = $db->prepare($sql7);
		
		$result = $query->execute(array(
			':nom' => $nom,
			':prenom' => $prenom,
			':idVoix' => $idVoix,
			':ville' => $ville,
			':telephone' => $telephone
		));

		$data['success'] = true;
	}
	catch(PDOException $e) {
		$data['success'] = false;
	 	$data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
	}
}

// render la vue avec le paramètre $data
