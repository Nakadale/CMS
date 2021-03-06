<html>
<?php include 'filesneeded.php' ?>
<head>
<title>Articles</title>
</head>
<body>
<?php
include '/dbconnect.php';
//sql query to get specific data from the database
$strSQL = "SELECT DATE_FORMAT(publish_up,'%e %M %Y') as date_added,asset_id,user.name, title,alias,introtext 
FROM `b96e8_content` 
LEFT OUTER JOIN `b96e8_users` AS user ON `b96e8_content`.created_by = user.id
WHERE state = 1 and catid <> 10 order by publish_up DESC LIMIT 3";

$objQuery = mysqli_query($objConnect,$strSQL) or die ("Error Query [".$strSQL."]");
?>

	<div class="rightBodyHeading">NEWS and EVENTS</div>
		<?php
			while($objResult = mysqli_fetch_array($objQuery))
			{
		?>      
			<div class="newsDate"><?php echo $objResult["name"];?> | <?php echo $objResult["date_added"];?></div>
			<div class="newsTitle">
			<a href="/list.php?id=<?php echo $objResult["asset_id"];?>&alias=<?php echo $objResult["alias"];?>&Archive=1" target="_new">
			<?php echo $objResult["title"];?></a></div>
			<div class="newsBody">
			<?php echo substr($objResult["introtext"],0,200) . " ..";?></div>
			<div class="readme">
			<a href="/list.php?id=<?php echo $objResult["asset_id"];?>&alias=<?php echo $objResult["alias"];?>&Archive=1" target="_new">Read more</a>
		<?php
		}
		?>
	

	</div>
<?php
mysqli_close($objConnect);
?>
</body>
</html>
