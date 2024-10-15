import os
import mysql.connector
from mysql.connector import Error

def connexion_base_de_donnees():
    try:
        connexion = mysql.connector.connect(
            host='webinfo.iutmontp.univ-montp2.fr',
            port=3316,
            database='turpinb',  
            user='turpinb',  
            password='080482285HA'  
        )
        if connexion.is_connected():
            print("Connexion à MySQL réussie")
            return connexion
    except Error as e:
        print(f"Erreur lors de la connexion à MySQL: {e}")
        return None

def file_to_blob(filename):

    script_dir = os.path.dirname(__file__)  
    file_path = os.path.join(script_dir, filename)
    
    if os.path.exists(file_path):
        try:
            with open(file_path, 'rb') as file:
                return file.read()
        except FileNotFoundError:
            print(f"Fichier non trouvé: {file_path}")
            return None
    else:
        print(f"Fichier non trouvé: {file_path}")
        return None

def inserer_langues():
    languages = [
        ('EN', 'Anglais', 'insertion/drapeaux/gb.png'),
        ('ZH', 'Chinois', 'insertion/drapeaux/cn.png'),
        ('HI', 'Hindi', 'insertion/drapeaux/in.png'),
        ('ES', 'Espagnol', 'insertion/drapeaux/es.png'),
        ('FR', 'Français', 'insertion/drapeaux/fr.png'),
        ('AR', 'Arabe', 'insertion/drapeaux/sa.png'),
        ('RU', 'Russe', 'insertion/drapeaux/ru.png'),
        ('PT', 'Portugais', 'insertion/drapeaux/pt.png'),
        ('DE', 'Allemand', 'insertion/drapeaux/de.png'),
        ('JA', 'Japonais', 'insertion/drapeaux/jp.png'),
        ('KO', 'Coréen', 'insertion/drapeaux/kr.png'),
        ('IT', 'Italien', 'insertion/drapeaux/it.png')
    ]

    connexion = connexion_base_de_donnees()
    if connexion is None:
        print("Impossible de se connecter à la base de données.")
        return

    try:
        curseur = connexion.cursor()

        sql = "INSERT INTO p_Langues (code_alpha, nom, drapeau) VALUES (%s, %s, %s)"

        for language in languages:
            code_alpha = language[0]
            nom = language[1]
            drapeau_blob = file_to_blob(language[2])

            if drapeau_blob is None:
                print(f"Erreur avec le fichier drapeau pour la langue {nom}")
                continue

            try:
                curseur.execute(sql, (code_alpha, nom, drapeau_blob))
                connexion.commit()
                print(f"Langue ajoutée : {nom}")
            except Error as e:
                print(f"Erreur lors de l'insertion de {nom} : {e}")

    finally:
        if connexion.is_connected():
            curseur.close()
            connexion.close()
            print("Connexion MySQL fermée.")
            
def inserer_jeux():
    jeux = [
        ('League of Legends', "insertion/logo/lol.png"),
        ('Rocket League', "insertion/logo/rl.PNG")
    ]

    connexion = connexion_base_de_donnees()
    if connexion is None:
        print("Impossible de se connecter à la base de données.")
        return

    try:
        curseur = connexion.cursor()

        sql = "INSERT INTO p_Jeux (nomJeu, logoJeu) VALUES (%s, %s)"

        for jeu in jeux:
            nom_jeu = jeu[0]
            logo_blob = file_to_blob(jeu[1])

            if logo_blob is None:
                print(f"Erreur avec le fichier logo pour le jeu {nom_jeu}")
                continue

            try:
                curseur.execute(sql, (nom_jeu, logo_blob))
                connexion.commit()
                print(f"Jeu ajouté : {nom_jeu}")
            except Error as e:
                print(f"Erreur lors de l'insertion de {nom_jeu} : {e}")

    finally:
        if connexion.is_connected():
            curseur.close()
            connexion.close()
            print("Connexion MySQL fermée.")

""" 
def inserer_mode_jeux():
    mode_de_jeux = [
        ('flexibe', 'League of Legends'),
        ('solo/queue', 'League of Legends'),
        ('1v1','Rocket League'),
        ('2v2','Rocket League'),
        ('3v3','Rocket League')
    ]

    connexion = connexion_base_de_donnees()
    if connexion is None:
        print("Impossible de se connecter à la base de données.")
        return

    try:
        curseur = connexion.cursor()

        sql = "INSERT INTO p_Jeux (nomJeux, logo) VALUES (%s, %s)"

        for mode in inserer_mode_jeux:
            nom_jeu = mode[0]

            try:
                curseur.execute(sql, (nom_jeu))
                connexion.commit()
                print(f"Jeu ajouté : {nom_jeu}")
            except Error as e:
                print(f"Erreur lors de l'insertion de {nom_jeu} : {e}")

    finally:
        if connexion.is_connected():
            curseur.close()
            connexion.close()
            print("Connexion MySQL fermée.")
"""

