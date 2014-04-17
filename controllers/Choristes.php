<?php

class Choristes {

    // GET /choristes
    function get() {
        try {
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
            $data['success'] = false;
            $data['error'] = 'Connexion à la base de données impossible (' . $e->getMessage() . ').';
        }

        $sql = 'SELECT nom, prenom, typeVoix, ville, telephone, titre as responsabilite, SUM(participe.confirmation) as participations
            FROM Choriste
            LEFT JOIN participe ON Choriste.idChoriste = participe.idChoriste
            NATURAL JOIN Voix 
            NATURAL JOIN Utilisateur 
            LEFT JOIN Endosse ON Utilisateur.login = Endosse.login
            LEFT JOIN Responsabilite ON Endosse.id = Responsabilite.id 
            GROUP BY Choriste.idChoriste, nom, prenom, typeVoix, ville, telephone, responsabilite
            ORDER BY typeVoix;';

        // On récupère le nombre d'évènements
        $data['repets_count'] = Evenements::getCount();

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
                'title' => 'Liste des choristes'
                ), 
            'header');

        // Navbar
        Flight::render('navbar.php',
            array(
                'activePage' => 'choristes'
                ), 
            'navbar');

        // Footer
        Flight::render('footer.php',
            array(), 
            'footer');      

        // Finalement on rend le layout
        if($data['success'])
            Flight::render('ChoristesLayout.php', array('data' => $data));
        else
            Flight::render('ErrorLayout.php', array('data' => $data));
    }

    // GET /choristes/nouveau
    function displayChoristeForm() {
        $user = Flight::get('user');

        if($user['authenticated'])
            Flight::redirect(Flight::request()->base . '/choristes');

        // Récupération des voix pour le <select>
        $voix = Choristes::getVoix();

        // Header
        Flight::render('header.php',
            array(
                'title' => 'S\'inscrire'
                ), 
            'header');

        // Navbar
        Flight::render('navbar.php',
            array(
                'activePage' => 'choristes'
                ), 
            'navbar');

        // Footer
        Flight::render('footer.php',
            array(), 
            'footer');

        Flight::render('ChoristeNewLayout.php', array('voix' => $voix));
    }

    // Retourne l'ensemble des voix dans la base de données (ID + type)
    function getVoix() {
        $voix = NULL;

        try {
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
            $data['success'] = false;
            $data['error'] = 'Connexion à la base de données impossible (' . $e->getMessage() . ').';
        }

        $sql = 'SELECT idVoix, typeVoix FROM Voix;';

        if($db) {
            try {
                $query = $db->prepare($sql);
                
                $query->execute();

                $result = $query->fetchAll();

                $voix = $result;
            }
            catch(PDOException $e) { }
        }

        return $voix;
    }

    // Retourne l'identifiant d'une voix spécifiée par type
    function getVoixIdFromType($typeVoix) {
        $idVoix = NULL;

        // print_r($typeVoix); die;

        try {
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
            $data['success'] = false;
            $data['error'] = 'Connexion à la base de données impossible (' . $e->getMessage() . ').';
        }

        $sql = "SELECT idVoix FROM Voix WHERE typeVoix = :typeVoix;";

        if($db) {
            try {
                $query = $db->prepare($sql); 
                
                $query->execute(array(
                    ':typeVoix' => $typeVoix
                    )
                );

                $result = $query->fetch();

                $idVoix = $result['idvoix'];
            }
            catch(PDOException $e) { }
        }

        return $idVoix;
    }

    // POST /choristes/nouveau
    function subscribe() {
        // Récupération des données POST
        $login     = Flight::request()->data->login;
        $password  = Flight::request()->data->password;
        $nom       = Flight::request()->data->nom;
        $prenom    = Flight::request()->data->prenom;
        $ville     = Flight::request()->data->ville;
        $telephone = Flight::request()->data->telephone;
        $voix      = Flight::request()->data->voix;
        $statut    = Flight::request()->data->statut;

        try {
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
            $data['success'] = false;
            $data['error'] = 'Connexion à la base de données impossible (' . $e->getMessage() . ').';
        }

        // Création d'un utilisateur (login / mot de passe)
        $sql = "INSERT INTO utilisateur (login, motdepasse)
                  VALUES (:login, :password)";
    
        if($db) {
                try {
                    $query = $db->prepare($sql);
                    
                    $query->execute(array(
                        'login'    => $login,
                        'password' => md5($password)
                        )
                    );

                    $data['success'] = true;
     
                }
                catch(PDOException $e) {
                    $data['success'] = false;
                    $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
                }
            }

        $idVoix = Choristes::getVoixIdFromType($voix);

        // Création d'une inscription
        $sql = "INSERT INTO Inscription (typeInscription, montant, annee)
            VALUES (:statut, :montant, :annee)
            RETURNING idinscription;";

        switch($statut) {
            case "Etudiant":
                $montant = 200;
            case "Salarié":
                $montant = 300;
            case "Retraîté":
                $montant = 250;

            default:
                $montant = 275;
        }

        $idInscription = NULL;

        // On vérifie que l'insertion précédente a bien pu avoir lieu avec $data['success']
        if($db && $data['success']) {
            try {
                $query = $db->prepare($sql);
                
                $query->execute(array(
                    ':statut' => "'" . $statut . "'",
                    ':montant' => $montant,
                    ':annee' => date('Y')
                    )
                );

                $result = $query->fetch();

                $idInscription = $result['idinscription'];

                $data['success'] = true;
  
            }
            catch(PDOException $e) {
                $data['success'] = false;
                $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
            }
        }

        // Création d'un choriste
        $sql = "INSERT INTO Choriste (nom, prenom, idVoix, ville, telephone, login, idInscription)
            VALUES (:nom, :prenom, :idVoix, :ville, :telephone, :login, :idInscription)
            RETURNING idChoriste;";

        // On vérifie que l'insertion précédente a bien pu avoir lieu avec $data['success']
        if($db && $data['success']) {
            try {
                $query = $db->prepare($sql);
                
                $executed = $query->execute(array(
                    ':nom'           => $nom,
                    ':prenom'        => $prenom,
                    ':idVoix'        => $idVoix,
                    ':ville'         => $ville,
                    ':telephone'     => $telephone,
                    ':login'         => $login,
                    ':idInscription' => $idInscription,
                    )
                );

                $data['success'] = true;
                $data['message'] = "Votre compte '" . $login . "' a bien été créé.";
            }
            catch(PDOException $e) {
                $data['success'] = false;
                $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
            }
        }

        // Header
        Flight::render('header.php',
            array(
                'title' => 'Inscription' 
                ), 
            'header');

        // Navbar
        Flight::render('navbar.php',
            array(
                'activePage' => 'choristes'
                ), 
            'navbar');

        // Footer
        Flight::render('footer.php',
            array(), 
            'footer');      

        // Finalement on rend le layout
        if($data['success']) {
            // On authentifie l'utilisateur pour 12h
            setcookie('login', $login, time() + 60 * 60 * 12, '/');

            Flight::render('SuccessLayout.php', array('data' => $data));
        }
        else
            Flight::render('ErrorLayout.php', array('data' => $data));
    }
}