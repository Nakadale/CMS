<%@ Page Language="VB" ContentType="text/html" ResponseEncoding="iso-8859-1" %>

<!DOCTYPE html>
<html><head runat="server">

<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="maps, mapping, philippines, oceanography, cartography, charts, nautical charts, satellite image, aerial photo, digital data, topographic, thematic, land classification, remote sensing, hydrography, geodesy, reprography and printing, photogrammetry, information management">

<script src="jsFacefiles/jquery-1.2.2.pack.js" type="text/javascript"></script>
<script src="jsFacefiles/facebox.js" type="text/javascript"></script>

<script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox() 
    })
</script>

<link rel="stylesheet" href="styles/facebox.css" type="text/css" media="screen" />

<link rel="icon" href="/Images/namria.ico">  
<link rel="shortcut icon" href="/Images/namria.ico">

<!-- FlexSlider pieces -->
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script src="flexslider/jquery.flexslider-min.js"></script>
<script src="flexslider/jquery.flexslider.js"></script>

<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>

<script type="text/javascript" src="script/js.js"></script>
<script type="text/javascript" src="script/jquery.stellar.min.js"></script>
<script type="text/javascript" src="script/waypoints.min.js"></script>
<script type="text/javascript" src="script/jquery.easing.1.3.js"></script>
	
<!-- Includes for this demo -->
<link rel="stylesheet" href="css/demo.css" type="text/css" media="screen" />
	
<!-- Hook up the FlexSlider -->
<script type="text/javascript">
		$(window).load(function() {
			$('.flexslider').flexslider();
		});
</script>

<SCRIPT LANGUAGE="JavaScript">
<!--
Begin
function formHandler(menu){
var URL = document.menu.tides.options[document.menu.tides.selectedIndex].value;
}
// En
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</SCRIPT>

<link rel="stylesheet" type="text/css" href="css/flexdropdown.css" />

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

<script type="text/javascript" src="script/flexdropdown.js">

/***********************************************
* Flex Level Drop Down Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
***********************************************/

</script>
    
<link rel="stylesheet" href="Styles/homeStyle.css" type="text/css" >

<link href="SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>

<title>NAMRIA | The Central Mapping Agency of the Government of the Philippines</title>
</head>

<body>

<div id="topbar">
	<div class="row">
        
        <table width="100%" class="slide" id="slide2" data-slide="2" data-stellar-background-ratio="0">
        	<tr><td width="50px">
        		<img  src="Images/sealGovPh.png" alt="Seal of the Republic of the Philippines" style="margin-top:3px;"></td>         
        		<td style="color:#FFFFFF; vertical-align:middle; padding-top:5px;">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="http://www.namria.gov.ph">Home</a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="transparencySeal.aspx" data-flexmenu="flexmenu1" data-dir="h" data-offsets="5,15">Transparency Seal</a>	
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="products.aspx" data-flexmenu="flexmenu2" data-dir="h" data-offsets="5,15">Products</a>	
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  <a href="services.aspx" data-flexmenu="flexmenu3" data-dir="h" data-offsets="5,15">Services</a>

                    <!--HTML for Flex Drop Down Menu 1-->
                    <ul id="flexmenu1" class="flexdropdownmenu">
                    <li><a href="transparencySeal.aspx#annual">Annual Reports</a>
                        <ul>
                        <li><a href="transparencySeal.aspx#soab">Statement of Allotment, Obligation and Balances</a></li>
                        <li><a href="transparencySeal.aspx#di">Disbursement and Income</a></li>
                        <li><a href="transparencySeal.aspx#pp">Physical Plan</a></li>
                        <li><a href="transparencySeal.aspx#fro">Financial Report of Operation</a></li>
                        <li><a href="transparencySeal.aspx#far">Financial Accountability Reports</a></li>
                        </ul></li>
                    <li><a href="transparencySeal.aspx#abct">Approved Budgets and Corresponding Targets</a></li>
                    <li><a href="transparencySeal.aspx#ppkra">Program/Projects Key Result Areas</a></li>
                    <li><a href="transparencySeal.aspx#ppb">Program/Projects Beneficiaries</a></li>
                    <li><a href="transparencySeal.aspx#sppi">Status of Project/Program Implementation</a></li>
                    <li><a href="transparencySeal.aspx#app">Annual Procurement Plan</a></li>
                    <li><a href="transparencySeal.aspx#ca">Contracts Awarded</a></li>
                    <li><a href="transparencySeal.aspx#cc">Certificate of Compliance</a></li>
                    </ul>                     
                    
                    <!--HTML for Flex Drop Down Menu 2-->
                    <ul id="flexmenu2" class="flexdropdownmenu">
                        <li><a href="products.aspx#topo">Topographic Maps</a></li>
                        <li><a href="products.aspx#charts">Nautical Charts</a></li>
                        <li><a href="products.aspx#satellite">Satellite Images</a></li>
                        <li><a href="products.aspx#aerial">Aerial Photographs</a></li>
                        <li><a href="products.aspx#publications">Publications</a></li>
                        </li>
                    </ul>                   
                    
                    <!--HTML for Flex Drop Down Menu 2-->
                    <ul id="flexmenu3" class="flexdropdownmenu">
                        <li><a href="services.aspx#surveying">Surveying an Mapping</a></li>
                        <li><a href="services.aspx#gisDev">GIS Development</a></li>
                        <li><a href="services.aspx#gtc">Geomatics Training</a></li>
                        <li><a href="services.aspx#certifications">Certifications</a></li>
                        <li><a href="services.aspx#otherServices">Other Services</a></li>
                        </li>
                    </ul></td> 
                    
            <td width="20%" style="color:#FFFFFF; vertical-align:middle; padding-top:5px; text-align:right;">            	
                    <a href="about.aspx">About Us</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="contact.aspx">Contact Us</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> 
                          
			<td style="color:#FFFFFF; vertical-align:middle; padding-top:5px;" width="10%">
						<form method="get" action="http://www.google.com.ph/custom" target="google_window"> 
		  					<input class=text type="hidden" name="sitesearch" value="">
		  					<input class=text type="hidden" name="sitesearch" value="www.namria.gov.ph" checked="checked">
		  					<input type="hidden" name="client" value="pub-6753156445845742">
		  					<input type="hidden" name="forid" value="1">
		  					<input type="hidden" name="ie" value="ISO-8859-1">
		  					<input type="hidden" name="oe" value="ISO-8859-1">
		  					<input type="hidden" name="cof" value="GALT:#ff6600;GL:1;DIV:#f1f1f1;VLC:663399;AH:center;BGC:FFFFFF;LBGC:5C7302;ALC:5C7302;LC:5C7302;T:666666;GFNT:5C7302;GIMP:5C7302;LH:50;LW:206;L:http://www.namria.gov.ph/images/namria_adsense.jpg;S:http://www.namria.gov.ph;FORID:1">
		  					<input type="hidden" name="hl" value="en">
		  					<input class=subheadMenu type="hidden" name="domains" value="www.namria.gov.ph">
		  <input class="textbox" style="text-alignment: center;"  type="text" name="q" size="20" maxlength="50" value=" Search ..."></form></td></tr>
        </table>
        
    </div>
