<!DOCTYPE html>
<!-- saved from url=(0049)http://localhost/namria2014/transparencySeal.aspx -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"><meta charset="UTF-8"><meta name="keywords" content="maps, mapping, philippines, oceanography, cartography, charts, nautical charts, satellite image, aerial photo, digital data, topographic, thematic, land classification, remote sensing, hydrography, geodesy, reprography and printing, photogrammetry, information management">

<?php include 'articles/filesneeded.php' ?>

<title>
	NAMRIA | The Central Mapping Agency of the Government of the Philippines
</title></head>

<body>

<?php include 'articles/topbar.php' ?>
<?php include 'articles/masthead.php' ?>

<div id="mainMenu"> 
	<div id="">
        
        <table width="100%" height="100%">
        	<tbody><tr><td width="150px" align="center" bgcolor="#5e9ac0">
        		<a href="http://localhost/namria2014/about.aspx"></a></td>         
       		  <td>
                </td>         
        		<td width=""></td></tr>
        </tbody></table>
        
	</div>	
</div>

<?php include 'articles/mainmenu.php' ?>  
    
	<table width="100%">
  		<tbody><tr height="25">
    		<td class="indicator" style="border-top:1px dotted #dddddd; border-bottom:2px solid #dddddd; vertical-align:middle;">You are here &nbsp;&nbsp;&gt;&nbsp;&nbsp; <a href="http://localhost/namria2014/home.aspx">Home</a> &nbsp;&nbsp;&gt;&nbsp;&nbsp; News and Events</td>
   		  	<td width="150" class="indicator" style="border-top:1px dotted #dddddd; border-bottom:2px solid #dddddd; vertical-align:middle;"><div align="right">Follow us on</div></td>
   		  	<td width="80" class="image" style="border-top:1px dotted #dddddd; border-bottom:2px solid #dddddd; vertical-align:middle;">&nbsp;&nbsp;<a href="http://www.facebook.com/namria.gov.1" target="_blank"><img src="./images/facebook1.png" alt="Facebook" border="0"></a>&nbsp;&nbsp;<a href="https://twitter.com/namriagov" target="_blank"><img src="./images/twitter1.png" alt="Twitter" border="0"></a>&nbsp;</td>
  		</tr>
	</tbody></table>

<div class="MainBody">

	<div id="leftBody">
	<p>
	<h4> News & Events </h4>
	<br>
	<br>
	<br>
	<br>
		<?php 

		$archive = $_GET["Archive"];	

		if ($archive == '1')
		{
		include "articles/articleLoad.php";
		}
		elseif ($archive == '0')
		{
		include "articles/archiveLoad.php";
		}
		?>
		
	</div> <!--leftbody-->
	
	<div id="rightBody">
			<div id="mainBodyTitle" style="font-variant:small-caps;">&nbsp;</div>
			
			<div class="rightBodyHeading">

				<div id="pageMenuColumn">
					<h3 id="MenuTitle"> Recent Article </h3>
					<p>

					<table class="navigation" style="border:1px;">
						<tr>
							<?php include "articles/latestNews.php" ?>
						</tr>
					</table>
					
					<p>
					<h3 id="MenuTitle"> Monthly Archives </h3>
					<p>
									
					<?php include "articles/monthlyArchive.php" ?>
					
				</div> <!-- page column -->
		
			</div> <!-- right body heading -->
			
			</div> <!-- main body title -->
	</div> <!-- right body -->
</div>

<?php include 'articles/footeragency.php' ?>

<?php include 'articles/footerstandard.php' ?>

<script>            
			jQuery(document).ready(function() {
				var offset = 220;
				var duration = 500;
				jQuery(window).scroll(function() {
					if (jQuery(this).scrollTop() > offset) {
						jQuery('.back-to-top').fadeIn(duration);
					} else {
						jQuery('.back-to-top').fadeOut(duration);
					}
				});
				
				jQuery('.back-to-top').click(function(event) {
					event.preventDefault();
					jQuery('html, body').animate({scrollTop: 0}, duration);
					return false;
				})
			});
</script>




