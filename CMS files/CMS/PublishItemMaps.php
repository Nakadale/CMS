<!DOCTYPE html>
<html>
<head>
<?php include 'articles/filesneeded.php' ?>

<body class="bodytest">
</body>
<table style="width:100%;border:solid #FFFFFF 2px;">

	<tr class="NoticeTr">
		<th class="OtherTH" style="width:25%"> File Name </th>
		<th class="OtherTH" style="width:25%"> Date Uploaded </th>
		<th class="OtherTH" style="width:25%"> Uploaded By </th>
		<th class="OtherTH" style="width:25%"> Publish </th>
	</tr>
<?php
include 'articles/dbconnect.php';

// turn off any error messages in the page
error_reporting(0);

//this is the query to list all the unpublished uploads in the database.
//unpublished downloads will not appear in the downloads page and landing page.
$strSQL = "SELECT files.file_id, files.file_title, files.url_download, category.cat_dir,files.date_added, 
users.name FROM `b96e8_jdownloads_files` as files
Left outer join `b96e8_jdownloads_categories` as category on files.cat_id = category.id
Left outer join `b96e8_users` as users on files.submitted_by = users.id
where files.published <> 1 AND files.cat_id = '4' order by date_added DESC";

$objQuery = mysqli_query($objConnect,$strSQL) or die ("Error Query [".$strSQL."]");
?>

	<?php //create the header for the table and start of the form and input ?>
	<form action="PublishItemMaps.php" method="GET" name="frmPublish">
	<input type="hidden" name="PublishBtn" value="">
	<input type="hidden" name="id" value="">

		<?php 
				// this while loop will list down all unpublished uploads taken from the result of the SQL query
				while($objResult = mysqli_fetch_array($objQuery))
				{
				echo  "<tr>";
				echo "<td class='Othertd'><a href='/cms2/jdownloads/". $objResult["cat_dir"] ."/" . $objResult["url_download"] . "'>" . $objResult["file_title"] . "</a></td>";
				echo "<td class='Othertd'>". $objResult["date_added"] ."</td>";
				echo "<td class='Othertd'>". $objResult["name"] ."</td>";
				echo "<td class='Othertd'>";
                ?>
				<?php //this was put outside of PHP since Javascript commands does not work while inside PHP. ?>
				<input name="btnPublish" type="button" value="Publish File" onClick="frmPublish.PublishBtn.value='publish';frmPublish.id.value='<?php echo $objResult["file_id"]; ?>';frmPublish.submit();">
				
				<?php
                echo "</td>";
				echo "</tr>";

				} // while($objResult = mysqli_fetch_array($objQuery))
//closes the database connection			
mysqli_close($objConnect);
?>
</form>
</table>
</head>
</html>


<?php 
// gets the value of PublishBtn
$submitbutton= $_GET['PublishBtn'];
//checks if submitbutton has value before executing the commands inside the if statement
if ($submitbutton<>""){
	//to connect the database
	include 'articles/dbconnect.php';

	//updates the value of Published to 1 where file_id is equals to the select file to upload.
	$strSQL = "UPDATE `b96e8_jdownloads_files` SET Published = 1 WHERE file_id = " . $_GET["id"] . "";

	$objQuery = mysqli_query($objConnect,$strSQL) or die ("Error Query [".$strSQL."]");	

	//closes the database connection			
	mysqli_close($objConnect);
}

?>