</div>

<div id="masthead"> 
	<div id="mastheadLogo">
        
        <table width="100%" height="100%">
        	<tr><td width="150px" align="center" bgcolor="#5e9ac0">
        		<a href="about.aspx" style="background-color:#5e9ac0;"><img src="Images/logoNamria.png" alt="Logo of NAMRIA" style="margin-bottom:20px;"></a></td>         
       		  <td>
                <img src="Images/textNamria.png" alt="NAMRIA "></td>         
        		<td width=""></td></tr>
        </table>
        
	</div>	
</div>

<div id="banner">
	<div id="bannerSlider">
    
      <iframe style="margin-left: 0px;" src="slider.htm" scrolling="no" height="460px" width="1190px" frameborder="0"></iframe> 
    
    </div>
</div>

<div id="mainMenu">
        
	<div id="mainMenu01">
        
        <table width="100%" style="border-bottom:0px dotted #CCCCCC;">
        	<tr><td class="mainMenuTitle" height="25px" align="center"><a href="prodResultFrame.htm" rel="facebox">SEARCH</a></td></tr>
            <tr><td height="20px">&nbsp;</td></tr>
            <tr><td class="mainMenuText">Determine the availability of our maps and charts by searching through our catalog.<br /><br /></td></tr>
        </table>
        
	</div>	 
	<div id="mainMenu02">
        
        <table width="100%" style="border-bottom:0px dotted #CCCCCC;">
        	<tr><td class="mainMenuTitle" height="25px" align="center"><a href="about.aspx#mso">LOCATE</a></td>
            <tr><td height="20px">&nbsp;</td></tr>
            <tr><td class="mainMenuText">Buy our products from one of our Map Sales Offices located throughout the country.<br /><br /></td></tr>
        </table>
        
	</div> 
	<div id="mainMenu03">
        
        <table width="100%" style="border-bottom:0px dotted #CCCCCC;">
        	<tr><td class="mainMenuTitle" height="25px" align="center"><a href="download.aspx">DOWNLOAD</a></td>
            <tr><td height="20px">&nbsp;</td></tr>
            <tr><td class="mainMenuText">Get our topographic maps in different scales and other thematic maps, FREE.<br /><br /></td></tr>
        </table>
        
	</div> 
	<div id="mainMenu04">
        
        <table width="100%" style="border-bottom:0px dotted #CCCCCC;">
        	<tr><td class="mainMenuTitle" height="25px" align="center"><a href="learn.aspx">LEARN</a></td> 
            <tr><td height="20px">&nbsp;</td></tr>
            <tr><td class="mainMenuText">Acquaint yourself with maps and learn the types, uses, and how to read them.<br /><br /></td></tr>
        </table>
        
	</div>   
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  		<tr height="25">
    		<td class="indicator" style="border-top:1px dotted #dddddd; border-bottom:2px solid #dddddd; vertical-align:middle;">You are here &nbsp;&nbsp;>&nbsp;&nbsp; Home </td>
   		  	<td width="150" class="indicator" style="border-top:1px dotted #dddddd; border-bottom:2px solid #dddddd; vertical-align:middle;"><div align="right">Follow us on</div></td>
   		  	<td width="80" style="border-top:1px dotted #dddddd; border-bottom:2px solid #dddddd; vertical-align:middle;">&nbsp;&nbsp;<a href="http://www.facebook.com/namria.gov.1" target="_blank"><img src="Images/facebook1.png" alt="Facebook" border="0" /></a>&nbsp;&nbsp;<a href="https://twitter.com/namriagov" target="_blank"><img src="Images/twitter1.png" alt="Twitter" border="0" /></a>&nbsp;</td>
	  </tr>
	</table>
