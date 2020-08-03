<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Web Interface Monitoring for Mobile</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta http-equiv="Content-Language" content="en" />
	<meta name="robots" content="noindex, nofollow" />
	<meta name="author" content="Bruno Tadeu Russo"/>
	<meta http-equiv="refresh" content="120" /> 
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
   <LINK REL='stylesheet' TYPE='text/css' HREF='stylesheets/common.css'>
   <LINK REL='stylesheet' TYPE='text/css' HREF='stylesheets/status.css'>
	
	<script language="JavaScript">
	function autoResize(id){
		var newheight;
		var newwidth;

		if(document.getElementById){
			newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
			newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
		}

		document.getElementById(id).height= (newheight) + "px";
		document.getElementById(id).width= (newwidth) + "px";
	}
	</script>

</head>


<body bgcolor="#000000">

<div align="center">
<?php
	// Load config file 
	include 'config.php';
	print("<a href=\"$SERVER_NAME/mobile/index.php\"><img src=\"img/Logo.png\" width=\"140\" height=\"39\" border=\"0\" alt=\"\" align=\"middle\"></a>");
        print("<br><br>");
        print("<font size=\"+2\" color=\"#ffffff\"><strong>$BANNER</strong></font>");
        print("<br><br>");
        print("<br><br>");
?>
</div>
<br>

<?php

// Load config file 
include 'config.php';


//////////////////////////////////
$file_open = @fopen("$CONF_URL_MAP", "r");

// Here is the main function. If you do not understand sorry! I did the best could ;-) 
if ($file_open) {
	while (!feof($file_open)) {
		// Identify only: hostgroup or servicegroup 
		$buffer = fgets($file_open, 4096);

		if ($buffer != NULL){
        		print("<center><a href=\"$buffer\"><img src=\"img/maps.png\" width=\"22\" height=\"22\" border=\"0\" alt=\"Click here to map view\" align=\"middle\"></a></center>");
        print("<br><br>");
		}

    }
    // Close file 
    fclose($file_open);
}



// Open file and read list from groups 
$file_open = @fopen("$CONF_URL_DOWN", "r");
$COUNT = 1;

// Here is the main function. If you do not understand sorry! I did the best could ;-) 
if ($file_open) {
	while (!feof($file_open)) {
		// Identify only: hostgroup or servicegroup 
		$buffer = fgets($file_open, 4096);
		$title = strstr($buffer, '=');
		$title1 = strstr($title, '=');
		$chars = preg_split('/hostgroup=/', $title, -1, PREG_SPLIT_OFFSET_CAPTURE);
		$V = $chars[0][0];
		$chars_ = preg_split('/\&/', $V , -1, PREG_SPLIT_OFFSET_CAPTURE);
		$b = $chars_[0][0];
		$c = strlen($b);
		$c = $c-1;
		$hostgroup = substr($b, 1, $c );
  
		//Temporary
		$hostgroup = "Services";

		// This only exists to correct any mistake, it was necessary on some environments
		if ($COUNT == "1"){
			// Create template file, for group 
			$SERVICES = "$DOC_ROOT_TEMP/$hostgroup.html";
			$SERVICES_TEMP = "$DOC_ROOT_TEMP/$hostgroup.html.tmp";

			// Download URL from "monitoring"
			exec("wget --output-document '$SERVICES' --user=$USER_NAGIOS --password=$PASS_NAGIOS $buffer");
 
 			// Here count lines from file donwloaded 
			$LINHA = shell_exec("cat '$SERVICES' | grep -n \"Service Status Details For All Hosts\" | cut -f1 -d:");
			$TOT_LINHA = shell_exec("cat '$SERVICES' | wc -l");
			$CALCULO = $TOT_LINHA-$LINHA+1;
			

			// Initiates the creation of the file
			shell_exec("cat '$TEMPLATE_HTML' > '$SERVICES_TEMP' ");
			shell_exec("tail -n $CALCULO '$SERVICES' >> '$SERVICES_TEMP' ");

			// Change URL's, it's necessary to open links
			shell_exec("cat $SERVICES_TEMP | sed 's/status.cgi?/$SERVER_NAME_CONV\/cgi-bin\/status.cgi?/' > $SERVICES"); 
	 		shell_exec("cat $SERVICES | sed 's/extinfo.cgi?/$SERVER_NAME_CONV\/cgi-bin\/extinfo.cgi?/' > $SERVICES_TEMP"); 
 			shell_exec("cat $SERVICES_TEMP | sed 's/statusmap.cgi?/$SERVER_NAME_CONV\/cgi-bin\/statusmap.cgi?/' > $SERVICES"); 
 
			// Create index.php with iframes loading groups
			// The iframes size is flexibles. Thanks to function in javascript		
			print("<center>");
				print("<IFRAME SCROLLING=\"no\" SRC=\"tmp/$hostgroup.html\" width=\"100%\" 
					height=\"200px\" id=\"iframe$COUNT\" marginheight=\"0\" frameborder=\"0\" 
					onLoad=\"autoResize('iframe$COUNT');\"></iframe>");

			print("</center><br><br>");
		}
		// This conter is necessary to function javascript
		$COUNT++;
    }
    // Close file 
    fclose($file_open);
}

