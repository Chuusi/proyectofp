<?php
$controllers = glob(CONTROLLERS . '/*.php');
$models = glob(MODELS . '/*.php');

require_once __DIR__ . '/../config/database.php';

foreach ($controllers as $controller) {
    require_once($controller);
}

foreach ($models as $model) {
    require_once($model);
}