</div>

<div id="mainBody">
	<div id="leftBody">
   	  <div id="mainBodyTitle"><a name="visionMission" style="color:#666666;">NAMRIA</a></div>
        
      <div class="namriaVision">envisions a highly-professionalized, technically advanced, globally competitive, and environment and natural resources caring 
			agency. Its mission is to generate and disseminate reliable and up-to-date geographic information and provide related services, by employing state-of-the-art	
	  		technology, in support to national development and security.</div>
            
        <div style="margin-top:75px;"><a href="transparencySeal.aspx"><img src="images/transparencySeal.png" alt="Transparency Seal" border="0"></a></div>
  </div>
    
	<div id="rightBody">
    	<div id="mainBodyTitle" style="font-variant:small-caps;">Updates</div>
        <iframe src="../article/Article_load.php" width="570px" height="921px" scrolling="no"></iframe>
    </div>
</div>

<div id="subBody01">

	<div align="right"><ul class="navigation"><li data-slide="2"></li>
	</ul></div>
    
<div id="leftBody01">
        
        <div class="rightBodyHeading" style="margin-top:50px; text-align:left;">NEWS IN MAP</div>
        
        <img style="margin-top:15px;" src="Images/newsInMap.png" alt="Philippine Geoportal">        
        <div class="mapDate" style="text-align:left;">01 August 2013</div>
        <div class="newsBody" style="text-align:left;">Tacloban City, Leyte is one of the Eastern Visayas cities hardly hit by Typhoon Yolanda on November 08, 2013.</div>
        <div class="mapDate" style="text-align:left; padding-top:5px;">
          <p><a href="#">View Map</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#">Read Article</a></p>

        </div>
        
    </div>
    
	<div id="rightBody01">
		<iframe src="../complete/list.php" width="570px" height="501px" scrolling="no"></iframe>
	</div>
   
</div>

