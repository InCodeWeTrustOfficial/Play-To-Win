<?php
/** @var string $id */

use App\Covoiturage\Modele\Repository\TrajetRepository;
use App\Covoiturage\Modele\DataObject\Trajet;

$trajet = (new TrajetRepository())->recupererParClePrimaire($id);
?>
<?php use App\Covoiturage\Configuration\ConfigurationSite;?>
<form method="<?php if(ConfigurationSite::getDebug()){echo "get";}else{echo "post";} ?>" action="controleurFrontal.php">
    <input type='hidden' name='action' value='mettreAJour'>
    <input type='hidden' name='controleur' value='trajet'>
    <input type='hidden' name='id' value="<?= $id?>">
    <fieldset>
        <legend>Mon formulaire :</legend>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="depart_id">Depart</label>
            <input class="InputAddOn-field" type="text" placeholder="<?= $trajet->getDepart()?>" name="depart" id="depart_id" required/>
        </>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="arrivee_id">Arrivée</label>
            <input class="InputAddOn-field" type="text" placeholder="<?= $trajet->getArrivee()?>" name="arrivee" id="arrivee_id" required/>
        </>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="date_id">Date</label>
            <input class="InputAddOn-field" type="date" placeholder="<?= date_format($trajet->getDate(),"Y-m-d")?>" name="date" id="date_id"  required/>
        </>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="prix_id">Prix</label>
            <input class="InputAddOn-field" type="int" placeholder="<?= $trajet->getPrix()?>" name="prix" id="prix_id"  required/>
        </>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="conducteurLogin_id">Login du conducteur</label>
            <input class="InputAddOn-field" type="text" placeholder="<?= $trajet->getConducteur()->getLogin()?>" name="conducteurLogin" id="conducteurLogin_id" required/>
        </>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="nonFumeur_id">Non Fumeur ?</label>
            <input class="InputAddOn-field" type="checkbox" <?php if($trajet->isNonFumeur()){echo"checked=true";}?> name="nonFumeur" id="nonFumeur_id"/>
        </>
        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>
