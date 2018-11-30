<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<title>commusic_login</title>
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
?>

<?php

session_start();

if(isset($_SESSION['user'])){
	header("Location: index.php");//ログイン済みならメインページへ移動
	exit();
}

if(isset($_POST['login'])){//ログインボタンが押されたとき
	
	if(empty($_POST['username'])){
		print('ユーザー名が未入力です。<br>');
	}
	else if(empty($_POST['loginPass'])){
		print('パスワードが未入力です。<br>');
	}
	
	if(!empty($_POST['username'])&&!empty($_POST['username'])){
		
		$username = htmlspecialchars($_POST['username']);//ユーザー名
		$loginPass = htmlspecialchars($_POST['loginPass']);//パスワード
		
		try{
			$stmt = $pdo->prepare('SELECT*FROM users WHERE username = ?');
			$stmt->execute(array($username));
			
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
				
			if($loginPass==$row['pass']){
				$_SESSION['user'] = $username;
				header('index.php');
				exit();
			}
			else{
				echo "ユーザー名あるいはパスワードに誤りがあります。";
			}
		}
		catch(PDOException $e){
			echo "データベースエラー(PDOエラー)";
			var_dump($e->getMessage());
		}
	}
}

?>

<p><a href="Top.php">TOPへ</a></p>

</div>


</body>

</html>