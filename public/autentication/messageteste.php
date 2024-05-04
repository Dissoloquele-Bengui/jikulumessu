<?php
require_once 'vendor/autoload.php';

use VonageClientCredentialsBasic;
use VonageClient;

$basic  = new Basic('054c9d06', '9ftNYqGLWB6hvzP8')
$client = new Client($basic);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = $client->sms()->send(
        new VonageSMSMessageSMS('244947603703', 'JIKULUMESU', $_POST['Seu código de verificação é'])
    );

    $message = $response->current();

    if ($message->getStatus() == 0) {
        echo "A mensagem foi enviada com sucesso";
    } else {
        echo "O envio da mensagem falhou com o status: " . $message->getStatus() . "n";
    }
}