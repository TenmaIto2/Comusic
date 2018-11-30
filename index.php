<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<title>commusic_index</title>
</head>

<body bgcolor="#ffffe0">
	<h2>Commusic</h2>
	
<div style="text-align:center">

<?php
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);
?>

<?php
session_start();

echo "ようこそ".'&nbsp'.'<span style="color:#dc143c">'.$_SESSION['user'].'</span>'.'&nbsp'."さん".'<br>';


if(!isset($_SESSION['user'])){
	header("Location: Top.php");//ログインしてないとトップへ移動
	exit();
}

$showsql = 'SELECT * FROM threads order by id desc limit 0,5';
$result = $pdo -> query($showsql);


$threadtitle="";
$comment="";
$threadtitle = htmlspecialchars($_POST['threadtitle']);
$com = htmlspecialchars($_POST['comment']);
$comment = nl2br($com);
$name = $_POST['name'];

if(isset($_POST['suretate'])){

	if(!empty($_POST['threadtitle'])&&!empty($_POST['comment'])){
		$threadsql = $pdo -> prepare("INSERT INTO threads(name,title,comment) VALUES(:name,:title,:comment)");
		$threadsql -> bindParam(':name',$name,PDO::PARAM_STR);
		$threadsql -> bindParam(':title',$threadtitle,PDO::PARAM_STR);
		$threadsql -> bindParam(':comment',$comment,PDO::PARAM_STR);
		
		$threadFlag = $threadsql -> execute();
		if($threadFlag){
			$thread = $result->fetch(PDO::FETCH_ASSOC);
			$threadid = $thread['id']+1;
			header("Location: thread.php?id=".$threadid);
			
		}
		else{
			print('エラー：スレッド作成失敗...<br>');
		}
	}
	else{
		$error="スレッドタイトルと内容は必須です！";
	}
}

?>

<hr>

<p>～スレッド一覧(最新5件)～</p>
<table align="center" cellspacing="5">
<?php while($thread = $result->fetch(PDO::FETCH_ASSOC)):?>
	<tr>
	<td><a href="mission_6_thread.php?id=<?php echo $thread['id'];?>"><?php echo mb_strimwidth($thread['title'],0,30,"...",'UTF-8');?></a></td>
	<td><?php echo $thread['date'];?></td>
	<td>作成者：<?php echo $thread['name'];?></td>
	</tr>
<?php endwhile;?>
</table>

<p><a href="threadslist.php">もっと見る</a></p>

<hr>

<form method="post" action="mission_6_start.php">
	
	<p>～新規スレッド作成～</p>
	<p><input type="hidden" name="name" value="<?php echo $_SESSION['user'];?>"></p>
	<p><input type="text" name="threadtitle" placeholder="スレッドタイトル" value="" size="50"></p>
	<p><textarea name="comment" placeholder="スレッドの内容や説明" cols="50" rows="10" value=""></textarea></p>
	<p><input type="hidden" name="type" placeholder="" value="create"></p>
	<p><input type="submit" name="suretate" value="スレッド作成"></p>
	
</form>

<?php echo $error;?>

<hr>

<p><a href="logout.php">ログアウトする</a></p>

</div>

</body>

</html>