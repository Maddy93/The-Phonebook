<?php

$con=mysql_connect("localhost","root","Maddy#93");
if(!$con)
{
	die('could not connect:'.mysql_error());
}
$db=mysql_select_db("phonebook",$con);
?>