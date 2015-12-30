<html>
<head>
<title>Stats</title>
</head>
<body>

<?

require "DB.php";
require "util.php";

$db = DB::connect("mysql://games:games@localhost/games");

$sql = "select name,count(*) as num from scores group by name order by num desc";
doTable("# Games Played", $db, $sql);

$sql = "select s1.name as n1,s2.name as n2, count(*) as num from scores as s1 join scores as s2 on s1.gameid = s2.gameid where s1.name < s2.name group by s1.name, s2.name order by num desc limit 20";
doTable("Top pairings", $db, $sql);

$sql = "select name, elo from (select * from elo order by `name`, eloid desc) x group by `name` order by elo desc";
doTable("ELO", $db, $sql);

$sql = "select name,count(*) as num from scores where position=1 group by name order by num desc";
doTable("# Games Won", $db, $sql);

$sql = "SELECT name, concat(round(w / p * 100,0),'%') AS win_pct FROM (SELECT name, count(*) w FROM scores WHERE position=1 GROUP BY name) AS wins JOIN (SELECT name, count(*) p FROM scores GROUP BY name) AS plays USING (name) ORDER BY  w / p DESC";
doTable("Win Percentage", $db, $sql);

$sql = "select name,round(avg(position),1) as num from scores group by name order by num asc";
doTable("Average Rank", $db, $sql);

$sql = "SELECT name, round(avg((position-1) / (max_position-1)) * 4 + 1,1) AS avg_norm_rank FROM scores JOIN ( SELECT gameid, max(position) AS max_position FROM scores GROUP BY gameid) AS max_positions USING (gameid) GROUP BY name ORDER BY avg_norm_rank";
doTable("Normalised Rank", $db, $sql);

$sql = "select owner,count(*) as num from games group by owner order by num desc";
doTable("Game Owners", $db, $sql);

$sql = "select name,count(*) as num from games group by name order by num desc";
doTable("Top Games", $db, $sql);

?>

</body>
</html>
