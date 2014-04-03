<?php

// $request est l'objet qui contient les attributs de la requête

$choristeId = $request->post['choristeId'];
$eventId = $request->post['eventId'];
$presenceStatus = $request->post['presenceStatus'];

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
	try {
		// $sql1 : requête	
		$query = $db->prepare($sql1);
		
		$result = $query->execute(array(
		    ':choristeId' => $choristeId,
		    ':eventId' => $eventId,
		    ':presenceStatus' => $presenceStatus
		));

		$data['success'] = true;
	}
	catch(PDOException $e) {
		$data['success'] = false;
	 	$data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
	}
}

// render la vue avec le paramètre $data
