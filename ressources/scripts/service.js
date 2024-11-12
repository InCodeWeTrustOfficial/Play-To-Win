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

function updateAction() {
    const serviceSelect = document.getElementById("service_type_field");
    const actionInput = document.getElementById("action");

    if (serviceSelect.value === "coaching") {
        actionInput.value = "afficherListeCoaching";
    } else if (serviceSelect.value === "analyse_video") {
        actionInput.value = "afficherListeAnalyse";
    } else if (serviceSelect.value === "tous") {
        actionInput.value = "afficherListe";
    }
}