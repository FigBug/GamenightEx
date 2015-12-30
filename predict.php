<html>
<head>
<title>Predict</title>
</head>
<body>

<?

require "DB.php";
require "util.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$db = DB::connect("mysql://games:games@localhost/games");

$sql = "select distinct name from scores order by name asc";
$q = $db->query($sql);

$names = array();
while ($q->fetchInto($row))
  $names[] = $row[0]; 
?>
<h3>Predict a Game!</h3>
<form action="doitp.php" method="post">

<table border=0>
<?
foreach ($names as $name)
  echo "<tr><td><input type=checkbox name=$name value=$name>$name";
?>
</table>
<p>
<input type=submit value="Submit">
</form>

</body>
</html>
