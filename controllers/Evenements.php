<?php

require_once 'model/Evenements.php';
require_once 'model/Programme.php';

class Evenements {

    // GET /evenements
    function get() {

        //Récupérer un utilisateur connecté s'il y en a un
        $user = Flight::get('user');
        $login = null;

        try {

            $voix = Choristes::getVoix();

            if ($user['authenticated'])
                $login = $user['login'];

            list($status, $result) = E_Queries::getEvenements($login);
            $data['success'] = $status;
            $content = $result;

            if($data['success']) {
                // Initialisation (Utile lorsque la requête renvoie 0 rows)
                $data['content'] = null;
                //$data['content']: données récupérées avec les requêtes sql
                foreach($content as $row) {
                    $id = $row['idevenement'];

                    //Par défaut l'utilisateur ne va pas à l'évènement
                    $row['presence'] = "absent";
                    $data['content']["$id"] = $row ;
                }

                // Récupération des taux de présence de l'utilisateur
                if($data['success'] && $user['authenticated']) {
                    list($status, $result) = E_Queries::getRatesByUser($login);
                    $data['success'] = $status;

                    // Traitement des résultats
                    foreach($result as $row) {
                        $id = $row['idevenement'];
                        if ($row['confirmation'] == 0)
                            $data['content']["$id"]['presence'] = 'indécis';
                        else if ($row['confirmation'] == 1)
                            $data['content']["$id"]['presence'] = 'présent';
                    }
                }
            }

            if($data['success']) {
                // Récupération des taux de présence par voix
                list($status, $result) = E_Queries::getRatesByVoices($voix);
                $data['success'] = $status;

                // Traitement des résultats
                foreach($result as $row) {
                    $eventValide = true;

                    foreach($voix as $v) {
                        // Deux choristes par voix au minimum
                        if($row['nbc_' . $v['idvoix']] == NULL || $row['nbc_' . $v['idvoix']] < 2)
                            $eventValide = false;
                    }

                    $content[$row['idevenement']]['valide'] = $eventValide;

                }
            }

        }
        catch(PDOException $e) {
            $data['success'] = false;
            $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
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
                'activePage' => 'evenements'
                ),
            'navbar');

        // Footer
        Flight::render('footer.php',
            array(),
            'footer');

