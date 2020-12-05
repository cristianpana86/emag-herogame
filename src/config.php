<?php

$config  = [
    // General game parameters
    'GAME' => [
        'max_rounds_count' => 20,
    ],
    // Hero params section
    'HERO' => [
        'health_lower_limit' => 70,
        'health_upper_limit' => 100,
        'strength_lower_limit' => 90,
        'strength_upper_limit' => 100,
        'defense_lower_limit'  => 45,
        'defense_upper_limit' => 55,
        'speed_lower_limit'  => 40,
        'speed_upper_limit'  => 50,
        'luck_lower_limit'  => 10,
        'luck_upper_limit' => 30,
        'attacking_skills' => [
            'rapid_strike' => [
                'chancePercentage' => 10,
                'some_feature' => 10,
            ],
        ],
        'defensive_skills' => [
            'magic_shield' => [
                'chancePercentage' => 20,
                'some_feature' => 10,
            ],
        ],
    ],
    // Beast params section
    'BEAST' => [
        'health_lower_limit' => 60,
        'health_upper_limit' => 90,
        'strength_lower_limit' => 60,
        'strength_upper_limit' => 90,
        'defense_lower_limit'  => 40,
        'defense_upper_limit' => 60,
        'speed_lower_limit'  => 40,
        'speed_upper_limit'  => 60,
        'luck_lower_limit'  => 25,
        'luck_upper_limit' => 40,
        'attacking_skills' => [
            'dummy_strike' => [
                'chancePercentage' => 100,
                'extra_strength' => 10,
            ],
        ],
        'defensive_skills' => [
            'dummy_shield' => [
                'chancePercentage' => 100,
                'extra_health' => 10,
            ],
        ],
    ],
];

return $config;