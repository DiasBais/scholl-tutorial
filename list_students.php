<?php

require "functions.php";

start();

if (isset($_SESSION['logged'])) {
  if ($_SESSION['logged'] != true) header('Location: auth.php');
  if ($_SESSION['admin'] != true) header('Location: profile.php'); //
}
else header('Location: auth.php');

$db = connect_db();

$accounts = list_db($db, 'accounts');

echo "<style>td { padding: 3px }</style>";
echo "<table border='1'><tbody>";
echo "<tr><td>login</td><td>name</td><td>surname</td></tr>";
for ($i = 0; $i < count($accounts); $i++) {
  echo "<tr>";
  echo "<td>".$accounts[$i]['login']."</td>";
  echo "<td>".$accounts[$i]['name']."</td>";
  echo "<td>".$accounts[$i]['surname']."</td>";
  echo "</tr>";
}
echo "</tbody></table>";
close_db($db);

the_end();

?>
