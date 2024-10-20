<form method="get" action="controleurFrontal.php">
    <input type='hidden' name='action' value='creerDepuisFormulaire'>
    <input type='hidden' name='controleur' value='service'>
    <fieldset>
        <legend>Services</legend>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="nom_services_id">Nom services</label>
            <input class="InputAddOn-field" type="text" placeholder="Coaching personnalisé" name="nom_services" id="nom_services_id" required/>
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="description_id">Description</label>
            <textarea class="InputAddOn-field" name="description" id="description_id" placeholder="Décrivez le service en détail (ex: sessions, objectifs, contenu proposé)" rows="4" cols="50" required></textarea>
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="jeu_id">Jeu</label>
            <select class="InputAddOn-field" name="jeu" id="jeu_id" required>
                <option value="Rocket League">Rocket League</option>
                <option value="League of Legends">League of Legends</option>
            </select>
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="type_id">Type de services</label>
            <select class="InputAddOn-field" name="type" id="type_id" required onchange="toggleDateField()">
                <option value="Analyse vidéo">Analyse vidéo</option>
                <option value="Coaching">Coaching</option>
            </select>
        </p>

        <p class="InputAddOn" id="date_field" style="display:none;">
            <label class="InputAddOn-item" for="date_id">Date</label>
            <input class="InputAddOn-field" type="date" name="date" id="date_id"/>
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="prix_id">Prix</label>
            <input class="InputAddOn-field" type="number" placeholder="Ex: 20" name="prix" id="prix_id" required/>
        </p>

        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>

<script>
    function toggleDateField() {
        var typeSelect = document.getElementById("type_id");
        var dateField = document.getElementById("date_field");

        if (typeSelect.value === "Coaching") {
            dateField.style.display = "block";
        } else {
            dateField.style.display = "none";
        }
    }
</script>
