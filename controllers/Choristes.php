<?php

require_once 'model/Choristes.php';

class Choristes {

    // GET /choristes
    function get() {

        // On récupère le nombre d'évènements
        $data['repets_count'] = Evenements::getCount();

        try {
            list($status, $result) = C_Queries::getChoristes();
            $data['success'] = $status;
            $data['content'] = $result;
        }
        catch(PDOException $e) {
            $data['success'] = false;
            $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
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

        if(! in_array('error', $data))
            $data['error'] = "";
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

        Flight::render('ChoristeNewLayout.php', array(
            'voix' => $voix,
            'fail' => false
            )
        );
    }

    // Retourne l'ensemble des voix dans la base de données (ID + type)
    function getVoix() {
        $voix = NULL;

        try {
            list($status, $result) = C_Queries::getVoix();
            $voix = $result;
        }
        catch(PDOException $e) { }

        return $voix;
    }

    // Retourne l'identifiant d'une voix spécifiée par type
    function getIdVoixFromType($type) {
        $idVoix = null;

        try {
            list($status, $result) = C_Queries::getIdVoixFromType($type);
            $idVoix = $result['idvoix'];
        }
        catch(PDOException $e) {}

        return $idVoix;
    }

    // POST /choristes/nouveau
    function subscribe() {
        $fail['error'] = False;
        $idInscription = NULL;

        // Récupération des données POST
        $login     = Flight::request()->data->login;
        $password  = Flight::request()->data->password;
        $password1 = Flight::request()->data->password1;
        $nom       = Flight::request()->data->nom;
        $prenom    = Flight::request()->data->prenom;
        $ville     = Flight::request()->data->ville;
        $telephone = Flight::request()->data->telephone;
        $voix      = Flight::request()->data->voix;
        $statut    = Flight::request()->data->statut;

        // Vérification de l'égalité des mots de passe
        try {
            list($status, $result) = C_Queries::getNbChoristesFromLogin($login);

            // Vérification de l'existance de l'utilisateur
            if($result[0] > 0) {
                $fail['error'] = True;
                $fail['message'] = "L'identifiant " . $login . " existe déjà dans la base de données.";
            }

            // Vérification de l'égalité des mots de passe
            if($password != $password1) {
                $fail['error'] = true;
                $fail['message'] = "Les mots de passe entrés ne sont pas identiques.";
            }
        }
        catch(PDOException $e) {
            $fail['error'] = true;
            $fail['message'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
        }

        if(! $fail['error']) {
            $idVoix = Choristes::getIdVoixFromType($voix);

            // Création d'un utilisateur (login / mot de passe)
            $usr['login'] = $login;
            $usr['motdepasse'] = md5($password);
            try {
                list($status, $result) = C_Queries::insertUser($usr);
                $data['success'] = $status;
            }
            catch(PDOException $e) {
                $data['success'] = false;
                $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
            }

            // Définition du montant de la cotisation
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

            // Création d'une inscription
            // On vérifie l'insertion de l'utilisateur avec $data['success']
            if($data['success']) {
                $ins['typeinscription'] = $statut;
                $ins['montant'] = $montant;
                $ins['annee'] = date('Y');
                try {
                    list($status, $result, $id) = C_Queries::insertInscription($ins);
                    $data['success'] = $status;
                    $idInscription = $id;
                }
                catch(PDOException $e) {
                    $data['success'] = false;
                    $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
                }
            }

            // Création d'un choriste
            // On vérifie l'insertion de l'inscription avec $data['success']
            if($data['success']) {
                $cho['nom'] = $nom;
                $cho['prenom'] = $prenom;
                $cho['idvoix'] = $idVoix;
                $cho['ville'] = $ville;
                $cho['telephone'] = $telephone;
                $cho['login'] = $login;
                $cho['idinscription'] = $idInscription;
                try {
                    list($status, $result) = C_Queries::insertChoriste($cho);
                    $data['success'] = $status;
                    $data['message'] = "Votre compte <b>" . $login . "</b> a bien été créé.";
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
        }
        else {
            $voix = Choristes::getVoix();

            Flight::render('ChoristeNewLayout.php', array(
            'fail' => $fail,
            'voix' => $voix
                )
            );
        }
        if(! in_array('error', $data))
            $data['error'] = $result;
        if($data['success'])
            Flight::render('SuccessLayout.php', array('data' => $data));
        else
            Flight::render('ErrorLayout.php', array('data' => $data));
    }

    // GET /choristes/modification du compte
    function displayAccountForm() {
	   $user = Flight::get('user');

        // Récupération des voix pour le <select>
        $voix = Choristes::getVoix();

        // Header
        Flight::render('header.php',
            array(
                'title' => 'Mon compte'
                ),
            'header');

        // Navbar
        Flight::render('navbar.php',
            array(
                'activePage' => 'account'
                ),
            'navbar');

        // Footer
        Flight::render('footer.php',
            array(),
            'footer');

        Flight::render('ChoristeAccountLayout.php', array('voix' => $voix));
    }

    // POST /choristes/account
    function submitAccountForm() {
        // Récupération des données POST
        $login     = Flight::request()->data->login;
        $nom       = Flight::request()->data->nom;
        $prenom    = Flight::request()->data->prenom;
        $ville     = Flight::request()->data->ville;
        $telephone = Flight::request()->data->telephone;
        $voix      = Flight::request()->data->voix;
        $statut    = Flight::request()->data->statut;

        $current_pw     = Flight::request()->data["current-pw"];
        $new_pw         = Flight::request()->data["new-pw"];
        $new_pw_confirm = Flight::request()->data["new-pw-confirm"];

        if($new_pw == $new_pw_confirm) {

            $oldPassword = null;

            // On vérifie que le mot de passe actuel est le bon
            try {
                list($status, $result) = C_Queries::getPasswordFromLogin($login);
                $data['success'] = $status;
                $oldPassword = $result[0];
            }
            catch(PDOException $e) {
                $data['success'] = false;
                $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
            }

            if($oldPassword != md5($current_pw)) {
                $data['success'] = false;
                $data['error'] = 'Impossible de changer le mot de passe : le mot de passe actuel est incorrect.';
            } else {
                // Modification d'un utilisateur (login / mot de passe)
                $usr['login'] = $login;
                $usr['password'] = md5($new_pw);
                try {
                    list($status, $result) = C_Queries::updateUser($usr);
                    $data['success'] = $status;
                }
                catch(PDOException $e) {
                    $data['success'] = false;
                    $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
                }
            }
        }
        else {
            $data['success'] = false;
            $data['error'] = 'Impossible de changer le mot de passe : les mots de passe saisis sont différents.';
        }

        $idVoix = Choristes::getIdVoixFromType($voix);

        // Modification d'un choriste
        // On vérifie l'insertion de l'utilisateur avec $data['success']
        if($data['success']) {
            $cho['nom'] = $nom;
            $cho['prenom'] = $prenom;
            $cho['idVoix'] = $idVoix;
            $cho['ville'] = $ville;
            $cho['telephone'] = $telephone;
            $cho['login'] = $login;
            try {
                list($status, $result) = C_Queries::updateChoriste($cho);
                $data['success'] = true;
                $data['message'] = "Votre compte <b>" . $login . "</b> a bien été modifié.";
            }
            catch(PDOException $e) {
                $data['success'] = false;
                $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
            }
        }

        // Header
        Flight::render('header.php',
            array(
                'title' => 'Modification du profil'
                ),
            'header');

        // Navbar
        Flight::render('navbar.php',
            array(
                'activePage' => ''
                ),
            'navbar');

        // Footer
        Flight::render('footer.php',
            array(),
            'footer');

        // Finalement on rend le layout
        if($data['success'])
            Flight::render('SuccessLayout.php', array('data' => $data));
        else
            Flight::render('ErrorLayout.php', array('data' => $data));
    }

}
