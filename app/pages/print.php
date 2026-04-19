<?php

use App\Controllers\TableController;
use Dompdf\Dompdf;

$tableController = new TableController();
$id = $_GET['id'];
$info = $tableController->getTableById($id) ?? [];
$fileName = "tabla_" . $info['name'] . ".pdf";

ob_end_clean(); //Limpiamos el buffer para evitar renderizados no deseados en el PDF

//Instanciamos Dompdf, generamos el HTML con la función y lo cargamos a Dompdf
$dompdf = new Dompdf();
$html = printTable($info);
$dompdf->loadHtml($html);

//Configuramos el tamaño del papel y renderizamos
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

//Enviamos el PDF al navegador para la descarga
$dompdf->stream($fileName, ["Attachment" => true]);

exit;

function printTable($info)
{
    $table = $info['table'] ?? null;
    $tableName = $info['name'] ?? null;
    $creator = $info['creator'] ?? null;

    ob_start();
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
                color: #333;
            }

            .header {
                text-align: center;
                margin-bottom: 15px;
                padding: 10px;
                border: 2px solid #6c757d;
                border-left: 5px solid #ffc107;
                background-color: #f8f9fa;
                border-radius: .25rem;
            }

            .header h1 {
                margin: 0;
                font-size: 28px;
                color: #333;
            }

            .header small {
                color: #666;
                font-size: 12px;
                font-style: italic;
            }

            .day-section {
                margin-bottom: 10px;
                page-break-inside: avoid;
            }

            .day-header {
                background-color: #0056b3;
                color: white;
                padding: 2px;
                font-size: 16px;
                font-weight: bold;
                border: 2px solid #0056b3;
                border-left: 5px solid #007bff;
                text-align: center;
                border-top-left-radius: .25rem;
                border-top-right-radius: .25rem;
            }

            .exercises-table {
                width: 100%;
                border-collapse: collapse;
                border: 1px solid #6c757d;
            }

            .exercises-table thead {
                background-color: #e9ecef;
            }

            .exercises-table th {
                padding: 6px;
                text-align: center;
                border: 1px solid #6c757d;
                font-weight: bold;
                background-color: #e9ecef;
                font-size: 14px;
            }

            .exercises-table td {
                padding: 6px;
                border: 1px solid #6c757d;
                vertical-align: middle;
            }

            .exercise-name {
                font-size: 12px;
                font-weight: bold;
                color: #333;
            }

            .exercise-description {
                font-size: 10px;
                color: #666;
                font-style: italic;
            }

            .col-name {
                width: 60%;
            }

            .col-series {
                width: 20%;
                text-align: center;
                vertical-align: middle;
            }

            .col-reps {
                width: 20%;
                text-align: center;
                vertical-align: middle;
            }

            .footer {
                margin-top: 40px;
                padding-top: 10px;
                border-top: 1px solid #ddd;
                font-size: 10px;
                color: #999;
                text-align: center;
            }
        </style>
    </head>

    <body>
        <table style="width: 100%; border: none; margin-bottom: 15px;">
            <tr>
                <td style="text-align: left; font-size: 10px; color: #999; font-style: italic;">
                    Página desarrollada por Ángel Leal Araya
                </td>
                <td style="text-align: right; font-size: 10px; color: #999; font-style: italic;">
                    Crea tu rutina
                </td>
            </tr>
        </table>

        <div class="header">
            <h1>Tabla: <?= $tableName ?></h1>
            <small>Creada por: <?= $creator ?></small>
        </div>

        <?php foreach ($table as $day => $exercises) {
            $group = reset($exercises)['group'] ?? '0';
            $sameGroup = true;
            foreach ($exercises as $exercise) {
                if ($exercise['group'] !== $group) {
                    $sameGroup = false;
                    break;
                }
            }


        ?>
            <div class="day-section">
                <div class="day-header">
                    <?= DOW_TO_SP[$day] . ' - ' . ($sameGroup ? EXERCISE_GROUPS[$group] : 'Mixto') ?>
                </div>
                <table class="exercises-table">
                    <thead>
                        <tr>
                            <th class="col-name">Ejercicio</th>
                            <th class="col-series">Series</th>
                            <th class="col-reps">Repeticiones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($exercises as $exercise) { ?>
                            <tr>
                                <td class="col-name">
                                    <div class="exercise-name"><?= $exercise['name'] ?></div>
                                    <div class="exercise-description"><?= $exercise['description'] ?></div>
                                </td>
                                <td class="col-series"><?= $exercise['series'] ?></td>
                                <td class="col-reps"><?= $exercise['reps'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>

        <div class="footer">
            Documento generado desde Crea tu rutina
        </div>
    </body>

    </html>
<?php
    return ob_get_clean();
}
?>