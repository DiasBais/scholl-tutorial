<?php

require "functions.php";

start();

// if (isset($_SESSION['logged'])) {
  // if ($_SESSION['logged'] != true) header('Location: auth.php');
// }

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
echo "</tbody></table><br>";
echo "<table border='1'><tbody>";
echo "<tr><td>id</td><td>author</td><td>title</td><td>description</td><td>views</td><td>photo</td></tr>";
for ($i = 0; $i < count($news); $i++) {
  if ($news[$i]) {
    if ($news[$i]['author'] != $_SESSION['alogin']) continue;
    echo "<tr>";
    echo "<td>".$news[$i]['id']."</td>";
    echo "<td>".$news[$i]['title']."</td>";
    echo "<td>".$news[$i]['description']."</td>";
    echo "<td>".$news[$i]['views']."</td>";
    echo "<td>".$news[$i]['photo']."</td>";
    echo "</tr>";
  }
}
echo "</tbody></table>";

close_db($db);

the_end();

?>
