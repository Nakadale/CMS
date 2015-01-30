<?php
				//db connection. will need to be placed outside this code so that it will not be exploited.
				include 'articles/dbconnect.php';
				
				// turn off any error messages in the page
				error_reporting(0);	
					
				//sql query to get specific data from the database
				$strSQL = "SELECT distinct DATE_FORMAT(publish_up,'%M %Y') as date_added, Month(publish_up) as Month, year(publish_up) as Year FROM `b96e8_content` WHERE state = 1 and catid <> 10 order by publish_up";
				$objQuery = mysqli_query($objConnect,$strSQL) or die ("Error Query [".$strSQL."]");
				?>

				<!--will show the article title and the full content of the article -->
				<?php
				while($objResult = mysqli_fetch_array($objQuery))
				{
				?>
					<ul class="navi">
						<a href="/list.php?Month=<?php echo $objResult["Month"];?>&Year=<?php echo $objResult["Year"];?>&Archive=0">
							<li class="menuSub">
						<?php echo $objResult["date_added"]; ?>
							</li>
						</a>					
					</ul>	
				<?php				
				}
				?>
				<?php
				mysql_close($objConnect);
				?>