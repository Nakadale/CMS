<?php
		//db connection. will need to be placed outside this code so that it will not be exploited.
		include 'dbconnect.php';

		// turn off any error messages in the page
		error_reporting(0);

		$id = $_GET["id"];	
			
		//sql query to get specific data from the database
		$strSQL = "SELECT DATE_FORMAT(publish_up,'%e %M %Y') as date_added, user.name,`b96e8_content`.* 
		FROM `b96e8_content`
		LEFT OUTER JOIN `b96e8_users` AS user ON `b96e8_content`.created_by = user.id
		WHERE asset_id = '$id' and state = 1 and catid <> 10 order by publish_up";
		
		$objQuery = mysqli_query($objConnect,$strSQL) or die ("Error Query [".$strSQL."]");
		?>

		<!--will show the article title and the full content of the article -->
		<?php
		while($objResult = mysqli_fetch_array($objQuery))
		{
		?>
		<br>
			<h2><?php echo $objResult["name"];?> | <?php echo $objResult["date_added"];?> </h2>
			<br>
			<h3> <?php echo $objResult["title"];?> </h3>

			<div align="center">
			<?php echo $objResult["introtext"];?>
			<?php echo $objResult["fulltext"];?>
			</div>
		<p>
		<?php
		}
		?>
		<?php
		mysql_close($objConnect);
		?>
		
		<table width="100%">
			<tr>
				<td style="text-align:left;">
					<?php
					if (($id-1) >= 0)
					{
						//db connection. will need to be placed outside this code so that it will not be exploited.
						include 'dbconnect.php';

						// turn off any error messages in the page
						error_reporting(0);

						$strSQL = "SELECT DATE_FORMAT(publish_up,'%e %M %Y') as date_added,asset_id, title,alias,introtext FROM `b96e8_content` WHERE state = 1 and catid <> 10 and asset_id = ". ($id-1) ." order by publish_up LIMIT 1";
						
						$objQuery = mysqli_query($objConnect,$strSQL) or die ("Error Query [".$strSQL."]");
						
						$RowCount = mysqli_num_rows($objQuery);

						if ($RowCount <> 0)
						{
							while($objResult = mysqli_fetch_array($objQuery))
							{    
							?>
							<a href="/cms/list.php?id=<?php echo $objResult["asset_id"];?>&alias=<?php echo $objResult["alias"];?>&Archive=1">
							&lt;Previous</a>
							<?php
							}
						mysql_close($objConnect);
						}
					}
					else					
					?>
				</td> 	
				<td>
					<?php
					if (($id-1) >= 0)
					{
						//db connection. will need to be placed outside this code so that it will not be exploited.
						include 'dbconnect.php';

						// turn off any error messages in the page
						error_reporting(0);

						$strSQL = "SELECT DATE_FORMAT(publish_up,'%e %M %Y') as date_added,asset_id, title,alias,introtext FROM `b96e8_content` WHERE state = 1 and catid <> 10 and asset_id = ". ($id+1) ." order by publish_up LIMIT 1";
						
						$objQuery = mysqli_query($objConnect,$strSQL) or die ("Error Query [".$strSQL."]");
						
						$RowCount = mysqli_num_rows($objQuery);

						if ($RowCount <> 0)
						{
							while($objResult = mysqli_fetch_array($objQuery))
							{    
							?>
							<a href="/cms/list.php?id=<?php echo $objResult["asset_id"];?>&alias=<?php echo $objResult["alias"];?>&Archive=1">
							Next&gt;</a>
							<?php
							}
						mysql_close($objConnect);
						}
					}
					else					
					?>
				</td>
			<tr>
		</table>
		<p>		
		