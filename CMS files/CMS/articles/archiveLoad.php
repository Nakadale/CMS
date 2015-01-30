<?php
include 'articles/dbconnect.php';

//get month and year
if ((is_null($_GET["Month"]) == FALSE) and (is_null($_GET["Year"]) == FALSE))
{
$Month = $_GET["Month"];
$Year = $_GET["Year"];
// turn off any error messages in the page
error_reporting(0);

//sql query to get specific data from the database
$strSQL = "SELECT DATE_FORMAT(publish_up,'%e %M %Y') as date_added,user.name,DATE_FORMAT(publish_up,'%m %Y') as date_publish, asset_id, title,alias,introtext 
FROM `b96e8_content` 
LEFT OUTER JOIN `b96e8_users` AS user ON `b96e8_content`.created_by = user.id
WHERE state = 1 and catid <> 10 and MONTH(publish_up) = $Month and YEAR(publish_up) = $Year order by publish_up DESC";

$objQuery = mysqli_query($objConnect,$strSQL) or die ("Error Query [".$strSQL."]");
?>
		<?php
			while($objResult = mysqli_fetch_array($objQuery))
			{
		?>   
		
			<div class="newsDate"> <?php echo $objResult["name"];?> | <?php echo $objResult["date_added"];?></div><br>
			<div class="newsTitle">
			<a href="/cms/list.php?id=<?php echo $objResult["asset_id"];?>&alias=<?php echo $objResult["alias"];?>&Archive=1" target="_new" 
			style="font-size:26px">
			<?php echo $objResult["title"];?></a></div>
			<div class="newsBody">
			<?php echo substr($objResult["introtext"],0,200) . " ..";?></div>
			<div class="readme">
			<a href="/cms/list.php?id=<?php echo $objResult["asset_id"];?>&alias=<?php echo $objResult["alias"];?>&Archive=1" target="_new">Read more</a>
			</div>
		<?php
		}
		?>
	

<?php
mysql_close($objConnect);
}
?>
<p>