<?php

$user='���[�U�[';
$host='localhost';
$password='�p�X���[�h';
$database='�f�[�^�x�[�X';
$dsn = 'mysql:dbname=co_***_it_3919_com;host=localhost';
//���������΍�v�Q
$pdo=new PDO($dsn,$user,$password);

//���������΍�
$stmt=$pdo->query('SET NAMES SJIS');

//�e�[�u���̕ҏW�ԍ��̔ԍ��A���O���擾����

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
<title>�v���O���~���O�׋�</title>
</head>
<body>

<form method="post" action="mission_2-15.php" >
���O�F
	<input type="text" name="name" size="15" value="<?="$aps"?>"/><br/>
�R�����g�F
	<textarea name="comment" cols="30" row="5"><?="$gem"?></textarea><br/>

�p�X���[�h�F	
	<input type="text" name="password" size="5" value=""/><br/>

�폜�ԍ��F
	<input type="text" name="delete" size="5" value=""/><br/>
		
�ҏW�ԍ��F
	<input type="text" name="edit" size="5" value="<?="$col"?>"/><br/>
	<input type="hidden" name="editFlag" value="<?="$editFlag"?>"/>

	<input type="submit" value="���M" /><br/>

</form>
<?php echo "<hr>"; ?>
<?php


$user='���[�U�[';
$host='localhost';
$password='�p�X���[�h';
$database='�f�[�^�x�[�X';
$dsn = 'mysql:dbname=co_***_it_3919_com;host=localhost';
//���������΍�v�Q
//$pdo = new PDO("mysql:host=localhost;dbname=$database;charset=utf8;",  $user,  $password );
$pdo=new PDO($dsn,$user,$password);

//���������΍�
$stmt=$pdo->query('SET NAMES SJIS');

$show="SHOW TABLES FROM :database LIKE :tblog;";
$pre=$pdo->prepare("$show");

$log = "tblog";
$pre->bindParam(':database', $database, PDO::PARAM_STR);
$pre->bindParam(':tblog', $log, PDO::PARAM_STR);

$exe = $pre->execute();


if(1){
	//�e�[�u���������Ƃ��e�[�u���쐬
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


/*�폜����*/

if ( (($_POST["delete"])!="") && (($_POST["password"])!="") )
{
	$delNumber = $_POST["delete"];
	$delPass = $_POST["password"];
	$sdel = "SELECT * FROM tblog WHERE number = '$delNumber';";
	$sdel2 = $pdo->query($sdel);

	foreach($sdel2 as $erase){
		$erasePass = $erase['pass'];
	}
	//�ۑ��p�X���[�h�Ɠ��̓p�X���[�h���������Ƃ�
	if($delPass == $erasePass){
		$sql="delete from tblog where Number='$delNumber';";
		$result = $pdo->query($sql);
		
		echo "<br>";
		echo "�폜���܂���<br/>";
		echo "<br>";
		echo "<hr>";

	}else{
		echo "<br/>";
		echo "�p�X���[�h���Ⴂ�܂�<br/><br/>";
		echo "<hr>";
	}
}elseif( (($_POST["delete"])!="") && (($_POST["password"])=="") && (($_POST["edit"])=="") ){
	echo "<br/>";
	echo "�p�X���[�h�𓊍e�ԍ��Ɠ����ɓ��͂��Ă�������<br/><br/>";
	echo "<hr>";
}


/*�ҏW*/

if ( ((isset($_POST["editFlag"])) && ($_POST["editFlag"] != "")) && (($_POST["password"]) !=""))
{
	
	$Epass=$_POST['password'];
	$editNumber=$_POST['edit'];
	$Ename=$_POST['name'];
	$Ecomment=$_POST['comment'];
	$Etime=date('Y/m/d h:i:s');
	
	//�ҏW�ԍ��̃��R�[�h�擾
	$sed = "SELECT * FROM tblog WHERE number = '$editNumber';";
	$sed2 = $pdo->query($sed);
	//���e�ԍ��ƃp�X���[�h���擾
	foreach($sed2 as $edit){
		$editPass = $edit['pass'];
		
		if($Epass == $editPass){
		
			$sql = "UPDATE tblog SET name='$Ename', comment='$Ecomment', pass='$Epass', time='$Etime' WHERE number = '$editNumber';";
			$update = $pdo->query($sql);
			echo "<br>";
			echo "�ҏW�������܂���<br>";
			echo "<br>";
			echo "<hr>";
		}else{
			echo "<br>";
			echo "�p�X���[�h���Ⴂ�܂�<br/><br/>";
			echo "<hr>";
		}
	}
	
}elseif ( ((isset($_POST["editFlag"])) && ($_POST["editFlag"] != "")) && (($_POST["password"]) ==""))
{
	echo "<br>";
	echo "�p�X���[�h����͂��Ă�������<br/>";
	echo "<br/>";
	echo "<hr>";
}
/*
if ( (($_POST["edit"])!="") && (($_POST["password"])!="") && (($_POST["editFlag"]) == ""))
{
	echo "<br>";
	echo "�ҏW�ԍ��݂̂���͂��Ă�������<br/>";
	echo "<br>";
	echo "<hr>";
}
*/
if ( (($_POST["edit"])!="") && (($_POST["delete"])!="") )
{
	echo "<br>";
	echo "�폜����ѕҏW�͓����ɍs���܂���<br/>";
	echo "<br>";
	echo "<hr>";
	}

/*��������*/

//���O �R�����g �p�X���[�h �������Ă鎞���ҏW����̂Ƃ�

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
	echo "�p�X���[�h����͂��Ă�������<br/>";
	echo "<br>";
	echo "<hr>";
}

/*���O�̕\������*/

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