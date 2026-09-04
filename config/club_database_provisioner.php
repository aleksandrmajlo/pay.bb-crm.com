<?php

$isLocal = env('APP_ENV', 'production') === 'local';

$defaultBaseUrl = $isLocal
    ? 'http://localhost:8081'
    : 'https://login.bb-crm.com';

$defaultConfigPaths = $isLocal
    ? '/Volumes/Usb_flash/Sites/Billiard/login.bb-crm.com/config/database.php,/Volumes/Usb_flash/Sites/Billiard/pt.bb-crm.com/config,/Volumes/Usb_flash/Sites/Billiard/pay.bb-crm.com/config/database.php'
    : '/var/www/bb_crm/data/www/login.bb-crm.com/config/database.php,/var/www/bb_crm/data/www/pt.bb-crm.com/config/database.php,/var/www/bb_crm/data/www/pay.bb-crm.com/config/database.php';

// Local deletion must never be routed to the production provisioner,
// even when production values remain present in the local .env file.
$baseUrl = $isLocal
    ? env('CLUB_DATABASE_PROVISIONER_LOCAL_URL', $defaultBaseUrl)
    : env('CLUB_DATABASE_PROVISIONER_URL', $defaultBaseUrl);

$configPaths = $isLocal
    ? $defaultConfigPaths
    : env('CLUB_DATABASE_PROVISIONER_CONFIG_PATHS', $defaultConfigPaths);

return [
    'base_url' => $baseUrl,
    'token' => env('CLUB_DATABASE_PROVISIONER_TOKEN'),
    'idempotency_key' => env(
        'CLUB_DATABASE_PROVISIONER_IDEMPOTENCY_KEY',
        'club-database-provisioner'
    ),
    'connect_timeout' => (int) env('CLUB_DATABASE_PROVISIONER_CONNECT_TIMEOUT', 5),
    'timeout' => (int) env('CLUB_DATABASE_PROVISIONER_TIMEOUT', 30),
    'config_paths' => array_values(array_filter(array_map(
        'trim',
        explode(',', (string) $configPaths)
    ))),
];
