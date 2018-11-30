<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<title>commusic_logout</title>
</head>

<body bgcolor="#ffffe0">
	<h2>Commusic</h2>
	
	<hr>

<div style="text-align:center">

<?php
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);

session_start();
session_destroy();
$message = "ログアウトしました。";
?>

<p><?php echo $message ?></p>

<p><a href="Top.php">TOPへ</a></p>

</div>

</body>

</html>