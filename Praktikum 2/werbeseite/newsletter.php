<?php

$dataFile = 'newsletter_data.txt';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $terms = isset($_POST['terms']) ? $_POST['terms'] : false;
    $language = $_POST['language'];

    if (empty($name)) {
        echo "Der Name darf nicht leer sein.<br>";
        exit;
    } 
    if (!$terms) {
        echo "Sie müssen den Datenschutzbestimmungen zustimmen.<br>";
        exit;
    } 
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Ihre E-Mail-Adresse ist ungültig.<br>";
        exit;
    } 
    if (preg_match("/@(rcpt\.at|damnthespam\.at|wegwerfmail\.de|trashmail\..*)$/i", $email)) {
        echo "Ihre E-Mail entspricht nicht den Vorgaben.<br>";
        exit;
    } 

    $data = [
        'name' => $name,
        'email' => $email,
        'language' => $language
    ];
    file_put_contents($dataFile, json_encode($data).PHP_EOL, FILE_APPEND);

    header("Location: index.php?message=success");
    exit;
}

?>
