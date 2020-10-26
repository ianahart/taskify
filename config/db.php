<?php
// require(dirname(__DIR__) . '/vendor/autoload.php');

// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
// $dotenv->load();


include_once(__DIR__ . '/../public/classes/Task.php');
include_once(__DIR__ . '/../public/classes/User.php');



// $serverName = $_ENV['DB_HOST'];
// $username = $_ENV['DB_USERNAME'];
// $password = $_ENV['DB_PASSWORD'];
// $database = $_ENV['DB'];

// try {
//   $connection = new PDO("mysql:host=$serverName;dbname=$database", $username, $password);

//   $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//   echo 'Connection failed: ' . $e->getMessage();
// }

// $task = new Task($connection);
// $user = new User($connection);
