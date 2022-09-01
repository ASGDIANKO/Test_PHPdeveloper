<?
session_start();
echo'Выход';
echo'<br>';

require 'connect.php';

session_unset();

session_destroy();

unset($_SESSION['login']);

unset($_SESSION['password']);

@header('location: index.php');



  ?>
