<?php 

class Authentification {
    // POST /login
    function authenticate() {
        $login = Flight::request()->data->login;
        $password = Flight::request()->data->password;
        $remember = Flight::request()->data->remember;

        try {
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
            $data['success'] = false;
            $data['error'] = 'Connexion à la base de données impossible (' . $e->getMessage() . ').';
        }

        // TODO : remplacer par une requête préparée
        $sql = "SELECT motdepasse
                FROM Utilisateur
                WHERE login LIKE '" . $login  . "';";

        if($db) {
            try {
                $query = $db->prepare($sql);
                
                $query->execute();

                $data['success'] = true;
                $result = $query->fetch();
                $encryptedPassword = $result[0];
            }
            catch(PDOException $e) {
                $data['success'] = false;
                $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
            }
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
                setcookie('login', $login, $expires);
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
                $db = new PDO('pgsql:host='. Flight::get('postgres.host') .';dbname='. Flight::get('postgres.database'), 
                    Flight::get('postgres.user'), 
                    Flight::get('postgres.password'));
            }
            catch(PDOException $e) {
                $db = null;
                $data['success'] = false;
                $data['error'] = 'Connexion à la base de données impossible (' . $e->getMessage() . ').';
            }

            // TODO : remplacer par une requête préparée
            $sql = "SELECT u.login, c.nom, c.prenom, c.idChoriste, r.id
                FROM Utilisateur u
                LEFT JOIN Choriste c ON u.login = c.login
                LEFT JOIN endosse e ON u.login = e.login
                LEFT JOIN Responsabilite r ON e.id = r.id
                WHERE u.login LIKE '" . $login . "';";

            if($db) {
                try {
                    $query = $db->prepare($sql);
                    
                    $query->execute();

                    $data['success'] = true;
                    $data['content'] = $query->fetch();

                    $user['authenticated'] = true;
                    $user['nom'] = $data['content']['nom'];
                    $user['prenom'] = $data['content']['prenom'];
                    $user['idChoriste'] = $data['content']['idchoriste'];
                    $user['responsabilite'] = $data['content']['id'];
                }
                catch(PDOException $e) {
                    $data['success'] = false;
                    $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
                    
                    $user['authenticated'] = false;
                }
            }
        }

        return $user;
    }

    // GET /logout
    // Déconnecte l'utilisateur courant.
    function logout() {
        setcookie('login', NULL);
        Flight::redirect(Flight::request()->base);
    }
}
