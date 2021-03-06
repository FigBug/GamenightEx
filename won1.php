<html>
<head>
<title>What won 1st?</title>
</head>
<body>

<?

require "DB.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$db = DB::connect("mysqli://games:games@localhost/games");

echo "<table border=1>";

$sql = "select games.name,scores.name from scores inner join games on scores.gameid = games.gameid where scores.position=1 and games.number=1 order by scores.name, games.date asc, games.number asc";
$q = $db->query($sql);

$res = array();
$row = 0;

while ($q->fetchInto($r))
{
  $player  = $r[1];
  $game    = $r[0];

  if (!isset($res[$player]))
    $res[$player] = array();

  $res[$player][] = $game;

  $row = max($row, count($res[$player]));  
}

echo "<tr>";
foreach ($res as $key => $list)
  echo "<th>$key";

for ($i = 0; $i < $row; $i++)
{
  echo "<tr>";
  foreach ($res as $key => $list)
    echo "<td>$list[$i]";
}

echo "</table>";

?>

</body>
</html>
