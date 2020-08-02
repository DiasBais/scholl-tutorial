<?php

if (isset($_SESSION['logged'])) {
  if ($_SESSION['logged'] != true) header('Location: auth.php');
  if ($_SESSION['logged'] != false && $_SESSION['admin'] != false) header('Location: list_students.php');
  if ($_SESSION['logged'] != false && $_SESSION['admin'] != true) header('Location: profile.php');
}
else header('Location: auth.php');

?>
