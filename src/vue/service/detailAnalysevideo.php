<?php
/** @var Service $service */

use App\PlayToWin\Modele\DataObject\Service;

echo '
   <span class="service-price"> ' . htmlspecialchars($service->getNbJourRendu()) . ' Jour</span>
';