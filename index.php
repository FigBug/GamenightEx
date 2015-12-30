<html>
<head>
<title>Games</title>
</head>
<body>

<a href="addresult.php">Add Result</a> |
<a href="predict.php">Predict</a> |
<a href="history.php">History</a> |
<a href="stats.php">Stats</a> |
<a href="stats1.php">Stats (1st game only)</a> |
<a href="percentage.php">Expected</a> |
<a href="what.php">What played?</a> |
<a href="what1.php">What played 1st?</a> |
<a href="won.php">What won?</a> |
<a href="won1.php">What won 1st?</a>
<p>
<?

require "DB.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$db = DB::connect("mysql://games:games@localhost/games");

$sql = "select date,number,name,owner,gameid from games order by date asc, number asc";
$q = $db->query($sql);

echo "<table border=1>";
echo "<tr><th>#<th>Date<th>#<th>Game<th>Owner<th>Player<th>Score<th>Player<th>Score<th>Player<th>Score<th>Player<th>Score<th>Player<th>Score<th>Player<th>Score<th>Player<th>Score";

$idx = 1;
while ($q->fetchInto($r1))
{
  echo "<tr><td>$idx<td>$r1[0]<td>$r1[1]<td><a href=\"game.php?name=$r1[2]\">$r1[2]</a><td>$r1[3]";
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
