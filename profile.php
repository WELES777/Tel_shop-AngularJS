<?php
  
session_start();

if ($_SESSION['auth'] == 'yes_auth')
{	
 include("include/db_connect.php");
 include("functions/functions.php");
 
 if ($_POST["save_submit"])
 {

  $_POST["info_surname"] = clear_string($link,$_POST["info_surname"]);
  $_POST["info_name"] = clear_string($link,$_POST["info_name"]);
  $_POST["info_address"] = clear_string($link,$_POST["info_address"]);
  $_POST["info_phone"] = clear_string($link,$_POST["info_phone"]);
  $_POST["info_email"] = clear_string($link,$_POST["info_email"]);     

  $error = array();

  $pass   = md5($_POST["info_pass"]);
  $pass   = strrev($pass);
  $pass   = "9nm2rv8q".$pass."2yo6z";

  if($_SESSION['auth_pass'] != $pass)
  {
    $error[]='Nieprawidłowe hasło!';
  }else
  {

    if($_POST["info_new_pass"] != "")
    {
      if(strlen($_POST["info_new_pass"]) < 7 || strlen($_POST["info_new_pass"]) > 15)
      {
       $error[]='Podaj nowe hasło od 7 do 15 symboli!';
     }else
     {
       $newpass   = md5(clear_string($link,$_POST["info_new_pass"]));
       $newpass   = strrev($newpass);
       $newpass   = "9nm2rv8q".$newpass."2yo6z";
       $newpassquery = "pass='".$newpass."',";
     }
   }



   if(strlen($_POST["info_surname"]) < 3 || strlen($_POST["info_surname"]) > 15)
   {
    $error[]='Podaj nazwisko od 3 do 15 symboli!';
  }


  if(strlen($_POST["info_name"]) < 3 || strlen($_POST["info_name"]) > 15)
  {
    $error[]='Podaj imię od 3 do 15 symboli!';
  }



  if(!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i",trim($_POST["info_email"])))
  {
    $error[]='Podaj poprawny email!';
  }

  if(strlen($_POST["info_phone"]) == "")
  {
    $error[]='Podaj numer telefonu!';
  } 

  if(strlen($_POST["info_address"]) == "")
  {
    $error[]='Podaj adres dostawy!';
  }      



}

if(count($error))
{
  $_SESSION['msg'] = "<p align='left' id='form-error'>".implode('<br />',$error)."</p>";
}else
{
  $_SESSION['msg'] = "<p align='left' id='form-success'>Dane poprawnie zapisane!</p>";

  $dataquery = $newpassquery."surname='".$_POST["info_surname"]."',name='".$_POST["info_name"]."',email='".$_POST["info_email"]."',phone='".$_POST["info_phone"]."',address='".$_POST["info_address"]."'";      
  $update = mysqli_query($link, "UPDATE reg_user SET $dataquery WHERE login = '{$_SESSION['auth_login']}'");

  if ($newpass){ $_SESSION['auth_pass'] = $newpass; } 


  $_SESSION['auth_surname'] = $_POST["info_surname"];
  $_SESSION['auth_name'] = $_POST["info_name"];
  $_SESSION['auth_address'] = $_POST["info_address"];
  $_SESSION['auth_phone'] = $_POST["info_phone"];
  $_SESSION['auth_email'] = $_POST["info_email"];    

}

}  

?>
<!DOCTYPE html>
<html lang="pl" ng-app='myApp'>

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-2" />
  <link href="css/reset.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css"> 
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="trackbar/trackbar.css" rel="stylesheet" type="text/css" />

  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.0.4/angular.min.js"></script>
  <script type="text/javascript" src="/js/jquery-1.8.2.min.js"></script> 
  <script type="text/javascript" src="/js/jcarousellite_1.0.1.js"></script> 
  <script type="text/javascript" src="/js/shop-script.js"></script>
  <script type="text/javascript" src="/js/jquery.cookie.min.js"></script>
  <script type="text/javascript" src="/trackbar/jquery.trackbar.js"></script>
  <script type="text/javascript" src="/js/TextChange.js"></script>

  <title>Sklep internetowy sprzętu telekomunikacyjnego</title>
</head>
<body ng-controller="ProductController">
  <div id="block-body">
    <?php	
    include("include/block-header.php");    
    ?>
    <div id="block-right">
      <?php	
      include("include/block-category.php");  
      include("include/block-parameter.php");  
      include("include/block-news.php"); 
      ?>
    </div>
    <div id="block-content">

      <h3 class="title-h3" >Zmiana profilu</h3>

      <?php

      if($_SESSION['msg'])
      {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
      }

      ?>

      <form method="post">

        <ul id="info-profile">
          <li>
            <label for="info_pass">Obecne hasło</label>
            <span class="star">*</span>
            <input type="text" name="info_pass" id="info_pass" value="" />
          </li>

          <li>
            <label for="info_new_pass">Nowe hasło</label>

            <input type="text" name="info_new_pass" id="info_new_pass" value="" />
          </li>

          <li>
            <label for="info_surname">Nazwisko</label>
            <span class="star">*</span>
            <input type="text" name="info_surname" id="info_surname" value="<?php echo $_SESSION['auth_surname']; ?>"  />
          </li>

          <li>
            <label for="info_name">Imię</label>
            <span class="star">*</span>
            <input type="text" name="info_name" id="info_name" value="<?php echo $_SESSION['auth_name']; ?>"  />
          </li>


          <li>
            <label for="info_email">E-mail</label>
            <span class="star">*</span>
            <input type="text" name="info_email" id="info_email" value="<?php echo $_SESSION['auth_email']; ?>" />
          </li>

          <li>
            <label for="info_phone">Telefon</label>
            <span class="star">*</span>
            <input type="text" name="info_phone" id="info_phone" value="<?php echo $_SESSION['auth_phone']; ?>" />
          </li>

          <li>
            <label for="info_address">Adres dostawy</label>
            <span class="star">*</span>
            <textarea name="info_address"  > <?php echo $_SESSION['auth_address']; ?> </textarea>
          </li>

        </ul>

        <p align="right"><input type="submit" id="form_submit" name="save_submit" value="Zapisać" /></p>
      </form>

    </div>

    <?php	
    include("include/block-footer.php");    
    ?>
  </div>

</body>
</html>
<?php
} else { header("Location: index.php");  }	
?>
