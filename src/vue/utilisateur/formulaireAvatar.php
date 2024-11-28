<?php
/** @var string $id */
/** @var Utilisateur $utilisateur */
/** @var string $conf */
/** @var string $avatarPath */
use App\PlayToWin\Modele\DataObject\Utilisateur;
?>
<form method="<?=$conf?>" action="controleurFrontal.php" enctype="multipart/form-data">
    <input type='hidden' name='action' value='mettreAJourAvatar'>
    <input type='hidden' name='controleur' value="utilisateur">
    <input type='hidden' name='id' value="<?=$id?>">
    <fieldset>
        <legend>Modification de votre image de profil :</legend>
        <p>
            Image actuelle :
            <img src="../<?=$avatarPath?>" alt="Photo de profil" style="width: 70px; height: 70px; object-fit: cover;"
                 onerror="this.onerror=null; this.src='../ressources/img/defaut_pp.png';">
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="pp_id">Entrez votre nouvelle image de profil:</label>
            <input class="InputAddOn-field" type="file" name="<?=$id?>" id="pp_id" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mdp_id">Mot de passe&#42;</label>
            <input class="InputAddOn-field" type="password" value="" placeholder="" name="mdp" id="mdp_id" required>
        </p>
        <p>
            <input type="submit" value="Envoyer">
        </p>
    </fieldset>
</form>