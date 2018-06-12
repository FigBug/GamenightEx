<html>
<head>
<title>Games</title>
</head>
<body>

<form action="doit.php" method="post">

<?

require "DB.php";
require "util.php";

$db = DB::connect("mysqli://games:games@localhost/games");

$ts = time();

if (date('H') <= 12)
  $ts -= 86400;

$date = date('Y-m-d', $ts);

?>

<table border=0>
<tr><td>Date:<td><input type=date name=date value=<? echo $date; ?>>
<tr><td>Game:<td><input type=text name=game list=games>
<tr><td>Owner:<td><input type=text name=owner list=people>
<tr><td>Number:<td><input type=text name=number value=1 size=4>
<tr><td>Group:<td><input type=text name=club value=GamenightEx>
</table>
<p>
<table border=0>
<tr><th>Place<th>Name<th>Score
<tr><td><input type=text name=place1 value=1 size=4><td><input type=text name=name1 list=people><td><input type=text name=score1 size=4>
<tr><td><input type=text name=place2 value=2 size=4><td><input type=text name=name2 list=people><td><input type=text name=score2 size=4>
<tr><td><input type=text name=place3 value=3 size=4><td><input type=text name=name3 list=people><td><input type=text name=score3 size=4>
<tr><td><input type=text name=place4 value=4 size=4><td><input type=text name=name4 list=people><td><input type=text name=score4 size=4>
<tr><td><input type=text name=place5 value=5 size=4><td><input type=text name=name5 list=people><td><input type=text name=score5 size=4>
<tr><td><input type=text name=place6 value=6 size=4><td><input type=text name=name6 list=people><td><input type=text name=score6 size=4>
<tr><td><input type=text name=place7 value=7 size=4><td><input type=text name=name7 list=people><td><input type=text name=score7 size=4>
</table>
<p>
<input type=submit value="Submit">

<?

$sql = "select distinct name from games order by name";
$q = $db->query($sql);

echo "<datalist id=games>\n";
while ($q->fetchInto($r))
  echo "<option value=\"$r[0]\">\n";
echo "</datalist>\n";

$sql = "select distinct name from scores order by name";
$q = $db->query($sql);

echo "<datalist id=people>\n";
while ($q->fetchInto($r))
  echo "<option value=\"$r[0]\">\n";
echo "</datalist>\n";

?>

</form>
</body>
</html>
