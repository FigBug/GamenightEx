<html>
<head>
<title>Games</title>
</head>
<body>

<?
require "DB.php";
require "util.php";

$db = DB::connect("mysqli://games:games@localhost/games");

$gid = mysql_real_escape_string($_GET["gameid"]);

$sql = "select date,number,name,owner,club from games where gameid=$gid";
$q = $db->query($sql);

$q->fetchInto($r);

?>

<form action="doite.php?gameid=<? echo $gid ?>" method="post">

<table border=0>
<tr><td>Date:<td><input type=date name=date value="<? echo $r[0] ?>">
<tr><td>Game:<td><input type=text name=game value="<? echo $r[2] ?>">
<tr><td>Owner:<td><input type=text name=owner value="<? echo $r[3] ?>">
<tr><td>Number:<td><input type=text name=number size=4 value="<? echo $r[1] ?>">
<tr><td>Group:<td><input type=text name=club value="<? echo $r[4] ?>">
</table>
<p>
<table border=0>
<tr><th>Place<th>Name<th>Score

<?

$sql = "select position,name,points from scores where gameid=$gid order by position asc";
$q = $db->query($sql);

$i = 1;
while ($q->fetchInto($r))
{
  echo "<tr><td><input type=text name=place$i value=$r[0] size=4>";
  echo "<td><input type=text name=name$i value=\"$r[1]\">";
  echo "<td><input type=text name=score$i size=4 value=\"$r[2]\">";
  
  $i++;
}
$cur = $i;
for ($i = $cur; $i <= 7; $i++)
{
  echo "<tr><td><input type=text name=place$i value=$i size=4>";
  echo "<td><input type=text name=name$i>";
  echo "<td><input type=text name=score$i size=4>";
}

?>
</table>
<p>
<input type=submit value="Edit">
</form>
<form action="delete.php?gameid=<? echo $gid ?>" method="post">
<input type=submit value="Delete">
</form>
</body>
</html>
