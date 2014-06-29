<?php 

header("Content-Type: text/html; charset=UTF-8");

include_once './inc/database.class.php';
include_once './inc/session.class.php';

$session = new Session();

echo "File 2 Session ID: " . session_id() . " - number of session variables: " . count($_SESSION) . "<br />\n";
echo "<a href='./file_1.php' title=''>Go to file 1</a>\n";

?>