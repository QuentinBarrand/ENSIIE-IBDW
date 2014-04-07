<?php

class Evenements {

	// GET /evenements
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

				$data['success'] = true;
				$data['content'] = $query->fetchAll();
			}
			catch(PDOException $e) {
				$data['success'] = false;
			 	$data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
			}
		}

		// Header
		Flight::render('header.php',
			array(
				'title' => 'Liste des évènements'
				), 
			'header');

		// Navbar
		Flight::render('navbar.php',
			array(
				'user' => Flight::get('user'),
				'activePage' => 'evenements'
				), 
			'navbar');

		// Footer
		Flight::render('footer.php',
			array(), 
			'footer');		

		// Finalement on rend le layout
		if($data['success'])
			Flight::render('EvenementsLayout.php', array('data' => $data));
		else
			Flight::render('ErrorLayout.php', array('data' => $data));
	}
}