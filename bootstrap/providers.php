<?php

use Triibo\Mautic\MauticServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\FortifyServiceProvider::class,
    App\Providers\HorizonServiceProvider::class,
    App\Providers\VoltServiceProvider::class,
    MauticServiceProvider::class,
];
