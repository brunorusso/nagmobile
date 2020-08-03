<?php

//URL Access from Nagios 
$SERVER_NAME = "http://127.0.0.1/nagios";

//User name to access Nagios 
$USER_NAGIOS = "nagios";

// Password to acces Nagios 
$PASS_NAGIOS = "nagios";

//Document Root from Nagios
$DOC_ROOT = "/var/www/htdocs/nagios/mobile";

// This Variable print Message on TOP Page
$BANNER = "nagMobile monitoring by Nagios";

//This Parameters don't change 
$CONF_URL = "$DOC_ROOT/config_url.php";

$CONF_URL_DOWN = "$DOC_ROOT/config_url_down.php";

$CONF_URL_MAP = "$DOC_ROOT/config_url_map.php";

$DOC_ROOT_TEMP = "$DOC_ROOT/tmp";

$TEMPLATE_HTML = "$DOC_ROOT/template_header.html";

$SERVER_NAME_CONV = str_replace("/", "\/", $SERVER_NAME);

$VERSION_PRG = "0.5rc2";

$URL = "http://linux.brunorusso.eti.br/doku.php?id=nagmobile";

?>
