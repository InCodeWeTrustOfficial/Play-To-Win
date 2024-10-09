<form method="get" action = "controleurFrontal.php">
    <input type='hidden' name='action' value='creerDepuisFormulaire'>
    <input type='hidden' name='controleur' value="utilisateur">
    <fieldset>
        <legend>Mon formulaire :</legend>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="login_id">Login</label>
            <input class="InputAddOn-field" type="text" placeholder="leblancj" name="login" id="login_id" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="nom_id">Nom</label>
            <input class="InputAddOn-field" type="text"  placeholder="turpin" name="nom" id="nom_id" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="prenom_id">Prenom</label>
            <input class="InputAddOn-field" type="text"  placeholder="benjamin" name="prenom" id="prenom_id" required/>
        </p>
        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>