<div id="subBody02"> 

	<div align="center" style="visibility:hidden;"><img src="Images/triDivider.png"></div>
        
        <div style="margin:20px 0px 0px 0px; text-align:justify; font-size:12px; letter-spacing:0.45px; line-height:24px; border-top:1px dotted #CCCCCC; border-bottom:1px dotted #CCCCCC;">
        	TIME MERIDIAN 120 DEG EAST. 0000 IS MIDNIGHT. 1200 IS NOON. HEIGHT IS IN METERS AND RECKONED FROM THE DATUM OF SOUNDING ON CHARTS OF THE LOCALITY WHICH IS MEAN LOWER LOW WATER.</div>
        
    	<div style="padding-top:20px; text-align:center; font-size:20px; letter-spacing:3px; font-stretch:ultra-condensed; font-weight:bold; color:#666666;">PREDICTED HOURLY HEIGHT OF TIDE</div>
                
        <div style="margin-top:10px; margin-bottom:30px; text-align:center; font-size:16px; letter-spacing:2px; font-stretch:ultra-condensed; font-weight:bold; color:#666666;">
        
			<script language="JavaScript">
				var thisdate=new Date();
				var year=thisdate.getYear();
					if (year < 1000) year+=1900;
						var day=thisdate.getDay();
						var month=thisdate.getMonth();
						var daym=thisdate.getDate();
					if (daym < 10) daym = "0" + daym;
						var dayarray=new Array 	(
							"Sun",
							"Mon",
							"Tue",
							"Wed",
							"Thu",
							"Fri",
							"Sat");
						var montharray=new Array (
							"JANUARY",
							"FEBRUARY",
							"MARCH",
							"APRIL",
							"MAY",
							"JUNE",
							"JULY",
							"AUGUST",
							"SEPTEMBER",
							"OCTOBER",
							"NOVEMBER",
							"DECEMBER");
				
						document.write("" +year+ " - " +montharray[month]+ " - "+daym+"  ")
              </script> 
        
        </div>
    
	<div id="subBody0201">
        
        <table width="100%">
        	<tr><td class="mainMenuTitle" height="25px" align="center">      	
        
        	<div style="margin-top:0px;"> 
          	<ul id="MenuBar4" class="MenuBarVertical">
            <li><a class="MenuBarItemSubmenu" href="#">METRO MANILA</a>
                <ul>
                </ul>
            </li>
  			</ul></div></td></tr>
            <tr><td>&nbsp;</td></tr>
          <tr><td height="450px"><iframe border=0 name="tides" src="tides.asp" frameborder=0 width=293 scrolling=no height="450px"></iframe></td></tr>
        </table>
        
	</div>	 
	<div id="subBody0202">
        
        <table width="100%">
        	<tr><td class="mainMenuTitle" height="25px" align="center">       	
        
        	<div style="margin-top:0px;"> 
          	<ul id="MenuBar1" class="MenuBarVertical">
            <li><a class="MenuBarItemSubmenu" href="#">LUZON TIDE STATIONS</a>
                <ul>
                  <li><a href="tidesBat.asp" target="tidesLuzon">Batangas Bay, Batangas</a></li>
                  <li><a href="tidesLeg.asp" target="tidesLuzon">Legaspi Port, Albay</a></li>
                  <li><a href="tidesIrene.asp" target="tidesLuzon">Port Irene, Cagayan</a></li>
                  <li><a href="tidesPlw.asp" target="tidesLuzon">Puerto Princesa, Palawan</a></li>
                  <li><a href="tidesRqz.asp" target="tidesLuzon">Port Real, Quezon</a></li>
                  <li><a href="tidesSzm.asp" target="tidesLuzon">Subic Bay, Zambales</a></li>
                  <li><a href="tidesSfl.asp" target="tidesLuzon">San Fernando Harbor, La Union</a></li>
                  <li><a href="tidesSom.asp" target="tidesLuzon">San Jose, Occidental Mindoro</a></li>
                </ul>
            </li>
  			</ul></div></td> </tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td height="450px"><iframe border=0 name="tidesLuzon" src="tidesSfl.asp" frameborder=0 width=287 scrolling=no height="450px"></iframe></td></tr>
        </table>
        
	</div> 
	<div id="subBody0203">
        
        <table width="100%">
        	<tr><td class="mainMenuTitle" height="25px" align="center">        	
        
        	<div style="margin-top:0px;"> 
          	<ul id="MenuBar2" class="MenuBarVertical">
            <li><a class="MenuBarItemSubmenu" href="#">VISAYAS TIDE STATIONS</a>
                <ul>
                  <li><a href="tidesIlo.asp" target="tidesVisayas">Cebu Port, Cebu</a></li>
                  <li><a href="tidesIlo.asp" target="tidesVisayas">Iloilo Port, Iloilo</a></li>
                  <li><a href="tidesIlo.asp" target="tidesVisayas">Campongo Port, Eastern Samar</a></li>
                  <li><a href="tidesIlo.asp" target="tidesVisayas">Caticlan Port, Malay, Aklan</a></li>
                </ul>
            </li>
  			</ul></div></td> </tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td height="450px"><iframe border=0 name="tidesVisayas" src="tidesCeb.asp" frameborder=0 width=287 scrolling=no height="450px"></iframe></td></tr>
        </table>
        
	</div> 
	<div id="subBody0204">
        
        <table width="100%">
        	<tr><td class="mainMenuTitle" height="25px" align="center">       	
        
        	<div style="margin-top:0px;"> 
          	<ul id="MenuBar3" class="MenuBarVertical">
            <li><a class="MenuBarItemSubmenu" href="#">MINDANAO TIDE STATIONS</a>
                <ul>
                  <li><a href="tidesZamb.asp" target="tidesMindanao">Davao Port, Davao</a></li>
                  <li><a href="tidesCor.asp" target="tidesMindanao">Macabalan Port, CDO</a></li>
                  <li><a href="tidesGsan.asp" target="tidesMindanao">Makar, Gen. Santos</a></li>
                  <li><a href="tidesSr.asp" target="tidesMindanao">Surigao Port, Surigao</a></li>
                  <li><a href="tidesZamb.asp" target="tidesMindanao">Zamboanga City, Zamboanga</a></li>
                  <li><a href="tidesCor.asp" target="tidesMindanao">Tandag Port, Surigao del Sur</a></li>
                </ul>
            </li>
  			</ul></div></td> </tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td height="450px"><iframe border=0 name="tidesMindanao" src="tidesDav.asp" frameborder=0 width=293 scrolling=no height="450px"></iframe></td></tr>
        </table>
        
	</div>     
        
</div>

<div id="subBody03">
        
        <div style="margin:0px 0px 0px 0px; text-align:justify; font-size:12px; letter-spacing:0.45px; line-height:24px; border-top:1px dotted #CCCCCC; border-bottom:1px dotted #CCCCCC;">
        	TIME MERIDIAN 120 DEG EAST. 0000 IS MIDNIGHT. 1200 IS NOON. HEIGHT IS IN METERS AND RECKONED FROM THE DATUM OF SOUNDING ON CHARTS OF THE LOCALITY WHICH IS MEAN LOWER LOW WATER.</div>
            
</div>

<div id="footerAgency" style="padding-top:0px;">

	<div id="footerAgencyBody">
    
    <div class="slide" id="slide1" data-slide="1" data-stellar-background-ratio="0">
