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
$db->autocommit(false);

$gid = $db->escapeSimple($_GET["gameid"]);

$sql = "delete from games where gameid=$gid";
$db->query($sql);

$sql = "delete from scores where gameid=$gid";
$db->query($sql);

$db->query("commit");
$db->autocommit(true);

calcAllELOs($db);
calcAllELOs1($db);
?>

Game Deleted! (I hope)
<p>
<?

?>

<p>
<a href="index.php">Go Home</a>

</body>
</html>
