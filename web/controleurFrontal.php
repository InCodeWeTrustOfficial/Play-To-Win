<?php
//require_once __DIR__ . '/../src/Controleur/ControleurUtilisateur.php';
require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

use App\Covoiturage\Controleur\ControleurUtilisateur;




// initialisation en activant l'affichage de débogage
$chargeurDeClasse = new App\Covoiturage\Lib\Psr4AutoloaderClass(false);
$chargeurDeClasse->register();
// enregistrement d'une association "espace de nom" → "dossier"
$chargeurDeClasse->addNamespace('App\Covoiturage', __DIR__ . '/../src');


if(isset($_GET['action'])){
    $action = $_GET['action'];
} else{
    $action = 'afficherListe';
}

if(isset($_GET['controleur'])){
    $controleur = $_GET['controleur'];
} else{
    $controleur = 'utilisateur';
}

$nomDeClasseControleur = 'App\Covoiturage\Controleur\Controleur'.ucfirst($controleur);

$bool = false;
foreach (get_class_methods('App\Covoiturage\Controleur\ControleurUtilisateur') as $possibleAction) {
    if($possibleAction == $action && class_exists($nomDeClasseControleur)) {
        $nomDeClasseControleur::$possibleAction();
        $bool = true;
        break;
    }
}
if(!$bool){
    ControleurUtilisateur::afficherErreur("Vue inexistante");
}


// http://localhost/tds-php/TD4/Controleur/routeur.php?action=afficherListe
// l'url a utiliser