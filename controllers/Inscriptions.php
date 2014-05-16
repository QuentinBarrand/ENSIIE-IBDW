<?php

require_once 'model/Inscriptions.php';

class Inscriptions {

    // GET /inscriptions
    function get() {
        $user = Flight::get('user');

        // Restriction aux responsabilites webmaster et tresorier
        if(! $user['authenticated']) {
            Flight::forbidden();
            return;
        }
        if(! in_array($user['responsabilite'], array(2, 3))) {
            Flight::forbidden();
            return;
        }

        try {
            list($status, $result) = I_Queries::getInscriptions();
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
                'title' => 'Liste des inscriptions'
                ), 
            'header');

        // Navbar
        Flight::render('navbar.php',
            array(
                'activePage' => 'inscriptions'
                ), 
            'navbar');

        // Footer
        Flight::render('footer.php',
            array(), 
            'footer');      

        // Finalement on rend le layout
        if($data['success'])
            Flight::render('InscriptionsLayout.php', array('data' => $data));
        else
            Flight::render('ErrorLayout.php', array('data' => $data));
    }

    /*
     * Incrémente la valeur de validation pour l'id
     * fourni en paramètre.
     */
    function validate($inscriptionId) {
        $user = Flight::get('user');
        $base = Flight::request()->base;
        if($base == '/') $base = '';

        // Restriction aux responsabilites webmaster et tresorier
        if(! $user['authenticated']) {
            Flight::forbidden();
            return;
        }
        if(! in_array($user['responsabilite'], array(2, 3))) {
            Flight::forbidden();
            return;
        }

        // Detection du type de validation (Webmaster/Tresorier)
        $type = 1;
        if($user['responsabilite'] == 2)
            $type = 2;

        // Execution de la requête SQL
        try {
            list($status, $result) = I_Queries::updateInscription($type, $inscriptionId);
            $data['success'] = $status;
        }
        catch(PDOException $e) {
            $data['success'] = false;
            $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
        }

        // Finalement on reditige vers la liste des validations
        Flight::redirect($base . '/inscriptions');
    }

    /* Retourne le nombre total d'inscriptions en fonction
     * du type donné en paramètre.
     * 0: 1ère validation (webmaster)
     * 1: 2nde validation (trésorier)
     */
    function getCount($type) {

        $count = 0;

        try {
            list($status, $result) = I_Queries::getInscriptionCountByType($type);
            $data['success'] = $status;
            if($result[0])
                $count = $result[0];
        }
        catch(PDOException $e) { }

        return $count;
    }
}
