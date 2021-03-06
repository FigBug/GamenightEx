<html>
<head>
<title>Stats</title>
</head>
<body>
<center><h3>
<?

require "DB.php";
require "util.php";

    function fGetRGB($iH, $iS, $iV) {
        if($iH < 0)   $iH = 0;   // Hue:
        if($iH > 360) $iH = 360; //   0-360
        if($iS < 0)   $iS = 0;   // Saturation:
        if($iS > 100) $iS = 100; //   0-100
        if($iV < 0)   $iV = 0;   // Lightness:
        if($iV > 100) $iV = 100; //   0-100
        $dS = $iS/100.0; // Saturation: 0.0-1.0
        $dV = $iV/100.0; // Lightness:  0.0-1.0
        $dC = $dV*$dS;   // Chroma:     0.0-1.0
        $dH = $iH/60.0;  // H-Prime:    0.0-6.0
        $dT = $dH;       // Temp variable
        while($dT >= 2.0) $dT -= 2.0; // php modulus does not work with float
        $dX = $dC*(1-abs($dT-1));     // as used in the Wikipedia link
        switch(floor($dH)) {
            case 0:
                $dR = $dC; $dG = $dX; $dB = 0.0; break;
            case 1:
                $dR = $dX; $dG = $dC; $dB = 0.0; break;
            case 2:
                $dR = 0.0; $dG = $dC; $dB = $dX; break;
            case 3:
                $dR = 0.0; $dG = $dX; $dB = $dC; break;
            case 4:
                $dR = $dX; $dG = 0.0; $dB = $dC; break;
            case 5:
                $dR = $dC; $dG = 0.0; $dB = $dX; break;
            default:
                $dR = 0.0; $dG = 0.0; $dB = 0.0; break;
        }
        $dM  = $dV - $dC;
        $dR += $dM; $dG += $dM; $dB += $dM;
        $dR *= 255; $dG *= 255; $dB *= 255;
        return round($dR).",".round($dG).",".round($dB);
    }

$db = DB::connect("mysqli://games:games@localhost/games");
$game = $_GET['game'];
$game = $db->escapeSimple($game);

$sql = "select scores.name from scores inner join games on games.gameid=scores.gameid where games.name='$game' group by scores.name having count(*) >= 2";

$q = $db->query($sql);

$names = array();
while ($q->fetchInto($row))
  $names[] = $row[0];

sort($names);

$i = 0;
foreach ($names as $name)
{
  $col = fGetRGB($i / count($names) * 360, 95, 95);
  echo "<span style=\"color: rgb($col)\">$name</span> "; 
  $i++;
}

?>
</h3></center>
<img src="graphs/gameelo.php?game=<? echo $game; ?>">

</body>
</html>
