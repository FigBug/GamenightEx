<html>
<head>
<title>Expected Win Rates</title>
</head>
<body>

<h1>Expected Win Rates</h1>
<table border=1>
<?

require "DB.php";
require "util.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$db = DB::connect("mysql://games:games@localhost/games");

$sql = "select distinct name from scores order by name asc";
$q = $db->query($sql);

$names = array();
$elo   = array();

while ($q->fetchInto($r)) {
  $names[] = $r[0];
  $elo[] = getELO($db, $r[0]);
}

echo "<tr><th>";
foreach ($names as $name)
  echo "<th>$name";

$i = 0;
foreach ($names as $n1)
{
  echo "<tr><th>$n1";

  $j = 0;
  foreach ($names as $n2)
  {
    echo "<td align=center>";
    if ($n1 == $n2) {
      echo " ";
    } else {
      $diff = $elo[$i] - $elo[$j];
      $p = 1 / ( 1 + pow( 10, $diff / 400 ) );
      echo round($p * 100) . "%";
    }
    $j++;
  }
  $i++;
}

?>
</table>
</body>
</html>
