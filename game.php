<html>
<head>
<title>Game</title>
</head>
<body>

<?

require "DB.php";
require "util.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$db = DB::connect("mysql://games:games@localhost/games");

$name = $_GET['name'];

echo "<h1>$name</h1>";

$name = mysql_real_escape_string($name);

echo "<h3>Times Played: " . getNum($db, "select count(*) as num from games where name = '$name'") . "</h3>";

echo "<a href=\"http://figbug.com/games/gamehistory.php?game=$name\">";
echo "<img src=\"http://figbug.com/games/graphs/gameelo.php?game=$name\" width=433 height=250></a>";

doTable("Plays", $db, "select scores.name,count(*) as num from scores inner join games on games.gameid = scores.gameid where games.name = '$name' group by scores.name order by num desc");
doTable("Wins", $db, "select scores.name,count(*) as num from games inner join scores on games.gameid = scores.gameid where games.name='$name' and scores.position=1 group by scores.name order by num desc");
doTable("Win %", $db, "SELECT name, w / p * 100 AS win_pct FROM (SELECT scores.name, count(*) w FROM scores inner join games on games.gameid = scores.gameid WHERE position=1 and games.name = '$name' GROUP BY scores.name) AS wins JOIN (SELECT scores.name, count(*) p FROM scores inner join games on games.gameid = scores.gameid where games.name = '$name' GROUP BY scores.name) AS plays USING (name) ORDER BY win_pct DESC");
doTableArray("ELO", calcGameELOs($db, $name));

echo "<p>";

$sql = "select date,number,name,owner,gameid from games where name='$name'  order by date asc, number asc";
$q = $db->query($sql);

echo "<table border=1>";
echo "<tr><th>#<th>Date<th>#<th>Player<th>Score<th>Player<th>Score<th>Player<th>Score<th>Player<th>Score<th>Player<th>Score<th>Player<th>Score<th>Player<th>Score";

$idx = 1;
while ($q->fetchInto($r1))
{
  echo "<tr><td>$idx<td>$r1[0]<td>$r1[1]";
  $idx++;

  $gameid = $r1[4];

  $sql = "select name, points from scores where gameid = $gameid order by position asc";
  $q2 = $db->query($sql);

  while ($q2->fetchInto($r2))
  {
    echo "<td><a href=\"player.php?name=$r2[0]\">$r2[0]</a><td>$r2[1]";
  }
}

echo "</table>";
?>

</body>
</html>
