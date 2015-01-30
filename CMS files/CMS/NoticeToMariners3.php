<!DOCTYPE html>
<!-- saved from url=(0041)http://localhost/namria2014/download.aspx -->
<html>
<head>
<?php include 'articles/filesneeded.php' ?>
<body>
</body>
<table border="1" style="width:100%">
<?php
include 'articles/dbconnect.php';

// turn off any error messages in the page
error_reporting(0);

$strSQL = "Select Distinct YEAR(date_added) as year from b96e8_jdownloads_files as files
where cat_id = 7 and (year(CURRENT_TIMESTAMP)-year(date_added)) <= 2
order by YEAR(date_added) DESC";

$strSQL1 = "select * from month order by MonthNumber";

$strSQL3 = "Select Distinct YEAR(date_added) as year from b96e8_jdownloads_files as files
where cat_id = 7 and (year(CURRENT_TIMESTAMP)-year(date_added)) <= 2
order by YEAR(date_added) DESC";

$objQuery = mysqli_query($objConnect,$strSQL) or die ("Error Query [".$strSQL."]");
$objQuery1 = mysqli_query($objConnect,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objQuery3 = mysqli_query($objConnect,$strSQL3) or die ("Error Query [".$strSQL3."]");
?>
	<!-- create the header for the table -->
	<tr>
	<?php 
		while($objResult3 = mysqli_fetch_array($objQuery3))
		{
		echo "<th>" . $objResult3["year"] ."</th>";
	?>   
	
	<?php
	} // $objResult3
	?>			
	</tr>
	<!-- create the header for the table -->
	
	<!-- this will create the list and check if a certain month has a notice to mariners file uploaded 
	if not it will not create a link for that certain month -->
		<?php 
			while($objResult = mysqli_fetch_array($objQuery))
			{
				while($objResult1 = mysqli_fetch_array($objQuery1))
				{											

						echo "<td>"; 
						
							$strSQL2 = "Select url_download
							from `b96e8_jdownloads_files` as files 
							where cat_id = 7 and (year(CURRENT_TIMESTAMP)-year(date_added)) = 0
							and Month(date_added) = " . $objResult1["MonthNumber"] . " LIMIT 1";
							
							$objQuery2 = mysqli_query($objConnect,$strSQL2) or die ("Error Query [".$strSQL2."]");
						
							$objResult2 = mysqli_fetch_array($objQuery2);
								if ($objResult2 <> "")
								{
									echo "<a href='#'>" . $objResult1["MonthName"] . "</a>";
  
								}
								else
								{
									echo $objResult1["MonthName"];									
								}								
						
						echo "</td>";
						
						echo "<td>"; 
						
							$strSQL2 = "Select url_download
							from `b96e8_jdownloads_files` as files 
							where cat_id = 7 and (year(CURRENT_TIMESTAMP)-year(date_added)) = 1
							and Month(date_added) = " . $objResult1["MonthNumber"] . " LIMIT 1";
							
							$objQuery2 = mysqli_query($objConnect,$strSQL2) or die ("Error Query [".$strSQL2."]");
						
							$objResult2 = mysqli_fetch_array($objQuery2);
								if ($objResult2 <> "")
								{
									echo "<a href='#'>" . $objResult1["MonthName"] . "</a>";
  
								}
								else
								{
									echo $objResult1["MonthName"];									
								}								
						
						echo "</td>";
						
						echo "<td>"; 
						
							$strSQL2 = "Select url_download
							from `b96e8_jdownloads_files` as files 
							where cat_id = 7 and (year(CURRENT_TIMESTAMP)-year(date_added)) = 2
							and Month(date_added) = " . $objResult1["MonthNumber"] . " LIMIT 1";
							
							$objQuery2 = mysqli_query($objConnect,$strSQL2) or die ("Error Query [".$strSQL2."]");
						
							$objResult2 = mysqli_fetch_array($objQuery2);
								if ($objResult2 <> "")
								{
									echo "<a href='#'>" . $objResult1["MonthName"] . "</a>";
								}
								else
								{
									echo $objResult1["MonthName"];									
								}								
						
						echo "</td>";
						
						echo "</tr>";
				}
			}
		?>
<?php
mysqli_close($objConnect);
?>			
</table>
</head>
</html>
