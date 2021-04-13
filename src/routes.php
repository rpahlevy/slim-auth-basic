<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Firebase\JWT\JWT;

require_once 'Session.php';


$app->get('/', function(Request $request, Response $response) {
    $file = __DIR__ .'/../templates/homepage.html';
    return $response->write(file_get_contents($file));
});

$app->get('/login', function(Request $request, Response $response) {
    // cek apakah sudah login
    if (isset($_COOKIE['jwt_token'])) {
        $key = getenv('JWT_SECRET');
        $token = $_COOKIE['jwt_token'];
        try {
            $decoded = JWT::decode($token, $key, ['HS256']);
            // do something with $decoded
            return $response->withRedirect('/');
        } catch (Exception $e) {}
    }
    $file = __DIR__ .'/../templates/login.html';
    return $response->write(file_get_contents($file));
});

$app->post('/api/login', function(Request $request, Response $response) {
    $session = Session::getInstance();

    // generate token
    $key = getenv('JWT_SECRET');
    $exp = getenv('JWT_EXP');
    $now = new DateTime();
    $future = new DateTime("now +{$exp} hours");

    $payload = [
        "iss" => getenv('APP_URL'),
        "aud" => getenv('APP_URL'),
        "iat" => $now->getTimeStamp(),
        "sub" => $session->user,
        // "role" => "admin",
    ];

    $token = JWT::encode($payload, $key);
    // $decoded = JWT::decode($token, $key, ['HS256']);

    // remove $session->user
    unset($session->user);

    $data = [
        'success' => true,
        'message' => 'Berhasil login',
        'token' => $token,
    ];
    return $response->withJson($data);
});
