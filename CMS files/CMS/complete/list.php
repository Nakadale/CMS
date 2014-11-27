<html>
<link rel="stylesheet" href="../Css/homeStyle.css" type="text/css" >
<link rel="stylesheet" href="../Css/Demo.css" type="text/css" >
<head>
<title>Downloads</title>
</head>
<body>
<?php
$objConnect = mysqli_connect("localhost","root","P@ssw0rd","cms3") or die(mysql_error());
$objDB = mysqli_select_db($objConnect,"cms3");

// turn off any error messages in the page
error_reporting(0);

//sql query to get specific data from the database
$strSQL = "SELECT DATE_FORMAT(files.date_added,'%e %M %Y') as date_added ,files.file_title, user.name,files.url_download, category.cat_dir 
FROM `b96e8_jdownloads_files` as files 
left outer join `b96e8_jdownloads_categories` as category on files.cat_id = category.id
LEFT OUTER JOIN `b96e8_users` AS user ON files.created_id = user.id
where files.published = 1
order by files.date_added DESC LIMIT 3";
$objQuery = mysqli_query($objConnect,$strSQL) or die ("Error Query [".$strSQL."]");
?>

	<div class="rightBodyHeading" style="margin-top:50px;">DOWNLOADS</div>

		<?php
			while($objResult = mysqli_fetch_array($objQuery))
			{
			$strLink = "/cms/jdownloads/" + $objResult["cat_dir"] + "/" + $objResult["url_download"];
		?>
			<div class="downloads">        
			<div class="downloadsDate"><?php echo $objResult["name"];?> | <?php echo $objResult["date_added"];?></div>
			<div class="downloadsTitle"><a href="/cms/jdownloads/<?php echo $objResult["cat_dir"];?>/<?php echo $objResult["url_download"];?>" target="_blank">
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
