**Lien vers le site :** https://webinfo.iutmontp.univ-montp2.fr/~turpinb/web/controleurFrontal.php

**Lien vers le gitlab :** https://gitlabinfo.iutmontp.univ-montp2.fr/turpinb/s3-projetweb

**Récapitulatif de l'investissement :**
- Benjamin (47 %) : Gestions de l'architecture du projet / des Utilisateurs / Coachs / Sécurité / Messages flash
- Alexis (47 %) : Gestion des services et commandes / gestion du panier / affichage administrateur
- Badis (6 %) : A essayer de réaliser les disponibilités, mais n'étant pas fonctionnelles, elles ne sont pas présentes sur le rendu

**Utilisation de JavaScript :**

Il est à noter que nous avons privilégié au maximum l'utilisation du php, en réalisant une simulation d'affichage dynamique coté client bien que ce n'est pas le cas. Cependant pour quelques subtilités nous nous sommes permis de rajouter du code Javascript :

- Une première apparition du Javascript dans notre projet se situe dans dans les formulaires "jouer", afin de pouvoir utiliser dans un même formulaire une redirection vers une autre action facilement.
- En second le formulaire de création de services, un petit script est utilisé pour modifier le contrôleur qui sera utilisé pour sa création.
- En dernier l'affichage du type de produit (Coaching / Analyse Vidéo), le choix dans la liste est modifié afin de n'afficher qu'un certain type.