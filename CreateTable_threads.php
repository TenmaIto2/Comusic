<?php
$dsn = '�f�[�^�x�[�X��';
$user = '���[�U�[��';
$password = '�p�X���[�h';
$pdo = new PDO($dsn,$user,$password);
?>

<?php
$sql = "CREATE TABLE threads"
."("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."name varchar(32) NOT NULL,"
."title varchar(100) NOT NULL," 
."comment varchar(200) NOT NULL,"
."date timestamp"
.");";

$stmt = $pdo->query($sql);
?>

CREATE TABLE threads