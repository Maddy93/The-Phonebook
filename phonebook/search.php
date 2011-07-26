<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
"http://www.w3.org/TR/html4/frameset.dtd">
<?php session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != ''))
{
    header ("Location: login.php");
}
?>
<html>
<head>
<h1>SEARCH</h1>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript">
function showHint(str)
{
var xmlhttp;
if (str.length==0)
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","gethint.php?s="+str,true);
xmlhttp.send();
}
function colour(s)
{
	var t="col"+s;
	document.getElementById(t).style.backgroundColor="#f0ffff";
}
</script>
</head>
<body onload="colour('<?php echo $_GET['c']; ?>')">
<table border='1'>
<tr>
<th id="col1"><a href='search.php?c=1&d=<?php echo $_GET['d']=='1'?0:1 ?>' >name</a><?php echo isset($_GET['d'])?$_GET['c']=='1'?$_GET['d']=='0'?'<img src="up.png" width="10px" height="10px" />':'<img src="down.png" width="10px" height="10px" />':null:null ?></th>
<th id="col2"><a href='search.php?c=2&d=<?php echo $_GET['d']=='1'?0:1 ?>' >phonenumber(landline)</a><?php echo isset($_GET['d'])?$_GET['c']=='2'?$_GET['d']=='0'?'<img src="up.png" width="10px" height="10px" />':'<img src="down.png" width="10px" height="10px" />':null:null ?></th>
<th id="col3"><a href='search.php?c=3&d=<?php echo $_GET['d']=='1'?0:1 ?>' >phonenumber(cell)</a><?php echo isset($_GET['d'])?$_GET['c']=='3'?$_GET['d']=='0'?'<img src="up.png" width="10px" height="10px" />':'<img src="down.png" width="10px" height="10px" />':null:null ?></th>
<th id="col4"><a href='search.php?c=4&d=<?php echo $_GET['d']=='1'?0:1 ?>' >emailID</a><?php echo isset($_GET['d'])?$_GET['c']=='4'?$_GET['d']=='0'?'<img src="up.png" width="10px" height="10px" />':'<img src="down.png" width="10px" height="10px" />':null:null ?></th>
<th id="col5"><a href='search.php?c=5&d=<?php echo $_GET['d']=='1'?0:1 ?>' >last update on</a><?php echo isset($_GET['d'])?$_GET['c']=='5'?$_GET['d']=='0'?'<img src="up.png" width="10px" height="10px" />':'<img src="down.png" width="10px" height="10px" />':null:null ?></th>
<th id="col7"><a href='search.php?c=7&d=<?php echo $_GET['d']=='1'?0:1 ?>' >date of birth(y-m-d)</a><?php echo isset($_GET['d'])?$_GET['c']=='7'?$_GET['d']=='0'?'<img src="up.png" width="10px" height="10px" />':'<img src="down.png" width="10px" height="10px" />':null:null ?></th>
</tr>
<?php
require_once("connection.php");
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
if($_POST[cname]!=null || $_POST[cname]!="" || $_SESSION[disp]=="1")
{
	if($_POST['cname']!=null && $_POST['cname']!="" && $_POST['cname']!=$_SESSION['cname'])$_SESSION['cname']=$_POST['cname'];
	if(ord($_SESSION['cname'])>=48 && ord($_SESSION['cname'])<=57 || ord($_SESSION['cname'])==43)
	{
		if($_GET['c']!="7")$result=mysql_query("SELECT * FROM contacts where username='$_SESSION[uname]' AND (phonenumber_landline LIKE '%$_SESSION[cname]%' OR phonenumber_cell LIKE '%$_SESSION[cname]%') ORDER BY $col $dir",$con);
        else
        {
            $result=mysql_query("SELECT * FROM contacts where username='$_SESSION[uname]' AND (phonenumber_landline LIKE '%$_SESSION[cname]%' OR phonenumber_cell LIKE '%$_SESSION[cname]%') ORDER BY year $dir,month $dir,day $dir",$con);
        }
        if(!mysql_num_rows($result))
		{
			echo "<p>"."No contacts found"."</p>"."<br />";
		}
		else
		{
			$_SESSION['disp']="1";
			if($_GET['d']=="1" || $_GET['d']=="0" || $_SESSION['disp']=="1")
			{
				while($row=mysql_fetch_array($result))
				{
					echo	"<tr>";
					echo	"<td>".$row['name']."</td>";
					echo	"<td>".$row['phonenumber_landline']."</td>";
					echo	"<td>".$row['phonenumber_cell']."</td>";
					echo	"<td>".$row['emailID']."</td>";
					echo	"<td>".$row['date_of_entry']."</td>";
                    echo	"<td>".$row['day']."-".$row['month']."-".$row['year']."</td>";
					echo	"</tr>";
				}		
			}
		}
	}
	else 
	{
		if($_POST[cname]!=null && $_POST[cname]!="" && $_POST[cname]!=$_SESSION[cname])$_SESSION['cname']=$_POST['cname'];
		if($_GET['c']!="7")$result=mysql_query("SELECT * FROM contacts where username='$_SESSION[uname]' AND name LIKE '%$_SESSION[cname]%' ORDER BY $col $dir",$con);
		else
        {
            $result=mysql_query("SELECT * FROM contacts where username='$_SESSION[uname]' AND (phonenumber_landline LIKE '%$_SESSION[cname]%' OR phonenumber_cell LIKE '%$_SESSION[cname]%') ORDER BY year $dir,month $dir,day $dir",$con);
        }
		if(!mysql_num_rows($result))
		{
			echo "<p>"."No contacts found"."</p>"."<br />";
		}

		else 
		{
			$_SESSION['disp']="1";
			if($_GET['d']=="1" || $_GET['d']=="0" || $_SESSION['disp']=="1")
			{
				while($row=mysql_fetch_array($result))
				{
					echo	"<tr>";
					echo	"<td>".$row['name']."</td>";
					echo	"<td>".$row['phonenumber_landline']."</td>";
					echo	"<td>".$row['phonenumber_cell']."</td>";
					echo	"<td>".$row['emailID']."</td>";
					echo	"<td>".$row['date_of_entry']."</td>";
                    echo	"<td>".$row['day']."-".$row['month']."-".$row['year']."</td>";
					echo	"</tr>";
				}		
			}
		}
	}
}
mysql_close($con);
?>
</table>
<br />
<form action="search.php" method="post">
<table id="form">
<tr>
<td>Enter name or phonenumber(or part of either) of contact</td>
<td>:<input type="text" name="cname" onkeyup="showHint(this.value)"/></td>
</tr>
</table>
<input type="submit" value="search" id="button" />
</form>
<p> <span id="txtHint"></span></p>
<br />
<div>
<?php
if($_SESSION[uname]!='Pragyan')echo '<a href="welcome.php">'."go back to home".'</a>';
else echo '<a href="pwelcome.php">'."go back to home".'</a>';
?>
</div>
</body>
</html>