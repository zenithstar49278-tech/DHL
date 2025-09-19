<?php
$host = 'localhost';
$dbname = 'db8hcpfk0p8w38';
$user = 'ubpkik01jujna';
$pass = 'f0ahnf2qsque';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
