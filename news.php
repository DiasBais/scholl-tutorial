<?php

require "functions.php";

start();

if (isset($_SESSION['logged'])) {
  if ($_SESSION['logged'] != true) header('Location: auth.php');
}
else header('Location: auth.php');

$db = connect_db();

$news = list_db($db, 'news');

echo "<style>td { padding: 3px }</style>";
echo "<table border='1'><tbody>";
echo "<tr><td>id</td><td>author</td><td>title</td><td>description</td><td>views</td><td>photo</td></tr>";
for ($i = 0; $i < count($news); $i++) {
  if ($news[$i]) {
    echo "<tr>";
    echo "<td>".$news[$i]['id']."</td>";
    echo "<td>".$news[$i]['author']."</td>";
    echo "<td>".$news[$i]['title']."</td>";
    echo "<td>".$news[$i]['description']."</td>";
    echo "<td>".$news[$i]['views']."</td>";
    echo "<td><img src='".$news[$i]['photo']."' style='width: 50px;height 50px;'></td>";
    echo "</tr>";
  }
}
echo "</tbody></table>";

close_db($db);

the_end();

?>
