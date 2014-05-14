<?php 

require_once '../model/Authentication.php';

class Authentification {
    // POST /login
    function authenticate() {
        $login = Flight::request()->data->login;
        $password = Flight::request()->data->password;
        $remember = Flight::request()->data->remember;

        try {
            list($status, $result) = Queries::authenticate($login);
            $data['success'] = $success;
            $encryptedPassword = $result[0];
        }
        catch(PDOException $e) {
            $data['success'] = false;
            $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
        }

        if(! $data['success'])
            $fail = true;
        else {
            if(md5($password) == $encryptedPassword) {
                
                if($remember)
                    // La session expire dans un mois
                    $expires = time() + 60 * 60 * 24 * 30;
                else
                    // La session expire dans une heure
                    $expires = time() + 60 * 60;

                // Stockage des informations dans des cookies
                setcookie('login', $login, $expires, '/');
                Flight::redirect(Flight::request()->base);
            }  
            else
                $fail = true;
        }

        if($fail) {
            Flight::render('LoginLayout.php', 
                array(
                    'fail' => $fail
                )
            );
        }
    }

    // GET /login
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

    // Appelée à chaque requête. Si un cookie est présent, s'en sert pour récupérer les données utilisateur.
    function getUserDetails() {
        // TODO : retourner les détails utilisateur (login + role) depuis le cookie.
        $user = array();

        $login = Flight::request()->cookies->login;

        if($login == NULL) {
            $user['authenticated'] = false;
        }
        else {
            try {
                list($status, $result) = Queries::getUserDetails($login);
                $data['success'] = $success;
                $data['content'] = $result;
                $user['authenticated'] = true;
                $user['login'] = $login;
                $user['validation'] = $data['content']['validation'];
                $user['nom'] = $data['content']['nom'];
                $user['prenom'] = $data['content']['prenom'];
                $user['telephone'] = $data['content']['telephone'];
                $user['ville'] = $data['content']['ville']
                $user['idChoriste'] = $data['content']['idchoriste'];
                $user['responsabilite'] = $data['content']['id'];
                $user['idvoix'] = $data['content']['idvoix'];
                $user['login'] = $data['content']['login'];

                // Calcul des validation en attente si webmaster ou tresorier
                $user['inscriptions'] = 0;
                if(in_array($user['responsabilite'], array(2, 3))) {
                    // On détecte le type de validation (Webmaster/Tresorier)
                    $type = 0;
                    if($user['responsabilite'] == 2)
                        $type = 1;

                    // On effectue la requete
                    $user['validations'] = Inscriptions::getCount($type);
                }

            }
            catch(PDOException $e) {
                $data['success'] = false;
                $user['authenticated'] = false;
                $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
            }
        }
        return $user;
    }

    // GET /logout
    // Déconnecte l'utilisateur courant.
    function logout() {
        setcookie('login', NULL, time(), '/');
        Flight::redirect(Flight::request()->base);
    }
}
