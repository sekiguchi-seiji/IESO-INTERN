<?php
if ( ((isset($_GET["edit"])) && ($_GET["edit"] != "")) ){
	$log='log.txt';
	$mus=file($log, FILE_IGNORE_NEW_LINES);

	$col=$_GET["edit"];

	foreach($mus as $cyg){
		$oct=explode("<>",$cyg);
		if($oct[0]==$col){
		
		$aps=$oct[1];
		$gem=$oct[2];
		
		$editFlag="1";
		}
	}

}

?>

<!DOCTYPE html>
<html lang="ja">
<h1>mission</h1>


<head>
<title>プログラミング勉強</title>
</head>
<body>

<form method="get" action="mission_2-6.php" >
名前：
	<input type="text" name="name" size="15" value="<?="$aps"?>"/><br/>
コメント：
	<textarea name="comment" cols="30" row="5"><?="$gem"?></textarea><br/>

パスワード：	
	<input type="text" name="password" size="5" value=""/><br/>

削除：
	<input type="text" name="delete" size="5" value=""/><br/>
		
編集：
	<input type="text" name="edit" size="5" value="<?="$col"?>"/><br/>
	<input type="hidden" name="editFlag" value="<?="$editFlag"?>"/>

	<input type="submit" value="送信" /><br/>

</form>
<?php
/*削除処理*/


if ( (($_GET["delete"])!="") && (($_GET["password"])!="") )
{


	$log='log.txt';
	$posts=file($log, FILE_IGNORE_NEW_LINES);

	$fp=fopen('log.txt','w');
	fclose($fp);

	foreach($posts as $post){

		$arr=explode("<>",$post);
		
		if($arr[0]==($_GET["delete"])){

			if($arr[4]==($_GET["password"])){
				echo"削除しました";
				echo"<br>";
			}
			else{
				echo"パスワードが違います";
			}
		}else{
			if ($arr[0] != ($_GET["delete"])){
				$fp = fopen($log, 'a');
				fwrite($fp,"$post\n");
				fclose($fp);
			}
		}
	}
}



/*編集*/
if ( ((isset($_GET["editFlag"])) && ($_GET["editFlag"] != "")) && (($_GET["password"]) !="")){

	$log='log.txt';
	$peg=file($log, FILE_IGNORE_NEW_LINES);

	$fp=fopen('log.txt','w');
	fclose($fp);
	$pass=$_GET['password'];
	$number=$_GET['edit'];
	$name=$_GET['name'];
	$comment=$_GET['comment'];
	$time=date('Y/m/d h:i:s');


	foreach($peg as $ser){
		$oph=explode("<>",$ser);	

			if ($oph[0] != ($_GET["edit"])){
				$fp=fopen($log,'a');
				fwrite($fp,"$ser\n");
				fclose($fp);
			}
			if($oph[0]==($_GET["edit"])){

				if($oph[4]==($_GET["password"])){

					$fp=fopen($log,'a');
					fwrite($fp,"$number<>$name<>$comment<>$time<>$pass\n");
					fclose($fp);
				}
				else{
					$fp=fopen($log,'a');
					fwrite($fp,"$ser\n");
					fclose($fp);
					echo"パスワードが違います";
					echo"<br>";
				}

			}
	}
}


/*書き込み*/
if (($_GET["name"] !="") && ($_GET["comment"] !="") && ($_GET["password"]!="") && ($_GET["edit"] =="")){			
	$log='log.txt';
	if(file_exists($log)){

		$andr=file($log);
		$leq=$andr[count($andr)-1];
		$boo=explode("<>",$leq);
		$spc=$boo[0];
		$number = $spc+1;
		
		$name=$_GET['name'];
		$comment=$_GET['comment'];
		$pass=$_GET['password'];	
		$time=date('Y/m/d h:i:s');
		$fp=fopen($log,'a+');
		fwrite($fp,"$number<>$name<>$comment<>$time<>$pass\n");
		fclose($fp);
	}
	else{
		touch($log);
		$name=$_GET['name'];
		$comment=$_GET['comment'];
		$pass=$_GET['password'];
		$time=date('Y/m/d h:i:s');
		$fp=fopen($log,'w');
		fwrite($fp,"1<>$name<>$comment<>$time<>$pass\n");
		fclose($fp);
	}
	
}

/*ログの表示処理*/
	$posts=file('log.txt',FILE_IGNORE_NEW_LINES);	//●
	foreach($posts as $post){

		$arr=explode("<>",$post);

		for($i = 0 ; $i <= 3 ; $i++){
			echo $arr[$i];
			echo " ";
		}
		echo"<br>";
	}

?>
</body>
</html>