//////////////////////////////////
$file_open = @fopen("$CONF_URL", "r");
$COUNT = 1;

// Here is the main function. If you do not understand sorry! I did the best could ;-) 
if ($file_open) {
	while (!feof($file_open)) {
		// Identify only: hostgroup or servicegroup 
		$buffer = fgets($file_open, 4096);
		$title = strstr($buffer, '=');
		$title1 = strstr($title, '=');
		$chars = preg_split('/hostgroup=/', $title, -1, PREG_SPLIT_OFFSET_CAPTURE);
		$V = $chars[0][0];
		$chars_ = preg_split('/\&/', $V , -1, PREG_SPLIT_OFFSET_CAPTURE);
		$b = $chars_[0][0];
		$c = strlen($b);
		$c = $c-1;
		$hostgroup = substr($b, 1, $c );

		// This only exists to correct any mistake, it was necessary on some environments
		if ($hostgroup != null){
			// Create template file, for group 
			$SERVICES = "$DOC_ROOT_TEMP/$hostgroup.html";
			$SERVICES_TEMP = "$DOC_ROOT_TEMP/$hostgroup.html.tmp";

			// Download URL from "monitoring"
			exec("wget --output-document '$SERVICES' --user=$USER_NAGIOS --password=$PASS_NAGIOS $buffer");
 
 			// Here count lines from file donwloaded 
			$LINHA = shell_exec("cat '$SERVICES' | grep -n \"CLASS='statusTitle'\" | cut -f1 -d:");
			$TOT_LINHA = shell_exec("cat '$SERVICES' | wc -l");
			$CALCULO = $TOT_LINHA-$LINHA+1;

			// Initiates the creation of the file
			shell_exec("cat '$TEMPLATE_HTML' > '$SERVICES_TEMP' ");
			shell_exec("tail -n $CALCULO '$SERVICES' >> '$SERVICES_TEMP' ");

			// Change URL's, it's necessary to open links
			shell_exec("cat $SERVICES_TEMP | sed 's/status.cgi?/$SERVER_NAME_CONV\/cgi-bin\/status.cgi?/' > $SERVICES"); 
	 		shell_exec("cat $SERVICES | sed 's/extinfo.cgi?/$SERVER_NAME_CONV\/cgi-bin\/extinfo.cgi?/' > $SERVICES_TEMP"); 
 			shell_exec("cat $SERVICES_TEMP | sed 's/statusmap.cgi?/$SERVER_NAME_CONV\/cgi-bin\/statusmap.cgi?/' > $SERVICES"); 
 
			// Create index.php with iframes loading groups
			// The iframes size is flexibles. Thanks to function in javascript		
			print("<center>");
				print("<IFRAME SCROLLING=\"no\" SRC=\"tmp/$hostgroup.html\" width=\"100%\" 
					height=\"200px\" id=\"iframe$COUNT\" marginheight=\"0\" frameborder=\"0\" 
					onLoad=\"autoResize('iframe$COUNT');\"></iframe>");

			print("</center><br><br>");
		}
		// This conter is necessary to function javascript
		$COUNT++;
    }
    // Close file 
    fclose($file_open);
}
?>
</body>
<footer>
<?php
	// Insert footer page 
	include 'config.php';
        print("<center><a href=\"$SERVER_NAME/mobile/index.php\"><img src=\"img/reload.png\" width=\"22\" height=\"22\" border=\"0\" alt=\"\" align=\"middle\"></a></center>");
        print("<br><br>");
	print("<br><hr><br><center><font color=\"#ffffff\">Version - $VERSION_PRG - Oct, 2010");
	print("<br>NagMobile - <a href=\"$URL\">$URL</a></font>");
	print("<br><font color=\"#ffffff\" size=\"-4\">Nagios, the Nagios logo, and Nagios graphics are the servicemarks, <br>trademarks, or registered trademarks owned by Nagios Enterprises.</font></center>");
?>
</footer>
</html>
