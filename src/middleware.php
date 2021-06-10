<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

use Slim\Http\Request;
use Slim\Http\Response;

require_once 'Session.php';


$app->add(new \Slim\Middleware\JwtAuthentication([
    "secure" => true,
    "relaxed" => ["localhost"],
    "path" => "/",
    "passthrough" => ["/login", "/api/login"],
    "cookie" => "jwt_token",
    "secret" => getenv('JWT_SECRET'),
    "error" => function (Request $request, Response $response, $arguments) {
        $file = __DIR__ .'/../templates/redirect-login.html';
        return $response->write(file_get_contents($file));
    }
]));

// $app->add(new \Slim\Middleware\HttpBasicAuthentication([
//     "secure" => true,
//     "relaxed" => ["localhost"],
//     "path" => ["/api/login"],
//     "realm" => "Protected",
//     "users" => [
//         "admin@abc.com" => "admin99",
//     ],
//     // "authenticator" => new PdoAuthenticator([
//     //     "pdo" => $pdo,
//     //     "table" => "users",
//     //     "user" => "email",
//     //     "hash" => "password"
//     // ]),
//     "callback" => function (Request $request, Response $response, $arguments) {
//         // simpan user (email) untuk digunakan membuat JWT
//         $session = Session::getInstance();
//         $session->user = $arguments['user'];
//     },
//     "error" => function (Request $request, Response $response, $arguments) {
//         $data = [
//             "success" => false,
//             "message" => "Username / Password salah",
//         ];
//         return $response->withJson($data);
//     }
// ]));
