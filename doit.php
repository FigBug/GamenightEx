<html>
<head>
<title>Games</title>
</head>
<body>

<?

require "DB.php";
require "util.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$db = DB::connect("mysql://games:games@localhost/games");

$date = mysql_real_escape_string($_POST["date"]);
$game = mysql_real_escape_string($_POST["game"]);
$owner = mysql_real_escape_string($_POST["owner"]);
$number = mysql_real_escape_string($_POST["number"]);
$club = mysql_real_escape_string($_POST["club"]);

$sql = "insert into games (date, number, name, owner, club) values ('$date', $number, '$game', '$owner', '$club')";
$db->query($sql);

$sql = "select gameid from games order by gameid desc limit 1";
$q = $db->query($sql);

$names = array();

if ($q->fetchInto($r))
{
  $gameid = $r[0];

  for ($i = 1; $i <= 7; $i++)
  {
    if (isset($_POST["name" . $i]) && $_POST["name" . $i] != "")
    {
      $name = mysql_real_escape_string($_POST["name" . $i]);
      $place = mysql_real_escape_string($_POST["place" . $i]);
      $score = mysql_real_escape_string($_POST["score" . $i]);

      $sql = "insert into scores (gameid, position, name, points) values ($gameid, $place, '$name', $score)";

      $db->query($sql);

      $names[] = $name;
    }
  }
}

$eloS = array();
$eloE = array();

foreach ($names as $n)
  $eloS[] = getELO($db, $n);

calcAllELOs($db);
calcAllELOs1($db);

foreach ($names as $n)
  $eloE[] = getELO($db, $n);

?>

Game Added! (I hope)
<p>
<?

for ($i = 0; $i < count($names); $i++)
{
  $change = $eloE[$i] - $eloS[$i];
  echo $names[$i] . ": " . ($change < 0 ? $change : ("+" . $change)) . "<br>";
}

?>

<p>
<a href="addresult.php">Add Another</a> |
<a href="index.php">Go Home</a>

</body>
</html>
