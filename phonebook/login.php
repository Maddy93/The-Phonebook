<?php
$uname="";
$pword="";
$error="";
session_start();
if(isset($_SESSION['login']))
                {
                    if($_SESSION['uname']=="Pragyan")
                    {
                        header("Location:pwelcome.php");
                        exit;
                    }
                    else
                    {
                        header("Location:welcome.php");
                        exit;
                    }
                }
if($_SERVER['REQUEST_METHOD']=='POST')
{
	$uname=$_POST['uname'];
	$pword=$_POST['password'];
	include("connection.php");
	if($db)
	{
		$password=md5($_POST['password']);
		$user="SELECT username FROM users where username='$_POST[uname]' AND password='$password'";
		$check=mysql_query($user);
		$rows=mysql_num_rows($check);
		if($rows==1)
		{
				$_SESSION['login']="1";
				$_SESSION['uname']=$uname;
				$_SESSION['cname']="";
				$_SESSION['time']=time();
				$_SESSION['disp']="0";
				if($_SESSION[uname]!='Pragyan')header("Location:welcome.php");
				else	header("Location:pwelcome.php");
		}
		else 
		{
			$error="invalid username and/or password";
		}
		mysql_close($con);
	}
	else
	{
		$error="register first";
	}
}
?>
<html>
<head>
<h1>LOGIN</h1>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript">
function validate()
{
	var x=document.forms["login"]["uname"].value;
	var y=document.forms["login"]["password"].value;
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
}
</script>
</head>
<body>
<form name="login" action="login.php" method="post" onsubmit="return validate()">
<table id="form">
<tr>
<td>Username</td><td>:<input type="text" name="uname" /></td>
</tr>
<tr>
<td>Password</td><td>:<input type="password" name="password" /></td>
</tr>
</table>
<input type="submit" value="login" id="button" /><br />
</form>
<div>
If you are not yet a user,<a href="register.php">click here to register</a>
</div>
<br />
<?php echo "<p>".$error."</p>"; ?>
</body>
</html>