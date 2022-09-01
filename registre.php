<?php
require 'connect.php';
$login = $_POST['login'];
$password = $_POST['password'];

if ($login == "" OR $password == ""){
	echo'<p>Ваш логин или пароль?<br/><a href="index.php">Назад</a></p>';
}
else
{
    $login = mysqli_real_escape_string($conn, $_POST["login"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    $sql = "INSERT INTO users (login, password) VALUES ('$login', sha1('$password'))";
        if(mysqli_query($conn, $sql)){
        echo "Данные успешно добавлены";
        echo'<br>';
        echo'<p><a href="index.php">Назад</a></p>';

    } else{
        echo "Ошибка: " . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>