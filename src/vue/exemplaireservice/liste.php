<?php


use App\PlayToWin\Modele\DataObject\ExemplaireService;

echo "<h2>Liste des services commandé</h2>";
/** @var ExemplaireService[] $exemplaireservices */
/** @var string $controleur  */
?>

<?php foreach ($exemplaireservices as $exemplaireservice): ?>
    <a  href="../web/controleurFrontal.php?controleur=exemplaireservice&action=afficherDetails&codeService=<?php echo $exemplaireservice->getCodeService(); ?>">
        <div>
            <?php echo $exemplaireservice->getSujet(); ?>
            <?php echo $exemplaireservice->getEtatService(); ?>
        </div>
    </a>
<?php endforeach; ?>