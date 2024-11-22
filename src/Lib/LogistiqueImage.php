<?php

namespace App\PlayToWin\Lib;

use App\PlayToWin\Controleur\ControleurGenerique;

class LogistiqueImage {

    private string $path;
    private string $dir;
    private array $allowed_ext;
    public function __construct(string $path){
        $this->path = $path;
        $this->dir = __DIR__ ."/../../";
        $this->allowed_ext = array("jpg", "png");
    }


    // On justifie le fait de passer un ControleurGenerique ET un controleur à part au cas où l'on doive afficher une action
    // d'un autre controleur.
    public function enregistrer(ControleurGenerique $control,string $name, string $action = null, $controleur = null) : void {

        if (!(!empty($_FILES[$name]) && is_uploaded_file($_FILES[$name]['tmp_name']))) {
            MessageFlash::ajouter("warning", "Problème avec le fichier.");
            $control::redirectionVersURL();
        } else {
            $explosion = explode(".", $_FILES[$name]['name']);
            $file_ext = end($explosion);

            $nameUrl = rawurlencode($name);

            if (!in_array($file_ext, $this->allowed_ext)) {
                MessageFlash::ajouter("warning", "Les fichiers autorisés sont en .png et .jpg");
                $control::redirectionVersURL($action."&id=$nameUrl", $controleur);
            } else {
                $pic_path = $this->dir.$this->path. $nameUrl .".". $file_ext;

                $other_ext = ($file_ext === "jpg") ? "png" : "jpg";
                $other_pic_path = $this->dir.$this->path. $nameUrl .".". $other_ext;

                if (file_exists($other_pic_path)) {
                    $this->supprimer($nameUrl);
                }

                if (!move_uploaded_file($_FILES[$name]['tmp_name'], $pic_path)) {
                    MessageFlash::ajouter("danger", "Problème d'export d'image, peut-être un problème venant de votre fichier.");
                    $control::redirectionVersURL();
                } else {
                    MessageFlash::ajouter("success", "Changement de votre image!");
                    $control::redirectionVersURL("afficherDetail&id=$nameUrl", $controleur);
                }
            }
        }
    }

    public function existe(string $name,string $ext) : bool {
        return file_exists($this->dir.$this->path . $name.".".$ext);
    }

    public function supprimer(string $name) : void {
        foreach ($this->allowed_ext as $ext) {
            if($this->existe($name, $ext)) unlink($this->dir.$this->path. $name.".".$ext);
        }
    }

    public function getCheminComplet(string $name) : string {
        $ext = "";
        if(file_exists($this->dir.$this->path.$name.".png")){
            $ext = ".png";
        } else if (file_exists($this->dir.$this->path.$name.".jpg")){
            $ext = ".jpg";
        }
        return $this->path.$name.$ext;
    }
}