<?

require "../color.php";

//error_reporting(0);

function drawChart($title, $DataSet, $names, $colors, $legend = false)
{
  // Initialise the graph
  $Chart = new pChart(1300,750);
  $Chart->setFontProperties("Fonts/tahoma.ttf",8);
  $Chart->setGraphArea(50,25,1200,725);
  $Chart->drawGraphArea(255,255,255,TRUE);
  $Chart->drawXYScale($DataSet->GetData(),$DataSet->GetDataDescription(),"ally","allx",150,150,150,TRUE,45);
  $Chart->setLineStyle(4);
  // Draw the 0 line
  $Chart->setFontProperties("Fonts/tahoma.ttf",6);
  $Chart->drawTreshold(0,143,55,72,TRUE,TRUE);

  foreach ($colors as $idx => $color)
    $Chart->setColorPalette($idx, $color[0], $color[1], $color[2]);

  $i = 0;
  foreach ($names as $name) {
    $Chart->drawXYGraph($DataSet->GetData(),$DataSet->GetDataDescription(), $name . "y", $name . "x", $i);
    $i++;
  }

  if ($legend)
    $Chart->drawLegend(465,40,$DataSet->GetDataDescription(),255,255,255);

  // Finish the graph
  $Chart->setFontProperties("Fonts/tahoma.ttf",10);
//  $Chart->drawTitle(60,22,$title,50,50,50,530);
  $Chart->Stroke();
}

$title = "ELO";

require('DB.php');

$db = DB::connect("mysql://roland:68volvo@localhost/games");

$sql = "select name from scores group by name having count(*) > 10";

$q = $db->query($sql);

$names = array();
while ($q->fetchInto($row))
  $names[] = $row[0];

sort($names);

$sql = "select games.date, games.gameid, scores.name, elo.elo from elo inner join games on games.gameid = elo.gameid inner join scores on games.gameid = scores.gameid where elo.name in (select name from scores group by name having count(*) > 10) and scores.name = elo.name order by games.gameid asc";

$q = $db->query($sql);

$date = array();
$x = array();
$y = array();
$allx = array();
$ally = array();

foreach ($names as $name) {
  $x[$name] = array();
  $y[$name] = array();
}

while ($q->fetchInto($row)) {
  $gatedate = $row[0];
  $gameid = $row[1];
  $player = $row[2];
  $elo = $row[3];

  $x[$player][] = $gameid - 828;
  $y[$player][] = $elo;
  
  $allx[] = $gameid - 828;
  $ally[] = $elo;
}

// Standard inclusions   
include("pChart/pData.class");
include("pChart/pChart.class");

// Dataset definition 
$DataSet = new pData;

$DataSet->AddPoint($allx, "allx");
$DataSet->AddSerie("allx");
$DataSet->AddPoint($ally, "ally");
$DataSet->AddSerie("ally");

foreach ($names as $name) {
  $DataSet->AddPoint($x[$name], $name . "x");
  $DataSet->AddSerie($name . "x");
  $DataSet->AddPoint($y[$name], $name . "y");
  $DataSet->AddSerie($name . "y");
}
//$DataSet->SetYAxisName("ELO");
//$DataSet->SetXAxisName("Game");

$colors = array();

$ratio = 0;
$gold = 0.618033988749895;
for ($i = 0; $i < count($names); $i++) {
  $ratio += $gold;
  $ratio = $ratio % 1;
  $colors[] = fGetRGB($i / count($names) * 360, 95, 95);
}

drawChart($title, $DataSet, $names, $colors);

?>
