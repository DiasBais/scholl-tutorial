<?php

require "functions.php";

if (isset($_SESSION['logged'])) {
  if ($_SESSION['logged'] != true) header('Location: auth.php');
}

$_SESSION['logged'] = false;
$_SESSION['alogin'] = '';
$_SESSION['apass'] = '';
$_SESSION['admin'] = '';
header('Location: auth.php');

?>
