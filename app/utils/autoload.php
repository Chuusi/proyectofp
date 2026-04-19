<?php
require '../vendor/autoload.php';
$controllers = glob(CONTROLLERS . '/*.php');
$models = glob(MODELS . '/*.php');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../utils/constants.php';

foreach ($controllers as $controller) {
    require_once($controller);
}

foreach ($models as $model) {
    require_once($model);
}
