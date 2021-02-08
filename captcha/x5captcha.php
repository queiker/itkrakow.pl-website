<?php
include("../res/x5engine.php");
$nameList = array("cwk","a2g","3wd","lmx","ema","f4w","m6s","ann","4dy","mma");
$charList = array("7","R","J","E","F","P","N","G","A","C");
$cpt = new X5Captcha($nameList, $charList);
//Check Captcha
if ($_GET["action"] == "check")
	echo $cpt->check($_GET["code"], $_GET["ans"]);
//Show Captcha chars
else if ($_GET["action"] == "show")
	echo $cpt->show($_GET['code']);
// End of file x5captcha.php
