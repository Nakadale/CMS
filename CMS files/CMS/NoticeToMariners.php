<!DOCTYPE html>
<!-- saved from url=(0041)http://localhost/namria2014/download.aspx -->
<html>
<head>
<?php include 'articles/filesneeded.php' ?>
<body id="bodytest">
</body>
<table style="width:100%;border:solid #FFFFFF 2px;">
<?php
include 'articles/dbconnect.php';

// turn off any error messages in the page
error_reporting(0);


//this is the sql query to get the 3 years starting from the current year till the 2 previous years sample. 2014, 2013, 2012
$strSQL = "Select Distinct YEAR(date_added) as year from b96e8_jdownloads_files as files
where cat_id = 7 and (year(CURRENT_TIMESTAMP)-year(date_added)) <= 2
order by YEAR(date_added) DESC LIMIT 3";

//this is the sql query to get all the months number and month names
$strSQL1 = "select * from month order by MonthNumber";

//these will run the queries to the correct database
$objQuery1 = mysqli_query($objConnect,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objQuery3 = mysqli_query($objConnect,$strSQL) or die ("Error Query [".$strSQL."]");
?>
	<!-- create the header for the table -->
	<tr class="NoticeTr">
	<?php 
		while($objResult3 = mysqli_fetch_array($objQuery3))
		{
		echo "<th class='Noticeth'>" . $objResult3["year"] ."</th>";
	?>   
	
	<?php
	} // $objResult3
	?>			
	</tr>
	<!-- create the header for the table -->
	
	<!-- this will create the list and check if a certain month has a notice to mariners file uploaded 
	if not it will not create a link for that certain month -->
		<?php 
			// while loop is for the months
			while($objResult1 = mysqli_fetch_array($objQuery1))
			{
				//these will run the queries to the correct database
				$objQuery = mysqli_query($objConnect,$strSQL) or die ("Error Query [".$strSQL."]");
				echo  "<tr>";
				// while loop is for the years
				while($objResult = mysqli_fetch_array($objQuery))
				{
					// this query will check if there is an uploaded file with the category "Notice to Mariners"\
					// Cat_ID for Notice to Mariners is 7
					// if there is no file uploaded in the database, this query will return a NULL value.
					// the LIMIT command at the end of the query is to tell SQL server if it found 1 data it will automatically end the script and return the result thereby resulting in a faster query.
					$strSQL2 = "Select MONTH(date_added) as Month, YEAR(date_added) as Year, files.* from `b96e8_jdownloads_files` as files where cat_id = 7 and year(date_added) = " . $objResult["year"] ." 
					and Month(date_added) = " . $objResult1["MonthNumber"] . " and published = 1
					order by MONTH(date_added),year(date_added) DESC LIMIT 1";
					
					//these will run the queries to the correct database
					$objQuery2 = mysqli_query($objConnect,$strSQL2) or die ("Error Query [".$strSQL2."]");
				
					//this will get the result of the query
					$objResult2 = mysqli_fetch_array($objQuery2);
						//it will check if the month from $strSQL2 result is equal to the month number in $strSQL result
						if ($objResult1["MonthNumber"] == $objResult2["Month"])
						{
							echo "<td class='Noticetd'><a href='/cms/jdownloads/Notice To Mariners/" . $objResult2["url_download"] . "'>" . $objResult1["MonthName"] . "</a></td>";
						}
						else
						{
							echo "<td class='Noticetd'>" . $objResult1["MonthName"] ."</td>";					
						}
				} // while($objResult = mysqli_fetch_array($objQuery))
					echo "</tr>";
			} // while($objResult = mysqli_fetch_array($objQuery))

//closes the database connection			
mysqli_close($objConnect);
?>			
</table>
</head>
</html>
