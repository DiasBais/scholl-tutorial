<?php

require "functions.php";

if (isset($_SESSION['logged'])) {
  if ($_SESSION['logged'] != false && $_SESSION['admin'] == true) header('Location: list_students.php');
  if ($_SESSION['logged'] != false && $_SESSION['admin'] == false) header('Location: profile.php');
}

if (isset($_POST['alogin']) && isset($_POST['apass'])) {

$alogin = $_POST['alogin'];
$apass = $_POST['apass'];

if (strlen($alogin) != 0 && strlen($apass) != 0) {
  $db = connect_db();

  $accounts = list_db($db, 'accounts');
  $logged = false;

  for ($i = 0; $i < count($accounts); $i++) {
    if ($alogin == $accounts[$i]['login']) {
      $logged = true;
      if ($apass == $accounts[$i]['password']) {
        $_SESSION['logged'] = true;
        $_SESSION['alogin'] = $alogin;
        $_SESSION['apass'] = $apass;
        $_SESSION['admin'] = $accounts[$i]['admin'];
        if ($accounts[$i]['admin'] == 1) header('Location: list_students.php');
        else header('Location: profile.php');
      }
    }
  }
  errors(4, $logged);
  close_db($db);
}
else errors(1, '');
}
else errors(1, '');
?>
