<?php
set_time_limit(0);

if(isset($_POST['submit']) && isset($_FILES['filedata']) && !empty($_FILES['filedata']) && $_FILES['filedata']['error'] == 0) {
    $file = escapeshellarg($_FILES['filedata']['tmp_name']);
    if(system("/usr/local/bin/hashcat --quiet -D1 -m 100 -a 0 --outfile=/var/www/vhosts/vanguardanalysis.com/web/data/recovered.txt --outfile-format=2 --username --potfile-path=/var/www/vhosts/vanguardanalysis.com/web/data/vanguard.pot $file /var/www/vhosts/vanguardanalysis.com/web/data/linked-singles.txt >/dev/null") !== FALSE) {
        if(file_exists("/var/www/vhosts/vanguardanalysis.com/web/data/recovered.txt")) {
            if(system("/home/ec2-user/pipal/pipal.rb /var/www/vhosts/vanguardanalysis.com/web/data/recovered.txt -o /var/www/vhosts/vanguardanalysis.com/web/data/pipal-output.txt >/dev/null") !== FALSE) {
                if(file_exists("/var/www/vhosts/vanguardanalysis.com/web/data/pipal-output.txt")) {
                    $f = file("/var/www/vhosts/vanguardanalysis.com/web/data/pipal-output.txt");
                    foreach($f as $k => &$l) {
                        $class = '';
                        $l = trim($l);
                        //echo "$k: l: $l\n";
                        if(strpos($l,"|") !== FALSE) {
                            $n .= "<div class=\"p\">$l</div>\n";
                            continue;
                        }

                        if(($f[$k-1] == "" || $f[$k-1] == "\n") && strpos($l,"=") === FALSE && strpos($l,":") === FALSE) {
                            $n .= "<br><div class=\"s\">{$l}</div>\n";
                        } else $n .= "<div>$l</div>\n";
                    }

		    echo "<div style=\"font-size: 18px; font-weight: bold;\">Report Generated!</div>";
                    echo "$n\n";
                }
            }
        }
    }
}
unlink("/var/www/vhosts/vanguardanalysis.com/web/data/recovered.txt");
unlink("/var/www/vhosts/vanguardanalysis.com/web/data/vanguard.pot");
unlink("/var/www/vhosts/vanguardanalysis.com/web/data/pipal-output.txt");
?>﻿
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Vanguard solutions</title>
 <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="http://fonts.googleapis.com/css?family=Arvo:400,700" rel="stylesheet" type="text/css" />
<link href="default.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<div id="wrapper-gradiant">
	<div id="wrapper-bgshadow">
		<div id="wrapper">
			<div id="header">
				<div id="logo">
					<h1>Vanguard </br> Analysis</h1>
				</div>
			</div>
			<div id="menu-wrapper">
				<div id="menu">
					<ul>
                                                <li><a href="index.html">Home</a></li>
                                                <li><a href="upload.php">Upload</a></li>
                                                <li><a href="about.html">About Us</a></li>
                                                <li><a href="support.html">Support</a></li>
                                                <li><a href="account.html">Account</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>

<div class="background">
  <div class="transbox">
	<form action="upload.php" method="post" enctype="multipart/form-data">
	    <p>Select file to upload:</p>
	    <input type="file" name="filedata" id="filedata">
	    <input type="submit" value="Upload File" name="submit">
	</form>
</div>
</div>
</div>

<div id="footer">
		<p>© VanguardAnalysis</p>
	</div>
</div>
</body>
</html>
