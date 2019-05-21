<?php
$host = "127.0.0.1";
$port = 3306;
$username = "root";
$password = "";
$database = "hotel";

try {
    $db = new PDO('mysql:host=127.0.0.1;dbname=hotel', $username, $password);

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec("use `$database`");
