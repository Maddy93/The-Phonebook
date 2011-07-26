<?php session_start() ;
if (!(isset($_SESSION['login']) && $_SESSION['login'] != ''))
{
    header ("Location: login.php");
}
if($_SESSION[uname]!="Pragyan")
{
    header ("Location: welcome.php");
}
?>
<html>
<head>
<h1>ADD TO EVERYONES CONTACTS</h1>
<link rel="stylesheet" type="text/css" href="style.css" />
<?php
require_once("connection.php");
if($_POST[cname]!=null || $_POST[cname]!="")
{
	$result=mysql_query("SELECT * from users",$con);
	while($row=mysql_fetch_array($result))
	{
        $dob=$_POST['year'] . '-' . $_POST['month'] . '-' . $_POST['day'];
        $sql="INSERT INTO contacts (name,phonenumber_landline,phonenumber_cell,emailId,day,month,year,date_of_entry,username) VALUES ('$_POST[cname]','$_POST[pnol]','$_POST[pnoc]','$_POST[emailID]','$_POST[day]','$_POST[month]','$_POST[year]',now(),'$row[username]')";
		if(!mysql_query($sql,$con))
		{
			echo "unable to add to user ".$row[username]." as same contact name already exists"."<br />";
		}
	}
}
?>
</head>
<body>
<form name="addc" action="addall.php" method="post">
<table id="form">
<tr>
<td>Enter contact name</td><td>:<input type="text" name="cname" /></td>
</tr>
<tr>
<td>Enter landline number</td><td>:<input type="text" name="pnol" /></td>
</tr>
<tr>
<td>Enter cell number</td><td>:<input type="text" name="pnoc" /></td>
</tr>
<tr>
<td>Enter emailID</td><td>:<input type="text" name="emailID" /></td>
</tr>
    <tr>
    <td>Enter date of birth</td><td>:
    <select name="day">
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
    <input type="text" name="year" size="4" maxlength="4" value="1000"/>
        </td>
        </tr>
</table>
<input type="submit" value="add to all" id="button" />
</form>
<div>
<a href="pwelcome.php">go back to home</a>
</div>
</body>
</html>
