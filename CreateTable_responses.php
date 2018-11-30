<?php
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);
?>

<?php
$sql = "CREATE TABLE responses"
."("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."threadid INT NOT NULL,"
."username varchar(32) NOT NULL,"
."comment TEXT NOT NULL,"
."date timestamp,"
."filename TEXT NULL,"
."extension TEXT NULL,"
."path varchar(255) NULL,"
."rawdata LONGBLOB NULL"
.")ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$stmt = $pdo->query($sql);
?>

CREATE TABLE responses