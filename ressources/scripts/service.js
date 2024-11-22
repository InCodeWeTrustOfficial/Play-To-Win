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
    const controleurInput = document.getElementById("controleur");
    const actionInput = document.getElementById("action");

    if (serviceSelect.value === "coaching") {
        actionInput.value = "afficherSelfListe";
        controleurInput.value = "coaching";
    } else if (serviceSelect.value === "analyse_video") {
        actionInput.value = "afficherSelfListe";
        controleurInput.value = "analysevideo";
    } else if (serviceSelect.value === "tous") {
        actionInput.value = "afficherListe";
        controleurInput.value = "service";
    }
}