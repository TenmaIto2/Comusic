<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<title>commusic_threadslist</title>
</head>

<body bgcolor="#ffffe0">
	<h2>Commusic</h2>
	
<div style="text-align:center">

<hr>

<?php
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);
?>

<?php
session_start();
if(!isset($_SESSION['user'])){
	header("Top.php");//ログインしてないとトップへ移動
	exit();
}


$showsql = 'SELECT * FROM threads order by id desc';
$result = $pdo -> query($showsql);

$countsqlthr = "SELECT COUNT(id) AS num FROM threads";
$result_c = $pdo -> query($countsqlthr); 
$c = $result_c -> fetch(PDO::FETCH_ASSOC);


?>

<p>
～スレッド一覧～
<?php print("（全".$c['num']."件）");?>
</p>
<table align="center" cellspacing="10" width="800">
<?php while($thread = $result->fetch(PDO::FETCH_ASSOC)):?>
	<tr align="left">
	<td><a href="mission_6_thread.php?id=<?php echo $thread['id'];?>"><?php echo $thread['title'];?></a></td>
	<td width="300"><?php echo $thread['date'];?></td>
	<td>作成者：<?php echo $thread['name'];?></td>
	</tr>
<?php endwhile;?>
</table>

<p><a href="index.php">戻る</a></p>

</div>

</body>

</html>