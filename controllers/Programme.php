<?php

class Programme {

    // GET /programme
	function get() {
        $user = Flight::get('user');

        try {
            // On récupère toutes les oeuvres
            list($status, $result) = P_Queries::getOeuvres();
            $data['success'] = $status;
            $data['content'] = $result;

            // On récupère les différents styles
            list($status, $result) = P_Queries::getStyles();
            $data['success'] = $status;
            $data['styles'] = $result;

            // On récupère l'ID de la saison actuelle
            list($status, $result) = P_Queries::getCurrentSeasonId();
            $data['success'] = $status;
            $data['id_saison'] = $result[0];

            // On récupère toutes les oeuvres de la saison
            list($status, $result) = P_Queries::getOeuvresBySeason($id_saison);
            $data['success'] = $status;
            $data['content'] = $result;

            if($user['authenticated'] && $user['idChoriste'] != NULL) {
            // On récupère la progression de l'utilisateur connecté sur chaque oeuvre
                list($status, $result) = P_Queries::getProgressionByChoriste($id_choriste);
                $data['success'] = $status;
                foreach($result as $r) {
                    $data['progression'][$r['idoeuvre']] = $r['nbevenements'];
                }
            }

            // Durée par style
            list($status, $result) = P_Queries::getDureeByStyle($id_saison);
            $data['styles'] = $result;
            $data['success'] = true;

        }
        catch(PDOException $e) {
            $data['success'] = false;
            $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
        }

        // Header
        Flight::render('header.php',
            array(
                'title' => 'Programme de l\'année'
                ), 
            'header');

        // Navbar
        Flight::render('navbar.php',
            array(
                'activePage' => 'programme'
                ), 
            'navbar');

        // Footer
        Flight::render('footer.php',
            array(), 
            'footer');      

        // Finalement on rend le layout
        if($data['success'])
            Flight::render('ProgrammeLayout.php', array('data' => $data));
        else
            Flight::render('ErrorLayout.php', array('data' => $data));
    }


    function getOeuvres() {
        $oeuvres = NULL;

        try {
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
            $data['success'] = false;
            $data['error'] = 'Connexion à la base de données impossible (' . $e->getMessage() . ').';
        }

        $sql = 'SELECT * FROM oeuvre;';

        if($db) {
            try {
                $query = $db->prepare($sql);
                
                $query->execute();

                $oeuvres = $query->fetchAll();
            }
            catch(PDOException $e) { }
        }
        
        return $oeuvres;
    }
}
