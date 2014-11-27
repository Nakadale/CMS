<?php
$objConnect = mysqli_connect("localhost","root","P@ssw0rd","cms3") or die(mysql_error());
$objDB = mysqli_select_db($objConnect,"cms3");
?>