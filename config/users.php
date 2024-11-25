<?php

return [
    'default_user' => [
        'name' => env('DEFAULT_USER_NAME', 'Robin'),
        'email' => env('DEFAULT_USER_EMAIL', 'robin@iesebre.com'),
        'password' => env('DEFAULT_USER_PASSWORD', 'RobinHood'),
    ],
    'default_teacher' => [
        'name' => env('DEFAULT_TEACHER_NAME', 'Batman'),
        'email' => env('DEFAULT_TEACHER_EMAIL', 'batman@iesebre.com'),
        'password' => env('DEFAULT_TEACHER_PASSWORD', 'TheDarkKnight'),
    ],
];
