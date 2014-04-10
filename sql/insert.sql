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

INSERT INTO Responsabilite(titre)
VALUES ('Chef de coeur');
INSERT INTO Responsabilite(titre)
VALUES ('Tresorier');
INSERT INTO Responsabilite(titre)
VALUES ('Webmaster');

INSERT INTO endosse(login, id)
VALUES ('ddiallo', 1);
INSERT INTO endosse(login, id)
VALUES ('ssabatier', 2);
INSERT INTO endosse(login, id)
VALUES ('qbarrand', 3);

INSERT INTO Inscription(idInscription, typeInscription, montant, annee, validation)
VALUES (1, 'etudiant', '200', '2014', 3);

INSERT INTO Voix(typeVoix)
VALUES ('alto');
INSERT INTO Voix(typeVoix)
VALUES ('soprano');
INSERT INTO Voix(typeVoix)
VALUES ('tenor');
INSERT INTO Voix(typeVoix)
VALUES ('bass');

INSERT INTO Choriste(nom, prenom, idVoix, ville, telephone, login ,idInscription)
VALUES ('sarboni', 'thomas', 1, 'angers', '0601020304', 'tsarboni', 1);
INSERT INTO Choriste(nom, prenom, idVoix, ville, telephone, login)
VALUES ('sabatier', 'sébastien', 4, 'bordeaux', '0602030405', 'ssabatier');
INSERT INTO Choriste(nom, prenom, idVoix, ville, telephone, login)
VALUES ('paume', 'mylène', 2, 'sarcelles', '0603040506', 'mpaume');
INSERT INTO Choriste(nom, prenom, idVoix, ville, telephone, login)
VALUES ('barrand', 'quentin', 3, 'taverny', '0604050607', 'qbarrand');
INSERT INTO Choriste(nom, prenom, idVoix, ville, telephone, login)
VALUES ('briquet', 'gaétan', 1, 'amiens', '0605060708', 'gbriquet');

INSERT INTO TypeEvt(typeEvt)
VALUES ('Concert');
INSERT INTO TypeEvt(typeEvt)
VALUES ('Répétition');
INSERT INTO TypeEvt(typeEvt)
VALUES ('Saison');

INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (2, '2014-01-09 14:00:00', '12 rue de la pétanque 33170 Gradignan', 'Préparation au concert du 6 avril');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (2, '2014-01-29 10:30:00', '12 rue de la pétanque 33170 Gradignan', 'Sychronisation intruments/choeur');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (2, '2014-02-20 18:00:00', '12 rue de la voile 33500 Arcachon', 'Raccord choeur');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (2, '2014-05-24 10:00:00', '12 rue de la pétanque 33170 Gradignan', 'Répétition générale concert 1');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (1, '2014-01-25 11:00:00', '12 rue du surf 33850 Lacanau', 'Messe de requiem');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (3, '2014-01-25 11:00:00', 'Salle de la cour', 'Saison 2014-2015');

-- Ajout de concerts
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (1, '2014-01-25 11:00:00', 'Lieu1', 'Evènement 1');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (1, '2014-02-25 11:00:00', 'Lieu2', 'Evènement 2');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (1, '2014-03-25 11:00:00', 'Lieu3', 'Evènement 3');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (1, '2014-04-25 11:00:00', 'Lieu4', 'Evènement 4');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (1, '2014-05-25 11:00:00', 'Lieu5', 'Evènement 5');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (1, '2014-06-25 11:00:00', 'Lieu6', 'Evènement 6');


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

INSERT INTO oeuvre(titre, auteur, partition, duree, style)
VALUES ('51 je taime', 'René Pastis', 'http://', '60', 'chanson à boire');
INSERT INTO oeuvre(titre, auteur, partition, duree, style)
VALUES ('Passion selon jéjé', 'Bébert Dupuis', 'http://', '60', 'baroque');
INSERT INTO oeuvre(titre, auteur, partition, duree, style)
VALUES ('Cantate de la mare', 'BACH Jérome', 'http://', '60', 'chanson à boire');
INSERT INTO oeuvre(titre, auteur, partition, duree, style)
VALUES ('Requiem pour un con', 'Gainsbourg Serge', 'http://', '75', 'chanson à boire');
INSERT INTO oeuvre(titre, auteur, partition, duree, style)
VALUES ('Requiem de ouf', 'Wolfgang Amadeus', 'http://', '60', 'chanson à boire');

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

