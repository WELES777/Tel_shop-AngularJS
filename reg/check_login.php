<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{ 
	      
	include("../include/db_connect.php");
	include("../functions/functions.php");
	$login = clear_string($link,$_POST['reg_login']);
	$result = mysqli_query($link, "SELECT login FROM reg_user WHERE login LIKE'%".$login."%'") or die("Brak połączenia z bazą danych ".mysqli_error($link));
	If (mysqli_num_rows($result) > 0)
	{
		echo 'false';
	}
	else
	{
		echo 'true';

	}
}
?>
