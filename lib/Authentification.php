<?php 

class Authentification {
	
	function displayLoginPage() {
		// Header
		Flight::render('header.php',
			array(
				'title' => 'Connexion'
				), 
			'header');

		// Footer
		Flight::render('footer.php',
			array(), 
			'footer');		


		// Finalement on rend le layout
		Flight::render('LoginLayout.php', array(
			'fail' => false
			)
		);
	}


	function authenticate() {
		// TODO 
		Flight::render('LoginLayout.php', 
			array(
				'fail' => true
			)
		);
	}
}