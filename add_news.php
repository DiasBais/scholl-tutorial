<?php

require "functions.php";

if (isset($_SESSION['logged'])) {
  if ($_SESSION['logged'] != true) header('Location: auth.php');
  if ($_SESSION['admin'] != true) header('Location: profile.php');
}

$db = connect_db();

if (isset($_POST['ntitle']) && isset($_POST['ndescription']) && isset($_POST['nphoto'])) {

$alogin = $_SESSION['alogin'];
$ntitle = $_POST['ntitle'];
$ndescription = $_POST['ndescription'];
$nphoto = $_POST['nphoto'];

if (strlen($ntitle) != 0 && strlen($ndescription) != 0 && strlen($nphoto) != 0) {
  $err = [ false, false, false, false ];
  if (strlen($ntitle) < 5 && strlen($ntitle) > 99) {
    $err[1] = true;
    $err[0] = true;
  }
  if ($err[0]) errors(6, $err);
  else {
    $db = connect_db();

    $accounts = list_db($db, 'news');

    $query = "INSERT INTO news VALUES (NULL, '".$ntitle."', '".$ndescription."', '".$alogin."', 0, '".$nphoto."')";

    if ($result = mysqli_query($db, $query)) {
      $err[2] = true;
      $err[0] = true;
      errors(6, $err);// !errors
    }
    close_db($db);
  }
}
else errors(5, '');
}
else errors(5, '');

?>