        // Finalement on rend le layout
        if(! in_array('error', $data))
            $data['error'] = $result;
        if($data['success'])
            Flight::render('EvenementsLayout.php', array('data' => $data));
        else
            Flight::render('ErrorLayout.php', array('data' => $data));

    }

    // GET /evenements/nouveau
    function displayEventForm($fail = NULL) {
        // Header
        Flight::render('header.php',
            array(
                'title' => 'Ajouter un évènement'
                ), 
            'header');

        // Navbar
        Flight::render('navbar.php',
            array(
                'activePage' => 'evenements'
                ), 
            'navbar');

        // Footer
        Flight::render('footer.php',
            array(
                'activePage' => 'nouvel_evenement'
                ),
            'footer');

        $user = Flight::get('user');

        if($user['authenticated'] && $user['responsabilite'] == 1) {
            $fail['error'] = $fail == NULL ? false : true;

            Flight::render('EvenementNewLayout.php', array(
                'fail' => $fail
                )
            );
        }
        else {
            $data = array(
                'error' => 'Vous n\'avez pas les droits nécessaires pour accéder à cette page.');
            Flight::render('ErrorLayout.php', $data);
        }
    }

    /* Retourne le nombre total d'évènements du type passé en paramètre
     * (par défaut 2 = répétitions) dans la base de données.
     */
    function getCount($type = 2) {
        
        try {
            list($status, $result) = E_Queries::getEventCountByType($type);
            $success = $status;
        }
        catch(PDOException $e) {
            $success = false;
        }

        $count = NULL;
        $count = $result[0];
        return $count;
    }

    // POST /evenements/nouveau
    function add() {
        // Récupération des données POST
        $nom   = Flight::request()->data->nom;
        $lieu  = Flight::request()->data->lieu;
        $date  = Flight::request()->data->date;
        $type  = Flight::request()->data->type;

        $timestamp = DateTime::createFromFormat("d/m/Y H:i", $date);
        $annee = date("Y", $timestamp->getTimestamp());

        if($type == 'saison' && Evenements::seasonExists($annee)) {
            $fail['error'] = true;
            $fail['message'] = "La saison " . $annee . " existe déjà.";

            Evenements::displayEventForm($fail);
            return;
        }

        switch($type) {
            case 'repetition':
            case 'concert':
                Evenements::addEvent($nom, $lieu, $date, $type);
                break;

            case 'saison':
                Evenements::displaySaisonForm($nom, $annee);
                break;
        }
    }

    // Fonction d'ajout d'une répétition ou d'un concert
    function addEvent($nom, $lieu, $date, $type) {

        // Traitement heureDate
        $timestamp = DateTime::createFromFormat("d/m/Y H:i", $date);
        $heureDate = date("Y-m-d H:i:s", $timestamp->getTimestamp());

        // Recuperation de l'id du type
        switch($type) {
            case 'repetition':
                $idType = 2;
                break;

            case 'concert':
                $idType = 1;
                break;
        }

        $evt['idtype'] = $idType;
        $evt['heuredate'] = $heureDate;
        $evt['lieu'] = $lieu;
        $evt['nom'] = $nom;

        try {
            list($status, $result) = E_Queries::insertEvent($evt);
            $data['success'] = $status;
            $data['message'] = "L'évènement <b>" . $nom . "</b> a bien été ajouté.";
        }
        catch(PDOException $e) {
            $data['success'] = false;
            $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
        }

        // Header
        Flight::render('header.php',
            array(
                'title' => 'Ajout d\'un évènement'
                ), 
            'header');

        // Navbar
        Flight::render('navbar.php',
            array(
                'activePage' => 'evenements'
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

    function displaySaisonForm($nom, $annee, $added = NULL) {
        $oeuvres = Programme::getOeuvres();

        // Header
        Flight::render('header.php',
            array(
                'title' => 'Ajouter une saison'
                ), 
            'header');

        // Navbar
        Flight::render('navbar.php',
            array(
                'activePage' => 'evenements'
                ), 
            'navbar');

        // Footer
        Flight::render('footer.php',
            array(), 
            'footer');

        Flight::render('SaisonNewLayout.php', array(
            'nom' => $nom,
            'annee' => $annee,
            'oeuvres' => $oeuvres,
            'added' => $added
            )
        );
    }

    // GET /oeuvre/nouveau
    function addOeuvre() {
        $titre     = Flight::request()->data->titre;
        $auteur    = Flight::request()->data->auteur;
        $partition = Flight::request()->data->partition;
        $duree     = intval(Flight::request()->data->duree);
        $style     = Flight::request()->data->style;

        // Pour le displaySaisonForm() en bas
        $nom       = Flight::request()->data->nom;
        $annee     = Flight::request()->data->annee;

        $oeuvre['titre']     = $titre;
        $oeuvre['auteur']    = $auteur;
        $oeuvre['partition'] = $partition;
        $oeuvre['duree']     = $duree;
        $oeuvre['style']     = $style;

        // On insère l'évènement courant
        try {
            list($status, $result) = E_Queries::insertOeuvre($oeuvre);
            $data['success'] = $status;
            $data['message'] = "L'oeuvre <b>" . $titre . "</b> a bien été ajouté.";
        }
        catch(PDOException $e) {
            $data['success'] = false;
            $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
        }

        Evenements::displaySaisonForm($nom, $annee, $data['message']);
    }

    // POST /saison/nouveau
    function addSaison() {
        $nom = Flight::request()->data->nom;
        $annee = Flight::request()->data->annee;
        $oeuvres = Flight::request()->data->oeuvres;

        // annee en timestamp compatible postgres
        $timestamp = DateTime::createFromFormat("Y", $annee);
        $heureDate = date("Y-m-d H:i:s", $timestamp->getTimestamp());

        $saison['idtype'] = 3;
        $saison['heuredate'] = $heureDate;
        $saison['lieu'] = '';
        $saison['nom'] = $nom;

        // Ajout de la saison en base de données
        try {
            list($status, $result, $id) = E_Queries::insertSaison($saison);
            $data['success'] = $status;
        }
        catch(PDOException $e) {
            $data['success'] = false;
            $data['error'] = 'Connexion à la base de données impossible (' . $e->getMessage() . ').';
        }

        // Ajout des oeuvres dans la table est_au_programme
        if(! isset($id)) {
            $data['success'] = false;
            $data['message'] = "Impossible d'ajouter la saison " . $annee .".";
        }
        else {
            if(count($oeuvres) > 0) {   
                try {
                    
                    list($status, $result) = P_Queries::addOeuvresToProgramme($oeuvres, $id);
                    $data['success'] = true;
                    $data['message'] = "La saison " . $nom . " (" . $annee .") a bien été ajoutée à la base de données.";
                }
                catch(PDOException $e) { }
            }

        }

        // Header
        Flight::render('header.php',
            array(
                'title' => 'Ajout d\'une saison'
                ), 
            'header');

        // Navbar
        Flight::render('navbar.php',
            array(
                'activePage' => 'evenements'
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

    // Retourne true si la saison existe, false sinon
    function seasonExists($annee) {
        $returnValue = NULL;

        try {
            list($status, $result) = E_Queries::countSeasonsByYear($annee);
            $success = $status;

            if($result[0] > 0) 
                $returnValue = true;
            else
                $returnValue = false;
        }
        catch(PDOException $e) { }

        return $returnValue;
    }

    // POST /evenements
    function updateEvents() {
        $user = Flight::get('user');

        $requestEvents = Flight::request()->data['idevenement'];
        $requestPresences = Flight::request()->data['presence'];

        //récupére la présence de l'utilisateur pour chaque évènements
        try {
            list($status, $result) = E_Queries::getPresencesByLogin($user['login']);
            foreach($result as $row) {
                $id = $row['idevenement'];
                $presences[$id] = $row ;
            }

        }
        catch(PDOException $e) {
            $data['success'] = false;
            $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
        }

        //on boucle sur les présences trouvées
        for ($i = 0; $i < min(count($requestEvents), count($requestPresences)); $i++) {

            try {
                // Traitement de l'absence
                if ($requestPresences[$i] == "absent") {
                    // Suppression de l'entrée si existante
                    if(isset($presences[$requestEvents[$i]]['confirmation']))
                        list($status, $result) = E_Queries::deletePresence($requestEvents[$i], $user['idChoriste']);
                }

                // Traitement des autres cas
                else {
                    // Préparation des champs
                    $presence = array();
                    if ($requestPresences[$i] == "indecis")
                    $presence['confirmation'] = 0;
                    if ($requestPresences[$i] == "present")
                        $presence['confirmation'] = 1;
                    $presence['idchoriste'] = $user['idChoriste'];
                    $presence['idevenement'] = $requestEvents[$i];

                    // Mise à jour si quelque-chose a changé
                    if(isset($presence['confirmation'])) {

                        // Insertion de l'entrée si absente
                        if (!isset($presences[$requestEvents[$i]]['confirmation']))
                            list($status, $result) = E_Queries::insertPresence($presence);

                        // Mise à jour de l'entrée si nécessaire
                        else if ($presence['confirmation'] != $presences[$requestEvents[$i]]['confirmation']) 
                            list($status, $result) = E_Queries::updatePresence($presence);

                    }
                }

            }
            catch(PDOException $e) { }
        }
        //Affichage de la liste des évènements
        Evenements::get();
    }

}
