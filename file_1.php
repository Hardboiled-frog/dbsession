<?php 

header("Content-Type: text/html; charset=UTF-8");

include_once './inc/database.class.php';
include_once './inc/session.class.php';

$session = new Session();

$_SESSION['test'] = 'TEST';

echo "File 1 Session ID: " . session_id() . " - number of session variables: " . count($_SESSION) . "<br />\n";
echo "<a href='file_2.php' title=''>Go to file 2</a>\n";

?>