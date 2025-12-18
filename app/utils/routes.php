<?php

use App\Core\Routes;

Routes::get('/home', function () {
    echo "Estás pidiendo tablas";
    die();
});
