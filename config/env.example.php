<?php
    require __DIR__ . '/local.development.php';

    // Database
    $settings['db1']['username'] = 'root';
    $settings['db1']['password'] = '';
    $settings['db1']['database'] = 'hotel';

    $settings['api_auth'] = [
        'users' => [
            'api-admin' => 'secret',
            'api-user' => 'secret',
        ],
    ];
?>
