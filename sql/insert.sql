DELETE FROM Responsabilite;
DELETE FROM Utilisateur;
DELETE FROM Voix;
DELETE FROM Choriste;
DELETE FROM Inscription;
DELETE FROM Evenement;
DELETE FROM TypeEvt;
DELETE FROM participe;
DELETE FROM Oeuvre;
DELETE FROM est_au_programme;

-- INSERT INTO Utilisateur(login, motdepasse)
-- VALUES ('ssabatier', crypt('ssabatier', gen_salt('bf')));
-- INSERT INTO Utilisateur(login, motdepasse)
-- VALUES ('mpaume', crypt('mpaume', gen_salt('bf')));
-- INSERT INTO Utilisateur(login, motdepasse)
-- VALUES ('qbarrand', crypt('qbarrand', gen_salt('bf')));
-- INSERT INTO Utilisateur(login, motdepasse)
-- VALUES ('gbriquet', crypt('gbriquet', gen_salt('bf')));
-- INSERT INTO Utilisateur(login, motdepasse)
-- VALUES ('gmonier', crypt('gmonier', gen_salt('bf')));
-- INSERT INTO Utilisateur(login, motdepasse)
-- VALUES ('tsarboni', crypt('tsarboni', gen_salt('bf')));
-- INSERT INTO Utilisateur(login, motdepasse)
-- VALUES ('ddiallo', crypt('ddiallo', gen_salt('bf')));

INSERT INTO Utilisateur(login, motdepasse)
VALUES ('ssabatier', md5('ssabatier'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('mpaume', md5('mpaume'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('qbarrand', md5('qbarrand'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('gbriquet', md5('gbriquet'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('gmonier', md5('gmonier'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('tsarboni', md5('tsarboni'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('ddiallo', md5('ddiallo'));

INSERT INTO Responsabilite(titre, login)
VALUES ('Chef de coeur', 'ddiallo');
INSERT INTO Responsabilite(titre, login)
VALUES ('Tresorier', 'ssabatier');
INSERT INTO Responsabilite(titre, login)
VALUES ('Webmaster', 'qbarrand');

INSERT INTO Inscription(idInscription, type_inscr, montant, annee)
VALUES (1, 'etudiant', '200', '2014');

INSERT INTO Voix(idVoix, typeVoix)
VALUES (1, 'alto');
INSERT INTO Voix(idVoix, typeVoix)
VALUES (2, 'soprano');
INSERT INTO Voix(idVoix, typeVoix)
VALUES (3, 'tenor');
INSERT INTO Voix(idVoix, typeVoix)
VALUES (4, 'bass');

INSERT INTO Choriste(idChoriste ,nom ,prenom ,idVoix ,ville ,telephone ,login ,idInscription)
VALUES (1, 'sarboni', 'thomas', 1, 'angers', '0601020304', 'tsarboni', 1);
INSERT INTO Choriste(idChoriste ,nom ,prenom ,idVoix ,ville ,telephone ,login ,idInscription)
VALUES (2, 'sabatier', 'sébastien', 4, 'bordeaux', '0602030405', 'ssabatier', 1);
INSERT INTO Choriste(idChoriste ,nom ,prenom ,idVoix ,ville ,telephone ,login ,idInscription)
VALUES (3, 'paume', 'mylène', 2, 'sarcelles', '0603040506', 'mpaume', 1);
INSERT INTO Choriste(idChoriste ,nom ,prenom ,idVoix ,ville ,telephone ,login ,idInscription)
VALUES (4, 'barrand', 'quentin', 3, 'taverny', '0604050607', 'qbarrand', 1);
INSERT INTO Choriste(idChoriste ,nom ,prenom ,idVoix ,ville ,telephone ,login ,idInscription)
VALUES (5, 'briquet', 'gaétan', 1, 'amiens', '0605060708', 'gbriquet', 1);

INSERT INTO TypeEvt(idType, typeEvt)
VALUES (1, 'Concert');
INSERT INTO TypeEvt(idType, typeEvt)
VALUES (2, 'Répétition');
INSERT INTO TypeEvt(idType, typeEvt)
VALUES (3, 'Saison');

INSERT INTO Evenement(idEvenement, idType, heuredate, lieu, nom)
VALUES (1, 2, '2014-01-09 14:00:00', '12 rue de la pétanque 33170 Gradignan', 'Préparation au concert du 6 avril');
INSERT INTO Evenement(idEvenement, idType, heuredate, lieu, nom)
VALUES (2, 2, '2014-01-29 10:30:00', '12 rue de la pétanque 33170 Gradignan', 'Sychronisation intruments/choeur');
INSERT INTO Evenement(idEvenement, idType, heuredate, lieu, nom)
VALUES (3, 2, '2014-02-20 18:00:00', '12 rue de la voile 33500 Arcachon', 'Raccord choeur');
INSERT INTO Evenement(idEvenement, idType, heuredate, lieu, nom)
VALUES (4, 2, '2014-05-24 10:00:00', '12 rue de la pétanque 33170 Gradignan', 'Répétition générale concert 1');
INSERT INTO Evenement(idEvenement, idType, heuredate, lieu, nom)
VALUES (5, 1, '2014-01-25 11:00:00', '12 rue du surf 33850 Lacanau', 'Messe de requiem');
INSERT INTO Evenement(idEvenement, idType, heuredate, lieu, nom)
VALUES (6, 3, '2014-01-25 11:00:00', 'Salle de la cour', 'Saison 2014-2015');

INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (1, 1, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (2, 1, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (1, 2, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (2, 2, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (1, 3, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (2, 3, 1);
INSERT INTO participe(idChoriste, idEvenement)
VALUES (1, 5);
INSERT INTO participe(idChoriste, idEvenement)
VALUES (2, 5);

INSERT INTO oeuvre(idoeuvre, titre, auteur, partition, duree, style)
VALUES (1, '51 je taime', 'René Pastis', 'http://', '60', 'chanson à boire');
INSERT INTO oeuvre(idoeuvre, titre, auteur, partition, duree, style)
VALUES (2, 'Passion selon jéjé', 'Bébert Dupuis', 'http://', '60', 'baroque');
INSERT INTO oeuvre(idoeuvre, titre, auteur, partition, duree, style)
VALUES (3, 'Cantate de la mare', 'BACH Jérome', 'http://', '60', 'chanson à boire');
INSERT INTO oeuvre(idoeuvre, titre, auteur, partition, duree, style)
VALUES (4, 'Requiem pour un con', 'Gainsbourg Serge', 'http://', '75', 'chanson à boire');
INSERT INTO oeuvre(idoeuvre, titre, auteur, partition, duree, style)
VALUES (5, 'Requiem de ouf', 'Wolfgang Amadeus', 'http://', '60', 'chanson à boire');

INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (1, 1);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (2, 1);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (3, 1);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (2, 2);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (3, 2);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (4, 2);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (4, 3);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (5, 3);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (1, 3);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (5, 4);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (1, 4);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (2, 4);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (1, 5);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (2, 5);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (3, 5);
--Saison
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (1, 6);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (2, 6);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (3, 6);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (4, 6);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (5, 6);

