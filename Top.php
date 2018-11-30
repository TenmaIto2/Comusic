<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<title>commusic_Top</title>
</head>

<body bgcolor="#ffffe0">
	<div style="text-align:center">
	
	<h1>Commusic</h1>
	music + community<br>
	音楽好きが集まる掲示板
	<hr>

<?php
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);
?>

<form method="post" action="login.php">
	
	<p>～ログイン～</p>
	<p><input type="text" name="username" placeholder="ユーザー名" value=""></p>
	<p><input type="password" name="loginPass" placeholder="パスワード" value=""></p>
	<p><input type="submit" name="login" value="ログイン"></p>
	
</form>

<hr>

<form method="post" action="signup.php">
	
	<p>～新規登録～</p>
	<p><input type="text" name="signupName" placeholder="ユーザー名" value=""></p>
	<p><input type="password" name="signupPass" placeholder="パスワード" value=""></p>
	<p><input type="submit" name="signup"value="登録"></p>
	
</form>

<hr>

<form method="post" action="deleteusers.php">
	
	<p>～退会(ユーザーデータ削除)～</p>
	<p><input type="text" name="deleteName" placeholder="ユーザー名" value=""></p>
	<p><input type="password" name="deletePass" placeholder="パスワード" value=""></p>
	<p><input type="submit" name="delete"value="退会"></p>
	
</form>

</div>

</body>

</html>