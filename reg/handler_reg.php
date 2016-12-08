<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{ 
   session_start();
     
   include("../include/db_connect.php");
   include("../functions/functions.php");
   $error = array();
   $_POST = json_decode(file_get_contents('php://input'), true);
   $login = (strtolower(clear_string($link,$_POST['reg_login']))); 
   $pass = (strtolower(clear_string($link,$_POST['reg_pass']))); 
   $surname = (clear_string($link,$_POST['reg_surname'])); 

   $name = (clear_string($link,$_POST['reg_name'])); 
   $email = (clear_string($link,$_POST['reg_email'])); 

   $phone = (clear_string($link,$_POST['reg_phone'])); 
   $address = (clear_string($link,$_POST['reg_address'])); 

    $pass   = md5($pass);
    $pass   = strrev($pass);
    $pass   = "9nm2rv8q".$pass."2yo6z";

    $ip = $_SERVER['REMOTE_ADDR'];

    mysqli_query($link, "	INSERT INTO reg_user(login,pass,surname,name,email,phone,address,datetime,ip)
      VALUES(

      '".$login."',
      '".$pass."',
      '".$surname."',
      '".$name."',
      '".$email."',
      '".$phone."',
      '".$address."',
      NOW(),
      '".$ip."'							
      )");

    echo "true";
}        



?>
