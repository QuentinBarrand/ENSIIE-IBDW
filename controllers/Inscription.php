<?php 

class Inscription {
    // POST /Inscription
    function subscribe() {
        $login = Flight::request()->data->login;
        $password = Flight::request()->data->password;
        $nom = Flight::request()->data->nom;
        $prenom = Flight::request()->data->prenom;
        $ville = Flight::request()->data->ville;
        $telephone = Flight::request()->data->telephone;
        $voix = Flight::request()->data->voix;

        try {
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
            $data['success'] = false;
            $data['error'] = 'Connexion à la base de données impossible (' . $e->getMessage() . ').';
        }

        // Requête d'insertion du login et du mot de passe
        $sql = 'INSERT INTO utilisateur (login ,motdepasse)
                  VALUES ('".$login."','".$pass."')';
    
        if($db) {
                try {
                    $query = $db->prepare($sql);
                    
                    $query->execute();

                    $data['success'] = true;
     
                }
                catch(PDOException $e) {
                    $data['success'] = false;
                    $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
                }
            }

           // Requête d'insertion des autres variables
        $sql = 'INSERT INTO Choriste (idChoriste, nom, prenom, idVoix, ville, telephone, login, idInscription)
            VALUES ('".$idchoriste."','".$nom."','".$prenom."', '".$voix."', '".$ville."', '".$telephone."', '".$login."', '".$idInscription."' )'
           
        if($db) {
            try {
                $query = $db->prepare($sql);
                
                $query->execute();

                $data['success'] = true;
  
            }
            catch(PDOException $e) {
                $data['success'] = false;
                $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
            }
        }

// GET /Inscription
    function displayInscriptionPage() {
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
        Flight::render('InscriptionLayout.php', array(
            'fail' => false
            )
        );
    }

}



