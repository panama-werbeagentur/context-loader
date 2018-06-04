<?php

// TYPO3 Version 8.1 and higher got a new config structure
// @see https://docs.typo3.org/typo3cms/extensions/core/Changelog/8.1/Breaking-75454-LocalConfigurationDBConfigStructureHasChanged.html
if (\TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) >= 8001000) {
    $DB = [
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
    ];
} else {
    $DB = [
        'username' => getenv('MYSQL_USER'),
        'password' => getenv('MYSQL_PASSWORD'),
        'host'     => getenv('MYSQL_HOST'),
        'port'     => getenv('MYSQL_PORT'),
        'socket'   => getenv('MYSQL_SOCKET'),
        'database' => getenv('MYSQL_DATABASE'),
    ];
}

return [
    'BE'   => [
        'installToolPassword' => getenv('TYPO3_INSTALLTOOL_PASSWORD'),
    ],
    'DB'   => $DB,
    'MAIL' => [
        'transport'                  => getenv('MAIL_TRANSPORT'),
        'transport_smtp_server'      => getenv('MAIL_TRANSPORT_SMTP_SERVER'),
        'transport_smtp_encrypt'     => getenv('MAIL_TRANSPORT_SMTP_ENCRYPT'),
        'transport_smtp_username'    => getenv('MAIL_TRANSPORT_SMTP_USERNAME'),
        'transport_smtp_password'    => getenv('MAIL_TRANSPORT_SMTP_PASSWORD'),
        'transport_sendmail_command' => getenv('MAIL_TRANSPORT_SENDMAIL_COMMAND'),

        'defaultMailFromAddress' => getenv('MAIL_DEFAULT_FROMADDRESS'),
        'defaultMailFromName'    => getenv('MAIL_DEFAULT_FROMNAME'),
    ]
];