<table width="1190px" border="0">
  		<tr>
    		<td height="75px" style="vertical-align:middle; font-size:18px; letter-spacing:2px; font-weight:bold;"><a href="http://namria.gov.ph">HOME</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="search.aspx">SEARCH</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="locate.aspx">LOCATE</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="download.aspx">&nbsp;DOWNLOAD</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="learn.aspx">LEARN</a></td>
   		  <td style="vertical-align:middle; text-align:right;"><a href="about.aspx">About Us</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#contact">Contact Us</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="sitemap.aspx">Site Map</a>&nbsp;&nbsp;&nbsp;</td>
	  </tr>
	</table>
    
	<table width="1190px" border="0">
  		<tr>
    		<td rowspan="2" style="vertical-align:middle;" width="609" height="400px">
  <p><span style="color:#FFFFFF; font-size:30px; font-variant:small-caps; font-weight:bold; letter-spacing:2px;">Do you produce road maps?</span><br /><br />
            	    <span style="color:#FFFFFF; font-size:14px; letter-spacing:2px; line-height:20px; margin-right:50px;">NAMRIA produces topographic maps that are use as base maps for other thematic maps like land cover, land condition, land 					
           	        classification, cadastral, etc. In addition, we have digital data of road maps available. This data comes from the Department of Public Works and Highways (DPWH).</span></p>
            	<p>&nbsp;</p>
       	  <span class="buttonBanner"><br /><a href="faqs.aspx" style="font-size:14px;" >more FAQs</a></span><br /><br /><br /><br /><br /><br /></td>
    		<td width="14" rowspan="2" style="vertical-align:middle;">&nbsp;</td>
   		  <td colspan="3" height="75px" style="text-align:right;"><span style="color:#FFFFFF; font-size:24px; font-variant:small-caps; font-weight:bold; letter-spacing:1px;"><br /><br /><span style="color:#5e9ac0; font-size:24px;">.</span>Contact Our Information Client Service Unit</span><br /><br /></td>
   		</tr>
  		<tr>
    		<td width="281" height="75" style="text-align:right;">
       	  <div style="text-align:right; font-size:24px; font-weight:bold;">
                	<br />(632) 887-5466 <br /><br /><br />
              </div>          	
    
              <div style="text-align:right; font-size:14px; line-height:20px;">
                    NAMRIA Main Office<br />
                    Lawton Ave., Fort Andres Bonifacio<br />
                    1638 Taguig City, Philippines<br />
                    Trunkline: (63-2) 810-4831<br /><br />  
                    
            </div> </td>
                
    		<td width="0" style="vertical-align:middle; text-align:right;"></td>
    		<td width="264" height="75"><br /><br />
    
    <form id="form1" runat="server" class="inquiry">
    
      <asp:SqlDataSource ID="SqlDataSource1" runat="server" ConnectionString="<%$ ConnectionStrings:ConnectionString %>"
            DeleteCommand="DELETE FROM [comments] WHERE [ids] = ?" InsertCommand="INSERT INTO [comments] ([messenger], [email], [comments], [datesent]) VALUES (?, ?, ?, { fn NOW() })"
            ProviderName="<%$ ConnectionStrings:ConnectionString.ProviderName %>" SelectCommand="SELECT * FROM [comments]"
            UpdateCommand="UPDATE [comments] SET [messenger] = ?, [email] = ?, [comments] = ? WHERE [ids] = ?">
            <DeleteParameters>
                <asp:Parameter Name="ids" Type="Int32" />
            </DeleteParameters>
            <UpdateParameters>
                <asp:Parameter Name="messenger" Type="String" />
                <asp:Parameter Name="email" Type="String" />
                <asp:Parameter Name="comments" Type="String" />
                <asp:Parameter Name="ids" Type="Int32" />
            </UpdateParameters>
            <InsertParameters>
                <asp:Parameter Name="messenger" Type="String" />
                <asp:Parameter Name="email" Type="String" />
                <asp:Parameter Name="comments" Type="String" />
            </InsertParameters>
        </asp:SqlDataSource> 
    
        <asp:FormView ID="FormView1" runat="server" DataKeyNames="id" DataSourceID="SqlDataSource1"
            DefaultMode="Insert">
            
            <EditItemTemplate>
                control_number:
                <asp:Label ID="control_numberLabel1" runat="server" class="textbox" Text='<%# Eval("ids") %>'>
                </asp:Label><br />
                name:
                <asp:TextBox ID="nameTextBox" runat="server" width="200" class="textbox" Text='<%# Bind("messenger") %>'>
                </asp:TextBox><br />
                email:
                <asp:TextBox ID="emailTextBox" runat="server" class="textbox" Text='<%# Bind("email") %>'>
                </asp:TextBox><br /><br />
                questions/comments/suggestions:
                <asp:TextBox ID="messageTextBox" runat="server" class="textbox" Text='<%# Bind("comments") %>'>
                </asp:TextBox><br />
                <asp:LinkButton ID="UpdateButton" runat="server" CausesValidation="True" CommandName="Update"
                    Text="Update">
                </asp:LinkButton>
                <asp:LinkButton ID="UpdateCancelButton" runat="server" CausesValidation="False" CommandName="Cancel"
                    Text="Cancel">
                </asp:LinkButton>
            </EditItemTemplate>
            
            <InsertItemTemplate>
                name:
                <asp:TextBox ID="nameTextBox" runat="server" class="textbox" width="180" Text='<%# Bind("messenger") %>'>
                </asp:TextBox><div style="line-height:5px;">&nbsp;</div>
                email:
                <asp:TextBox ID="emailTextBox" runat="server" class="textbox" width="180" Text='<%# Bind("email") %>'>
                </asp:TextBox><div style="line-height:15px;">&nbsp;</div>
                questions/comments/suggestions:<div style="line-height:5px;">&nbsp;</div>
                <asp:TextBox id="commentsTextBox" TextMode="multiline" Columns="28" Rows="5" runat="server" Text='<%# Bind("comments") %>'>
                </asp:TextBox><div style="line-height:10px;">&nbsp;</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
                <asp:LinkButton ID="InsertButton" runat="server" class="button" CausesValidation="True" CommandName="Insert"
                    Text="send">
                </asp:LinkButton>&nbsp;&nbsp;&nbsp;
                <asp:LinkButton ID="InsertCancelButton" runat="server" class="button" CausesValidation="False" CommandName="Cancel"
                    Text="cancel">
                </asp:LinkButton>
            </InsertItemTemplate>
            
            <ItemTemplate>
                control_number:
                <asp:Label ID="control_numberLabel" runat="server" Text='<%# Eval("ids") %>'>
                </asp:Label><br />
                name:
                <asp:Label ID="nameLabel" runat="server" Text='<%# Bind("messenger") %>'></asp:Label><br />
                email:
                <asp:Label ID="emailLabel" runat="server" Text='<%# Bind("email") %>'></asp:Label><br /><br />
                questions/comments/suggestions:
                <asp:Label ID="messageLabel" runat="server" Text='<%# Bind("comments") %>'></asp:Label><br />
                <asp:LinkButton ID="EditButton" runat="server" class="button" CausesValidation="False" CommandName="Edit"
                    Text="Edit">
                </asp:LinkButton>
                <asp:LinkButton ID="DeleteButton" runat="server" class="button" CausesValidation="False" CommandName="Delete"
                    Text="Delete">
                </asp:LinkButton>
                <asp:LinkButton ID="NewButton" runat="server" class="button" CausesValidation="False" CommandName="New"
                    Text="New">
                </asp:LinkButton>
            </ItemTemplate>
        </asp:FormView>
    </form>
            </td>
	  </tr>
	</table>
	</div>
    
    </div>

