<?php

require "functions.php";

if (isset($_SESSION['logged'])) {
  if ($_SESSION['logged'] != true) header('Location: auth.php');
  if ($_SESSION['admin'] != true) header('Location: profile.php'); //
}
else header('Location: auth.php');

$db = connect_db();

if (isset($_POST['aname']) && isset($_POST['asname']) && isset($_POST['alogin']) && isset($_POST['apass'])) {

$aname = $_POST['aname'];
$asname = $_POST['asname'];
$alogin = $_POST['alogin'];
$apass = $_POST['apass'];

if (strlen($aname) != 0 && strlen($asname) != 0 && strlen($alogin) != 0 && strlen($apass) != 0) {
  $err = [ false, false, false, false, false, false, false ];
  if (strlen($aname) < 4 && strlen($aname) > 29) {
    $err[1] = true;
    $err[0] = true;
  }
  if (strlen($asname) < 4 && strlen($asname) > 29) {
    $err[2] = true;
    $err[0] = true;
  }
  if (strlen($alogin) < 8 && strlen($alogin) > 49) {
    $err[3] = true;
    $err[0] = true;
  }
  if (strlen($apass) < 8 && strlen($apass) > 49) {
    $err[4] = true;
    $err[0] = true;
  }
  if ($err[0]) errors(3, $err);
  else {
    $db = connect_db();

    $accounts = list_db($db, 'accounts');

    for ($i = 0; $i < count($accounts); $i++) {
      if ($alogin == $accounts[$i]['login']) {
        $err[5] = true;
        $err[0] = true;
        errors(3, $err);
        break;
      }
    }
    if (!$err[5]) {
      $apass = md5($apass);
      $query = "INSERT INTO accounts VALUES (NULL, '".$aname."', '".$asname."', '".$alogin."', '".$apass."', '0')";

      if ($result = mysqli_query($db, $query)) {
        $err[6] = true;
        $err[0] = true;
        errors(3, $err);// !errors
      }
    }
    close_db($db);
  }
}
else errors(2, '');
}
else errors(2, '');

?>
