<?php

// Ejecutar desde consola si es necesario para poblar la base de datos con ejercicios de ejemplo

include('../config/config.php');
include('./autoload.php');

use App\Models\Exercise;

$exerciseModel = new Exercise();

$exercises = [

    // ---- PIERNA (1) ----
    [
        'name' => 'Sentadillas',
        'description' => 'Ejercicio básico multiarticular para cuádriceps y glúteos.',
        'reps' => 12,
        'series' => 4,
        'group' => 1,
        'creator' => 'Seeder'
    ],
    [
        'name' => 'Peso muerto convencional',
        'description' => 'Trabajo global de la cadena posterior.',
        'reps' => 6,
        'series' => 4,
        'group' => 1,
        'creator' => 'Seeder'
    ],
    [
        'name' => 'Prensa de piernas',
        'description' => 'Movimiento guiado para fuerza en miembros inferiores.',
        'reps' => 12,
        'series' => 4,
        'group' => 1,
        'creator' => 'Seeder'
    ],
    [
        'name' => 'Zancadas caminando',
        'description' => 'Ejercicio unilateral para estabilidad y potencia.',
        'reps' => 10,
        'series' => 3,
        'group' => 1,
        'creator' => 'Seeder'
    ],
    [
        'name' => 'Curl femoral tumbado',
        'description' => 'Aislamiento de isquiotibiales.',
        'reps' => 12,
        'series' => 3,
        'group' => 1,
        'creator' => 'Seeder'
    ],
    [
        'name' => 'Elevación de talones de pie',
        'description' => 'Trabajo específico de gemelos.',
        'reps' => 15,
        'series' => 4,
        'group' => 1,
        'creator' => 'Seeder'
    ],

    // ---- BRAZO (2) ----
    [
        'name' => 'Flexiones',
        'description' => 'Ejercicio de empuje para pecho, tríceps y hombros.',
        'reps' => 15,
        'series' => 4,
        'group' => 2,
        'creator' => 'Seeder'
    ],
    [
        'name' => 'Curl con barra recta',
        'description' => 'Trabajo principal para bíceps braquial.',
        'reps' => 10,
        'series' => 3,
        'group' => 2,
        'creator' => 'Seeder'
    ],
    [
        'name' => 'Curl alterno con mancuernas',
        'description' => 'Ejercicio unilateral para bíceps.',
        'reps' => 12,
        'series' => 3,
        'group' => 2,
        'creator' => 'Seeder'
    ],
    [
        'name' => 'Fondos en paralelas',
        'description' => 'Movimiento compuesto enfocado en tríceps.',
        'reps' => 8,
        'series' => 4,
        'group' => 2,
        'creator' => 'Seeder'
    ],
    [
        'name' => 'Extensión de tríceps en polea',
        'description' => 'Aislamiento del tríceps con agarre en cuerda.',
        'reps' => 12,
        'series' => 3,
        'group' => 2,
        'creator' => 'Seeder'
    ],
    [
        'name' => 'Press militar con barra',
        'description' => 'Empuje vertical para deltoides.',
        'reps' => 8,
        'series' => 4,
        'group' => 2,
        'creator' => 'Seeder'
    ],

    // ---- CORE (3) ----
    [
        'name' => 'Plancha',
        'description' => 'Ejercicio isométrico de estabilidad abdominal.',
        'reps' => 30,
        'series' => 3,
        'group' => 3,
        'creator' => 'Seeder'
    ],
    [
        'name' => 'Crunch abdominal',
        'description' => 'Flexión de tronco controlada para abdomen.',
        'reps' => 20,
        'series' => 3,
        'group' => 3,
        'creator' => 'Seeder'
    ],
    [
        'name' => 'Elevaciones de piernas',
        'description' => 'Trabajo enfocado en abdomen inferior.',
        'reps' => 15,
        'series' => 3,
        'group' => 3,
        'creator' => 'Seeder'
    ],
    [
        'name' => 'Russian twist',
        'description' => 'Movimiento rotacional para oblicuos.',
        'reps' => 20,
        'series' => 3,
        'group' => 3,
        'creator' => 'Seeder'
    ],

    // ---- VARIOS (4) ----
    [
        'name' => 'Dominadas pronas',
        'description' => 'Ejercicio compuesto de tracción para espalda y brazos.',
        'reps' => 8,
        'series' => 4,
        'group' => 4,
        'creator' => 'Seeder'
    ],
    [
        'name' => 'Remo con barra',
        'description' => 'Trabajo de tracción horizontal.',
        'reps' => 10,
        'series' => 4,
        'group' => 4,
        'creator' => 'Seeder'
    ],
    [
        'name' => 'Jalón al pecho',
        'description' => 'Alternativa en polea para dorsales.',
        'reps' => 12,
        'series' => 3,
        'group' => 4,
        'creator' => 'Seeder'
    ],
    [
        'name' => 'Hip thrust',
        'description' => 'Extensión de cadera enfocada en glúteos.',
        'reps' => 10,
        'series' => 4,
        'group' => 4,
        'creator' => 'Seeder'
    ],
    [
        'name' => 'Burpees',
        'description' => 'Ejercicio funcional de cuerpo completo.',
        'reps' => 12,
        'series' => 3,
        'group' => 4,
        'creator' => 'Seeder'
    ],
    [
        'name' => 'Mountain climbers',
        'description' => 'Movimiento dinámico para resistencia y core.',
        'reps' => 30,
        'series' => 3,
        'group' => 4,
        'creator' => 'Seeder'
    ],
    [
        'name' => 'Farmer walk',
        'description' => 'Trabajo de agarre y estabilidad global.',
        'reps' => 40,
        'series' => 3,
        'group' => 4,
        'creator' => 'Seeder'
    ]
];

$result = $exerciseModel->insertMany($exercises);

echo "Insertados: " . count($result->getInsertedIds());
