<html>
<head>
<title>Games</title>
</head>
<body>

<form action="doit.php" method="post">

<table border=0>
<tr><td>Date:<td><input type=date name=date value=<?php echo date('Y-m-d'); ?>>
<tr><td>Game:<td><input type=text name=game>
<tr><td>Owner:<td><input type=text name=owner>
<tr><td>Number:<td><input type=text name=number value=1 size=4>
<tr><td>Group:<td><input type=text name=club value=GamenightEx>
</table>
<p>
<table border=0>
<tr><th>Place<th>Name<th>Score
<tr><td><input type=text name=place1 value=1 size=4><td><input type=text name=name1><td><input type=text name=score1 size=4>
<tr><td><input type=text name=place2 value=2 size=4><td><input type=text name=name2><td><input type=text name=score2 size=4>
<tr><td><input type=text name=place3 value=3 size=4><td><input type=text name=name3><td><input type=text name=score3 size=4>
<tr><td><input type=text name=place4 value=4 size=4><td><input type=text name=name4><td><input type=text name=score4 size=4>
<tr><td><input type=text name=place5 value=5 size=4><td><input type=text name=name5><td><input type=text name=score5 size=4>
<tr><td><input type=text name=place6 value=6 size=4><td><input type=text name=name6><td><input type=text name=score6 size=4>
<tr><td><input type=text name=place7 value=7 size=4><td><input type=text name=name7><td><input type=text name=score7 size=4>
</table>
<p>
<input type=submit value="Submit">
</form>
</body>
</html>
