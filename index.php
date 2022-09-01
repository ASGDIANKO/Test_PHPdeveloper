<?php
session_start();
require 'connect.php';

if  (isset($_GET['start'])) {

if (!isset($_SESSION['login']) AND !isset($_SESSION['password']) AND !isset($_SESSION['SID'])){
    echo'Чтобы оставить комментарии к тексту надо <a href="index.php?authorize">авторизоваться,</a> если вы уже зарегистрированы.';
    echo'<br>';
    echo'Если вы еще не зарегистрированы, пора это сделать <a href="index.php?registre">сейчас!</a>';
}
Else
{
if(sha1(crypt($_SESSION['login'],$_SESSION['password'])) === $_SESSION['SID']){
	echo'<FORM ACTION="" METHOD="POST">';

$q2 = @mysqli_query($conn, "SELECT * FROM users WHERE login='".$_SESSION['login']."'
   AND password='".$_SESSION['password']."' ");
if(@mysqli_num_rows($q2)==1){
  $r2 = @mysqli_fetch_array($q2);

echo''.ucfirst($r2['login']).'(<a href="authorize_exit.php">Выход</a>)';
echo' <br>';
echo'Ваши комментарии к тексту';
echo' <br>';
?>
<input type="hidden" name="login" class="enter"  value="<?=htmlspecialchars(stripslashes($r2['login']));?>">
<p><textarea name="user_text"  style="width: 50%; height: 50px; class="enter"></textarea></p>
<input type="submit" value="Ввод" name="insert_com">
<?
}
echo'</form>';
}

if (ISSET($_POST['insert_com'])){
	$login = $_POST['login'];
	$user_text = $_POST['user_text'];

	if ($user_text == ""){
	echo'<p>NO COMMENT!<br/><a href="index.php">Назад</a></p>';
	}
	if($login !='' AND $user_text !=''){
	$sql = "INSERT INTO comments (login, user_text) VALUES ('$login', '$user_text')";
        if(mysqli_query($conn, $sql)){
        echo "комментарии успешно добавлены";
        echo'<br>';
	    } else{
        echo "Ошибка: " . mysqli_error($conn);
	    }
	    mysqli_close($conn);
		}
	}
	}
}

if  (isset($_GET['authorize'])) {
	echo'authorize';
	echo'<br>';
	?>
	<p><form  action="authorize.php" method="post">Логин:</p>
	<p><input name="login" type="text" class="enter" size="30"></p>
	<p>Пароль:</p>
	<p><input name="password" type="password" class="enter" size="30"></p>
	<p><input type="submit" value="Вход">
	</form></p>
	<?
}

if  (isset($_GET['registre'])) {
	echo'registre';
	echo'<br>';
	?>
	<FORM ACTION="registre.php" METHOD="POST">
	<p>Логин:</br></p>
	<p><INPUT TYPE='text' NAME='login' size='30' ></br></p>
	<p>Пароль:</br></p>
	<p><INPUT type='password' value='' NAME='password' size='30' ></br></p>
	<p><input type='submit' value='Регистрация'   ></br></p>
	</FORM>
	<?
}

echo'<h1>TEXT TO COMMENT</h1>';
echo'<p>Это текст для комментарий. Оставьте ваши комментарии, плиз! Это текст для комментарий. Оставьте ваши комментарии, плиз!
Это текст для комментарий. Оставьте ваши комментарии, плиз! Это текст для комментарий. Оставьте ваши комментарии, плиз!
Это текст для комментарий. Оставьте ваши комментарии, плиз! Это текст для комментарий. Оставьте ваши комментарии, плиз!</p>';
echo'<br>';

echo'<a href="index.php?start">Оставьте ваши комментарии</a>';

function show_small(){
require 'connect.php';
$sql = "SELECT * FROM comments ORDER BY id DESC LIMIT 0,3;";
if($result = mysqli_query($conn, $sql)){

    $rowsCount = mysqli_num_rows($result); // количество полученных строк
    echo "<p>$rowsCount - последние комментарии</p>";
    foreach($result as $row){
    	echo "<p>Автор:<b>" . $row["login"] . "</b><br><b>написал:</b>"  . $row["user_text"] . "</p>";
    }
    mysqli_free_result($result);
} else{
    echo "Ошибка: " . mysqli_error($conn);
}
mysqli_close($conn);

echo'<a href="index.php?show_all">Показать ещё</a>';
}

if  (isset($_GET['show_all'])) {

require 'connect.php';

$sql = "SELECT * FROM comments ORDER BY id DESC ";
if($result = mysqli_query($conn, $sql)){

    $rowsCount = mysqli_num_rows($result); // количество полученных строк
    echo "<p>Получено объектов: $rowsCount</p>";
    foreach($result as $row){
		echo "<p>Автор:<b>" . $row["login"] . "</b><br><b>написал:</b>"  . $row["user_text"] . "</p>";
    }   
	mysqli_free_result($result);
} else{
    echo "Ошибка: " . mysqli_error($conn);
}
mysqli_close($conn);

echo'<a href="index.php?show_small">Показать три последние</a>';
}

else show_small();
echo'<br>';
?>
	<FORM ACTION="" METHOD="POST">
	<p><b>фильтр по авторам</b></p>
	<p><INPUT TYPE='text' NAME='login' size='30' ></br></p>
	<p><input type='submit' value='Поиск' name='filtre' ></p>
	</FORM>
	<?
 if  (isset($_POST['filtre'])) {

	require 'connect.php';
	$login = $_POST['login'];
	if ($login == ""){
	echo'<p>Начинайте наберать автора!</p>';
	}
	if($login !='' ){
		$sql = "SELECT * FROM comments WHERE login = '$login' ";
		if($result = mysqli_query($conn, $sql)){

    	$rowsCount = mysqli_num_rows($result); // количество полученных строк
    	echo "<p>Фильтр по логину: $rowsCount</p>";
    	foreach($result as $row){
		echo "<p>Автор:<b>" . $row["login"] . "</b><br><b>написал:</b>"  . $row["user_text"] . "</p>";
    	}
   	 mysqli_free_result($result);
} else{
    echo "Ошибка: " . mysqli_error($conn);
}
mysqli_close($conn);
}
}
echo'<br>';



?>