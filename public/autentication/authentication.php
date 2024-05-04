<?php

// If using Composer:
require __DIR__ . '/vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\Auth\FirebaseAuth;

$firebaseConfig = array(
    'apiKey' => '<YOUR_API_KEY>',
    'authDomain' => '<YOUR_AUTH_DOMAIN>',
    'databaseURL' => '<YOUR_DATABASE_URL>',
    'projectId' => '<YOUR_PROJECT_ID>',
    'storageBucket' => '<YOUR_STORAGE_BUCKET>',
    'messagingSenderId' => '<YOUR_MESSAGING_SENDER_ID>',
    'appId' => '<YOUR_APP_ID>'
);

$firebase = FirebaseAuth::fromCredentials($firebaseConfig);

$token = $_POST['token'];

try {
    $decodedToken = JWT::decode($token, '<YOUR_SECRET_KEY>', true, array('HS256'));
    $uid = $decodedToken['uid'];

    // Verify the user ID in your database or perform other authentication checks
    // If successful, set session variables or redirect to a secure page

    echo json_encode(array('status' => 'success', 'message' => 'Usuário autenticado'));
} catch (Exception $e) {
    echo json_encode(array('status' => 'error', 'message' => 'Falha na autenticação: ' . $e->getMessage()));
}

