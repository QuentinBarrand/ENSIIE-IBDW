INSERT INTO Utilisateur(login, motdepasse)
VALUES ('Müller Chris', md5('*2012-05-03*'));

INSERT INTO Utilisateur(login, motdepasse)
VALUES ('Müller Chris', md5('*2012-05-03*'));
/* ERREUR:  la valeur d'une clé dupliquée rompt la contrainte unique « pk_utilisateur » */


INSERT INTO Utilisateur(login, motdepasse)
VALUES ('Mylène P.', md5(''));

INSERT INTO Utilisateur(login, motdepasse)
VALUES ('Raj Shankar Sivasubramaniam', md5('1789/12/03-$'));

INSERT INTO Voix(typeVoix)
VALUES ('');
/* ERREUR:  une valeur NULL viole la contrainte NOT NULL de la colonne « idvoix » */

INSERT INTO oeuvre(idoeuvre, titre, auteur, partition, duree, style)
VALUES (3, 'Column of sadness', 'Steeve Edward', 'http://www.youtube.com/~theme_song12345647847', '00:00:30', 'classique');
/* ERREUR:  syntaxe en entrée invalide pour l'entier : « 00:00:30 » */


INSERT INTO oeuvre(idoeuvre, titre, auteur, partition, duree, style)
VALUES (3, 'Column of sadness', 'Steeve Edward', 'http://www.youtube.com/~theme_song12345647847\12"', '30', 'classique');
/* ERREUR:  valeur trop longue pour le type character varying(45) */


INSERT INTO oeuvre(idoeuvre, titre, auteur, partition, duree, style)
VALUES (5, 'Les violons', 'Jean Eude', 'http://www.youtube.com/~violons12345647847\12"', '300000', 'baroque');
/* ERREUR:  la valeur « 300000 » est en dehors des limites du type smallint */

INSERT INTO Evenement(idEvenement, idType, heuredate, lieu, nom)
ibdw-> VALUES (4, 2, '2014-05-24 10:00:00', '41, allée des rosignols 65170 Tarbes', 'Saison printemps-été 2014');
/* ERREUR:  une instruction insert ou update sur la table « evenement » viole la contrainte de clé
étrangère « fk_typeevt »
DÉTAIL : La clé (idtype)=(2) n'est pas présente dans la table « typeevt ». */



