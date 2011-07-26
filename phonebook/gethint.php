<?php session_start(); ?>
<?php
$s=$_GET['s'];
require_once("connection.php");
$sql=mysql_query("SELECT name from contacts where username='$_SESSION[uname]'",$con);
$hint="Suggestions:";
if(mysql_num_rows($sql)!=0)
{
    while($row=mysql_fetch_array($sql))
    {
        if(strstr($row['name'],$s)!=false)$hint.=$row['name'].',';
    }
}
$sql=mysql_query("SELECT phonenumber_landline,phonenumber_cell from contacts where username='$_SESSION[uname]'",$con);
if(mysql_num_rows($sql)!=0)
{
    while($row=mysql_fetch_array($sql))
    {
        if(strstr($row['phonenumber_landline'],$s)!=false)$hint.=$row['phonenumber_landline'].',';
        if(strstr($row['phonenumber_cell'],$s)!=false)$hint.=$row['phonenumber_cell'].',';
    }
}
if($hint=="Suggestions:")$hint.="no matches";
$response=$hint;
echo $response;
mysql_close($con);
?>
