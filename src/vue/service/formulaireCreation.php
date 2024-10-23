<form method="get" action="controleurFrontal.php" id="serviceForm">
    <input type='hidden' name='action' value='creerDepuisFormulaire'>
    <input type='hidden' name='controleur' id="controleur" value='coaching'>
    <fieldset>
        <legend>Services</legend>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="nom_services_id">Nom du service</label>
            <input class="InputAddOn-field" type="text" placeholder="Ex : Coaching personnalisé" name="nom_services" id="nom_services_id" required/>
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="description_id">Description</label>
            <textarea class="InputAddOn-field" name="description" id="description_id" placeholder="Décrivez le service en détail (ex : sessions, objectifs, contenu proposé)" rows="4" cols="50" required></textarea>
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="jeu_id">Jeu</label>
            <select class="InputAddOn-field" name="jeu" id="jeu_id" required>
                <option value="Rocket League">Rocket League</option>
                <option value="League of Legends">League of Legends</option>
            </select>
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="type_id">Type de service</label>
            <select class="InputAddOn-field" name="type" id="type_id" required onchange="toggleFields()">
                <option value="analysevideo" selected>Analyse vidéo</option>
                <option value="coaching">Coaching</option>
            </select>
        </p>

        <p class="InputAddOn" id="date_champ" style="display:none;">
            <label class="InputAddOn-item" for="duree_id">Duree du coaching</label>
            <input class="InputAddOn-field" type="number" name="duree" id="duree_id" placeholder="Ex : 30 min" min="0" step="15" />
        </p>

        <p class="InputAddOn" id="nbJourRendu_champ" style="display:block;">
            <label class="InputAddOn-item" for="nbJourRendu_id">Nombre de jours avant le rendu</label>
            <input class="InputAddOn-field" type="number" name="nbJourRendu" id="nbJourRendu_id" placeholder="Ex : 5" min="1" />
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="prix_id">Prix</label>
            <input class="InputAddOn-field" type="number" placeholder="Ex : 20" name="prix" id="prix_id" required/>
        </p>

        <p id="affichageControleur">Controleur : analysevideo</p>

        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>

<script>
    toggleFields();

    function toggleFields() {
        var typeSelect = document.getElementById("type_id");
        var dateField = document.getElementById("date_champ");
        var daysBeforeField = document.getElementById("nbJourRendu_champ");
        var controleurInput = document.getElementById("controleur");
        var affichageControleur = document.getElementById("affichageControleur");

        if (typeSelect.value === "analysevideo") {
            dateField.style.display = "none";
            daysBeforeField.style.display = "block";
            controleurInput.value = "analysevideo";
        } else if (typeSelect.value === "coaching") {
            dateField.style.display = "block";
            daysBeforeField.style.display = "none";
            controleurInput.value = "coaching";
        }

        affichageControleur.textContent = "Controleur : " + controleurInput.value;
    }
</script>
