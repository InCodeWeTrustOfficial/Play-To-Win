<form method="get" action="controleurFrontal.php">
    <input type='hidden' name='action' value='creerDepuisFormulaire'>
    <input type='hidden' name='controleur' value='trajet'>
    <fieldset>
        <legend>Services </legend>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="depart_id">Depart</label>
            <input class="InputAddOn-field" type="text" placeholder="Montpellier" name="depart" id="depart_id" required/>
        </>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="arrivee_id">Arrivée</label>
            <input class="InputAddOn-field" type="text" placeholder="Sète" name="arrivee" id="arrivee_id" required/>
        </>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="date_id">Date</label>
            <input class="InputAddOn-field" type="date" placeholder="JJ/MM/AAAA" name="date" id="date_id"  required/>
        </>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="prix_id">Prix</label>
            <input class="InputAddOn-field" type="int" placeholder="20" name="prix" id="prix_id"  required/>
        </>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="conducteurLogin_id">Login du conducteur</label>
            <input class="InputAddOn-field" type="text" placeholder="leblancj" name="conducteurLogin" id="conducteurLogin_id" required/>
        </>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="nonFumeur_id">Non Fumeur ?</label>
            <input class="InputAddOn-field" type="checkbox" placeholder="leblancj" name="nonFumeur" id="nonFumeur_id"/>
        </>
        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>
