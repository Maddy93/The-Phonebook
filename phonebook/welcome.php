<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
"http://www.w3.org/TR/html4/frameset.dtd">
<?php session_start() ;
if (!(isset($_SESSION['login']) && $_SESSION['login'] != ''))
{
    header ("Location: login.php");
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript">
function colour(s)
{
	var t="col"+s;
	document.getElementById(t).style.backgroundColor="#f0ffff";
}
</script>
<?php
$_SESSION['disp']="0";
?>
</head>
<body onload="colour('<?php echo $_GET['c']; ?>')">
<?php
switch($_GET['c']) 
{
     	case "1":
        $col = "name";
        break;
     	case "2": 
        $col = "phonenumber_landline";
        break;
     	case "3":
        $col = "phonenumber_cell";
        break;
     	case "4":
        $col = "emailID";
        break;
    case "5":
        $col = "date_of_entry";
        break;
    case "7":
        $col = "year";
        break;
     	default:
          $col = "name";
} 
if($_GET['d'] == "1") 
{
	$dir = "DESC";
}
else 
{
     	$dir = "ASC";
}
require_once("connection.php");
$check=$_POST['ckbox'];
for($i=0;$i<count($check);$i++)
{
    $del=mysql_query("select name from contacts where name='$check[$i]' and username='$_SESSION[uname]'",$con);
    if(mysql_num_rows($del)!=0)
    {
        $rem=mysql_query("delete from contacts where name='$check[$i]' and username='$_SESSION[uname]'",$con);
    }
}
echo "welcome ".$_SESSION[uname];
$time=getdate(time());
switch($time[month])
{
    case "January":$t=1;break;
    case "February":$t=2;break;
    case "March":$t=3;break;
    case "April":$t=4;break;
    case "May":$t=5;break;
    case "June":$t=6;break;
    case "July":$t=7;break;
    case "August":$t=8;break;
    case "September":$t=9;break;
    case "October":$t=10;break;
    case "November":$t=11;break;
    case "December":$t=12;break;
    default:$t=1;break;
}
$bday="select name from contacts where username='$_SESSION[uname]' AND day='$time[mday]' AND month='$t'" ;
$run=mysql_query($bday,$con);
if(mysql_num_rows($run)!=0)
{
    echo "<br />"."todays birthdays: ";
    while($row=mysql_fetch_array($run))
    {
        echo $row['name'];
    }
}
?>
<table border='1'>
<tr>
<th id="col1"><a href='welcome.php?c=1&d=<?php echo $_GET['d']=='1'?0:1 ?>' >name</a><?php echo isset($_GET['d'])?$_GET['c']=='1'?$_GET['d']=='0'?'<img src="up.png" width="10px" height="10px" />':'<img src="down.png" width="10px" height="10px" />':null:null ?></th>
<th id="col2"><a href='welcome.php?c=2&d=<?php echo $_GET['d']=='1'?0:1 ?>' >phonenumber(landline)</a><?php echo isset($_GET['d'])?$_GET['c']=='2'?$_GET['d']=='0'?'<img src="up.png" width="10px" height="10px" />':'<img src="down.png" width="10px" height="10px" />':null:null ?></th>
<th id="col3"><a href='welcome.php?c=3&d=<?php echo $_GET['d']=='1'?0:1 ?>' >phonenumber(cell)</a><?php echo isset($_GET['d'])?$_GET['c']=='3'?$_GET['d']=='0'?'<img src="up.png" width="10px" height="10px" />':'<img src="down.png" width="10px" height="10px" />':null:null ?></th>
<th id="col4"><a href='welcome.php?c=4&d=<?php echo $_GET['d']=='1'?0:1 ?>' >emailID</a><?php echo isset($_GET['d'])?$_GET['c']=='4'?$_GET['d']=='0'?'<img src="up.png" width="10px" height="10px" />':'<img src="down.png" width="10px" height="10px" />':null:null ?></th>
<th id="col5"><a href='welcome.php?c=5&d=<?php echo $_GET['d']=='1'?0:1 ?>' >last update on</a><?php echo isset($_GET['d'])?$_GET['c']=='5'?$_GET['d']=='0'?'<img src="up.png" width="10px" height="10px" />':'<img src="down.png" width="10px" height="10px" />':null:null ?></th>
<th id="col7"><a href='welcome.php?c=7&d=<?php echo $_GET['d']=='1'?0:1 ?>' >date of birth(y-m-d)</a><?php echo isset($_GET['d'])?$_GET['c']=='7'?$_GET['d']=='0'?'<img src="up.png" width="10px" height="10px" />':'<img src="down.png" width="10px" height="10px" />':null:null ?></th>
<th></th>
<th>select to delete</th>
</tr>
<?php
mysql_select_db("phonebook",$con);
if($_GET['c']!="7")$sql="SELECT name,phonenumber_landline,phonenumber_cell,emailID,day,month,year,date_of_entry FROM contacts WHERE username='$_SESSION[uname]' ORDER BY $col $dir";
else
{
    $sql="SELECT name,phonenumber_landline,phonenumber_cell,emailID,day,month,year,date_of_entry FROM contacts WHERE username='$_SESSION[uname]' ORDER BY year $dir,month $dir,day $dir";
}
$result=mysql_query($sql,$con);
echo  '<form action="welcome.php" method="post">';
while($row=mysql_fetch_array($result))
{
	echo	"<tr>";
	echo	"<td class='col1'>".$row['name']."</td>";
	echo	"<td class='col2'>".$row['phonenumber_landline']."</td>";
	echo	"<td class='col3'>".$row['phonenumber_cell']."</td>";
	echo	"<td class='col4'>".$row['emailID']."</td>";
	echo	"<td class='col5'>".$row['date_of_entry']."</td>";
	echo	"<td class='col6'>".$row['day']."-".$row['month']."-".$row['year']."</td>";
	echo	"<td class='col7'>"."<a href='edit2.php?cname=$row[name]'>"."edit".'</a>'."</td>";
    echo    "<td class='col8'>"."<input type='checkbox' name='ckbox[]' value=$row[name]>"."</td>";
	echo	"</tr>";
}
?>
</table>
<br />
<div>
<a href="add.php">add</a>
<br />
<a href="search.php">search</a>
<br />
<a href="logout.php">logout</a>
<br />
</div>
</table>
</body>
</html>