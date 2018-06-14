<?

//error_reporting(0);
function toYStr($date)
{
  $time = strtotime($date);
  return date('M y', $time);
}

$title = "ELO (1st games)";

require('DB.php');
require('graphfunc.php');

$name = $_GET['name'];
preg_replace("/[^A-Za-z0-9 ]/", '', $name);

$db = DB::connect("mysqli://games:games@localhost/games");

$sql = "select games.date, elo1.elo from elo1 inner join games on games.gameid = elo1.gameid where elo1.name = '$name' and games.number = 1 order by elo1.eloid asc";

$q = $db->query($sql);

$date = array();
$val = array();

$year = 0;

while ($q->fetchInto($row)) {
  if ($year != toYStr($row[0]))
    $date[] = toYStr($row[0]);
  else
    $date[] = "";
  $year = toYStr($row[0]);
  
  $val[]  = $row[1];
}

// Standard inclusions   
include("pChart/pData.class");
include("pChart/pChart.class");

// Dataset definition 
$DataSet = new pData;
$DataSet->AddPoint($val, "Serie1");
$DataSet->AddPoint($date, "Serie2");
$DataSet->AddSerie("Serie1");
$DataSet->SetAbsciseLabelSerie("Serie2");
$DataSet->SetYAxisName("ELO");
$DataSet->SetXAxisName("Game");

drawChart($title, $DataSet, "line", array(array(255,0,0)));

?>
