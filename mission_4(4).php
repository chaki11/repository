<?php

$dsn = 'データベース名';

$user = 'ユーザー名';

$password = 'パスワード';

$pdo = new PDO($dsn,$user,$password);

$sql= "CREATE TABLE mis_4"

."("

."id INT auto_increment primary key,"

."name char(32) not null,"

."comment TEXT not null,"

."datetime DATETIME,"

."pass char(32)"

.");";

$stmt = $pdo->query($sql);


/* テーブル作成


$sql= "CREATE TABLE mis_4"

."("

."id INT,"

."name char(32),"

."comment TEXT,"

."datetime DATETIME,"

."pass char(32)"

.");";

$stmt = $pdo->query($sql);



$sql = 'SHOW TABLES';

$result = $pdo -> query($sql);

foreach ($result as $row){

  echo $row[0];

  echo '<br>';

}

echo "<hr>";



$sql ='SHOW CREATE TABLE mis_4';

$result = $pdo -> query($sql);

foreach ($result as $row){

  print_r($row);

}



echo "<hr>";

*/




/* 編集ボタンのクリック後、フォーム表示する内容の取得 */



if ((isset($_POST["edit"]) && $_POST["edit"] != "") &&

         (isset($_POST["editPass"]) && $_POST["editPass"] != "")){

  $sql = "SELECT COUNT(*) FROM mis_4";

  $uncertainNum = $_POST["edit"];

  $uncertainKey = $_POST["editPass"];

  $sql = "SELECT id,name,comment,pass FROM mis_4 where id=$uncertainNum and pass='$uncertainKey'";

  $results = $pdo->query($sql);

  foreach ($results->fetchAll() as $row){

    $editNum = $row['id'];

    $editedName = $row['name'];

    $editedPost = $row['comment'];

    $editPass = $row['pass'];

  }

}



/* 新規の投稿と編集による投稿の分岐 */



if ((isset($_POST["name"]) && $_POST["name"] != "") &&

		(isset($_POST["comment"]) && $_POST["comment"] != "") &&

			(isset($_POST["password"]) && $_POST["password"] != "")){

  if ($_POST["editnum"] > 0){

     $id = $_POST["editnum"];

     $name = $_POST["name"];

     $comment= $_POST["comment"];

     $pass = $_POST["password"];

     $sql = "update mis_4 set name='$name',comment='$comment',pass='$pass' where id=$id";

     $result = $pdo->query($sql);

  }else{

     $sql = 'SELECT * FROM mis_4 ';

     $id += 1; 
     

     $gyos = $pdo -> query($sql);

     foreach ($gyos->fetchAll() as $gyo){

     
$id = 1;
     }

     $sql = $pdo -> prepare("INSERT INTO mis_4 (name,comment,datetime,pass) VALUES (:name,:comment,:datetime,:pass)");

    

     $sql -> bindParam(':name',$name,PDO::PARAM_STR);

     $sql -> bindParam(':comment',$comment,PDO::PARAM_STR);

     $sql -> bindParam(':datetime',$datetime,PDO::PARAM_STR);

     $sql -> bindParam(':pass',$pass,PDO::PARAM_STR);

     $name = $_POST["name"];

     $comment = $_POST["comment"];

     $datetime = date("Y/m/d H:i:s");

     $pass = $_POST["password"];

     $sql -> execute();

  }

}



/* 削除ボタンクリック後 */



if ((isset($_POST["delete"]) && $_POST["delete"] != "") &&

	(isset($_POST["delPass"]) && $_POST["delPass"] != "")){

  $delnum = $_POST["delete"];

  $delPass = $_POST["delPass"];

  $sql = "update mis_4 set name='---削除されました。---',comment='',datetime='',pass='' where id=$delnum and pass='$delPass'";

  $result = $pdo->query($sql);

}

?>



<!DOCTYPE HTML>

<html lang="ja">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>mission4の掲示板</title>

</head>

<body>

    <form action="mission_4(4).php" method="post">

	名前(必須)

	<br>

	<input type="text" name="name" size="20" value = "<?php echo $editedName;?>">

	<input type="hidden" name="editnum" value="<?php echo $editNum ?>">

	<br>

	コメント(必須)

	<br>

	<input type="text" name="comment" size="50" value = "<?php echo $editedPost;?>">

	<br>

        パスワードを決めて下さい。(必須)

        <br>

        <input type="text" name="password" value= "<?php echo $editPass;?>">

        <br> 

	<input type="submit" value="送信">

        <br>

    </form>

    <form action="mission_4(4).php" method="post">

	削除対象番号(必須)

        <br>   

	<input type="text" name="delete" size="5">

        <br>

        パスワードを入力して下さい。(必須)

        <br>

        <input type="text" name="delPass">

	<br>

	<input type="submit" value="削除">

	<br>

    </form>

    <form action="mission_4(4).php" method="post">

	編集対象番号(必須)

	<br>

	<input type="text" name="edit" size="5">

	<br>

        パスワードを入力して下さい。(必須)

        <br>

        <input type="text" name="editPass">

        <br>

	<input type="submit" value="編集">

        <br>

    </form>



<!-- テーブル内容を取得して表示 -->

    <?php 

  	$sql = 'SELECT * FROM mis_4 ORDER BY id ASC';
	

  	$results = $pdo -> query($sql);

  	foreach ($results->fetchAll() as $row){

    	echo $row['id'].'  ';

    	echo $row['name'].'  ';

    	echo $row['comment'].'  ';

    	echo $row['datetime'].'<br>';

        }

    ?>

    <br>

    

</body>

</html>