<?PHP 
$conn = mysqli_connect("localhost", "root", "root");
if (!$conn) {
  die("Ошибка: " . mysqli_connect_error());
}
// Создаем базу данных db_com
$sql = "CREATE DATABASE IF NOT EXISTS db_com";
if(mysqli_query($conn, $sql)){
  //  echo "База данных успешно создана";
} else{
    echo "Ошибка: " . mysqli_error($conn);
}
mysqli_close($conn);

$conn = mysqli_connect("localhost", "root", "root", "db_com");
if (!$conn) {
  die("Ошибка: " . mysqli_connect_error());
}

$sql = "CREATE TABLE IF NOT EXISTS Users
    (id INTEGER AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(30),
    password VARCHAR(120));";
if(mysqli_query($conn, $sql)){
  //  echo "Таблица users успешно создана";
} else{
    echo "Ошибка: " . mysqli_error($conn);
}

$sql = "CREATE TABLE IF NOT EXISTS comments
    (id INTEGER AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(30),
    user_text TEXT);";
if(mysqli_query($conn, $sql)){
   // echo "Таблица comments успешно создана";
} else{
    echo "Ошибка: " . mysqli_error($conn);
}
//mysqli_close($conn);