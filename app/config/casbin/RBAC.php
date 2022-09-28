<?php

return [
    'Users' => [
        'doubleswu' => [
            'normal',
            env('CASBIN_ADMIN_USER_NAME')
        ],
        'user_1' => [
            'group1'
        ],
    ],
    'Apis' => [
        'normal' => [
            'api/test' => ['GET','POST']
        ]
    ],
    'Roles' => [
        'normal',
        'group1'
    ]
];