<div id="facebox" style="display:none;">       <div class="popup">         <div class="content">         </div>         <a href="http://localhost/namria2014/transparencySeal.aspx#" class="close"><img src="images/labelClose.png" title="close" class="close_image"></a>       </div>     </div><ul id="flexmenu1" class="flexdropdownmenu jqflexmenu" style="display: none; visibility: visible; z-index: 1000;">
                    <li style="z-index: 1000;"><a href="http://localhost/namria2014/transparencySeal.aspx#annual">Annual Reports<img src="./images/arrow.gif" class="rightarrowclass" style="border:0;"></a>
                        <ul style="display: none; visibility: visible;">
                        <li><a href="http://localhost/namria2014/transparencySeal.aspx#soab">Statement of Allotment, Obligation and Balances</a></li>
                        <li><a href="http://localhost/namria2014/transparencySeal.aspx#di">Disbursement and Income</a></li>
                        <li><a href="http://localhost/namria2014/transparencySeal.aspx#pp">Physical Plan</a></li>
                        <li><a href="http://localhost/namria2014/transparencySeal.aspx#fro">Financial Report of Operation</a></li>
                        <li><a href="http://localhost/namria2014/transparencySeal.aspx#far">Financial Accountability Reports</a></li>
                        </ul></li>
                    <li><a href="http://localhost/namria2014/transparencySeal.aspx#abct">Approved Budgets and Corresponding Targets</a></li>
                    <li><a href="http://localhost/namria2014/transparencySeal.aspx#ppkra">Program/Projects Key Result Areas</a></li>
                    <li><a href="http://localhost/namria2014/transparencySeal.aspx#ppb">Program/Projects Beneficiaries</a></li>
                    <li><a href="http://localhost/namria2014/transparencySeal.aspx#sppi">Status of Project/Program Implementation</a></li>
                    <li><a href="http://localhost/namria2014/transparencySeal.aspx#app">Annual Procurement Plan</a></li>
                    <li><a href="http://localhost/namria2014/transparencySeal.aspx#ca">Contracts Awarded</a></li>
                    <li><a href="http://localhost/namria2014/transparencySeal.aspx#cc">Certificate of Compliance</a></li>
                    </ul><ul id="flexmenu2" class="flexdropdownmenu jqflexmenu" style="display: none; visibility: visible; z-index: 1000;">
                        <li><a href="http://localhost/namria2014/products.aspx#topo">Topographic Maps</a></li>
                        <li><a href="http://localhost/namria2014/products.aspx#charts">Nautical Charts</a></li>
                        <li><a href="http://localhost/namria2014/products.aspx#satellite">Satellite Images</a></li>
                        <li><a href="http://localhost/namria2014/products.aspx#aerial">Aerial Photographs</a></li>
                        <li><a href="http://localhost/namria2014/products.aspx#publications">Publications</a></li>
                        
                    </ul><ul id="flexmenu3" class="flexdropdownmenu jqflexmenu" style="display: none; visibility: visible; z-index: 1000;">
                        <li><a href="http://localhost/namria2014/services.aspx#surveying">Surveying an Mapping</a></li>
                        <li><a href="http://localhost/namria2014/services.aspx#gisDev">GIS Development</a></li>
                        <li><a href="http://localhost/namria2014/services.aspx#gtc">Geomatics Training</a></li>
                        <li><a href="http://localhost/namria2014/services.aspx#certifications">Certifications</a></li>
                        <li><a href="http://localhost/namria2014/services.aspx#otherServices">Other Services</a></li>
                        
                    </ul><div id="fancybox-tmp"></div><div id="fancybox-loading"><div></div></div><div id="fancybox-overlay"></div><div id="fancybox-wrap"><div id="fancybox-outer"><div class="fancy-bg" id="fancy-bg-n"></div><div class="fancy-bg" id="fancy-bg-ne"></div><div class="fancy-bg" id="fancy-bg-e"></div><div class="fancy-bg" id="fancy-bg-se"></div><div class="fancy-bg" id="fancy-bg-s"></div><div class="fancy-bg" id="fancy-bg-sw"></div><div class="fancy-bg" id="fancy-bg-w"></div><div class="fancy-bg" id="fancy-bg-nw"></div><div id="fancybox-inner"></div><a id="fancybox-close"></a><a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a><a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a></div></div></body></html>