<!DOCTYPE html>
<!-- saved from url=(0041)http://localhost/namria2014/download.aspx -->
<html>
<head>
<?php include 'articles/filesneeded.php' ?>
<body id="bodytest">
</body>
<table style="width:752px;border:solid #FFFFFF 2px;">
<?php
include 'articles/dbconnect.php';

// turn off any error messages in the page
error_reporting(0);


//this is to get the files uploaded under the category Job Opportunities(5) or Annual Reports(11)
$strSQL1 = "SELECT file_title,If(((cat_id = 11) or (cat_id = 5)),url_download,''	) as Maps, cat_dir
FROM `b96e8_jdownloads_files` as files
left outer join `b96e8_jdownloads_categories` as categories on files.cat_id = categories.id
where cat_id not in (7,8,4,0,12,10,9)
order by date_added DESC";

//this is to get the files uploaded under the category Info Mapper(10) or Other Maps(9)
$strSQL = "SELECT file_title,If(((cat_id = 11) OR (cat_id = 9)),url_download,'') as Publications, cat_dir
FROM `b96e8_jdownloads_files` as files
left outer join `b96e8_jdownloads_categories` as categories on files.cat_id = categories.id
where cat_id not in (7,8,4,11,5,12,0)
order by date_added DESC";

//this is to get the files uploaded under the category Others(10)
$strSQL2 = "select file_title,If(cat_id = 12,url_download,'') as Others
FROM `b96e8_jdownloads_files` as files
where cat_id not in (7,8,4,0,10,11,5,9)
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
			$num1 = mysqli_num_rows($objQuery);
			$num2 = mysqli_num_rows($objQuery1);
			$num3 = mysqli_num_rows($objQuery2);
			$tableloop =0;
			$count =0; 
			$Directory = array(,);
			$File_name = array();
			$File_title = array();
			$Directory1 = array();
			$File_name1 = array();
			$File_title1 = array();
			$Directory2 = array();
			$File_name2 = array();
			$File_title2 = array();
			
			
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
			
				while($objResult = mysqli_fetch_array($objQuery))
					{
						array_push($Directory, $objResult['cat_dir'],$objResult['Publications'], $objResult['file_title']); 
					}

				while($objResult1 = mysqli_fetch_array($objQuery1))
					{
						array_push($Directory1, $objResult1['cat_dir'],$objResult['Maps'], $objResult1['file_title']); 
					}
					
				while($objResult2 = mysqli_fetch_array($objQuery2))
					{
						array_push($Directory2, $objResult2['cat_dir'],$objResult2['Others'], $objResult2['file_title']); 
					}
								
					
					echo $Directory[1];
					
				while ($count != $tableloop )
					{
					echo "<tr><td class='Othertd' style='width:33.3%'>";
					echo "<a href='/cms2/jdownloads/". $Directory[$count][0] ."/" . $File_name[$count] . "'>" . $File_title[$count] . "</a>";
					echo "</td>";	
					echo "<td class='Othertd' style='width:33.3%'>";					
					echo "<a href='/cms2/jdownloads/". $Directory1[$count] ."/" . $File_name1[$count] . "'>" . $File_title1[$count] . "</a>";
					echo "</td>";	
					echo "<td class='Othertd' style='width:33.3%'>";					
					echo "<a href='/cms2/jdownloads/". $Directory2[$count] ."/" . $File_name2[$count] . "'>" . $File_title2[$count] . "</a>";	
					echo "</td></tr>";	
					$count++;					
					
					}

			
//closes the database connection			
mysqli_close($objConnect);
?>			
</table>
</head>
</html>
