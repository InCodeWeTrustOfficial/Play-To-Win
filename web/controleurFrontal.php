<?php
//require_once __DIR__ . '/../src/Controleur/ControleurUtilisateur.php';
require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

use App\PlayToWin\Controleur\ControleurUtilisateur;
use App\PlayToWin\Lib\PreferenceControleur;




// initialisation en activant l'affichage de débogage
$chargeurDeClasse = new App\PlayToWin\Lib\Psr4AutoloaderClass(false);
$chargeurDeClasse->register();
// enregistrement d'une association "espace de nom" → "dossier"
$chargeurDeClasse->addNamespace('App\PlayToWin', __DIR__ . '/../src');


if(isset($_REQUEST['action'])){
    $action = $_REQUEST['action'];
} else{
    $action = 'afficherListe';
}

if(isset($_REQUEST['controleur'])){
    $controleur = $_REQUEST['controleur'];
} else{
    if(PreferenceControleur::existe()){
        $controleur = PreferenceControleur::lire();
    } else{
        $controleur = 'utilisateur';
    }
}

$nomDeClasseControleur = 'App\PlayToWin\Controleur\Controleur'.ucfirst($controleur);

$bool = false;
foreach (get_class_methods($nomDeClasseControleur) as $possibleAction) {
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