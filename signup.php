<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<title>commusic_signup</title>
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

$signupName = htmlspecialchars($_POST['signupName']);
$signupPass = htmlspecialchars($_POST['signupPass']);

if(!empty($_POST['signupName'])){

	if(!empty($_POST['signupPass'])){
		$signupsql = $pdo -> prepare("INSERT INTO users(username,pass) VALUES(:username,:pass)");
		$signupsql -> bindParam(':username',$signupName,PDO::PARAM_STR);
		$signupsql -> bindParam(':pass',$signupPass,PDO::PARAM_STR);
		$signupFlag = $signupsql -> execute();
			
		if ($signupFlag){
			print('登録しました。<br>');
		}
		else{
				print('エラー:入力されたユーザーネームは既に登録されている可能性があります。<br>');
		}
	}
	
	else{
		print('パスワードを設定してください。<br>');
	}
}

else{
	print('ユーザーネームを入力してください。<br>');
}

?>

<p><a href="Top.php">戻る</a></p>

</div>


</body>

</html>