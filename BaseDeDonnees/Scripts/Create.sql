-- Création des tables sans contraintes de clés étrangères

CREATE TABLE IF NOT EXISTS p_Jeux (
    nomJeu VARCHAR(50),
    PRIMARY KEY(nomJeu)
);

CREATE TABLE IF NOT EXISTS p_Utilisateurs (
    idUtilisateur VARCHAR(32),
    nom VARCHAR(32),
    prenom VARCHAR(32),
    pseudo VARCHAR(32),
    email VARCHAR(256),
    emailAValider VARCHAR(256),
    nonce VARCHAR(32),
    dateDeNaissance DATE,
    mdpHache VARCHAR(256),
    estAdmin TINYINT(1),
    PRIMARY KEY(idUtilisateur)
);

CREATE TABLE IF NOT EXISTS p_Langues (
    code_alpha VARCHAR(2),
    nom VARCHAR(50),
    PRIMARY KEY(code_alpha)
);

CREATE TABLE IF NOT EXISTS p_Coachs (
    idCoach VARCHAR(32),
    biographieCoach VARCHAR(50),
    PRIMARY KEY(idCoach)
);

CREATE TABLE IF NOT EXISTS p_ModesDeJeu (
    nomMode VARCHAR(50),
    PRIMARY KEY(nomMode)
);

CREATE TABLE IF NOT EXISTS p_Classements (
    idClassement VARCHAR(50),
    nomClassement VARCHAR(50),
    divisionClassement VARCHAR(50),
    PRIMARY KEY(idClassement, nomClassement, divisionClassement)
);

CREATE TABLE IF NOT EXISTS p_Disponibilites (
    idDisponibilite VARCHAR(50),
    dateDebut DATE,
    dateFin DATE,
    PRIMARY KEY(idDisponibilite)
);

CREATE TABLE IF NOT EXISTS p_Commandes (
    idCommande VARCHAR(50),
    dateAchatCommande DATE,
    idUtilisateur VARCHAR(32) NOT NULL,
    PRIMARY KEY(idCommande)
);

CREATE TABLE IF NOT EXISTS p_ExemplaireService (
    idExemplaire VARCHAR(50),
    etatService VARCHAR(50),
    sujet VARCHAR(256),
    idCommande VARCHAR(50) NOT NULL,
    codeService INT NOT NULL,
    quantite INT,
    PRIMARY KEY(idExemplaire)
);

CREATE TABLE IF NOT EXISTS p_Services (
    codeService INT AUTO_INCREMENT,
    nomService VARCHAR(50),
    descriptionService TEXT,
    prixService FLOAT,
    idCoach VARCHAR(32) NOT NULL,
    nomJeu VARCHAR(50) NOT NULL,
    PRIMARY KEY(codeService)
);

CREATE TABLE IF NOT EXISTS p_Coachings (
    codeService INT,
    duree INT,
    PRIMARY KEY(codeService)
);

CREATE TABLE IF NOT EXISTS p_AnalysesVideo (
    codeService INT,
    nbJourRendu INT,
    PRIMARY KEY(codeService)
);



CREATE TABLE IF NOT EXISTS p_Parler (
    idUtilisateur VARCHAR(32),
    code_alpha VARCHAR(2),
    PRIMARY KEY(idUtilisateur, code_alpha)
);

CREATE TABLE IF NOT EXISTS p_jouer (
    nomJeu VARCHAR(50),
    idUtilisateur VARCHAR(32),
    nomMode VARCHAR(50),
    idClassement VARCHAR(50) NOT NULL,
    nomClassement VARCHAR(50) NOT NULL,
    divisionClassement VARCHAR(50) NOT NULL,
    PRIMARY KEY(nomJeu, idUtilisateur, nomMode)
);

CREATE TABLE IF NOT EXISTS p_avoirDisponibiliteCoach (
    idCoach VARCHAR(32),
    idDisponibilite VARCHAR(50),
    PRIMARY KEY(idCoach, idDisponibilite)
);
CREATE TABLE IF NOT EXISTS p_avoirReserve (
    idCoach VARCHAR(32),
    idDisponibilite VARCHAR(50),
    PRIMARY KEY(idCoach, idDisponibilite)
);

CREATE TABLE IF NOT EXISTS p_avoirDisponibiliteService (
    idDisponibilite VARCHAR(50),
    idExemplaire VARCHAR(50),
    PRIMARY KEY(idDisponibilite, idExemplaire)
);
