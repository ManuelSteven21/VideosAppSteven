<?php

return [
    'default_user' => [
        'name' => env('DEFAULT_USER_NAME', 'Robin'),
        'email' => env('DEFAULT_USER_EMAIL', 'robin@iesebre.com'),
        'password' => env('DEFAULT_USER_PASSWORD', 'RobinHood'),
        'current_team_id' => env('DEFAULT_USER_CURRENT_TEAM_ID', 1),
    ],
    'default_teacher' => [
        'name' => env('DEFAULT_TEACHER_NAME', 'Batman'),
        'email' => env('DEFAULT_TEACHER_EMAIL', 'batman@iesebre.com'),
        'password' => env('DEFAULT_TEACHER_PASSWORD', 'TheDarkKnight'),
        'current_team_id' => env('DEFAULT_TEACHER_CURRENT_TEAM_ID', 2),
    ],
];
