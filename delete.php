<html>
<head>
<title>Games</title>
</head>
<body>

<?

require "DB.php";
require "util.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$db = DB::connect("mysql://games:games@localhost/games");

$gid = mysql_real_escape_string($_GET["gameid"]);

$sql = "delete from games where gameid=$gid";
$db->query($sql);

$sql = "delete from scores where gameid=$gid";
$db->query($sql);

calcAllELOs($db);
?>

Game Deleted! (I hope)
<p>
<?

?>

<p>
<a href="index.php">Go Home</a>

</body>
</html>
