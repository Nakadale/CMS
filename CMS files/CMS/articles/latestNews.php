				<?php
				//db connection. will need to be placed outside this code so that it will not be exploited.
				include 'articles/dbconnect.php';
				$counter = 3;

				// turn off any error messages in the page
				error_reporting(0);
					
				//sql query to get specific data from the database
				$strSQL = "SELECT * FROM `b96e8_content` WHERE state = 1 and catid <> 10 order by publish_up LIMIT 5";
				$objQuery = mysqli_query($objConnect,$strSQL) or die ("Error Query [".$strSQL."]");
				?>

				<!--will show the article title and the full content of the article -->
				<?php
				while($objResult = mysqli_fetch_array($objQuery))
				{
				?>
					<ul class="navi">
						<a href="/cms/list.php?id=<?php echo $objResult["asset_id"];?>&alias=<?php echo $objResult["alias"];?>&Archive=1">	
					<li class="menuSub">
								<?php echo $objResult["title"]; ?>
					</li>
						</a>
					</ul>
						
				<?php
				$counter = $counter + 1;
				}
				?>
				<?php
				mysql_close($objConnect);
				?>