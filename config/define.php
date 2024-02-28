<?php

return [
    'permission' => [
        'movie' =>[
            'view_list' => 'view movies',
            'view_detail' => 'view movie',
            'add' => 'add movie',
            'update' => 'update movie',
            'delete' => 'delete movie',
        ],
        'cinema' =>[
            'view_list' => 'view cinemas',
            'view_detail' => 'view cinema',
            'add' => 'add cinema',
            'update' => 'update cinema',
            'delete' => 'delete cinema',
        ],
        'room' =>[
            'view_list' => 'view rooms',
            'view_detail' => 'view room',
            'add' => 'add room',
            'update' => 'update room',
            'delete' => 'delete room',
        ],
        'seat' =>[
            'view_list' => 'view seats',
            'view_detail' => 'view seat',
            'add' => 'add seat',
            'update' => 'update seat',
            'delete' => 'delete seat',
        ],
        'order' =>[
            'view_list' => 'view orders',
            'view_detail' => 'view order',
            'add' => 'add order',
            'update' => 'update order',
            'delete' => 'delete order',

            'view_self_list'=>'view self orders',
            'view_seft_detail' => 'view self order'
        ],
        'schedule' =>[
            'view_list' => 'view schedules',
            'view_detail' => 'view schedule',
            'add' => 'add schedule',
            'update' => 'update schedule',
            'delete' => 'delete schedule',
        ]
    ],
    'price' => [
        'mon' => 50000,
        'tue' => 80000,
        'wed' => 80000,
        'thu' => 80000,
        'fri' => 90000,
        'sar' => 80000,
        'sun' => 100000,
    ]
];
