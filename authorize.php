<?php 
session_start();
echo'authorize';
echo'<br>';

require 'connect.php';
$login = mysqli_real_escape_string($conn, $_POST["login"]);
$password = mysqli_real_escape_string($conn, $_POST["password"]);
if ($login == "" OR $password == ""){
	echo'<p>Ваше логин или пароль?<br/><a href="index.php">Назад</a></p>';
	}
if($login !='' AND $password !=''){

$q1=mysqli_query($conn, "SELECT * FROM users WHERE login='".$login."' AND password='".sha1($password)."'");
if(mysqli_num_rows($q1)===1) {
	$r=mysqli_fetch_array($q1);
	$_SESSION['login'] = $r['login'];
	$_SESSION['password'] = $r['password'];
	$_SESSION['SID'] = sha1(crypt($r['login'],$r['password']));
	@Header("Location: index.php");
	mysql_close();
	}
else {
	echo "<p>Не правильные данные</p>";
	echo '<p><a href="index.php">Назад</a></p>';
	}
}
?>