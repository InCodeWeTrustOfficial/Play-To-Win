<?php
$servername = "webinfo.iutmontp.univ-montp2.fr";
$username = "turpinb";
$password = "080482285HA";
$dbname = "turpinb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function fileToBlob($filename) {
    return file_get_contents($filename);
}

$languages = [
    ['EN', 'Anglais', '../ressources/img/drapeaux/gb.png'],
    ['ZH', 'Chinois', '../ressources/img/drapeaux/cn.png'],
    ['HI', 'Hindi', '../ressources/img/drapeaux/in.png'],
    ['ES', 'Espagnol', '../ressources/img/drapeaux/es.png'],
    ['FR', 'Français', '../ressources/img/drapeaux/fr.png'],
    ['AR', 'Arabe', '../ressources/img/drapeaux/sa.png'],
    ['RU', 'Russe', '../ressources/img/drapeaux/ru.png'],
    ['PT', 'Portugais', '../ressources/img/drapeaux/pt.png'],
    ['DE', 'Allemand', '../ressources/img/drapeaux/de.png'],
    ['JA', 'Japonais', '../ressources/img/drapeaux/jp.png'],
    ['KO', 'Coréen', '../ressources/img/drapeaux/kr.png'],
    ['IT', 'Italien', '../ressources/img/drapeaux/it.png'],
];

$stmt = $conn->prepare("INSERT INTO p_Langues (code_alpha, nom, drapeau) VALUES (?, ?, ?)");

$stmt->bind_param("ssi", $code_alpha, $nom, $drapeau);

foreach ($languages as $language) {
    $code_alpha = $language[0];
    $nom = $language[1];
    $drapeau = fileToBlob($language[2]);

    if (!$stmt->execute()) {
        echo "Erreur: " . $stmt->error . "<br>";
    } else {
        echo "Langue ajoutée: " . $nom . "<br>";
    }
}

$stmt->close();
$conn->close();
?>
