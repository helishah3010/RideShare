<?php
$connection = mysql_connect("localhost","root");
$condb = mysql_select_db("ride2015", $connection);
if(!$connection) {
	die("Sorry!Could'nt connect:".mysqli_connect_error());
}
?>