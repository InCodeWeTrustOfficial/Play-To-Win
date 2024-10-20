-- Ajout des contraintes de clés étrangères

-- Table p_Coachs
ALTER TABLE p_Coachs
ADD CONSTRAINT fk_Coachs_Utilisateurs FOREIGN KEY (idUtilisateur) REFERENCES p_Utilisateurs(idUtilisateur);

-- Table p_Panier
ALTER TABLE p_Panier
ADD CONSTRAINT fk_Panier_Utilisateurs FOREIGN KEY (idUtilisateur) REFERENCES p_Utilisateurs(idUtilisateur);

-- Table p_ExemplaireService
ALTER TABLE p_ExemplaireService
ADD CONSTRAINT fk_ExemplaireService_Panier FOREIGN KEY (idPanier) REFERENCES p_Panier(idPanier),
ADD CONSTRAINT fk_ExemplaireService_Coachings FOREIGN KEY (codeService) REFERENCES p_Coachings(codeService),
ADD CONSTRAINT fk_ExemplaireService_AnalysesVideo FOREIGN KEY (codeService) REFERENCES p_AnalysesVideo(codeService);

-- Table p_Coachings
ALTER TABLE p_Coachings
ADD CONSTRAINT fk_Coachings_Jeux FOREIGN KEY (nomJeu) REFERENCES p_Jeux(nomJeu),
ADD CONSTRAINT fk_Coachings_Coachs FOREIGN KEY (idUtilisateur) REFERENCES p_Coachs(idUtilisateur);

-- Table p_AnalysesVideo
ALTER TABLE p_AnalysesVideo
ADD CONSTRAINT fk_AnalysesVideo_Jeux FOREIGN KEY (nomJeu) REFERENCES p_Jeux(nomJeu),
ADD CONSTRAINT fk_AnalysesVideo_Coachs FOREIGN KEY (idUtilisateur) REFERENCES p_Coachs(idUtilisateur);

-- Table p_Parler
ALTER TABLE p_Parler
ADD CONSTRAINT fk_Parler_Utilisateurs FOREIGN KEY (idUtilisateur) REFERENCES p_Utilisateurs(idUtilisateur),
ADD CONSTRAINT fk_Parler_Langues FOREIGN KEY (code_alpha) REFERENCES p_Langues(code_alpha);

-- Table p_jouer
ALTER TABLE p_jouer
ADD CONSTRAINT fk_jouer_Jeux FOREIGN KEY (nomJeu) REFERENCES p_Jeux(nomJeu),
ADD CONSTRAINT fk_jouer_Utilisateurs FOREIGN KEY (idUtilisateur) REFERENCES p_Utilisateurs(idUtilisateur),
ADD CONSTRAINT fk_jouer_ModesDeJeu FOREIGN KEY (nomMode) REFERENCES p_ModesDeJeu(nomMode),
ADD CONSTRAINT fk_jouer_Classements FOREIGN KEY (idClassement, nomClassement, divisionClassement) 
REFERENCES p_Classements(idClassement, nomClassement, divisionClassement);

-- Table p_avoirDisponibiliteCoach
ALTER TABLE p_avoirDisponibiliteCoach
ADD CONSTRAINT fk_avoirDisponibiliteCoach_Coachs FOREIGN KEY (idUtilisateur) REFERENCES p_Coachs(idUtilisateur),
ADD CONSTRAINT fk_avoirDisponibiliteCoach_Disponibilites FOREIGN KEY (idDisponibilite) REFERENCES p_Disponibilites(idDisponibilite);

-- Table p_avoirDisponibiliteService
ALTER TABLE p_avoirDisponibiliteService
ADD CONSTRAINT fk_avoirDisponibiliteService_Disponibilites FOREIGN KEY (idDisponibilite) REFERENCES p_Disponibilites(idDisponibilite),
ADD CONSTRAINT fk_avoirDisponibiliteService_ExemplaireService FOREIGN KEY (idExemplaire) REFERENCES p_ExemplaireService(idExemplaire);