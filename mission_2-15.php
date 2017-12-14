<?php

$user='ユーザー';
$host='localhost';
$password='パスワード';
$database='データベース';
$dsn = 'mysql:dbname=co_***_it_3919_com;host=localhost';
//文字化け対策v２
$pdo=new PDO($dsn,$user,$password);

//文字化け対策
$stmt=$pdo->query('SET NAMES SJIS');

//テーブルの編集番号の番号、名前を取得する

if ( ((isset($_POST["edit"])) && ($_POST["edit"] != "") && ($_POST["comment"] == "")) && (($_POST["pass"])=="")){

	$col=$_POST["edit"];
	$hidden = "SELECT * FROM tblog WHERE number = '$col';";
	$hidden2 = $pdo->query($hidden);

	foreach($hidden2 as $hide){
		$aps = $hide['name'];
		$gem = $hide['comment'];
	}
	$editFlag="1";
	
}
?>


<!DOCTYPE html>
<html lang="ja">
<h1>What's Up</h1>


<head>
<title>プログラミング勉強</title>
</head>
<body>

<form method="post" action="mission_2-15.php" >
名前：
	<input type="text" name="name" size="15" value="<?="$aps"?>"/><br/>
コメント：
	<textarea name="comment" cols="30" row="5"><?="$gem"?></textarea><br/>

パスワード：	
	<input type="text" name="password" size="5" value=""/><br/>

削除番号：
	<input type="text" name="delete" size="5" value=""/><br/>
		
編集番号：
	<input type="text" name="edit" size="5" value="<?="$col"?>"/><br/>
	<input type="hidden" name="editFlag" value="<?="$editFlag"?>"/>

	<input type="submit" value="送信" /><br/>

</form>
<?php echo "<hr>"; ?>
<?php


$user='ユーザー';
$host='localhost';
$password='パスワード';
$database='データベース';
$dsn = 'mysql:dbname=co_***_it_3919_com;host=localhost';
//文字化け対策v２
//$pdo = new PDO("mysql:host=localhost;dbname=$database;charset=utf8;",  $user,  $password );
$pdo=new PDO($dsn,$user,$password);

//文字化け対策
$stmt=$pdo->query('SET NAMES SJIS');

$show="SHOW TABLES FROM :database LIKE :tblog;";
$pre=$pdo->prepare("$show");

$log = "tblog";
$pre->bindParam(':database', $database, PDO::PARAM_STR);
$pre->bindParam(':tblog', $log, PDO::PARAM_STR);

$exe = $pre->execute();


if(1){
	//テーブルが無いときテーブル作成
	$sql="CREATE TABLE tblog"

	."("
	."number INT,"
	."name TEXT,"
	."comment TEXT,"
	."time TEXT,"
	."pass TEXT"
	.");";

	$stmt = $pdo->query($sql);


}


/*削除処理*/

if ( (($_POST["delete"])!="") && (($_POST["password"])!="") )
{
	$delNumber = $_POST["delete"];
	$delPass = $_POST["password"];
	$sdel = "SELECT * FROM tblog WHERE number = '$delNumber';";
	$sdel2 = $pdo->query($sdel);

	foreach($sdel2 as $erase){
		$erasePass = $erase['pass'];
	}
	//保存パスワードと入力パスワードが等しいとき
	if($delPass == $erasePass){
		$sql="delete from tblog where Number='$delNumber';";
		$result = $pdo->query($sql);
		
		echo "<br>";
		echo "削除しました<br/>";
		echo "<br>";
		echo "<hr>";

	}else{
		echo "<br/>";
		echo "パスワードが違います<br/><br/>";
		echo "<hr>";
	}
}elseif( (($_POST["delete"])!="") && (($_POST["password"])=="") && (($_POST["edit"])=="") ){
	echo "<br/>";
	echo "パスワードを投稿番号と同時に入力してください<br/><br/>";
	echo "<hr>";
}


/*編集*/

if ( ((isset($_POST["editFlag"])) && ($_POST["editFlag"] != "")) && (($_POST["password"]) !=""))
{
	
	$Epass=$_POST['password'];
	$editNumber=$_POST['edit'];
	$Ename=$_POST['name'];
	$Ecomment=$_POST['comment'];
	$Etime=date('Y/m/d h:i:s');
	
	//編集番号のレコード取得
	$sed = "SELECT * FROM tblog WHERE number = '$editNumber';";
	$sed2 = $pdo->query($sed);
	//投稿番号とパスワードを取得
	foreach($sed2 as $edit){
		$editPass = $edit['pass'];
		
		if($Epass == $editPass){
		
			$sql = "UPDATE tblog SET name='$Ename', comment='$Ecomment', pass='$Epass', time='$Etime' WHERE number = '$editNumber';";
			$update = $pdo->query($sql);
			echo "<br>";
			echo "編集完了しました<br>";
			echo "<br>";
			echo "<hr>";
		}else{
			echo "<br>";
			echo "パスワードが違います<br/><br/>";
			echo "<hr>";
		}
	}
	
}elseif ( ((isset($_POST["editFlag"])) && ($_POST["editFlag"] != "")) && (($_POST["password"]) ==""))
{
	echo "<br>";
	echo "パスワードを入力してください<br/>";
	echo "<br/>";
	echo "<hr>";
}
/*
if ( (($_POST["edit"])!="") && (($_POST["password"])!="") && (($_POST["editFlag"]) == ""))
{
	echo "<br>";
	echo "編集番号のみを入力してください<br/>";
	echo "<br>";
	echo "<hr>";
}
*/
if ( (($_POST["edit"])!="") && (($_POST["delete"])!="") )
{
	echo "<br>";
	echo "削除および編集は同時に行えません<br/>";
	echo "<br>";
	echo "<hr>";
	}

/*書き込み*/

//名前 コメント パスワード が入ってる時＆編集が空のとき

if (($_POST["name"] !="") && ($_POST["comment"] !="") && ($_POST["password"]!="") && ($_POST["edit"] =="")){			

	$sql=$pdo -> prepare("INSERT INTO tblog(number, name, comment, time, pass) VALUES(:number, :name, :comment, :time, :pass)");

	
	$sql->bindParam(':number', $number,PDO::PARAM_INT);
	$sql->bindParam(':name', $name,PDO::PARAM_STR);
	$sql->bindParam(':comment', $comment,PDO::PARAM_STR);
	$sql->bindParam(':time', $time,PDO::PARAM_STR);
	$sql->bindParam(':pass', $pass, PDO::PARAM_STR);
	
	
	$numbermax0 = "SELECT MAX(number) FROM tblog;";
	$numbermax1 = $pdo -> query($numbermax0);
	
	foreach ($numbermax1 as $row){
		$numberMAX = $row[0]+1;	
	}
	
	$number = $numberMAX;
	$name = $_POST['name'];
	$comment = $_POST['comment'];
	$time = date('Y/m/d h:i:s');
	$pass = $_POST['password'];
	
	
	$sql -> execute();
}elseif (($_POST["name"] !="") && ($_POST["comment"] !="") && ($_POST["password"]=="") && ($_POST["edit"] =="")){
	echo "<br>";
	echo "パスワードを入力してください<br/>";
	echo "<br>";
	echo "<hr>";
}

/*ログの表示処理*/

$sq="SELECT * FROM tblog ORDER BY number;";
$result= $pdo -> query($sq);


foreach ($result as $row){


	echo $row['number'].',';

	echo $row['name'].',';

	echo $row['comment'].',';

	echo $row['time'].'<br>';

}


?>
</body>
</html>