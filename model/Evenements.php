<?php

require_once 'Generic.php';

class Queries {

    /* --- EVENEMENTS RELATED QUERIES --- */

    function getEvenements($voix, $user = NULL) {

        $fetchall = True;

        $sql = 'SELECT idEvenement, heureDate, lieu, nom, idType
                FROM Evenement
                NATURAL JOIN TypeEvt ';
        if (! $user) {
            $sql .= "WHERE typeEvt LIKE 'Concert' ";
        }
        $sql .= 'ORDER BY heureDate DESC;';

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }
}

