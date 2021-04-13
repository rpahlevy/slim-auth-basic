<?php
// DIC configuration

$container = $app->getContainer();

// db
// $container['db'] = function($c) {
//     $settings = $c->get('settings')['db'];
//     $connection = $settings['connection'];
//     $host = $settings['host'];
//     $port = $settings['port'];
//     $database = $settings['database'];
//     $username = $settings['username'];
//     $password = $settings['password'];

//     $dsn = "$connection:host=$host;port=$port;dbname=$database";
//     $options = [
//         PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
//         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//         PDO::ATTR_EMULATE_PREPARES   => false,
//     ];

//     try {
//         return new PDO($dsn, $username, $password, $options);
//     } catch (PDOException $e) {
//         throw new PDOException($e->getMessage(), (int)$e->getCode());
//     }
// };

/**
 * HELPER UNTUK DUMP + DIE
 */
function dump($var, $die=true) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    if ($die) {
        die();
    }
}

function asset($path) {
    if ($path[0] != '/') {
        $path = "/{$path}";
    }
    return "{$_ENV['APP_URL']}{$path}";
}

function url($path) {
    if ($path[0] != '/') {
        $path = "/{$path}";
    }
    return "{$_ENV['APP_URL']}{$path}";
}

function number_digit($number, $digit=1) {
    $target = pow(10, intval($digit)-1);
    if ($number > $target) {
        return $number;
    }
    $target_str_len = strlen((string)$target);
    $number_str = "$number";
    while (strlen($number_str) < $target_str_len) {
        $number_str = "0$number_str";
    }
    return $number_str;
}

/**
 * HELPER UNTUK FORMAT DATE
 */
function tanggal_format($time, $usetime=false) {
    switch (date('n', $time)) {
        case 1: $month = 'Januari'; break;
        case 2: $month = 'Februari'; break;
        case 3: $month = 'Maret'; break;
        case 4: $month = 'April'; break;
        case 5: $month = 'Mei'; break;
        case 6: $month = 'Juni'; break;
        case 7: $month = 'Juli'; break;
        case 8: $month = 'Agustus'; break;
        case 9: $month = 'September'; break;
        case 10: $month = 'Oktober'; break;
        case 11: $month = 'November'; break;
        default: $month = 'Desember'; break;
    }
    return date('j', $time) .' '. $month .' '. date('Y', $time) . ($usetime ? ' '. date('H:i', $time) : '');
}
