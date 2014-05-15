<?php

require_once 'Generic.php';

class E_Queries {

    /* --- EVENEMENTS RELATED QUERIES --- */

    function addOeuvreToProgramme($oeuvre) {

        $fetchall = False;

        $sql = "INSERT INTO est_au_programme
                VALUES ";

        $first = true;
        foreach($oeuvres as $oeuvreId) {
            if(! $first)
                $sql .= ',';
            $first = false;
            $sql .= "(" . $oeuvreId . ", " . $saisonId . ")";
        }
        $sql .= ';';

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function getOeuvres() {

        $fetchall = True;

        $sql = "SELECT titre, auteur, partition, duree, style
                FROM oeuvre
                ORDER BY style;";

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function getStyles() {

        $fetchall = True;

        $sql = "SELECT DISTINCT style
                FROM oeuvre
                ORDER BY style;";

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function getCurrentSeasonId() {

        $fetchall = False;

        $sql = "SELECT idEvenement
                FROM Evenement
                NATURAL JOIN TypeEvt
                WHERE typeEvt LIKE 'Saison'
                AND EXTRACT(YEAR from heureDate) = EXTRACT(YEAR from now());";

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function getOeuvresBySeason($id_saison) {

        $fetchall = True;

        $sql = "SELECT Oeuvre.*, nom as nomSaison
                FROM Oeuvre
                NATURAL JOIN est_au_programme
                NATURAL JOIN Evenement
                NATURAL JOIN TypeEvt
                WHERE idEvenement = " . $id_saison . "
                ORDER BY Oeuvre.style;";

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function getProgressionByChoriste($id_choriste) {

        $fetchall = True;

        $sql = "SELECT idOeuvre,Count(est_au_programme.idEvenement) AS nbEvenements
                FROM est_au_programme
                NATURAL JOIN evenement
                NATURAL JOIN participe
                WHERE idType = 2
                AND idChoriste = " . $id_choriste . "
                AND confirmation = 1";

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function getDureeByStyle($id_saison) {

        $fetchall = True;

        $sql = "SELECT style, SUM(duree) AS dureeStyle
                FROM Oeuvre
                NATURAL JOIN est_au_programme
                NATURAL JOIN Evenement
                AND idEevenement = " . $id_saison . "
                GROUP BY style, nom;";

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

}
