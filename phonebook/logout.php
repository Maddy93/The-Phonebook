<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != ''))
{
    header ("Location: login.php");
}
session_destroy();
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<br />
<div>
User has logged out<br />
<a href="login.php">Click here to login again</a>
</div>
</body>
</html>