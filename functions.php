<?php

session_start();

function start() {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Authorization</title>
</head>
<body>
  <style>a { padding-left: 3px; border-left: 1px solid black; text-decoration: none; color: blue; }</style>
  <div id="menu">
    <?php
    if (isset($_SESSION['logged'])) {
      if ($_SESSION['logged'] != false && $_SESSION['admin'] != true) {
    ?>
    <a href="news.php" style="padding-left: 0;border-left: 0;">Новости</a>
    <a href="profile.php">Личный кабинет</a>
    <?php
      }
    }
    if (isset($_SESSION['logged'])) {
      if ($_SESSION['logged'] != false && $_SESSION['admin'] != false) {
    ?>
    <a href="list_students.php">Список учеников</a>
    <a href="add_student.php">Добавить учени-ка(цу)</a>
    <?php
      }
    }
    if (isset($_SESSION['logged'])) {
      if ($_SESSION['logged'] != false) {
    ?>
    <a href="logout.php">Выход</a>
    <?php
      }
      else {
      ?>
      <a href="auth.php">Авторизация</a>
      <?php
      }
    }
    else {
    ?>
    <a href="auth.php">Авторизация</a>
    <?php
    }
    ?>
  </div><br>
<?php
}

function the_end() {
?>
</form>
</body>
</html>
<?php
}

function errors($num_err, $prmt) {
  start();
  if ($num_err == 1) {
?>
<form action="auth.php" method="post">
<input type="text" placeholder="login" name="alogin" value=""><br><br>
<input type="text" placeholder="password" name="apass" value=""><br><br>
<input type="submit">
<?php
  }
  else if ($num_err == 2) {
?>
<form action="add_student.php" method="post">
<input type="text" placeholder="Name" name="aname" minlength="4" maxlength="30" value=""><br><br>
<input type="text" placeholder="Surname" name="asname" minlength="1" maxlength="30" value=""><br><br>
<input type="text" placeholder="login" name="alogin" minlength="8" maxlength="50" value=""><br><br>
<input type="password" placeholder="password" name="apass" minlength="8" maxlength="50" value=""><br><br>
<input type="submit">
<?php
  }
  else if ($num_err == 3) {
?>
<div style="background: gray; color: red; padding-bottom: 5px; padding-left: 15px;">
<?php
if ($prmt[1]) {
?><p>Имя должен быть больше 3 и меньше 30 символов</p><?php
}
if ($prmt[2]) {
?><p>Фамилия должен быть больше 3 и меньше 30 символов</p><?php
}
if ($prmt[3]) {
?><p>Логин должен быть больше 7 и меньше 50 символов</p><?php
}
if ($prmt[4]) {
?><p>Пароль должен быть больше 7 и меньше 50 символов</p><?php
}
if ($prmt[5]) {
?><p>Вы ввели существующую логин</p><?php
}
if ($prmt[6]) {
?><p style="color: green;">Успешно добавлено учетный запись</p><?php
}
?>
</div><br>
<form action="add_student.php" method="post">
<input type="text" placeholder="Name" name="aname" minlength="4" maxlength="30" value=""><br><br>
<input type="text" placeholder="Surname" name="asname" minlength="1" maxlength="30" value=""><br><br>
<input type="text" placeholder="login" name="alogin" minlength="8" maxlength="50" value=""><br><br>
<input type="password" placeholder="password" name="apass" minlength="8" maxlength="50" value=""><br><br>
<input type="submit">
<?php
  }
  else if ($num_err == 4) {
?>
<div style="background: gray; color: red; padding-bottom: 5px; padding-left: 15px;">
<?php
if (!$prmt) {
?><p>Вы не правильно ввели логин</p><?php
}
else {
?><p>Вы не правильно ввели пароль</p><?php
}
?>
</div><br>
<form action="auth.php" method="post">
<input type="text" placeholder="login" name="alogin" value=""><br><br>
<input type="text" placeholder="password" name="apass" value=""><br><br>
<input type="submit">
<?php
  }
  the_end();
}

function connect_db() {
  $host = 'localhost';
  $user = 'root';
  $pass = '';
  $db = 'scholl';

  $con = mysqli_connect($host, $user, $pass, $db);

  // Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
  }

  return $con;
}

function list_db($db, $table) {
  $arg = [[]];

  if ($result = mysqli_query($db, "SELECT * FROM $table")) {
    $rows = mysqli_num_rows($result);
    $row = mysqli_fetch_all($result);
    if ($table == 'accounts') {
      for ($i = 0; $i < $rows; $i++) {
        if ($row[$i]) {
          $arg[$i]['id'] = $row[$i][0];
          $arg[$i]['name'] = $row[$i][1];
          $arg[$i]['surname'] = $row[$i][2];
          $arg[$i]['login'] = $row[$i][3];
          $arg[$i]['password'] = $row[$i][4];
          $arg[$i]['admin'] = $row[$i][5];
        }
      }
    }
    else if ($table == 'news') {
      for ($i = 0; $i < $rows; $i++) {
        if ($row = mysqli_fetch_all($result)) {
          $arg[$i]['id'] = $row[$i][0];
          $arg[$i]['title'] = $row[$i][1];
          $arg[$i]['description'] = $row[$i][2];
          $arg[$i]['author'] = $row[$i][3];
          $arg[$i]['views'] = $row[$i][4];
          $arg[$i]['photo'] = $row[$i][5];
        }
      }
    }
    mysqli_free_result($result);
  }
  return $arg;
}

function close_db($db) {
  mysqli_close($db);
}

/*

$password = md5('123456789');

$query = "INSERT INTO accounts VALUES (NULL, 'Бобылёв', 'Борис', 'Boris.Bobilev', '".$password."', '1')";

$result = mysqli_query($con, $query);

if ($result) echo "yes<br>";
else echo "no<br>";

*/

//
/*
$account = [[]];

// Perform query
if ($result = mysqli_query($con, "SELECT * FROM accounts")) {
  $rows = mysqli_num_rows($result);
  for ($i = 0; $i < $rows; $i++) {
    $row = mysqli_fetch_all($result);
    $account[$i]['id'] = $row[$i][0];
    $account[$i]['name'] = $row[$i][1];
    $account[$i]['surname'] = $row[$i][2];
    $account[$i]['login'] = $row[$i][3];
    $account[$i]['pass'] = $row[$i][4];
    $account[$i]['admin'] = $row[$i][5];
  }
  mysqli_free_result($result);
}

/*
echo "<br>";
for ($i = 0; $i < count($accounts); $i++) {
  echo "id: ".$accounts[$i]['id']."<br>";
  echo "name: ".$accounts[$i]['name']."<br>";
  echo "surname: ".$accounts[$i]['surname']."<br>";
  echo "login: ".$accounts[$i]['login']."<br>";
  echo "pass: ".$accounts[$i]['pass']."<br>";
  echo "admin: ".$accounts[$i]['admin']."<br><br>";
}
*/

//

?>
