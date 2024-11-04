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
        print(fichier_sql + " : exécuté avec succès.")
        
    except Error as e:
        print(f"Erreur lors de l'exécution du script SQL : {e}")

    finally:
        if connexion.is_connected():
            curseur.close()
            connexion.close()
            print("Connexion MySQL fermée.")

def executer_trigger_commande():
    connexion = connexion_base_de_donnees()
    if connexion is None:
        print("Impossible de se connecter à la base de données.")
        return

    try:
        curseur = connexion.cursor()

        trigger_sql = """
        CREATE OR REPLACE TRIGGER tr_aft_ins_ExemplaireServices
        AFTER INSERT ON p_ExemplaireService
        FOR EACH ROW
        BEGIN
        UPDATE p_Commandes c
        SET c.prixTotal = COALESCE(c.prixTotal, 0) + (
            SELECT s.prixService
            FROM p_Services s
            WHERE s.codeService = NEW.codeService
        )
        WHERE c.idCommande = NEW.idCommande;
        END;
        """

        curseur.execute(trigger_sql, multi=True)
        connexion.commit()
        print("Trigger exécuté avec succès.")

    except Error as e:
        print(f"Erreur lors de l'exécution du trigger : {e}")

    finally:
        if connexion.is_connected():
            curseur.close()
            connexion.close()
            print("Connexion MySQL fermée.")
            
if __name__ == "__main__":
    print("\nDrop :")
    executer_script_sql("Scripts/Drop.sql")
    print("\nCreate : \n")
    executer_script_sql("Scripts/Create.sql")
    print("\nAlter : \n")
    executer_script_sql("Scripts/Alter.sql")
    print("\nTrigger : \n")
    executer_trigger_commande()
    print("\nInsertion : \n")
    executer_script_sql("Scripts/Insert.sql")