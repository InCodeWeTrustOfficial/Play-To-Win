<?php
// ControleurAdministrateur.php
namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Modele\DataObject\ObjetListable;
use App\PlayToWin\Modele\Repository\Association\JouerRepository;
use App\PlayToWin\Modele\Repository\Association\ParlerRepository;
use App\PlayToWin\Modele\Repository\Single\AnalyseVideoRepository;
use App\PlayToWin\Modele\Repository\Single\CoachingRepository;
use App\PlayToWin\Modele\Repository\Single\CoachRepository;
use App\PlayToWin\Modele\Repository\Single\JeuRepository;
use App\PlayToWin\Modele\Repository\Single\UtilisateurRepository;

class ControleurAdministrateur extends ControleurGenerique {
    private static string $controleur = "administrateur";

    public static function afficherListeUtilisateurs(): void {
        $estAdmin = ConnexionUtilisateur::estAdministrateur();
        $utilisateurs = (new UtilisateurRepository())->recuperer();

        $tableauHTML = self::genererTableauObjets($utilisateurs, $estAdmin, "utilisateur");
        $boutonCreation = self::genererBoutonCreation("utilisateur");

        self::afficherVue('vueGenerale.php', [
            "titre" => "Liste des utilisateurs",
            "cheminCorpsVue" => "administrateur/liste.php",
            "contenuTableau" => $tableauHTML,
            "boutonCreation" => $boutonCreation
        ]);
    }

    public static function afficherListeServices(): void {
        $estAdmin = ConnexionUtilisateur::estAdministrateur();
        $services = array_merge(
            (new AnalyseVideoRepository())->recuperer(),
            (new CoachingRepository())->recuperer()
        );

        $tableauHTML = self::genererTableauObjets($services, $estAdmin, "service");
        $boutonCreation = self::genererBoutonCreation("service");

        self::afficherVue('vueGenerale.php', [
            "titre" => "Liste des services",
            "cheminCorpsVue" => "administrateur/liste.php",
            "contenuTableau" => $tableauHTML,
            "boutonCreation" => $boutonCreation
        ]);
    }

    public static function afficherListeCoachs(): void {
        $estAdmin = ConnexionUtilisateur::estAdministrateur();
        $utilisateurs = self::filtrerCoachsParJeuEtLangue();

        $tableauHTML = self::genererTableauObjets($utilisateurs, $estAdmin, "coach");
        $boutonCreation = self::genererBoutonCreation("coach");

        self::afficherVue('vueGenerale.php', [
            "titre" => "Liste des coachs",
            "cheminCorpsVue" => "administrateur/liste.php",
            "contenuTableau" => $tableauHTML,
            "boutonCreation" => $boutonCreation
        ]);
    }

    private static function filtrerCoachsParJeuEtLangue(): array {
        $utilisateurs = [];

        if (!isset($_REQUEST['jeu']) || $_REQUEST['jeu'] === 'rien') {
            $utilisateurs = (new CoachRepository())->recuperer();
        } else {
            $jeu = (new JeuRepository())->recupererParClePrimaire($_REQUEST['jeu']);
            if ($jeu === null) {
                $utilisateurs = (new CoachRepository())->recuperer();
            } else {
                $tabs = (new JouerRepository())->recupererJoueursAvecJeu($jeu->getCodeJeu());
                foreach ($tabs as $tab) {
                    if ((new CoachRepository())->estCoach($tab->getId())) {
                        $utilisateurs[] = (new CoachRepository())->recupererParClePrimaire($tab->getId());
                    }
                }
            }
        }

        if (isset($_REQUEST['lang']) && $_REQUEST['lang'] !== 'rien') {
            $utilisateurs = array_filter($utilisateurs, function($utilisateur) {
                return (new ParlerRepository())->existeTuple([$utilisateur->getId(), $_REQUEST['lang']]);
            });
        }

        return $utilisateurs;
    }

    private static function genererTableauObjets(array $objets, bool $estAdmin, string $controleur): string {
        if (empty($objets)) return '';

        $html = '<div class="admin-list">';
        $html .= '<div class="admin-list-header">';
        $html .= '<h2>Liste des ' . htmlspecialchars(ucfirst($controleur)) . 's</h2>';
        $html .= '</div>';

        $html .= '<table class="admin-table"><thead><tr>';

        foreach ($objets[0]->getNomColonnes() as $colonne) {
            $html .= "<th>" . htmlspecialchars($colonne) . "</th>";
        }
        $html .= '<th>Actions</th></tr></thead><tbody>';

        foreach ($objets as $objet) {
            $html .= self::genererLigneTableau($objet, $estAdmin);
        }

        $html .= '</tbody></table></div>';
        return $html;
    }

    private static function genererLigneTableau(ObjetListable $objet, bool $estAdmin): string {
        $idURL = rawurlencode($objet->getIdListable());
        $elements = $objet->getElementColonnes();

        $html = '<tr>';
        foreach ($elements as $element) {
            $html .= '<td class="admin-list-text">';
            if ($element === $objet->getIdListable()) {
                $html .= sprintf(
                    '<a class="admin-list-id" href="../web/controleurFrontal.php?controleur=%s&action=afficherDetail&id=%s">%s</a>',
                    $objet->getControleur(),
                    $idURL,
                    htmlspecialchars($element)
                );
            } else {
                $html .= htmlspecialchars($element);
            }
            $html .= '</td>';
        }

        if ($estAdmin) {
            $html .= self::genererBoutonsAction($objet->getControleur(), $idURL);
        }

        $html .= '</tr>';
        return $html;
    }

    private static function genererBoutonsAction(string $controleur, string $idURL): string {
        return sprintf(
            '<td class="admin-actions">
                <a href="../web/controleurFrontal.php?controleur=%s&action=afficherFormulaireMiseAJour&id=%s" 
                   class="admin-btn admin-btn-edit">Modifier</a>
                <a href="../web/controleurFrontal.php?controleur=%s&action=supprimer&id=%s" 
                   class="admin-btn admin-btn-delete">Supprimer</a>
            </td>',
            $controleur, $idURL, $controleur, $idURL
        );
    }

    private static function genererBoutonCreation(string $controleur): string {
        $lienControleur = $controleur === "coach" ? "utilisateur" : $controleur;
        return sprintf(
            '<div class="admin-create-section">
                <a href="../web/controleurFrontal.php?controleur=%s&action=afficherFormulaireCreation" 
                   class="admin-create-btn">Créer un nouveau %s</a>
            </div>',
            $lienControleur,
            htmlspecialchars(ucfirst($controleur))
        );
    }
}