<?php

require_once 'Generic.php';

class A_Queries {

    /* --- AUTHENTICATION RELATED QUERIES --- */

    function authenticate($login) {

        $fetchall = False;

        $sql = "SELECT u.motdepasse, i.validation
                FROM Utilisateur u
                NATURAL JOIN Choriste c
                NATURAL JOIN Inscription i
                WHERE u.login LIKE '" . $login  . "'
                AND i.validation > 0;";

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function getUserDetails($login) {

        $fetchall = False;

        $sql = "SELECT u.login, i.validation, c.nom, c.prenom,c.telephone, c.ville, c.idChoriste, r.id, v.idVoix
                FROM Utilisateur u
                LEFT JOIN Choriste c ON u.login = c.login
                LEFT JOIN Voix v ON c.idVoix = v.idVoix
                LEFT JOIN Inscription i ON c.idInscription = i.idInscription
                LEFT JOIN endosse e ON u.login = e.login
                LEFT JOIN Responsabilite r ON e.id = r.id
                WHERE u.login LIKE '" . $login . "';";

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

}

