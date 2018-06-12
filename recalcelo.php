<?

require "DB.php";
require "util.php";

$db = DB::connect("mysqli://games:games@localhost/games");

calcAllELOs($db);
calcAllELOs1($db);
