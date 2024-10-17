-- Création des nouvelles tables avec CREATE OR REPLACE
CREATE TABLE IF NOT EXISTS p_Jeux (
    nomJeu VARCHAR(50),
    logoJeu LONGBLOB,
    PRIMARY KEY(nomJeu)
);

CREATE TABLE IF NOT EXISTS p_Utilisateurs (
    idUtilisateur INT AUTO_INCREMENT,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    pseudo VARCHAR(50),
    email VARCHAR(50),
    dateDeNaissance VARCHAR(50),
    mdp VARCHAR(50),
    avatar LONGBLOB,
    PRIMARY KEY(idUtilisateur)
);

CREATE TABLE IF NOT EXISTS p_Langues (
    code_alpha VARCHAR(2),
    nom VARCHAR(50),
    drapeau LONGBLOB,
    PRIMARY KEY(code_alpha)
);

CREATE TABLE IF NOT EXISTS p_Coachs (
    idUtilisateur INT,
    BiographieCoach VARCHAR(50),
    BaniereCoach VARCHAR(50),
    PRIMARY KEY(idUtilisateur)
);

CREATE TABLE IF NOT EXISTS p_ModesDeJeu (
    nomMode VARCHAR(50),
    PRIMARY KEY(nomMode)
);

CREATE TABLE IF NOT EXISTS p_Classements (
    idClassement VARCHAR(50),
    nomClassement VARCHAR(50),
    divisionClassement VARCHAR(50),
    avatarClassement LONGBLOB,
    PRIMARY KEY(idClassement, nomClassement, divisionClassement)
);

CREATE TABLE IF NOT EXISTS p_Services (
    codeService VARCHAR(50),
    nomService VARCHAR(50),
    descriptionService TEXT,
    prixService VARCHAR(50),
    idUtilisateur INT NOT NULL,
    nomJeu VARCHAR(50) NOT NULL,
    PRIMARY KEY(codeService)
);

CREATE TABLE IF NOT EXISTS p_Disponibilites (
    idDisponibilite VARCHAR(50),
    dateDebut DATE,
    dateFin DATE,
    PRIMARY KEY(idDisponibilite)
);

CREATE TABLE IF NOT EXISTS p_Panier (
    idPanier VARCHAR(50),
    dateAchatPanier VARCHAR(50),
    idUtilisateur INT NOT NULL,
    PRIMARY KEY(idPanier)
);

CREATE TABLE IF NOT EXISTS p_ExemplaireService (
    idExemplaire VARCHAR(50),
    etatService VARCHAR(50),
    idPanier VARCHAR(50) NOT NULL,
    codeService VARCHAR(50) NOT NULL,
    PRIMARY KEY(idExemplaire)
);

CREATE TABLE IF NOT EXISTS p_Coachings (
    codeService VARCHAR(50),
    duree VARCHAR(50),
    PRIMARY KEY(codeService)
);

CREATE TABLE IF NOT EXISTS p_AnalysesVideo (
    codeService VARCHAR(50),
    tempsMaxRendu VARCHAR(50),
    PRIMARY KEY(codeService)
);

CREATE TABLE IF NOT EXISTS p_Parler (
    idUtilisateur INT,
    code_alpha VARCHAR(2),
    PRIMARY KEY(idUtilisateur, code_alpha)
);

CREATE TABLE IF NOT EXISTS p_jouer (
    nomJeu VARCHAR(50),
    idUtilisateur INT,
    nomMode VARCHAR(50),
    idClassement VARCHAR(50) NOT NULL,
    nomClassement VARCHAR(50) NOT NULL,
    divisionClassement VARCHAR(50) NOT NULL,
    PRIMARY KEY(nomJeu, idUtilisateur, nomMode)
);

CREATE TABLE IF NOT EXISTS p_avoirDisponibiliteCoach (
    idUtilisateur INT,
    idDisponibilite VARCHAR(50),
    PRIMARY KEY(idUtilisateur, idDisponibilite)
);

CREATE TABLE IF NOT EXISTS p_avoirDisponibiliteService (
    idDisponibilite VARCHAR(50),
    idExemplaire VARCHAR(50),
    PRIMARY KEY(idDisponibilite, idExemplaire)
);
