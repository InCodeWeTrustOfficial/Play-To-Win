<?php

/** @var Service $service */

use App\PlayToWin\Modele\DataObject\Service;

echo '
    <span class="service-price"> ' . $duree = htmlspecialchars($service->getDuree()) . ' min </span>
';