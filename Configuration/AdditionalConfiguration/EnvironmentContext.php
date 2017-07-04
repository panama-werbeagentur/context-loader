<?php
return [
    'BE'      => [
        'installToolPassword' => getenv('TYPO3_INSTALLTOOL_PASSWORD'),
    ],
    'DB'      => [
        'Connections' => [
            'Default' => [
                'charset'     => getenv('MYSQL_CHARSET'),
                'driver'      => getenv('MYSQL_DRIVER'),
                'user'        => getenv('MYSQL_USER'),
                'password'    => getenv('MYSQL_PASSWORD'),
                'host'        => getenv('MYSQL_HOST'),
                'port'        => getenv('MYSQL_PORT'),
                'unix_socket' => getenv('MYSQL_SOCKET'),
                'dbname'      => getenv('MYSQL_DATABASE'),
            ],
        ],
    ]
];
