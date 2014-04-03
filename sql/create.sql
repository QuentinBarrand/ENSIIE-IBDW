DROP TABLE IF EXISTS Responsabilite CASCADE;
DROP TABLE IF EXISTS Choriste CASCADE;
DROP TABLE IF EXISTS Inscription CASCADE;
DROP TABLE IF EXISTS Utilisateur CASCADE;
DROP TABLE IF EXISTS endosse CASCADE;
DROP TABLE IF EXISTS Voix CASCADE;
DROP TABLE IF EXISTS Evenement CASCADE;
DROP TABLE IF EXISTS TypeEvt CASCADE;
DROP TABLE IF EXISTS participe CASCADE;
DROP TABLE IF EXISTS Oeuvre CASCADE;
DROP TABLE IF EXISTS est_au_programme CASCADE;

--CREATE EXTENSION pgcrypto;

create table Utilisateur (
    login varchar(45),
    motdepasse text NOT NULL,
    constraint pk_utilisateur PRIMARY KEY(login)
);

create table Responsabilite (
    id smallint,
    titre varchar(30),
    constraint pk_id PRIMARY KEY(id)
);

create table endosse (
    login varchar(45) unique,
    id smallint unique,
    constraint pk_endosse PRIMARY KEY (login, id),
    constraint fk_responsabilite foreign key (login) references Utilisateur (login) ON DELETE CASCADE,
    constraint fk_utilisateur foreign key (id) references Responsabilite (id) ON DELETE CASCADE
);

create table Inscription (
    idInscription smallint,
    typeInscription varchar(10) NOT NULL,
    montant decimal NOT NULL,
    annee varchar(10) NOT NULL,
    validation smallint DEFAULT 0,
    constraint pk_idInscription PRIMARY KEY(idInscription)
);

create table Voix (
    idVoix smallint,
    typeVoix varchar(45) NOT NULL,
    constraint pk_idVoix PRIMARY KEY(idVoix)
);

create table Choriste (
    idChoriste smallint,
    nom varchar(45) NOT NULL,
    prenom varchar(45) NOT NULL,
    idVoix smallint NOT NULL,
    ville varchar(45) NOT NULL,
    telephone varchar(30) NOT NULL,
    login varchar(45) NOT NULL,
    idInscription smallint,
    constraint pk_idChoriste PRIMARY KEY(idChoriste),
    constraint fk_utilisateur foreign key (login) references Utilisateur (login) ON DELETE CASCADE,
    constraint fk_voix foreign key (idVoix) references Voix (idVoix) ON DELETE CASCADE,
    constraint fk_inscription foreign key (idInscription) references Inscription (idInscription)
);

create table TypeEvt (
    idType smallint,
    typeEvt varchar(45) NOT NULL,
    constraint pk_idType PRIMARY KEY(idType)
);

create table Evenement (
    idEvenement smallint,
    idType smallint NOT NULL,
    heureDate timestamp NOT NULL,
    lieu varchar(45) NOT NULL,
    nom varchar(45) NOT NULL,
    constraint pk_idEvenement PRIMARY KEY(idEvenement),
    constraint fk_typeEvt foreign key (idType) references TypeEvt (idType) ON DELETE CASCADE
);

create table participe (
    idChoriste smallint NOT NULL,
    idEvenement smallint NOT NULL,
    confirmation smallint DEFAULT NULL,
    constraint pk_participe PRIMARY KEY (idChoriste, idEvenement),
    constraint fk_participe_choriste foreign key (idChoriste) references Choriste (idChoriste) ON DELETE CASCADE,
    constraint fk_participe_evenement foreign key (idEvenement) references Evenement (idEvenement) ON DELETE CASCADE
);

create table Oeuvre (
    idOeuvre smallint,
    titre varchar(45),
    auteur varchar(45),
    partition varchar(45),
    duree smallint,
    style varchar(45),
    constraint pk_oeuvre PRIMARY KEY (idOeuvre)
);

create table est_au_programme (
    idOeuvre smallint,
    idEvenement smallint,
    constraint pk_est_au_programme PRIMARY KEY (idOeuvre, idEvenement),
    constraint fk_programme_oeuvre foreign key (idOeuvre) references Oeuvre (idOeuvre) ON DELETE CASCADE,
    constraint fk_programme_evenement foreign key (idEvenement) references Evenement (idEvenement) ON DELETE CASCADE
);