def inserer_classement():
    classements = [
        # Classements pour League of Legends
        ('L-1', 'Fer', 4, "insertion/classement/fer-lol.png"),
        ('L-2', 'Fer', 3, "insertion/classement/fer-lol.png"),
        ('L-3', 'Fer', 2, "insertion/classement/fer-lol.png"),
        ('L-4', 'Fer', 1, "insertion/classement/fer-lol.png"),
        ('L-5', 'Bronze', 4, "insertion/classement/bronze-lol.png"),
        ('L-6', 'Bronze', 3, "insertion/classement/bronze-lol.png"),
        ('L-7', 'Bronze', 2, "insertion/classement/bronze-lol.png"),
        ('L-8', 'Bronze', 1, "insertion/classement/bronze-lol.png"),
        ('L-9', 'Argent', 4, "insertion/classement/argent-lol.png"),
        ('L-10', 'Argent', 3, "insertion/classement/argent-lol.png"),
        ('L-11', 'Argent', 2, "insertion/classement/argent-lol.png"),
        ('L-12', 'Argent', 1, "insertion/classement/argent-lol.png"),
        ('L-13', 'Or', 4, "insertion/classement/or-lol.png"),
        ('L-14', 'Or', 3, "insertion/classement/or-lol.png"),
        ('L-15', 'Or', 2, "insertion/classement/or-lol.png"),
        ('L-16', 'Or', 1, "insertion/classement/or-lol.png"),
        ('L-17', 'Platine', 4, "insertion/classement/platine-lol.png"),
        ('L-18', 'Platine', 3, "insertion/classement/platine-lol.png"),
        ('L-19', 'Platine', 2, "insertion/classement/platine-lol.png"),
        ('L-20', 'Platine', 1, "insertion/classement/platine-lol.png"),
        ('L-21', 'Diamant', 4, "insertion/classement/diamant-lol.png"),
        ('L-22', 'Diamant', 3, "insertion/classement/diamant-lol.png"),
        ('L-23', 'Diamant', 2, "insertion/classement/diamant-lol.png"),
        ('L-24', 'Diamant', 1, "insertion/classement/diamant-lol.png"),
        ('L-25', 'Émeraude', 4, "insertion/classement/emeuraude-lol.png"),
        ('L-26', 'Émeraude', 3, "insertion/classement/emeuraude-lol.png"),
        ('L-27', 'Émeraude', 2, "insertion/classement/emeuraude-lol.png"),
        ('L-28', 'Émeraude', 1, "insertion/classement/emeuraude-lol.png"),
        ('L-29', 'Maitre', 1, "insertion/classement/maitre-lol.png"),
        ('L-30', 'Grand Maitre', 1, "insertion/classement/grand_maitre-lol.png"),
        ('L-31', 'Challenger', 1, "insertion/classement/challenger-lol.png"),

        # Classements pour Rocket League
        ('R-1', 'Fer', 1, None),
        ('R-2', 'Fer', 2, None),
        ('R-3', 'Fer', 3, None),
        ('R-4', 'Argent', 1, None),
        ('R-5', 'Argent', 2, None),
        ('R-6', 'Argent', 3, None),
        ('R-7', 'Or', 1, None),
        ('R-8', 'Or', 2, None),
        ('R-9', 'Or', 3, None),
        ('R-10', 'Platine', 1, None),
        ('R-11', 'Platine', 2, None),
        ('R-12', 'Platine', 3, None),
        ('R-13', 'Diamant', 1, None),
        ('R-14', 'Diamant', 2, None),
        ('R-15', 'Diamant', 3, None),
        ('R-16', 'Champion', 1, None),
        ('R-17', 'Champion', 2, None),
        ('R-18', 'Champion', 3, None),
        ('R-19', 'Grand Champion', 1, None),
        ('R-20', 'Grand Champion', 2, None),
        ('R-21', 'Grand Champion', 3, None),
        ('R-22', 'Supersonic Legend', 1, None)
    ]

    connexion = connexion_base_de_donnees()
    if connexion is None:
        print("Impossible de se connecter à la base de données.")
        return

    try:
        curseur = connexion.cursor()

        sql = "INSERT INTO p_Classements (idClassement, nomClassement, divisionClassement, avatarClassement) VALUES (%s, %s, %s, %s)"

        for classement in classements:
            id_classement = classement[0]
            nom_classement = classement[1]
            division = classement[2]
            avatar_filename = classement[3]
            classement_avatar = None

            if avatar_filename is not None:
                classement_avatar = file_to_blob(avatar_filename)
                
                if classement_avatar is None:
                    print(f"Erreur avec le fichier logo pour le classement {id_classement}: fichier non trouvé")
                    continue

            try:
                curseur.execute(sql, (id_classement, nom_classement, division, classement_avatar))
                connexion.commit()
                print(f"Classement ajouté : {id_classement} {nom_classement} {division}")
            except Error as e:
                print(f"Erreur lors de l'insertion du classement {id_classement} {nom_classement} {division} : {e}")

    finally:
        if connexion.is_connected():
            curseur.close()
            connexion.close()
            print("Connexion MySQL fermée.")

def executer_script_sql(fichier_sql):
    connexion = connexion_base_de_donnees()
    if connexion is None:
        print("Impossible de se connecter à la base de données.")
        return

    try:
        curseur = connexion.cursor()
        script_dir = os.path.dirname(__file__)
        file_path = os.path.join(script_dir, fichier_sql)
        
        with open(file_path, 'r', encoding='utf-8') as file:
            script = file.read()
            
        instructions = script.strip().split(';')
        
        for instruction in instructions:
            if instruction.strip():  
                curseur.execute(instruction)
    
        connexion.commit()
        print("Script SQL exécuté avec succès.")
        
    except Error as e:
        print(f"Erreur lors de l'exécution du script SQL : {e}")

    finally:
        if connexion.is_connected():
            curseur.close()
            connexion.close()
            print("Connexion MySQL fermée.")
            
if __name__ == "__main__":
    executer_script_sql("Scripts/Drop.sql")
    executer_script_sql("Scripts/Create.sql")
    executer_script_sql("Scripts/Alter.sql")
    inserer_langues()
    inserer_jeux()
    inserer_classement()