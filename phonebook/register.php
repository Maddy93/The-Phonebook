<html>
<head>
<h1>REGISTER</h1>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript">
function validate()
{
	var x=document.forms["register"]["uname"].value;
	var y=document.forms["register"]["password"].value;
	var z=document.forms["register"]["password2"].value;
    if(x==null || x=="")
	{
		alert("Please fill in username");
		return false;
	}
	else if(y==null || y=="")
	{
		alert("Please fill in password");
		return false;
	}
    else if(y!=z)
    {
        alert("Passwords dont match");
        return false;
    }
}
</script>
</head>
<body>
<?php
require_once("connection.php");
if(!$db)
{
	mysql_query("CREATE DATABASE phonebook",$con);
	mysql_select_db("phonebook",$con);
	$sql="CREATE TABLE users
	(
		username	varchar(20),
		PRIMARY KEY(username),
		password	CHAR(32)
	)";
	mysql_query($sql,$con);
	$sql="CREATE TABLE contacts
	(
		name			varchar(20),
		phonenumber_landline 	varchar(15),
		phonenumber_cell	varchar(15),
		emailID			varchar(25),
		day			int,
		month			int,
		year			int,
		date_of_entry timestamp default CURRENT_TIMESTAMP,
		username	varchar(20),
		PRIMARY KEY (name,username),
		FOREIGN KEY (username) REFERENCES users(username)
	)";
	mysql_query($sql,$con);
}
if($_POST[uname]!=null || $_POST[uname]!="")
{
	mysql_select_db("phonebook",$con);	
	$result=mysql_query("SELECT username FROM users where username='$_POST[uname]'",$con);
	if(mysql_num_rows($result)==0)
	{
		$password=md5($_POST['password']);
		mysql_query("INSERT INTO users (username,password) VALUES ('$_POST[uname]','$password')");
		echo "<p>"."You have successfully registered!Login to start using."."</p>"."<br />";
	}
	else echo "<p>"."username already used, please change username"."</p>"."<br />";
}
mysql_close($con);
?>
<form name="register" action="register.php" onsubmit="return validate()" method="post">
<table id="form">
<tr>
<td>Enter Username</td><td>:<input type="text" name="uname" /></td>
</tr>
<tr>
<td>Enter Password</td><td>:<input type="password" name="password" /></td>
</tr>
<tr>
<td>Confirm Password</td><td>:<input type="password" name="password2" /></td>
</tr>
</table>
<input type="submit" value="register" id="button" />
</form>
<div>
<a href="login.php">Go back to login</a>
</div>
</body>
</html>