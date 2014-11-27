<!DOCTYPE html>
<html>
<head>
<?php 
//will load all files needed like css and javascript.
include 'articles/filesneeded.php' 
?>
<body id="bodytest">
</body>
<table style="width:752px;border:solid #FFFFFF 2px;">
<?php
//database connection
include 'articles/dbconnect.php';

// turn off any error messages in the page
error_reporting(0);

//this is to get the files uploaded under the category Job Opportunities(5) or Annual Reports(11)
$strSQL1 = "SELECT file_title,If(((cat_id = 11) or (cat_id = 5)),url_download,''	) as Maps, cat_dir
FROM `b96e8_jdownloads_files` as files
left outer join `b96e8_jdownloads_categories` as categories on files.cat_id = categories.id
where cat_id not in (7,8,4,0,12,10,9) and files.published = 1
order by date_added DESC";

//this is to get the files uploaded under the category Info Mapper(10) or Other Maps(9)
$strSQL = "SELECT file_title,If(((cat_id = 10) OR (cat_id = 9)),url_download,'') as Publications, cat_dir
FROM `b96e8_jdownloads_files` as files
left outer join `b96e8_jdownloads_categories` as categories on files.cat_id = categories.id
where cat_id not in (7,8,4,11,5,12,0) and files.published = 1
order by date_added DESC";

//this is to get the files uploaded under the category Others(10)
$strSQL2 = "select file_title,If(cat_id = 12,url_download,'') as Others
FROM `b96e8_jdownloads_files` as files
where cat_id not in (7,8,4,0,10,11,5,9) and files.published = 1
order by date_added DESC";

//these will run the queries to the correct database
$objQuery = mysqli_query($objConnect,$strSQL) or die ("Error Query [".$strSQL."]");
$objQuery1 = mysqli_query($objConnect,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objQuery2 = mysqli_query($objConnect,$strSQL2) or die ("Error Query [".$strSQ2."]");
?>
	<!-- create the header for the table -->
	<tr class="OtherTr">
	<?php 
		echo "<th class='OtherTH' style='width:33.3%'> Maps and Charts </th>";
		echo "<th class='OtherTH' style='width:33.3%'> Publications </th>";
		echo "<th class='OtherTH' style='width:33.3%'> Others </th>";
		?>   	
	</tr>
	<!-- create the header for the table -->
	
		<?php 
			//gets how many records are returned in the result
			$num1 = mysqli_num_rows($objQuery);
			$num2 = mysqli_num_rows($objQuery1);
			$num3 = mysqli_num_rows($objQuery2);
				
			//initialization for counter and temp variable
			$tableloop =0;
			$count =0; 
			
			//arrays to be used to store data taken from the database
			$Directory1 = array();
			$File_name1 = array();
			$File_title1 = array();
			$Directory2 = array();
			$File_name2 = array();
			$File_title2 = array();
			$Directory3 = array();
			$File_name3 = array();
			$File_title3 = array();
			
			
			//this is to get which of the 3 has the highest record count. 
			if ($num1 <= $num2)
			{
			$tableloop = $num2;
			}
			else
			{
			$tableloop = $num1;			
			}
			
			if ($tableloop < $num3)
			{
			$tableloop = $num3;
			}

			//this will put all data taken from the database into the arrays		
				while($objResult = mysqli_fetch_array($objQuery))
					{
						array_push($Directory1, $objResult['cat_dir']); 
						array_push($File_name1, $objResult['Publications']); 
						array_push($File_title1, $objResult['file_title']); 
					}

				while($objResult1 = mysqli_fetch_array($objQuery1))
					{
						array_push($Directory2, $objResult1['cat_dir']); 
						array_push($File_name2, $objResult1['Maps']); 
						array_push($File_title2, $objResult1['file_title']); 
					}
					
				while($objResult2 = mysqli_fetch_array($objQuery2))
					{
						array_push($Directory3, $objResult2['cat_dir']); 
						array_push($File_name3, $objResult2['Others']); 
						array_push($File_title3, $objResult2['file_title']); 
					}

			//this will populate the table and create the links of the files
				while ($count != $tableloop )
					{
					echo "<tr><td class='Othertd' style='width:33.3%'>";
					echo "<a href='/cms/jdownloads/". $Directory1[$count] ."/" . $File_name1[$count] . "'>" . $File_title1[$count] . "</a>";
					echo "</td>";	
					echo "<td class='Othertd' style='width:33.3%'>";					
					echo "<a href='/cms/jdownloads/". $Directory2[$count] ."/" . $File_name2[$count] . "'>" . $File_title2[$count] . "</a>";
					echo "</td>";	
					echo "<td class='Othertd' style='width:33.3%'>";					
					echo "<a href='/cms/jdownloads/". $Directory3[$count] ."/" . $File_name3[$count] . "'>" . $File_title3[$count] . "</a>";	
					echo "</td></tr>";	
					$count++;										
					}

//closes the database connection			
mysqli_close($objConnect);
?>			
</table>
</head>
</html>
