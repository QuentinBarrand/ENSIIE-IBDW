<?php

require_once 'Generic.php';

class C_Queries {

    /* --- CHORISTES RELATED QUERIES --- */

    function getChoristes() {

        $fetchall = True;

        $sql = 'SELECT nom, prenom, typeVoix, ville, telephone, titre as responsabilite, SUM(participe.confirmation) as participations
                FROM Choriste
                LEFT JOIN participe ON Choriste.idChoriste = participe.idChoriste
                NATURAL JOIN Voix
                NATURAL JOIN Utilisateur
                LEFT JOIN Endosse ON Utilisateur.login = Endosse.login
                LEFT JOIN Responsabilite ON Endosse.id = Responsabilite.id
                WHERE Endosse.id IS NULL OR Endosse.id != 1
                GROUP BY Choriste.idChoriste, nom, prenom, typeVoix, ville, telephone, responsabilite
                ORDER BY typeVoix;';

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function getVoix() {

        $fetchall = True;

        $sql = 'SELECT idvoix, typevoix FROM Voix;';

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function getIdVoixFromType($type) {

        $fetchall = False;

        $sql = "SELECT idvoix FROM Voix WHERE typevoix = '" . $type . "';";

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function getNbChoristesFromLogin($login) {

        $fetchall = False;

        $sql = "SELECT COUNT(*) FROM Choriste WHERE login = '" . $login . "';";

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function getPasswordFromLogin($login) {

        $fetchall = False;

        $sql = "SELECT motdepasse FROM Utilisateur WHERE login = '" . $login . "';";

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function insertUser($user) {

        $fetchall = False;

        list($fields, $values) = Query::getFields($user);

        $sql = 'INSERT INTO Utilisateur (' . $fields . ')
                VALUES (' . $values . ');';

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function insertInscription($inscription) {

        $fetchall = False;

        list($fields, $values) = Query::getFields($inscription);

        $sql = 'INSERT INTO Inscription (' . $fields . ')
                VALUES (' . $values . ');';

        $id_sql = "SELECT currval('inscription_idinscription_seq');";

        list($success, $result) = Query::execute($sql, $fetchall);
        list($success, $id_result) = Query::execute($id_sql, $fetchall);
        return array($success, $result, $id_result[0]);
    }

    function insertChoriste($choriste) {

        $fetchall = False;

        list($fields, $values) = Query::getFields($choriste);

        $sql = 'INSERT INTO Choriste (' . $fields . ')
                VALUES (' . $values . ');';

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function updateUser($user) {

        $fetchall = False;

        $sql = "UPDATE Utilisateur
                SET motdepasse = '" . $user['motdepasse'] . "'
                WHERE login = '" . $user['login'] . "';";

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function updateChoriste($choriste) {

        $fetchall = False;

        list($fields, $values) = Query::getFields($choriste);

        $sql = 'UPDATE Choriste SET ';
        for($i=count($fields); $i > 0; $i--) {
            $sql .= $fields[$i] . ' = ' . $values[$i];
            if($i != 1)
                $sql .= ',';
        }
        $sql .= "WHERE login = '" . $choriste['login'] . ";";

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

}

