<html>
<link rel="stylesheet" href="homeStyle.css" type="text/css" >
<link rel="stylesheet" href="Demo.css" type="text/css" >
<head>
<title>Customer Information System</title>
</head>
<body>
<?php
$objConnect = mysqli_connect("localhost","root","","cms2") or die(mysql_error());
$objDB = mysqli_select_db($objConnect,"cms2");

// turn off any error messages in the page
error_reporting(0);

//sql query to get specific data from the database
$strSQL = "SELECT DATE_FORMAT(files.date_added,'%e %M %Y') as date_added ,files.file_title, files.url_download, category.cat_dir FROM `b96e8_jdownloads_files` as files left outer join `b96e8_jdownloads_categories` as category on files.cat_id = category.id";
$objQuery = mysqli_query($objConnect,$strSQL) or die ("Error Query [".$strSQL."]");
?>

	<div class="rightBodyHeading" style="margin-top:50px;">DOWNLOADS</div>

		<?php
			while($objResult = mysqli_fetch_array($objQuery))
			{
			$strLink = "/cms2/jdownloads/" + $objResult["cat_dir"] + "/" + $objResult["url_download"];
		?>
			<div class="downloads">        
			<div class="downloadsDate"><?php echo $objResult["date_added"];?></div>
			<div class="downloadsTitle"><a href="/cms2/jdownloads/<?php echo $objResult["cat_dir"];?>/<?php echo $objResult["url_download"];?>">
			<?php echo $objResult["file_title"];?></a></div>
			</div>
		<?php
		}
		?>
	

	
<?php
mysql_close($objConnect);
?>
</body>
</html>