</div>

<div id="footerStandard">
    
	<div id="footerStandardBody">
     
	<div id="subfooter01" style="padding-top: 70px;">
    	<span style="color:#cccccc; font-size:26px; font-variant:small-caps; font-weight:bold; letter-spacing:2px; padding-bottom:40px;">Government Portal</span><br /><br /><br /><br />   
        
        <span style="color:#FFFFFF; font-size:20px; font-variant:small-caps; font-weight:bold; letter-spacing:2px; padding-left:20px;">Executive</span><br />
        <ul>
        	<li><a href="http://www.president.gov.ph" target="_blank">Office of the President</a></li>
          <li><a href="http://www.ovp.gov.ph" target="_blank">Office of the Vice President</a></li> 
            <li><a href="http://www.coa.gov.ph" target="_blank">Commission on Audit</a></li>
            <li><a href="http://www.csc.gov.ph" target="_blank">Civil Service Commission</a></li>
            <li><a href="http://www.comelec.gov.ph" target="_blank">Commission on Elections</a></li>
            <li><a href="http://www.bsp.gov.ph" target="_blank">Banko Sentral ng Pilipinas</a> </li>
            <li><a href="http://www.neda.gov.ph" target="_blank">National Economic and Development Authority</a></li> 
    	</ul>  <br />    
      <form name="form" id="form">
        <select name="Cabinet" id="Cabinet" onChange="MM_jumpMenu('parent',this,0)" style="margin-left:20px; height:30px; width:240px; font-family:myFirstFont, 'Trebuchet MS', Verdana, Arial, Helvetica, sans-serif;">
                      <option value="">Cabinet Offices</option>
          <option value="http://www.ched.gov.ph" target="_blank">Commission on Higher Education</a></option>
          <option value="http://www.dar.gov.ph/" target="_blank">Department of Agrarian Reform</a></option>
                      <option value="http://www.da.gov.ph" target="_blank">Department of Agriculture</a></option>
                      <option value="http://www.dbm.gov.ph" target="_blank">Department of Budget and Management</a></option>
                      <option value="http://www.deped.gov.ph" target="_blank">Department of Education</a></option>
                      <option value="http://www.doe.gov.ph" target="_blank">Department of Energy</a></option>
                      <option value="http://www.denr.gov.ph/" target="_blank">Department of Environment and Natural Resources</a></option>
          <option value="http://www.dof.gov.ph/" target="_blank">Department of Finance</a></option>
                      <option value="http://www.dfa.gov.ph" target="_blank">Department of Foreign Affairs</a></option>
          <option value="http://www.doh.gov.ph" target="_blank">Department of Health</a></option>
                      <option value="http://www.doj.gov.ph" target="_blank">Department of Justice</a></option>
                      <option value="http://www.dilg.gov.ph" target="_blank">Department of the Interior and Local Government</a></option>
                      <option value="http://www.dole.gov.ph" target="_blank">Department of Labor and Employment</a></option>
                      <option value="http://www.dpwh.gov.ph/index.asp" target="_blank">Department of Public Works and Highways </a></option>
          <option value="http://www.dost.gov.ph" target="_blank">Department of Science and Technology</a></option>
                      <option value="http://www.dswd.gov.ph" target="_blank">Department of Social Welfare and Development</a></option>
                      <option value="http://www.tourism.gov.ph" target="_blank">Department of Tourism</a></option>
          <option value="http://www.dti.gov.ph" target="_blank">Department of Trade and Industry</a></option>
                      <option value="http://www.dotcmain.gov.ph/" target="_blank">Department of Transportation and Communications</a></option>
        </select>
      </form><br /> 
                     
                  <form name="form" id="form">
                    <select name="Agencies" id="Agencies" onChange="MM_jumpMenu('parent',this,0)" style="margin-left:20px; height:30px; width:240px; font-family:myFirstFont, 'Trebuchet MS', Verdana, Arial, Helvetica, sans-serif;">
                      <option value="">Agencies and Bureaus</option>                      
                      <option value="http://www.bcda.gov.ph" target="_blank">Bases Conversion Development Authority</a></option>
                      <option value="http://www.boi.gov.ph" target="_blank">Board of Investments</a></option>
                      <option value="">Bureau of Agricultural Statistics</option>
                      <option value="http://www.dswd.gov.ph" target="_blank">Bureau of Child and Youth Welfare</a></option>
                      <option value="http://customs.gov.ph/boc" target="_blank">Bureau of Customs</a></option>
                      <option value="http://www.tourism.gov.ph" target="_blank">Bureau of Domestic Tourism Promotion</a></option>
                      <option value="http://www.rei.dost.gov.ph" target="_blank">Bureau of Emergency Assistance</a></option>
                      <option value="http://www.manila-online.net/bles/blesmain.htm" target="_blank">Bureau of Labor and Employment Statistics</a></option>
                      <option value="http://www.info.com.ph/%7Ephblrnet/" target="_blank">Bureau of Labor Relations</a></option>
                      <option value="http://www.dti.gov.ph" target="_blank">Bureau of Export Trade Promotion</a></option>
                      <option value="http://www.immigration.gov.ph" target="_blank">Bureau of Immigration</a></option>
                      <option value="http://www.bir.gov.ph" target="_blank">Bureau of Internal Revenue</a></option>
                      <option value="http://www.info.com.ph/%7Ebrwrpid/" target="_blank">Bureau of Rural Workers</a></option>
                      <option value="http://www.undp.org/tcdc/phi4656.htm" target="_blank">Bureau of Small and Medium Business Development</a></option>
                      <option value="http://www.citem.gov.ph" target="_blank">Center for International Trade Expositions and Missions</a></option>
                      <option value="http://www.dap.edu.ph" target="_blank">Development Academy of the Philippines</a></option>
                      <option value="http://www.devbankphil.com/welcome.htm" target="_blank">Development Bank of the Philippines</a></option>
                      <option value="http://www.doe.gov.ph" target="_blank">Energy Industry Administration Bureau</a></option>
                      <option value="http://www.doe.gov.ph" target="_blank">Energy Planning and Monitoring Bureau</a></option>
                      <option value="http://www.doe.gov.ph" target="_blank">Energy Resources and Development Bureau</a></option>
                      <option value="http://www.denr.gov.ph" target="_blank">Forest Management Bureau</a></option>
                      <option value="http://www.dti.gov.ph" target="_blank">Garment and Textile Export Board</a></option>
                      <option value="http://www.gsis.gov.ph" target="_blank">Government Service Insurance System</a></option>
                      <option value="http://www.dti.gov.ph/ipo" target="_blank">Intellectual Property Office</a></option>
                      <option value="http://www.landbank.com" target="_blank">Land Bank of the Philippines</a></option>
                      <option value="http://www.psdn.org.ph/denr/lmb/lmb1.htm" target="_blank">Land Management Bureau</a></option>
                      <option value="http://www.mmda.gov.ph" target="_blank">Metropolitan Manila Development Authority</a></option>
                      <option value="http://www.ncca.gov.ph" target="_blank">National Commission for Culture and the Arts</a></option>
                      <option value="http://www.ncc.gov.ph" target="_blank">National Computer Center</a></option>
                      <option value="http://www.ncmb.dole.gov.ph/" target="_blank">National Conciliation and Mediation Board</a></option>
                      <option value="http://www.nfa.gov.ph" target="_blank">National Food Authority</a></option>
                      <option value="http://www.nlrc.dole.gov.ph/" target="_blank">National Labor Relations Commission</a></option>
                      <option value="http://www.worldtelphil.com/client/nomm/" target="_blank">National Office of Mass Media</a></option>
                      <option value="http://www.napocor.com.ph" target="_blank">National Power Corporation</a></option>
                      <option value="http://www.nscb.gov.ph" target="_blank">National Statistical Coordination Board</a></option>
                      <option value="http://www.census.gov.ph" target="_blank">National Statistics Office</a></option>
                      <option value="http://www.ntc.gov.ph" target="_blank">National Telecommunications Commission</a></option>
                      <option value="http://www.nwpc.dole.gov.ph" target="_blank">National Wages and Productivity Commission</a></option>
                      <option value="http://www.osg.doj.gov.ph" target="_blank">Office of the Solicitor General</a></option>
                      <option value="http://www.dotpcvc.gov.ph" target="_blank">Philippine Convention and Visitors Corporation</a></option>
                      <option value="http://pcastrd.dost.gov.ph" target="_blank">Philippine Council for Advanced Science &amp; Technology Research &amp; Development</a></option>
                      <option value="http://www.pcarrd.dost.gov.ph" target="_blank">Philippine Council for Agri-Forestry &amp; Natural Resources Research &amp; Development</a></option>
                      <option value="http://www.pchrd.dost.gov.ph" target="_blank">Philippine Council for Health and Research Development</a></option>
                      <option value="http://www.pcierd.dost.gov.ph" target="_blank">Philippine Council for Industry &amp; Energy Research &amp; Development</a></option>
                      <option value="http://pdx.rpnet.com/pdic/index.htm" target="_blank">Philippine Deposit Insurance Corporation</a></option>
                      <option value="http://www.peza.gov.ph" target="_blank">Philippine Economic Zone Authority</a></option>
                      <option value="http://www.pia.gov.ph" target="_blank">Philippine Information Agency</a></option>
                      <option value="http://www.pids.gov.ph/" target="_blank">Philippine Institute for Development Studies</a></option>
                      <option value="http://www.dti.gov.ph" target="_blank">Philippine International Trading Corporation</a></option>
                      <option value="http://www.pnptmg.com" target="_blank">Philippine National Police - Traffic Management Group</a></option>
                      <option value="http://www.poea.gov.ph" target="_blank">Philippine Overseas Employment Administration</a></option>
                      <option value="http://www.expo.edu.ph/" target="_blank">Philippine Pavillion Web Page</a></option>
                      <option value="http://www.ppa.gov.ph" target="_blank">Philippine Ports Authority</a></option>
                      <option value="">Philippine Sports Commission</option>
                      <option value="http://www.stii.dost.gov.ph/scinet.html" target="_blank">Science and Technology Information Network</a></option>
                      <option value="http://www.sec.gov.ph" target="_blank">Securities and Exchange Commission</a></option>
                      <option value="http://www.sss.gov.ph" target="_blank">Social Security System</a></option>
                      <option value="http://www.sss.gov.ph" target="_blank">Southern Philippines Development Authority </a></option>
                      <option value="http://www.srtc.gov.ph" target="_blank">Statistical Research and Training Center</a></option>
                      <option value="http://www.tariffcommission.gov.ph/" target="_blank">Tariff Commission</a></option>
                      <option value="http://pdx.rpnet.com/tlrc/index.htm" target="_blank">Technology and Livelihood Resource Center</a></option>
                      <option value="http://www.tesda.org" target="_blank">Technical Education and Skills Development Authority</a></option>
                    </select>
                  </form>
                  
                  <br /><br /><br /><br /><br /><br /><br />
                  <div align="left" style="font-size:11px;"><a href="use.aspx">Terms of Use</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="policy.aspx">Privacy Policy</a></div>
	</div>	 
    
	<div id="subfooter02" style="padding-top: 145px;">
        <span style="color:#FFFFFF; font-size:20px; font-variant:small-caps; font-weight:bold; letter-spacing:2px; padding-left:20px;">Legislative</span>
        <ul>
        	<li><a href="http://www.senate.gov.ph/">Senate of the Philippines</a></li>
    		<li><a href="http://www.congress.gov.ph/">House of Representatives</a></li>
    	</ul> 
        <br /><br />
        <span style="color:#FFFFFF; font-size:20px; font-variant:small-caps; font-weight:bold; letter-spacing:2px; padding-left:20px;">Judiciary</span>
        <ul>
        	<li><a href="http://sc.judiciary.gov.ph/">Supreme Court</a></li>
    		<li><a href="http://ca.judiciary.gov.ph/">Court of Appeals</a></li>
    		<li><a href="http://sb.judiciary.gov.ph/">Sandiganbayan</a></li>
    		<li><a href="http://cta.judiciary.gov.ph/">Court of Tax Appeals</a></li>
    		<li><a href="http://jbc.judiciary.gov.ph/">Judicial Bar and Council</a></li>
    	</ul> 
	</div> 
	<div id="subfooter03">
        
            	<!-- Begin W3Counter Tracking Code -->
                <div style="visibility:hidden;">
  					<script type="text/javascript" src="http://www.w3counter.com/tracker.js"></script>
  					<script type="text/javascript">w3counter(563);</script>
  					<noscript>
  						<a href="http://www.w3counter.com"><img src="http://www.w3counter.com/tracker.php?id=563" border="0" style="visibility:hidden;" alt="W3Counter Web Stats" /></a>
  					</noscript>
                </div>
  				<!-- End W3Counter Tracking Code-->
	</div> 
	<div id="subfooter04">

	<div align="right"><a href="#" class="back-to-top"><img src="Images/top.png" alt="Top Page"></a>
	</div>
    
	</div>  
    
    </div>
</div>


<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>


<script type="text/javascript">
<!--
var MenuBar2 = new Spry.Widget.MenuBar("MenuBar2", {imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>


<script type="text/javascript">
<!--
var MenuBar3 = new Spry.Widget.MenuBar("MenuBar3", {imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>

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

</body>

</html>
