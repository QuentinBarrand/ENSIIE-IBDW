<?php

class Evenements {

    // GET /evenements
    function get() {
        try {
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
            $data['success'] = false;
            $data['error'] = 'Connexion à la base de données impossible (' . $e->getMessage() . ').';
        }

        // On récupère tous les évènements
        $sql1 = "SELECT idEvenement, heureDate, lieu, nom 
            FROM evenement
            NATURAL JOIN TypeEvt
            WHERE typeEvt LIKE 'Concert' 
            ORDER BY heureDate DESC;";

        $voix = Choristes::getVoix();

        $sql2 = 'SELECT Evenement.idEvenement, heureDate, lieu, nom';

        foreach($voix as $v)
            $sql2 .= ', nbc_' . $v['idvoix'];


        $sql2 .= ' FROM Evenement
                  NATURAL JOIN TypeEvt ';

        foreach($voix as $v)
            $sql2 .= 'LEFT OUTER JOIN (
                          SELECT idEvenement, count(participe.idChoriste) as nbc_' . $v['idvoix'] . '
                          FROM participe
                          NATURAL JOIN Choriste
                          WHERE idVoix = ' . $v['idvoix'] . '
                          AND confirmation = 1
                          GROUP BY idEvenement
                        ) as view_nbvoix_' . $v['idvoix'] . '
                      ON Evenement.idEvenement = view_nbvoix_' . $v['idvoix'] . '.idEvenement ';

        $sql2 .= "WHERE typeEvt='Concert'
                  ORDER BY heureDate DESC;";

        if($db) {
            try {
                // SQL 1
                $query = $db->prepare($sql1);
                $query->execute();

                $data['success'] = true;
                $data['content'] = $query->fetchAll();

                // SQL2
                $query = $db->prepare($sql2);
                $query->execute();

                $result = $query->fetchAll();
                // var_dump($sql2);
                // echo '<pre>';
                // var_dump($result);
                // echo '</pre>';
                // die;
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

    // GET /evenements/nouveau
    function displayEventForm() {
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
            array(), 
            'footer');

        $user = Flight::get('user');

        if($user['authenticated'] && $user['responsabilite'] == 1)
            Flight::render('EvenementNewLayout.php');
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
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
        }

        $sql = 'SELECT count(idEvenement) as TotalRepetitions
                    FROM Evenement
                    WHERE idType = ' . $type . ';';

        $count = NULL;

        if($db) {
            try {
                $query = $db->prepare($sql);
                $query->execute();

                $result = $query->fetch();
                $count = $result[0];
            }
            catch(PDOException $e) { }
        }

        return $count;
    }

    // POST /evenements/nouveau
    function add() {
        // Récupération des données POST
        $nom   = Flight::request()->data->nom;
        $lieu  = Flight::request()->data->lieu;
        $date  = Flight::request()->data->date;
        $heure = Flight::request()->data->heure;
        $type  = Flight::request()->data->type;

        $timestamp = DateTime::createFromFormat("d/m/Y", $date);
        $annee = date("Y", $timestamp->getTimestamp());

        switch($type) {
            case 'repetition':
            case 'concert':
                Evenements::addEvent($nom, $lieu, $date, $heure, $type);
                break;

            case 'saison':
                Evenements::displaySaisonForm($nom, $annee);
                break;
        }
    }

    // Fonction d'ajout d'une répétition ou d'un concert
    function addEvent($nom, $lieu, $date, $heure, $type) {
        try {
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
            $data['success'] = false;
            $data['error'] = 'Connexion à la base de données impossible (' . $e->getMessage() . ').';
        }

        // On insère l'évènement courant
        $sql = "INSERT INTO Evenement(idType, heureDate, lieu, nom)
            VALUES(:idType, :heureDate, :lieu, :nom)
            RETURNING idEvenement;";

        switch($type) {
            case 'repetition':
                $idType = 1;
                break;

            case 'concert':
                $idType = 2;
                break;
        }

        // Traitement heureDate
        $timestamp = DateTime::createFromFormat("d/m/Y", $date);
        $heureDate = date("Y-m-d H:i:s", $timestamp->getTimestamp());

        if($db) {
            try {
                $query = $db->prepare($sql);
                $query->execute(array(
                    ':idType' => $idType,
                    ':heureDate' => $heureDate,
                    ':lieu' => $lieu,
                    ':nom' => $nom
                    )
                );

                $data['success'] = true;
                $data['message'] = "L'évènement <b>" . $nom . "</b> a bien été ajouté.";
            }
            catch(PDOException $e) {
                $data['success'] = false;
                $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
            }
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

        try {
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
            $data['success'] = false;
            $data['error'] = 'Connexion à la base de données impossible (' . $e->getMessage() . ').';
        }

        // On insère l'évènement courant
        $sql = "INSERT INTO Oeuvre(titre, auteur, partition, duree, style)
            VALUES(:titre, :auteur, :partition, :duree, :style)
            RETURNING idOeuvre;";

        if($db) {
            try {
                $query = $db->prepare($sql);
                $query->execute(array(
                    ':titre' => $titre,
                    ':auteur' => $auteur,
                    ':partition' => $partition,
                    ':duree' => $duree,
                    ':style' => $style
                    )
                );

                $data['success'] = true;
                $data['message'] = "L'oeuvre <b>" . $titre . "</b> a bien été ajouté.";
            }
            catch(PDOException $e) {
                $data['success'] = false;
                $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
            }
        }

        Evenements::displaySaisonForm($nom, $annee, $data['message']);
    }

    // GET 
    function addSaison() {
        // Récupération des oeuvres et ajout dans la base de données
    }
}
