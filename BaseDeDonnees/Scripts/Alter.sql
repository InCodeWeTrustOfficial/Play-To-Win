-- p_Coach
ALTER TABLE p_Coach ADD CONSTRAINT fk_coach_utilisateur
    FOREIGN KEY (idCoach) REFERENCES p_Utilisateurs(idUtilisateur);

-- p_Services
ALTER TABLE p_Services ADD CONSTRAINT fk_services_jeux
    FOREIGN KEY (nomJeux) REFERENCES p_Jeux(nomJeux);

-- p_Coaching
ALTER TABLE p_Coaching ADD CONSTRAINT fk_coaching_service
    FOREIGN KEY (code_service) REFERENCES p_Services(code_service);

-- p_Analyse_video
ALTER TABLE p_Analyse_video ADD CONSTRAINT fk_analyse_service
    FOREIGN KEY (code_service) REFERENCES p_Services(code_service);

-- p_Classement_Info
ALTER TABLE p_Classement_Info ADD CONSTRAINT fk_classement_jeux
    FOREIGN KEY (nomJeux) REFERENCES p_Jeux(nomJeux);

-- p_Panier
ALTER TABLE p_Panier ADD CONSTRAINT fk_panier_utilisateur
    FOREIGN KEY (idUtilisateur) REFERENCES p_Utilisateurs(idUtilisateur);

-- p_Mode
ALTER TABLE p_Mode ADD CONSTRAINT fk_mode_classement1
    FOREIGN KEY (idClassement) REFERENCES p_Classement_Info(idClassement);

ALTER TABLE p_Mode ADD CONSTRAINT fk_mode_classement2
    FOREIGN KEY (idClassement) REFERENCES p_Classement_Info(idClassement);

ALTER TABLE p_Mode ADD CONSTRAINT fk_mode_jeux
    FOREIGN KEY (nomJeux) REFERENCES p_Jeux(nomJeux);

ALTER TABLE p_Mode ADD CONSTRAINT fk_mode_utilisateur
    FOREIGN KEY (idUtilisateur) REFERENCES p_Utilisateurs(idUtilisateur);

-- p_Exemplaire_Service
ALTER TABLE p_Exemplaire_Service ADD CONSTRAINT fk_exemplaire_service
    FOREIGN KEY (code_service) REFERENCES p_Services(code_service);

ALTER TABLE p_Exemplaire_Service ADD CONSTRAINT fk_exemplaire_panier
    FOREIGN KEY (idPanier) REFERENCES p_Panier(idPanier);

-- p_Parler
ALTER TABLE p_Parler ADD CONSTRAINT fk_parler_utilisateur
    FOREIGN KEY (idUtilisateur) REFERENCES p_Utilisateurs(idUtilisateur);

ALTER TABLE p_Parler ADD CONSTRAINT fk_parler_langue
    FOREIGN KEY (code_alpha) REFERENCES p_Langues(code_alpha);

-- p_ProposerService
ALTER TABLE p_ProposerService ADD CONSTRAINT fk_utilisateur_service
    FOREIGN KEY (idCoach) REFERENCES p_Coach(idCoach);

ALTER TABLE p_ProposerService ADD CONSTRAINT fk_service_utilisateur
    FOREIGN KEY (code_service) REFERENCES p_Services(code_service);

-- p_avoir_disponibilite
ALTER TABLE p_avoir_disponibilite ADD CONSTRAINT fk_utilisateur_disponibilite
    FOREIGN KEY (idCoach) REFERENCES p_Coach(idCoach);

ALTER TABLE p_avoir_disponibilite ADD CONSTRAINT fk_disponibilite_utilisateur
    FOREIGN KEY (idDisponibilite) REFERENCES p_Disponibilite(idDisponibilite);

-- p_Avoir_dispo
ALTER TABLE p_Avoir_dispo ADD CONSTRAINT fk_exemplaire_disponibilite
    FOREIGN KEY (idExemplaire) REFERENCES p_Exemplaire_Service(idExemplaire);

ALTER TABLE p_Avoir_dispo ADD CONSTRAINT fk_disponibilite_exemplaire
    FOREIGN KEY (idDisponibilite) REFERENCES p_Disponibilite(idDisponibilite);