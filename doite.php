<html>
<head>
<title>Games</title>
</head>
<body>

<?

require "DB.php";
require "util.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$db = DB::connect("mysqli://games:games@localhost/games");
$db->autocommit(false);

$gid = $db->escapeSimple($_GET["gameid"]);
$date = $db->escapeSimple($_POST["date"]);
$game = $db->escapeSimple($_POST["game"]);
$owner = $db->escapeSimple($_POST["owner"]);
$number = $db->escapeSimple($_POST["number"]);
$club = $db->escapeSimple($_POST["club"]);

$sql = "delete from games where gameid=$gid";
$db->query($sql);

$sql = "delete from scores where gameid=$gid";
$db->query($sql);

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
      $name = $db->escapeSimple($_POST["name" . $i]);
      $place = $db->escapeSimple($_POST["place" . $i]);
      $score = $db->escapeSimple($_POST["score" . $i]);

      $sql = "insert into scores (gameid, position, name, points) values ($gameid, $place, '$name', $score)";

      $db->query($sql);

      $names[] = $name;
    }
  }
}

$db->query("commit");
$db->autocommit(true);

$eloS = array();
$eloE = array();

foreach ($names as $n)
  $eloS[] = getELO($db, $n);

calcAllELOs($db);
calcAllELOs1($db);

foreach ($names as $n)
  $eloE[] = getELO($db, $n);

?>

Game Edited! (I hope)
<p>
<?

for ($i = 0; $i < count($names); $i++)
{
  $change = $eloE[$i] - $eloS[$i];
  echo $names[$i] . ": " . ($change < 0 ? $change : ("+" . $change)) . "<br>";
}

?>

<p>
<a href="index.php">Go Home</a>

</body>
</html>
