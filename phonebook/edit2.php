<?php session_Start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != ''))
{
    header ("Location: login.php");
}
?>
<html>
<head>
<h1>EDIT CONTACT</h1>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript">
function validate()
{
	var x=document.forms["edit"]["cname"].value;
	var y=document.forms["edit"]["pnol"].value;
	var z=document.forms["edit"]["pnoc"].value;
	var w=document.forms["edit"]["emailID"].value;
	var pat=new RegExp("[^0-9+]");
	var pat2=new RegExp("[^0-9]");
	if(x==null || x=="")
	{
		alert("Please fill in username");
		return false;
	}	
	else if(pat.test(y)==true)
	{
		alert("Phonenumber(landline) should have only numbers(+ can be the first character alone) ");
		return false;
	}	
	else if(pat.test(z)==true)
	{
		alert("Phonenumber(cell) should have only numbers(+ can be the first character alone) ");
		return false;
	}
	else if(pat2.test(y.substring(1))==true || pat2.test(z.substring(1))==true)
	{
		alert("Phonenumbers can have have + only as first character");
		return false;
	}
	else if(w!=null && w!="")
	{
		if(w.indexOf("@")==-1 || w.indexOf(".")==-1 || w.indexOf("@")==0 || w.indexOf(".")==0)
		{
			alert("invalid email ID");
			return false;
		}
	}
}
</script>
<?php
require_once("connection.php");
if($_SESSION['disp']=='0')
{
	$_SESSION[cname]=$_GET['cname'];
	$_SESSION[disp]='1';
}
$row=mysql_fetch_array(mysql_query("SELECT * FROM contacts where name='$_SESSION[cname]' AND username='$_SESSION[uname]'")); 
if($_POST[cname]!=null || $_POST[cname]!="")
{
	
	$result=mysql_query("SELECT * FROM contacts where name='$_POST[cname]' AND username='$_SESSION[uname]' AND name<>'$row[name]'",$con);
	if(mysql_num_rows($result)==0)
	{
		mysql_query("UPDATE contacts SET name='$_POST[cname]',phonenumber_landline='$_POST[pnol]',phonenumber_cell='$_POST[pnoc]',emailID='$_POST[emailID]',day='$_POST[day]',month='$_POST[month]',year='$_POST[year]',date_of_entry=now() where name='$_SESSION[cname]' AND username='$_SESSION[uname]'");
		echo "<p>"."contact details have been changed"."</p>";
		if($_POST[cname]!='$_SESSION[cname]')$_SESSION[cname]=$_POST['cname'];
	}
	else echo "<p>"."new contact name exists,please change it"."</p>";
	echo "<br />";  
}
mysql_close($con);
?>
</head>
<body>
<?php
$con = mysql_connect("localhost", "root", "Maddy#93");
if (!$con)
{
  die('Could not connect: ' . mysql_error());
}
mysql_select_db("phonebook",$con);
$row=mysql_fetch_array(mysql_query("SELECT * FROM contacts where name='$_SESSION[cname]' AND username='$_SESSION[uname]'")); 
mysql_close($con);
?>
Enter new contact details:
<form name="edit" action="edit2.php" onsubmit="return validate()" method="post">
<table id="form">
<tr>
<td>Enter contact new name</td><td>:<input type="text" name="cname" value="<?php echo $row['name'] ?>" /></td>
</tr>
<tr>
<td>Enter landline number</td><td>:<input type="text" name="pnol" value="<?php echo $row['phonenumber_landline'] ?>" /></td>
</tr>
<tr>
<td>Enter cell number</td><td>:<input type="text" name="pnoc" value="<?php echo $row['phonenumber_cell'] ?>" /></td>
</tr>
<tr>
<td>Enter emailID</td><td>:<input type="text" name="emailID" value="<?php echo $row['emailID'] ?>" /></td>
</tr>
    <tr>
    <td>Edit date of birth</td><td>:
    <select name="day">
        <option value="<?php echo $row['day'] ?>"><?php echo $row['day'] ?></option>">
        <option value="01">01</option>
        <option value="02">02</option>
        <option value="03">03</option>
        <option value="04">04</option>
        <option value="05">05</option>
        <option value="06">06</option>
        <option value="07">07</option>
        <option value="08">08</option>
        <option value="09">09</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>
        <option value="23">23</option>
        <option value="24">24</option>
        <option value="25">25</option>
        <option value="26">26</option>
        <option value="27">27</option>
        <option value="28">28</option>
        <option value="29">29</option>
        <option value="30">30</option>
        <option value="31">31</option>
    </select>
    <select name="month">
        <option value="<?php echo $row['month'] ?>"><?php echo $row['month'] ?></option>">
        <option value="01">Jan</option>
        <option value="02">feb</option>
        <option value="03">Mar</option>
        <option value="04">Apr</option>
        <option value="05">May</option>
        <option value="06">Jun</option>
        <option value="07">Jul</option>
        <option value="08">Aug</option>
        <option value="09">Sept</option>
        <option value="10">Oct</option>
        <option value="11">Nov</option>
        <option value="12">Dec</option>
    </select>
    <input type="text" name="year" size="4" maxlength="4" value="<?php echo $row['year'] ?>"/>
        </td>
        </tr>
</table>
<input type="submit" value="edit" id="button" />
</form>
<div>
<?php
if($_SESSION[uname]!='Pragyan')echo '<a href="welcome.php">'."go back to home".'</a>';
else echo '<a href="pwelcome.php">'."go back to home".'</a>';
?>
</div>
</body>
</html>