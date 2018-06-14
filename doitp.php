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

$names = array();
$elo   = array();
$q     = array();


foreach ($_POST as $name) {
  $names[] = $name;
  $elo[$name] = getELO($db, $name);
  $q[$name] = pow(10, $elo[$name] / 400);
}

$qsum = 0;
foreach ($q as $qitem)
  $qsum += $qitem;

$percent = array();
foreach ($names as $name)
  $percent[$name] = $q[$name] / $qsum;

arsort($percent);

?>

<h3>Predicted Result:</h3>
<table border=1>
<?
$i = 1;
foreach ($percent as $name => $p) {
  $pp = round($p * 100);
  echo "<tr><td>$i<td>$name<td>$pp%";
  $i++;
}
?>
</table>
<p>
<a href="predict.php">Predict Another</a>
<a href="index.php">Go Home</a>

</body>
</html>
