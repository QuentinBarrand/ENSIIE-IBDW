DROP TABLE IF EXISTS responsabilite CASCADE;
DROP TABLE IF EXISTS choriste CASCADE;
DROP TABLE IF EXISTS inscription CASCADE;
DROP TABLE IF EXISTS utilisateur CASCADE;
DROP TABLE IF EXISTS evenement CASCADE;
DROP TABLE IF EXISTS participe CASCADE;
DROP TABLE IF EXISTS oeuvre CASCADE;
DROP TABLE IF EXISTS est_au_programme CASCADE;

create table Utilisateur (
login varchar(45),
motdepasse bytea NOT NULL,
constraint pk_utilisateur PRIMARY KEY(login))
;

create table Responsabilite (
titre varchar(30),
login varchar(45) NOT NULL,
constraint pk_titre PRIMARY KEY(titre),
constraint fk_responsabilite_user foreign key (login) references Utilisateur (login))
;

create table Inscription (
idInscription smallint,
type_inscr varchar(10) NOT NULL,
montant decimal NOT NULL,
annee varchar(10) NOT NULL,
constraint pk_idInscription PRIMARY KEY(idInscription)
);

create table Choriste (
idChoriste smallint,
nom varchar(45) NOT NULL,
prenom varchar(45) NOT NULL,
typeVoix char NOT NULL,
ville varchar(45) NOT NULL,
telephone varchar(30) NOT NULL,
login varchar(45) NOT NULL,
idInscription smallint,
constraint pk_idChoriste PRIMARY KEY(idChoriste),
constraint fk_utilisateur foreign key (login) references Utilisateur (login) ON DELETE CASCADE,
constraint fk_voix foreign key (typeVoix) references Voix (typeVoix) ON DELETE CASCADE,
constraint fk_inscription foreign key (idInscription) references Inscription (idInscription)
);

create table Voix (
idVoix smallint,
typeVoix varchar(45) NOT NULL,
constraint pk_idVoix PRIMARY KEY(idVoix)
);

create table evenement (
idEvenement smallint,
typeEvt varchar(45) NOT NULL,
heureDate timestamp NOT NULL,
lieu varchar(45) NOT NULL,
nom varchar(45) NOT NULL,
constraint fk_evt foreign key (typeEvt) references TypeEvt (typeEvt) ON DELETE CASCADE,
constraint pk_idEvenement PRIMARY KEY(idEvenement)
);

create table TypeEvt (
idType smallint,
typeEvt varchar(45) NOT NULL,
constraint pk_idType PRIMARY KEY(idType)
);

create table participe (
Choriste_idChoriste smallint,
Evenement_IdEvenement smallint,
constraint pk_participe PRIMARY KEY (Choriste_idChoriste, Evenement_IdEvenement),
constraint fk_participe_choriste foreign key (Choriste_idChoriste) references Choriste (idChoriste) ON DELETE CASCADE,
constraint fk_participe_evenement foreign key (Evenement_IdEvenement) references Evenement (idEvenement) ON DELETE CASCADE
);

create table oeuvre (
idOeuvre smallint,
titre varchar(45),
auteur varchar(45),
partition varchar(45),
duree smallint,
style varchar(45),
constraint pk_oeuvre PRIMARY KEY (idOeuvre)
);

create table est_au_programme (
oeuvre_idOeuvre smallint,
Evenement_IdEvenement smallint,
constraint pk_est_au_programme PRIMARY KEY (oeuvre_idOeuvre, Evenement_IdEvenement),
constraint fk_programme_oeuvre foreign key (oeuvre_idOeuvre) references Oeuvre (idOeuvre) ON DELETE CASCADE,
constraint fk_programme_evenement foreign key (Evenement_IdEvenement) references Evenement (idEvenement) ON DELETE CASCADE
);
