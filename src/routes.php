<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Firebase\JWT\JWT;

require_once 'Session.php';


$app->post('/api/login', function(Request $request, Response $response) {
    $session = Session::getInstance();

    // get user & pass
    $email = $request->getParam('email');
    $password = $request->getParam('password');

    $res_unauthorized = [
        'status' => 'error',
        'message' => 'Unauthorized',
    ];

    $users = [
        'admin@abc.com' => '$2y$10$koHgqFVEMvBFge9Ud/v0hO22voKEpzq2V07rUsQOEir/TF9v5tc6y', // admin99
    ];
    if (!isset($users[$email])) {
        return $response->withStatus(401)->withJson($res_unauthorized);
    }

    if (!password_verify($password, $users[$email])) {
        return $response->withStatus(401)->withJson($res_unauthorized);
    }

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

    $data = [
        'status' => 'success',
        'data' => $token,
    ];
    return $response->withJson($data);
});

$app->get('/api/me', function(Request $request, Response $response) {
    $key = getenv('JWT_SECRET');
    $token = $_COOKIE['jwt_token'];
    try {
        $decoded = JWT::decode($token, $key, ['HS256']);
        // do something with $decoded
        return $response->withJson([
            'status' => 'success',
            'data' => [
                'email' => $decoded->sub
            ]
        ]);
    } catch (Exception $e) {
        return $response->withJson([
            'status' => 'error',
            'message' => 'Invalid token'
        ]);
    }
});
