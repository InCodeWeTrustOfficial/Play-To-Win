-- Ajout des contraintes de clés étrangères

-- Table p_Coachs
ALTER TABLE p_Coachs
ADD CONSTRAINT fk_Coachs_Utilisateurs FOREIGN KEY (idCoach) REFERENCES p_Utilisateurs(idUtilisateur) ON DELETE CASCADE;

-- Table p_Commande
ALTER TABLE p_Commandes
ADD CONSTRAINT fk_Commande_Utilisateurs FOREIGN KEY (idUtilisateur) REFERENCES p_Utilisateurs(idUtilisateur) ON DELETE CASCADE;

-- Table p_Services
ALTER TABLE p_Services
ADD CONSTRAINT fk_Services_Coachs FOREIGN KEY (idCoach) REFERENCES p_Coachs(idCoach) ON DELETE CASCADE,
ADD CONSTRAINT fk_Services_Jeux FOREIGN KEY (nomJeu) REFERENCES p_Jeux(nomJeu) ON DELETE CASCADE;

-- Table p_Coachings
ALTER TABLE p_Coachings
ADD CONSTRAINT fk_Coachings_Services FOREIGN KEY (codeService) REFERENCES p_Services(codeService) ON DELETE CASCADE;

-- Table p_AnalysesVideo
ALTER TABLE p_AnalysesVideo
ADD CONSTRAINT fk_AnalysesVideo_Services FOREIGN KEY (codeService) REFERENCES p_Services(codeService) ON DELETE CASCADE;

-- Table p_Parler
ALTER TABLE p_Parler
ADD CONSTRAINT fk_Parler_Utilisateurs FOREIGN KEY (idUtilisateur) REFERENCES p_Utilisateurs(idUtilisateur) ON DELETE CASCADE,
ADD CONSTRAINT fk_Parler_Langues FOREIGN KEY (code_alpha) REFERENCES p_Langues(code_alpha) ON DELETE CASCADE;

-- Table p_jouer
ALTER TABLE p_jouer
ADD CONSTRAINT fk_jouer_Jeux FOREIGN KEY (nomJeu) REFERENCES p_Jeux(nomJeu) ON DELETE CASCADE,
ADD CONSTRAINT fk_jouer_Utilisateurs FOREIGN KEY (idUtilisateur) REFERENCES p_Utilisateurs(idUtilisateur) ON DELETE CASCADE,
ADD CONSTRAINT fk_jouer_ModesDeJeu FOREIGN KEY (nomMode) REFERENCES p_ModesDeJeu(nomMode) ON DELETE CASCADE,
ADD CONSTRAINT fk_jouer_Classements FOREIGN KEY (idClassement, nomClassement, divisionClassement)
    REFERENCES p_Classements(idClassement, nomClassement, divisionClassement) ON DELETE CASCADE;

-- Table p_avoirDisponibiliteCoach
ALTER TABLE p_avoirDisponibiliteCoach
ADD CONSTRAINT fk_avoirDisponibiliteCoach_Coachs FOREIGN KEY (idCoach) REFERENCES p_Coachs(idCoach) ON DELETE CASCADE,
ADD CONSTRAINT fk_avoirDisponibiliteCoach_Disponibilites FOREIGN KEY (idDisponibilite) REFERENCES p_Disponibilites(idDisponibilite) ON DELETE CASCADE;

ALTER TABLE p_avoirReserve
ADD CONSTRAINT fk_avoirReserve_Coachs FOREIGN KEY (idCoach) REFERENCES p_Coachs(idCoach) ON DELETE CASCADE,
ADD CONSTRAINT fk_avoirReserve_Disponibilites FOREIGN KEY (idDisponibilite) REFERENCES p_Disponibilites(idDisponibilite) ON DELETE CASCADE;

-- Table p_avoirDisponibiliteService
ALTER TABLE p_avoirDisponibiliteService
ADD CONSTRAINT fk_avoirDisponibiliteService_Disponibilites FOREIGN KEY (idDisponibilite) REFERENCES p_Disponibilites(idDisponibilite) ON DELETE CASCADE,
ADD CONSTRAINT fk_avoirDisponibiliteService_ExemplaireService FOREIGN KEY (idExemplaire) REFERENCES p_ExemplaireService(idExemplaire) ON DELETE CASCADE;

-- Table p_ExemplaireService
ALTER TABLE p_ExemplaireService
ADD CONSTRAINT fk_ExemplaireService_Commande FOREIGN KEY (idCommande) REFERENCES p_Commandes(idCommande) ON DELETE CASCADE,
ADD CONSTRAINT fk_ExemplaireService_Services FOREIGN KEY (codeService) REFERENCES p_Services(codeService) ON DELETE CASCADE;