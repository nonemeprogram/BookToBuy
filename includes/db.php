<?php
$host = 'localhost';
$dbname = 'mybooklist';
$username = 'root'; // Sostituisci con il tuo username
$password = ''; // Sostituisci con la tua password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
