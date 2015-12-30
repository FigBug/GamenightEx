<html>
<head>
<title>Player</title>
</head>
<body>

<?

require "DB.php";
require "util.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$db = DB::connect("mysql://games:games@localhost/games");

$name = $_GET['name'];
$name = mysql_real_escape_string($name);

echo "<h1>$name</h1>";

echo "<h3>Attendance: " . getNum($db, "select count(*) as num from scores inner join games on games.gameid = scores.gameid where games.number = 1 and scores.name = '$name'") . "</h3>";
echo "<h3>Games Played: " . getNum($db, "select count(*) as num from scores where name = '$name'") . "</h3>";
echo "<h3>ELO: " . getNum($db, "select elo from elo where name = '$name' order by eloid desc limit 1") . "</h3>";

echo "<img src=\"graphs/elo.php?name=$name\">";

doTable("Besties", $db, "select opp, concat(round(p / t * 100,0),'%') as pct from (select scores.name,s.name as opp,count(*) as p from scores inner join scores as s on scores.gameid = s.gameid where scores.name = '$name' and s.name <> '$name' group by s.name order by p desc) as plays join (select scores.name,count(*) as t from scores where scores.name = '$name') as total using (name) order by p/t desc limit 10");
doTable("Games Played", $db, "select games.name,count(*) as num from games inner join scores on games.gameid = scores.gameid where scores.name = '$name' group by games.name order by num desc");
doPositionTable("Play History", $db, "select games.date,games.name,scores.position from games inner join scores on scores.gameid=games.gameid where scores.name = '$name' order by games.date asc, games.number asc");

?>

</body>
</html>
