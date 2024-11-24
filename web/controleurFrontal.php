<?php
//require_once __DIR__ . '/../src/Controleur/ControleurUtilisateur.php';
require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

use App\PlayToWin\Controleur\ControleurJeux;
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
        $controleur = 'jeux';
    }
}

$nomDeClasseControleur = 'App\PlayToWin\Controleur\Controleur'.ucfirst($controleur);

$bool = false;
if (class_exists($nomDeClasseControleur)){
    foreach (get_class_methods($nomDeClasseControleur) as $possibleAction) {
        if($possibleAction == $action) {
            $nomDeClasseControleur::$possibleAction();
            $bool = true;
            break;
        }
    }
}
if(!$bool){
    ControleurJeux::afficherErreur();
}