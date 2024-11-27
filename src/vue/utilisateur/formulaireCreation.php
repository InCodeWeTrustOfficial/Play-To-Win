<?php use App\PlayToWin\Configuration\ConfigurationSite;
/** @var Langue[] $langues */
/** @var boolean $conf */
?>
<form method="<?=$conf?>" action="controleurFrontal.php">
    <input type='hidden' name='action' value='creerDepuisFormulaire'>
    <input type='hidden' name='controleur' value="utilisateur">
    <fieldset>
        <legend>Mon formulaire :</legend>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="id_id">id</label>
            <input class="InputAddOn-field" type="text" placeholder="bnj_rl" name="id" id="id_id"
                   pattern="^[a-zA-Z0-9_]+$"
                   maxlength="32"
                   title="Certains caractères ne sont pas valides !"
                   required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="nom_id">Nom</label>
            <input class="InputAddOn-field" type="text"  placeholder="turpin" name="nom" id="nom_id" maxlength="32" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="prenom_id">Prenom</label>
            <input class="InputAddOn-field" type="text"  placeholder="benjamin" name="prenom" id="prenom_id" maxlength="32" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="pseudo_id">Pseudo</label>
            <input class="InputAddOn-field" type="text"  placeholder="BNJ" name="pseudo" id="pseudo_id" maxlength="32" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="email_id">Email&#42;</label>
            <input class="InputAddOn-field" type="email" value="" placeholder="toto@yopmail.com" name="email" id="email_id" maxlength="256" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="date_id">Date de naissance</label>
            <input class="InputAddOn-field" type="date" name="dateDeNaissance" id="date_id"  required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mdp_id">Mot de passe&#42;</label>
            <input class="InputAddOn-field" type="password" value="" placeholder="" name="mdp" id="mdp_id" maxlength="128" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mdp2_id">Vérification du mot de passe&#42;</label>
            <input class="InputAddOn-field" type="password" value="" placeholder="" name="mdp2" id="mdp2_id" maxlength="128" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="lang_id">Sélectionnez votre langue principale</label>
            <select name="lang" id="lang_id">
                <?php
                echo '<option value="FR" selected="selected">Français</option>';
                foreach ($langues as $l){
                    if($l->getCodeAlpha() != "FR"){
                        echo '<option value="'.$l->getCodeAlpha().'">'.htmlspecialchars($l->getNom()).'</option>';
                    }
                }
                ?>
            </select>
        </p>
        <?php
        use App\PlayToWin\Lib\ConnexionUtilisateur;
        use App\PlayToWin\Modele\DataObject\Langue;

        /** @var boolean $estAdmin */

        if ($estAdmin){
            echo '
            <p class="InputAddOn">
            <label class="InputAddOn-item" for="estAdmin_id">Administrateur ?</label>
            <input class="InputAddOn-field" type="checkbox" name="estAdmin" id="estAdmin_id"/>
        </>';
        }
        ?>
        <p>
            <input type="submit" value="Envoyer">
        </p>
    </fieldset>
</form>