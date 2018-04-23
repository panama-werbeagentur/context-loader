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
    ],
    'MAIL' => [
        'transport' => getenv('MAIL_TRANSPORT'),
        'transport_smtp_server' => getenv('MAIL_TRANSPORT_SMTP_SERVER'),
        'transport_smtp_encrypt' => getenv('MAIL_TRANSPORT_SMTP_ENCRYPT'),
        'transport_smtp_username' => getenv('MAIL_TRANSPORT_SMTP_USERNAME'),
        'transport_smtp_password' => getenv('MAIL_TRANSPORT_SMTP_PASSWORD'),
        'transport_sendmail_command' => getenv('MAIL_TRANSPORT_SENDMAIL_COMMAND'),

        'defaultMailFromAddress' => getenv('MAIL_DEFAULT_FROMADDRESS'),
        'defaultMailFromName' => getenv('MAIL_DEFAULT_FROMNAME'),
    ]
];
