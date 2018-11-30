<?php
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);
?>

<?php
$sql = "CREATE TABLE users"
."("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."username varchar(32) NOT NULL UNIQUE,"
."pass varchar(255) NOT NULL"
.");";

$stmt = $pdo->query($sql);
?>

CREATE TABLE users