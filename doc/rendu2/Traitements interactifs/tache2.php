<?php

// $request est l'objet qui contient les attributs de la requête

// L'identifiant du chef de choeur
$choristeId = $request->post['choristeId'];
$eventType = $request->post['eventType'];
$eventDate = $request->post['eventDate'];
$subscribe = $request->post['subscribe'];

$oeuvres = array();

// Récupération des oeuvres : variables POST oeuvre0, oeuvre1, oeuvre2...
$i = 0;

while(isset($request->post['oeuvre' . $i])
{
	$oeuvres[$i] = $request->post['oeuvre' . $i];
	$i++;
}

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
	// Ajout de l'évènement
	try {
		// $sql2 : requête	
		$query = $db->prepare($sql2);
		
		$query->execute(array(
		    ':choristeId' => $choristeId,
		    ':eventType' => $eventType,
		    ':eventDate' => $presenceStatus
		));

		// Résultat de la requête : identifiant de l'évènement créé
		$eventId = $query->fetch()->eventId;
	}
	catch(PDOException $e) {
		$data['success'] = false;
	 	$data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
	}

	// Si l'évènement n'a pas été créé correctement
	if(! isset($eventId))
	{
		$data['success'] = false;
	 	$data['error'] = 'L\'évènement n\'a pas pu être créé.';

		// render la vue avec le paramètre $data
	}

	// Ajout de la participation du chef de choeur qui a ajouté l'évènement
	if($subscribe) {
		try {
			// $sql3 : requête	
			$query = $db->prepare($sql3);
			
			$query->execute(array(
			    ':choristeId' => $choristeId,
			    ':eventId' => $eventId,
			));
		}
		catch(PDOException $e) {
			$data['success'] = false;
		 	$data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
		}
	}

	// Ajout des oeuvres
	try {
		foreach ($oeuvre as $oeuvreId) {
			// $sql4 : requête	
			$query = $db->prepare($sql4);
			
			$query->execute(array(
			    ':eventId' => $choristeId,
			    ':oeuvreId' => $oeuvreId,
			));
		}

		$data['success'] = true;
		$data['eventId'] = $eventId;
	}
	catch(PDOException $e) {
		$data['success'] = false;
	 	$data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
	}
}

// render la vue avec le paramètre $data