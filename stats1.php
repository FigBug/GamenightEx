<html>
<head>
<title>Stats</title>
</head>
<body>

<?

require "DB.php";
require "util.php";

$db = DB::connect("mysqli://games:games@localhost/games");

$sql = "select scores.name,count(*) as num from scores inner join games on games.gameid = scores.gameid where number = 1 group by scores.name order by num desc";
doTable("# Games Played", $db, $sql);

$sql = "select s1.name as n1,s2.name as n2, count(*) as num from scores as s1 join scores as s2 on s1.gameid = s2.gameid where s1.name < s2.name and s1.gameid in (select gameid from games where number = 1) group by s1.name, s2.name order by num desc limit 20";
doTable("Top Pairings", $db, $sql);

$sql = "select name, elo from (select * from elo1 order by `name`, eloid desc) x group by `name` order by elo desc";
doTable("ELO", $db, $sql);

$sql = "select scores.name,count(*) as num from scores inner join games on games.gameid = scores.gameid where number = 1 and position=1 group by scores.name order by num desc";
doTable("# Games Won", $db, $sql);

$sql = "SELECT name, concat(round(w / p * 100,0),'%') AS win_pct FROM (SELECT scores.name, count(*) w FROM scores inner join games on games.gameid=scores.gameid WHERE games.number = 1 and position=1 GROUP BY scores.name) AS wins JOIN (SELECT scores.name, count(*) p FROM scores inner join games on games.gameid=scores.gameid WHERE games.number = 1 GROUP BY scores.name) AS plays USING (name) ORDER BY w/p DESC";
doTable("Win Percentage", $db, $sql);

$sql = "select scores.name,round(avg(position),1) as num from scores inner join games on games.gameid = scores.gameid where number = 1 group by scores.name order by num asc";
doTable("Average Rank", $db, $sql);

$sql = "SELECT name, round(avg((position-1) / (max_position-1)) * 4 + 1,1) AS avg_norm_rank FROM ( select scores.scoreid,scores.gameid,scores.position,scores.name,scores.points from scores inner join games on games.gameid = scores.gameid where games.number = 1) as s JOIN ( SELECT gameid, max(position) AS max_position FROM scores GROUP BY gameid) AS max_positions USING (gameid) GROUP BY name ORDER BY avg_norm_rank";
doTable("Normalised Rank", $db, $sql);

$sql = "select owner,count(*) as num from games where number = 1 group by owner order by num desc";
doTable("Game Owners", $db, $sql);

$sql = "select name,count(*) as num from games where number = 1 group by name order by num desc";
doTable("Top Games", $db, $sql);

?>

</body>
</html>
