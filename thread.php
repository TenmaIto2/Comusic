<!DOCTYPE html>

<?php
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);
?>

<?php

ini_set('max_execution_time',5000);

session_start();

if(!isset($_SESSION['user'])){
	header("Location: Top.php");//ログインしてないとトップへ移動
	exit();
}

$id = $_GET['id'];

$showsqlthr = "SELECT * FROM threads where id=".$id;
$result = $pdo -> query($showsqlthr);
$thread = $result -> fetch(PDO::FETCH_ASSOC);

$showsqlres = "SELECT * FROM responses where threadid =".$id;
$response = $pdo -> query($showsqlres);

$countsqlres = "SELECT COUNT(id) AS num FROM responses";
$result_c = $pdo -> query($countsqlres); 
$c = $result_c -> fetch(PDO::FETCH_ASSOC);

$username = $_POST['name'];
$com = htmlspecialchars($_POST['comment']);
$comment = nl2br($com);

$fname="";
$extension="";
$rawdata="";
$date="";
$target="";
$file="";

$filename = htmlspecialchars($_FILES['upfile']['name']);
$tmp = pathinfo($_FILES['upfile']['name']);
$ext = $tmp['extension'];

$tmp_name = $_FILES['upfile']['tmp_name'];

if(isset($_POST['res'])){//投稿ボタンが押された

	if(!empty($_POST['comment'])){//コメントがあるとき
		
		if(isset($_FILES['upfile']['error'])&& $_FILES['upfile']['name']!==""){//ファイルが送信されたとき
		
			$rawdata = file_get_contents($_FILES['upfile']['tmp_name']);
		
			if($ext==="jpg"|| $ext==="jpeg"|| $ext==="JPG" || $ext==="JPEG"){
				$extension = "jpeg";
			}
			elseif($ext==="png"|| $ext==="PNG"){
				$extension = "png";
			}
			elseif($ext==="gif"|| $ext==="GIF"){
				$extension = "gif";
			}
			elseif($ext==="mp4"|| $ext==="MP4"){
				$extension = "mp4";
			}
			elseif($ext==="mp3"|| $ext==="MP3"){
				$extension = "mp3";
			}
			else{
				$f_error = "非対応ファイルです。";
			}
			
			$date = getdate();
			$fname = $_FILES['upfile']['tmp_name'].$date['year'].$date['mon'].$date['mday'].$date['hours'].$date['minutes'].$date['seconds'];
			$fname = hash("sha256",$fname);
			
			$destination = sprintf('%s/%s.%s'
				,'upfiles'
				,$fname
				,$extension
			);
		}
		move_uploaded_file($tmp_name, $destination);
		
		
		$ressql = $pdo -> prepare("INSERT INTO responses(username,threadid,comment,filename,extension,path,rawdata) VALUES(:username,:threadid,:comment,:filename,:extension,:path,:rawdata)");
		$ressql -> bindParam(':username',$username,PDO::PARAM_STR);
		$ressql -> bindParam(':threadid',$id,PDO::PARAM_INT);
		$ressql -> bindParam(':comment',$comment,PDO::PARAM_STR);
		$ressql -> bindParam(':filename',$fname,PDO::PARAM_STR);
		$ressql -> bindParam(':extension',$extension,PDO::PARAM_STR);
		$ressql -> bindParam(':path',$destination,PDO::PARAM_STR);
		$ressql -> bindParam(':rawdata',$rawdata,PDO::PARAM_STR);
		
		$resFlag = $ressql -> execute();
		if($resFlag){
			$response = $result->fetch(PDO::FETCH_ASSOC);
		}
		else{
			$error="エラー：投稿失敗...";
		}
	}
}


$showsqlres = "SELECT * FROM responses where threadid =".$id;
$response = $pdo -> query($showsqlres);


?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">

<title><?php echo $thread['title']."-commusic";?></title>

<style type="text/css">
img.size{
height: 300px;
}
</style>

</head>

<body bgcolor="#ffffe0">
	<h2>Commusic</h2>
	
	<hr>

<div style="text-align:center">

<p>
<table align="center" cellspacing="10" rules="" width="800" height="">
	<tr><td><font size="5"><b><?php echo $thread['title'];?><b></font></td></tr>
	<tr><td>投稿者：<?php echo $thread['name'];?></td></tr>
	<tr><td height="50" align="center" valign="top"><?php echo $thread['comment'];?></td></tr>
	<tr><td><font size="2">作成日時：<?php echo $thread['date'];?></td></tr>
</table>
</p>


<hr>

<p>
～レス一覧～
<?php print("（全".$c['num']."件）");?>
</p>

<?php echo $error;?>
<?php $n=1;?>
<?php foreach($response as $res): ?>

<p>
<table align="center" cellspacing="5" border="1" rules="all" width="700" height="">
	<tr><td width="50"><?php echo $n;?></td><td>投稿者：<?php echo $res['username'];?></td><td width="270">投稿日時：<?php echo $res['date'];?></td></tr>
	<tr><td colspan="3" height="50" align="left" valign="top"><?php echo $res['comment'];?></td></tr>
	<tr><td colspan="3">

	<?php if($res['extension']=="mp4"):?>
		<video src="<?= htmlspecialchars($res['path'], ENT_QUOTES, 'utf-8');?>" height="300" controls></video>
		
	<?php elseif($res['extension']=="jpeg"||$res['extension']=="png"||$res['extension']=="gif"):?>
			<img src="<?= htmlspecialchars($res['path'], ENT_QUOTES, 'utf-8');?>" class="size">
		
	<?php elseif($res['extension']=="mp3"):?>
		<audio src="<?= htmlspecialchars($res['path'], ENT_QUOTES, 'utf-8');?>" controls></audio>
		
	<?php endif;?>
	</td></tr>
</table>

</p>
<?php $n=$n+1;?>
<?php endforeach; ?>



<hr>

<?php echo $f_error;?>

<form method="post" action='<?php echo "mission_6_thread.php?id=".$id;?>' enctype="multipart/form-data">

<p>～レス投稿フォーム～</p>
	<p><input type="hidden" name="name" value="<?php echo $_SESSION['user'];?>"></p>
	<p><textarea name="comment" placeholder="コメント" cols="40" rows="8" value=""></textarea></p>
	<p><input type="file" name="upfile"></p>
	<p><input type="hidden" name="id" placeholder="" value="<?php echo $id;?>"></p>
	<p><input type="hidden" name="type" placeholder="" value="create"></p>
	<p><input type="submit" name="res"value="投稿する"></p>

</form>

<p><font size="2" color="#dc143c">
注：ファイルのみの投稿はできません。コメントも同時に投稿してください。
</font></p>
<font size="2">
<table align="center">
<caption>対応フォーマット</caption>
<tr align="left"><td>画像：jpeg,png,gif</td></tr>
<tr align="left"><td>動画：mp4</td></tr>
<tr align="left"><td>オーディオ：mp3</td></tr>
</table>
</font>

<p><?php echo $f_error; ?>

<hr>

<p><a href="index.php">戻る</a></p>


</div>


</body>

</html>
