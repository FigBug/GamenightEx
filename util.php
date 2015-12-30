
<?
require "elo.php";

function ordSuffix($n) 
{
  $str = "$n";
  $t = $n > 9 ? substr($str,-2,1) : 0;
  $u = substr($str,-1);

  if ($t==1) 
    return $str . 'th';
  else switch ($u) 
  {
     case 1: return $str . 'st';
     case 2: return $str . 'nd';
     case 3: return $str . 'rd';
     default: return $str . 'th';
  }
}

function doTable($title, $db, $sql)
{
  echo "<h3>$title</h3>";
  echo "<table border=1>";

  $q = $db->query($sql);

  while ($q->fetchInto($r))
  {
    echo "<tr>";
    foreach ($r as $item)
      echo "<td>$item";
  }
  echo "</table>"; 
}

function doPositionTable($title, $db, $sql)
{
  echo "<h3>$title</h3>";
  echo "<table border=1>";

  $q = $db->query($sql);

  while ($q->fetchInto($r))
  {
    echo "<tr>";
    $i = 0;
    $len = count($r);
    foreach ($r as $item)
    {
      $i++;
      if ($i < $len)
        echo "<td>" . $item;
      else
        echo "<td>" . ordSuffix($item);
    }
  }
  echo "</table>";
}

function getNum($db, $sql)
{
  $q = $db->query($sql);
  
  if ($q->fetchInto($r))
  {
    return $r[0];
  }
  else
  {
    return "";
  }
}

function getAllGameIDs($db)
{
  $sql = "select gameid from games order by date asc, number asc";
  $q = $db->query($sql);

  $res = array();

  while ($q->fetchInto($r))
    $res[] = $r[0];

  return $res;
}

function getELO($db, $name)
{
  $sql = "select elo from elo where name = '$name' order by eloid desc limit 1";
  $q = $db->query($sql);

  if ($q->fetchInto($row))
    return $row[0];
  else
    return 1500;
}

function calcAllELOs($db)
{
  $sql = "delete from elo";
  $db->query($sql);

  $games = getAllGameIDs($db);

  foreach ($games as $gameid)
  {
    $sql = "select name,position from scores where gameid='$gameid'";
    $q1 = $db->query($sql);

    $names = array();
    $match = new ELOMatch();

    while ($q1->fetchInto($r1))
    {
      $name = $r1[0];
      $pos  = $r1[1];
      $elo  = getELO($db, $name);

      $names[] = $name;

      $match->addPlayer($name, $pos, $elo);
    }

    $match->calculateELOs();

    foreach ($names as $name) 
    {
      $newELO = $match->getELO($name);
      $sql = "insert into elo (gameid,name,elo) values ($gameid, '$name', $newELO)";
      $db->query($sql);
    }
  }
}

function rgbToHsl( $r, $g, $b ) {
	$oldR = $r;
	$oldG = $g;
	$oldB = $b;
	$r /= 255;
	$g /= 255;
	$b /= 255;
    $max = max( $r, $g, $b );
	$min = min( $r, $g, $b );
	$h;
	$s;
	$l = ( $max + $min ) / 2;
	$d = $max - $min;
    	if( $d == 0 ){
        	$h = $s = 0; // achromatic
    	} else {
        	$s = $d / ( 1 - abs( 2 * $l - 1 ) );
		switch( $max ){
	            case $r:
	            	$h = 60 * fmod( ( ( $g - $b ) / $d ), 6 ); 
                        if ($b > $g) {
	                    $h += 360;
	                }
	                break;
	            case $g: 
	            	$h = 60 * ( ( $b - $r ) / $d + 2 ); 
	            	break;
	            case $b: 
	            	$h = 60 * ( ( $r - $g ) / $d + 4 ); 
	            	break;
	        }			        	        
	}
	return array( round( $h, 2 ), round( $s, 2 ), round( $l, 2 ) );
}

function hslToRgb( $h, $s, $l ){
    $r; 
    $g; 
    $b;
	$c = ( 1 - abs( 2 * $l - 1 ) ) * $s;
	$x = $c * ( 1 - abs( fmod( ( $h / 60 ), 2 ) - 1 ) );
	$m = $l - ( $c / 2 );
	if ( $h < 60 ) {
		$r = $c;
		$g = $x;
		$b = 0;
	} else if ( $h < 120 ) {
		$r = $x;
		$g = $c;
		$b = 0;			
	} else if ( $h < 180 ) {
		$r = 0;
		$g = $c;
		$b = $x;					
	} else if ( $h < 240 ) {
		$r = 0;
		$g = $x;
		$b = $c;
	} else if ( $h < 300 ) {
		$r = $x;
		$g = 0;
		$b = $c;
	} else {
		$r = $c;
		$g = 0;
		$b = $x;
	}
	$r = ( $r + $m ) * 255;
	$g = ( $g + $m ) * 255;
	$b = ( $b + $m  ) * 255;
    return array( floor( $r ), floor( $g ), floor( $b ) );
}

?>
