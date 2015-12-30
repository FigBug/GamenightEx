<?

function drawChart($title, $DataSet, $type, $colors, $legend = false)
{
  // Initialise the graph
  $Chart = new pChart(550,340);
  $Chart->setFontProperties("Fonts/tahoma.ttf",8);
  $Chart->setGraphArea(60,30,530,300);
  $Chart->drawFilledRoundedRectangle(7,7,543,333,5,240,240,240);
  $Chart->drawRoundedRectangle(5,5,545,335,5,230,230,230);
  $Chart->drawGraphArea(255,255,255,TRUE);
  $Chart->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,0,TRUE);

  // Draw the 0 line
  $Chart->setFontProperties("Fonts/tahoma.ttf",6);
  $Chart->drawTreshold(0,143,55,72,TRUE,TRUE);

  foreach ($colors as $idx => $color)
    $Chart->setColorPalette($idx, $color[0], $color[1], $color[2]);

  if ($type == "bar")
    $Chart->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription());
  else if ($type == "line")
    $Chart->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());

  if ($legend)
    $Chart->drawLegend(465,40,$DataSet->GetDataDescription(),255,255,255);

  // Finish the graph
  $Chart->setFontProperties("Fonts/tahoma.ttf",10);
  $Chart->drawTitle(60,22,$title,50,50,50,530);
  $Chart->Stroke();
}

?>