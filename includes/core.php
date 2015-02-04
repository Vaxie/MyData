<?php
session_start(); //
date_default_timezone_set("Europe/Copenhagen"); // Sørg altid for at vores tidszone er "dansk tid"\\
define('SYSTEM_RUNNING', true); //
include_once("class/MySystem.class.php"); // Her includer vi MySystem.class.php\\
include_once("class/MyData.class.php"); // Her includer vi MySystem.class.php\\

 //                     Betydning af include_once                         \\
//  Dette er en metode, der minder om include men den eneste forskel er - \\
// - at hvis koden fra en fil allerede er inkluderet, vil det ikke være inkluderet igen.\\
// Som navnet antyder, vil den kun blive kørt én gang. \\
?>
