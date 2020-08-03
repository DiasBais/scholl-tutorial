<?php

require "functions.php";

start();

if (isset($_SESSION['logged'])) {
  if ($_SESSION['logged'] != true) header('Location: auth.php');
  if ($_SESSION['logged'] != false && $_SESSION['admin'] != 0) header('Location: list_students.php');
}
else header('Location: auth.php');

$db = connect_db();

$accounts = list_db($db, 'accounts');
$news = list_db($db, 'news');

echo "<style>td { padding: 3px }</style>";
echo "<table border='1'><tbody>";
echo "<tr><td>name</td><td>surname</td><td>login</td></tr>";
for ($i = 0; $i < count($accounts); $i++) {
  if ($accounts[$i]) {
    if ($accounts[$i]['login'] != $_SESSION['alogin']) continue;
    echo "<tr>";
    echo "<td>".$accounts[$i]['name']."</td>";
    echo "<td>".$accounts[$i]['surname']."</td>";
    echo "<td>".$accounts[$i]['login']."</td>";
    echo "</tr>";
    break;
  }
}
echo "</tbody></table>";

close_db($db);

the_end();

?>
