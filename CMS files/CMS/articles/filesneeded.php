<script src="jsFacefiles/jquery-1.2.2.pack.js" type="text/javascript"></script>
<script src="jsFacefiles/facebox.js" type="text/javascript"></script>

<link rel="stylesheet" href="styles/facebox.css" type="text/css" media="screen" />
<link rel="icon" href="http://localhost/Images/namria.ico"><link rel="shortcut icon" href="http://localhost/Images/namria.ico">

<!-- FlexSlider pieces -->
<link rel="stylesheet" href="styles/facebox.css" type="text/css" media="screen" />

<link rel="icon" href="/Images/namria.ico">  
<link rel="shortcut icon" href="/Images/namria.ico">

<!-- FlexSlider pieces -->
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>-->
<script src="flexslider/jquery.flexslider-min.js"></script>
<script src="flexslider/jquery.flexslider.js"></script>

<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>

<script type="text/javascript" src="script/js.js"></script>
<script type="text/javascript" src="script/jquery.stellar.min.js"></script>
<script type="text/javascript" src="script/waypoints.min.js"></script>
<script type="text/javascript" src="script/jquery.easing.1.3.js"></script>
	
<!-- Includes for this demo -->
<link rel="stylesheet" href="./css/demo.css" type="text/css" media="screen" />
	
<!-- Hook up the FlexSlider -->

<link rel="stylesheet" type="text/css" href="./css/flexdropdown.css" />

<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>-->

<script type="text/javascript" src="script/flexdropdown.js">

/***********************************************
* Flex Level Drop Down Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
***********************************************/

</script>
    
<link rel="stylesheet" href="Styles/pageStyle.css" type="text/css" >

<link href="SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="jsFancyBox/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="jsFancyBox/jquery.mousewheel-3.0.2.pack.js"></script>
<script type="text/javascript" src="jsFancyBox/jquery.fancybox-1.3.1.js"></script>
<link rel="stylesheet" type="text/css" href="jsFancyBox/jquery.fancybox-1.3.1.css" media="screen" />
<link rel="stylesheet" href="style.css" />



<script type="text/javascript">
function formHandler(menu){
var URL = document.menu.tides.options[document.menu.tides.selectedIndex].value;
}
// En
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

		$(document).ready(function() {
			/*
			*   Examples - images
			*/

			$("a#example1").fancybox({
				'titleShow'		: false
			});

			$("a#example2").fancybox({
				'titleShow'		: false,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});

			$("a#example3").fancybox({
				'titleShow'		: false,
				'transitionIn'	: 'none',
				'transitionOut'	: 'none'
			});

			$("a#example4").fancybox();

			$("a#example5").fancybox({
				'titlePosition'	: 'inside'
			});

			$("a#example6").fancybox({
				'titlePosition'	: 'over'
			});

			$("a[rel=example_group]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				}
			});

			/*
			*   Examples - various
			*/

			$("#various1").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});

			$("#various2").fancybox();

			$("#various3").fancybox({
				'width'				: '75%',
				'height'			: '75%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});

			$("#various4").fancybox({
				'padding'			: 0,
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
		});
</script>

<script type="text/javascript">
 function resizeIframe(obj)
 {
   obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
   obj.style.width = obj.contentWindow.document.body.scrollWidth + 'px';                        
 }
 </script> 