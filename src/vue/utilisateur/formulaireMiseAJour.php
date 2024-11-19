<?php
/** @var string $id */
/** @var Utilisateur $utilisateur */
use App\PlayToWin\Modele\DataObject\Utilisateur;
use App\PlayToWin\Modele\Repository\Single\UtilisateurRepository;
$utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($id);
?>
<?php use App\PlayToWin\Configuration\ConfigurationSite;?>
<form method="<?php if(ConfigurationSite::getDebug()){echo "get";}else{echo "post";} ?>" action="controleurFrontal.php">
    <input type='hidden' name='action' value='mettreAJour'>
    <input type='hidden' name='controleur' value="utilisateur">
    <fieldset>
        <legend>Formulaire de modification :</legend>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="id_id">id</label>
            <input class="InputAddOn-field" value="<?= $id ?>" readonly ="readonly" type="text" name="id" id="id_id" required>

        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="nom_id">Nom</label>
            <input class="InputAddOn-field" type="text"  placeholder="<?= $utilisateur->getNom()?>" name="nom" id="nom_id" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="prenom_id">Prenom</label>
            <input class="InputAddOn-field" type="text"  placeholder="<?= $utilisateur->getPrenom()?>" name="prenom" id="prenom_id" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="pseudo_id">Pseudo</label>
            <input class="InputAddOn-field" type="text"  placeholder="<?= $utilisateur->getPseudo()?>" name="pseudo" id="pseudo_id" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="email_id">Email</label>
            <input class="InputAddOn-field" type="text"  value="<?= $utilisateur->getEmail()?>" name="email" id="email_id" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="date_id">Date de naissance</label>
            <input class="InputAddOn-field" type="date" name="date" id="date_id"  required>
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="amdp_id">Ancien mot de passe&#42;</label>
            <input class="InputAddOn-field" type="password" value="" placeholder="" name="amdp" id="amdp_id" required>
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mdp_id">Nouveau Mot de passe&#42;</label>
            <input class="InputAddOn-field" type="password" value="" placeholder="" name="mdp" id="mdp_id" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mdp2_id">Vérification du nouveau mot de passe&#42;</label>
            <input class="InputAddOn-field" type="password" value="" placeholder="" name="mdp2" id="mdp2_id" required>
        </p>

        <?php
        use App\PlayToWin\Lib\ConnexionUtilisateur;
        if (ConnexionUtilisateur::estAdministrateur()){
            echo '
        
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="estAdmin_id">Administrateur</label>
            <input class="InputAddOn-field" type="checkbox" name="estAdmin" id="estAdmin_id"';
        if ($utilisateur->isAdmin()) {
            echo " checked";
        } echo '>
        </p>
        ';}
        ?>

        <p>
            <input type="submit" value="Envoyer">
        </p>
    </fieldset>
</form>