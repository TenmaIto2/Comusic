<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">

<title>commusic_deleteUsers</title>
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

$dlname = $_POST['deleteName'];
$dlpass = $_POST['deletePass'];

if($dlname!=null && $dlpass!=null){
	$sql = 'SELECT * FROM users';
	$result = $pdo -> query($sql);
	
	foreach($result as $row){
		if($row['username']==$dlname){
			if($row['pass']==$dlpass){
				$sql = "DELETE FROM users WHERE username = :username AND pass = :pass";
				$stmt = $pdo->prepare($sql);
				$stmt -> bindParam(':username',$dlname,PDO::PARAM_INT);
				$stmt -> bindParam(':pass',$dlpass,PDO::PARAM_STR);
				$deleteFlag = $stmt->execute();
				if ($deleteFlag){
					print('ユーザーデータを削除しました。<br>');
				}
				else{
					print('ユーザーデータ削除失敗...<br>');
				}
			}
			else{
				echo "パスワードが違います!";
			}
		}
	}
}
?>


<p><a href="Top.php">TOPへ</a></p>


</div>


</body>

</html>
