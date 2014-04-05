<?php

class Evenements {


	function get() {
		try {
			$db = new PDO('pgsql:host='. Flight::get('postgres.host') .';dbname='. Flight::get('postgres.database'), 
				Flight::get('postgres.user'), 
				Flight::get('postgres.password'));
		}
		catch(PDOException $e) {
			$db = null;
			$data['success'] = false;
			$data['error'] = 'Connexion à la base de données impossible (' . $e->getMessage() . ').';
		}

		$sql = "SELECT * FROM Evenement WHERE idType=2;";

		if($db) {
			try {
				$query = $db->prepare($sql);
				
				$query->execute();

				$data['content'] = $query->fetchAll();

				$data['success'] = true;
			}
			catch(PDOException $e) {
				$data['success'] = false;
			 	$data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
			}
		}

		Flight::render('events.php', array('data' => $data['content']));
	}
}