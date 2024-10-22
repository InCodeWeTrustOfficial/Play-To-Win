<?php
/** @var string $id */
use App\Covoiturage\Modele\DataObject\Utilisateur;
use App\Covoiturage\Modele\Repository\UtilisateurRepository;
$utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($id);
?>
<?php use App\Covoiturage\Configuration\ConfigurationSite;?>
<form method="<?php if(ConfigurationSite::getDebug()){echo "get";}else{echo "post";} ?>" action="controleurFrontal.php">
    <input type='hidden' name='action' value='mettreAJour'>
    <input type='hidden' name='controleur' value="utilisateur">
    <fieldset>
        <legend>Formulaire de modification :</legend>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="id_id">id</label>
            <input class="InputAddOn-field" value="<?= $id ?>" readonly ="readonly" type="text" name="id" id="id_id" required/>

        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="nom_id">Nom</label>
            <input class="InputAddOn-field" type="text"  placeholder="<?= $utilisateur->getNom()?>" name="nom" id="nom_id" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="prenom_id">Prenom</label>
            <input class="InputAddOn-field" type="text"  placeholder="<?= $utilisateur->getPrenom()?>" name="prenom" id="prenom_id" required/>
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="email_id">Email</label>
            <input class="InputAddOn-field" type="text"  value="<?= $utilisateur->getEmail()?>" name="email" id="email_id" required/>
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

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="estAdmin_id">Administrateur</label>
            <input class="InputAddOn-field" type="checkbox" placeholder="" name="estAdmin" id="estAdmin_id" <?php if($utilisateur->isAdmin()){echo"checked=true";}?>>
        </p>

        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>