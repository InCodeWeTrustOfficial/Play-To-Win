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
        ('EN', 'Anglais', 'drapeaux/gb.png'),
        ('ZH', 'Chinois', 'drapeaux/cn.png'),
        ('HI', 'Hindi', 'drapeaux/in.png'),
        ('ES', 'Espagnol', 'drapeaux/es.png'),
        ('FR', 'Français', 'drapeaux/fr.png'),
        ('AR', 'Arabe', 'drapeaux/sa.png'),
        ('RU', 'Russe', 'drapeaux/ru.png'),
        ('PT', 'Portugais', 'drapeaux/pt.png'),
        ('DE', 'Allemand', 'drapeaux/de.png'),
        ('JA', 'Japonais', 'drapeaux/jp.png'),
        ('KO', 'Coréen', 'drapeaux/kr.png'),
        ('IT', 'Italien', 'drapeaux/it.png')
    ]
    
    print(f"Répertoire de travail actuel : {os.getcwd()}")

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
        ('League of Legends', "logo/lol.png"),
        ('Rocket League', "logo/rl.PNG")
    ]
    
    print(f"Répertoire de travail actuel : {os.getcwd()}")

    connexion = connexion_base_de_donnees()
    if connexion is None:
        print("Impossible de se connecter à la base de données.")
        return

    try:
        curseur = connexion.cursor()

        sql = "INSERT INTO p_Jeux (nom_jeu, logo) VALUES (%s, %s)"

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

def inserer_classement():
    classements = [
        ('Fer', 4, "classement/fer-lol.png", 'League of Legends'),
        ('Fer', 3, "classement/fer-lol.png", 'League of Legends'),
        ('Fer', 2, "classement/fer-lol.png", 'League of Legends'),
        ('Fer', 1, "classement/fer-lol.png", 'League of Legends'),
        ('Bronze', 4, "classement/bronze-lol.png", 'League of Legends'),
        ('Bronze', 3, "classement/bronze-lol.png", 'League of Legends'),
        ('Bronze', 2, "classement/bronze-lol.png", 'League of Legends'),
        ('Bronze', 1, "classement/bronze-lol.png", 'League of Legends'),
        ('Argent', 4, "classement/argent-lol.png", 'League of Legends'),
        ('Argent', 3, "classement/argent-lol.png", 'League of Legends'),
        ('Argent', 2, "classement/argent-lol.png", 'League of Legends'),
        ('Argent', 1, "classement/argent-lol.png", 'League of Legends'),
        ('Or', 4, "classement/or-lol.png", 'League of Legends'),
        ('Or', 3, "classement/or-lol.png", 'League of Legends'),
        ('Or', 2, "classement/or-lol.png", 'League of Legends'),
        ('Or', 1, "classement/or-lol.png", 'League of Legends'),
        ('Platine', 4, "classement/platine-lol.png", 'League of Legends'),
        ('Platine', 3, "classement/platine-lol.png", 'League of Legends'),
        ('Platine', 2, "classement/platine-lol.png", 'League of Legends'),
        ('Platine', 1, "classement/platine-lol.png", 'League of Legends'),
        ('Diamant', 4, "classement/diamant-lol.png", 'League of Legends'),
        ('Diamant', 3, "classement/diamant-lol.png", 'League of Legends'),
        ('Diamant', 2, "classement/diamant-lol.png", 'League of Legends'),
        ('Diamant', 1, "classement/diamant-lol.png", 'League of Legends'),
        ('Émeraude', 4, "classement/emeuraude-lol.png", 'League of Legends'),
        ('Émeraude', 3, "classement/emeuraude-lol.png", 'League of Legends'),
        ('Émeraude', 2, "classement/emeuraude-lol.png", 'League of Legends'),
        ('Émeraude', 1, "classement/emeuraude-lol.png", 'League of Legends'),
        ('Maitre', 1, "classement/maitre-lol.png", 'League of Legends'),
        ('Grand Maitre', 1, "classement/grand_maitre-lol.png", 'League of Legends'),
        ('Challenger', 1, "classement/challenger-lol.png", 'League of Legends'),

        ('Fer', 1, None, 'Rocket League'),
        ('Fer', 2, None, 'Rocket League'),
        ('Fer', 3, None, 'Rocket League'),
        ('Argent', 1, None, 'Rocket League'),
        ('Argent', 2, None, 'Rocket League'),
        ('Argent', 3, None, 'Rocket League'),
        ('Or', 1, None, 'Rocket League'),
        ('Or', 2, None, 'Rocket League'),
        ('Or', 3, None, 'Rocket League'),
        ('Platine', 1, None, 'Rocket League'),
        ('Platine', 2, None, 'Rocket League'),
        ('Platine', 3, None, 'Rocket League'),
        ('Diamant', 1, None, 'Rocket League'),
        ('Diamant', 2, None, 'Rocket League'),
        ('Diamant', 3, None, 'Rocket League'),
        ('Champion', 1, None, 'Rocket League'),
        ('Champion', 2, None, 'Rocket League'),
        ('Champion', 3, None, 'Rocket League'),
        ('Grand Champion', 1, None, 'Rocket League'),
        ('Grand Champion', 2, None, 'Rocket League'),
        ('Grand Champion', 3, None, 'Rocket League'),
        ('Supersonic Legend', 1, None, 'Rocket League')
    ]

    print(f"Répertoire de travail actuel : {os.getcwd()}")

    connexion = connexion_base_de_donnees()
    if connexion is None:
        print("Impossible de se connecter à la base de données.")
        return

    try:
        curseur = connexion.cursor()

        sql = "INSERT INTO p_Classement_Info (nomClassement, division, classement_avatar, nomJeux) VALUES (%s, %s, %s, %s)"

        for classement in classements:
            nom_classement = classement[0]
            division = classement[1]
            classement_avatar = classement[2]
            nom_jeux = classement[3]

            try:
                curseur.execute(sql, (nom_classement, division, classement_avatar, nom_jeux))
                connexion.commit()
                print(f"Classement ajouté : {nom_classement} {division} pour le jeu {nom_jeux}")
            except Error as e:
                print(f"Erreur lors de l'insertion du classement {nom_classement} {division} : {e}")

    finally:
        if connexion.is_connected():
            curseur.close()
            connexion.close()
            print("Connexion MySQL fermée.")
            
if __name__ == "__main__":
    inserer_langues()
    inserer_jeux()