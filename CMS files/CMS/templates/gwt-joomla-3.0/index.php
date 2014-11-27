<?php defined('_JEXEC') or die;
// Load template framework 
include_once JPATH_THEMES . '/' . $this->template . '/framework.php'; 
?>

<?php

defined('_JEXEC') or die;

$doc = JFactory::getDocument();

$doc->addStyleSheet('templates/' . $this->template . '/css/foundation.css');
$doc->addStyleSheet('templates/' . $this->template . '/style.css');
$doc->addScript('templates/' . $this->template . '/js/vendor/modernizr.js', 'text/javascript');
JHtml::_('jquery.framework');


$option = JFactory::getApplication()->input->getVar('option');
$view = JFactory::getApplication()->input->getVar('view');
// Make sure it is a single article
if ($option == 'com_content' && $view == 'article'):
  $id = JFactory::getApplication()->input->getInt('id');
  $article = JTable::getInstance('content');
  $article->load($id);
  $author_id = $article->created_by;
  $user = JFactory::getUser($author_id);

  $article_title = $article->get('title');
  $article_created = $article->created;

  $article_alias = $article->get('alias');
  $article_introtext = $article->get('introtext');
  $article_fulltext = $article->get('fulltext');
  $author = $user->name;

  $db = &JFactory::getDBO();
  $id = JRequest::getString('id');
  $db->setQuery('SELECT #__categories.title FROM #__content, #__categories WHERE #__content.catid = #__categories.id AND #__content.id = '.$id);
  $category = $db->loadResult();
endif;





if ($this->params->get('headerBackgroundImage'))
{
	$background = 'style="background-image:url('.$this->params->get('headerBackgroundImage').');background-position:right;"';
} else {
  $background = 'style="background-color:'.$this->params->get('headerBackgroundColor').';background-position:right;"';
}

if ($this->params->get('bannerBackgroundImage'))
{
	$bannerBackground = 'style="background-image:url('.$this->params->get('bannerBackgroundImage').');background-position:right;"';
} else {
  $bannerBackground = 'style="background-color:'.$this->params->get('bannerBackgroundColor').';background-position:right;"';
}

if ($this->params->get('bannerFeaturedImage'))
{
	$featuredBackground = 'style="background-image:url('.$this->params->get('bannerFeaturedImage').');background-position:right;"';
} else {
  $featuredBackground = 'style="background-color:'.$this->params->get('bannerFeaturedColor').';background-position:right;"';
}



//if ($this->params->get('accessAccessibility'))
//{  $accessibilityLink = '<a class="skips" href="'.$this->params->get('accessAccessibility').'" accesskey="0">Skip to //Accessibility Instructions</a>';}
//else
//{  $accessibilityLink = '';}

//if ($this->params->get('accessHome'))
//{  $homeLink = '<a class="skips" href="'.$this->params->get('accessHome').'" accesskey="1">Skip to Home</a>';}
//else
//{  $homeLink = '';}

//if ($this->params->get('accessContent'))
//{  $contentLink = '<a class="skips" href="'.$this->params->get('accessContent').'" accesskey="R">Skip to Content</a>';}
//else
//{  $contentLink = '';}

//if ($this->params->get('accessFAQ'))
//{  $FAQLink = '<a class="skips" href="'.$this->params->get('accessFAQ').'" accesskey="5">Skip to FAQ</a>';}
//else
//{  $FAQLink = '';}

//if ($this->params->get('accessContact'))
//{  $contactLink = '<a class="skips" href="'.$this->params->get('accessContact').'" accesskey="C">Skip to Contact</a>';}
//else
//{  $contactLink = '';}

//if ($this->params->get('accessFeedback'))
//{  $feedbackLink = '<a class="skips" href="'.$this->params->get('accessFeedback').'" accesskey="K">Skip to Feedback</a>';}
//else
//{  $feedbackLink = '';}

//if ($this->params->get('accessSiteMap'))
//{  $sitemapLink = '<a class="skips" href="'.$this->params->get('accessSiteMap').'" accesskey="M">Skip to Site Map</a>';}
//else
//{  $sitemapLink = '';}

//if ($this->params->get('accessSearch'))
//{  $searchLink = '<a class="skips" href="'.$this->params->get('accessSearch').'" accesskey="S">Skip to Search</a>';}
//else
{  $searchLink = '';}
?>

<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="en" > <!--<![endif]-->

<head>
  <jdoc:include type="head" />
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="<?php echo 'templates/' . $this->template . '/js/vendor/modernizr.js'; ?>"></script>
</head>
<body>

   
   
   
   

<!-- top bar -->
<?php include_once JPATH_THEMES . '/' . $this->template . '/layouts/topbar.php'; ?>
    
<!-- masthead -->
<?php include_once JPATH_THEMES . '/' . $this->template . '/layouts/masthead.php'; ?>
 
<!-- banner -->
<?php include_once JPATH_THEMES . '/' . $this->template . '/layouts/banner.php'; ?>
    
<!-- auxiliary / breadcrumb -->
<?php include_once JPATH_THEMES . '/' . $this->template . '/layouts/breadcrumb.php'; ?>

<!-- contents -->
<?php include_once JPATH_THEMES . '/' .$this->template . '/layouts/contents.php'; ?>

<!-- agency footer -->
<?php //include_once JPATH_THEMES . '/' . $this->template . '/layouts/agencyfooter.php'; ?>

<!-- standard footer -->
<?php include_once JPATH_THEMES . '/' . $this->template .'/layouts/standardfooter.php'; ?>





<!--a href="#" class="scrollup">Scroll</a><a>Hello</a-->

<!-- JS Files -->
<script src="<?php echo 'templates/' . $this->template . '/js/vendor/jquery.js'; ?>"></script>
<script src="<?php echo 'templates/' . $this->template . '/js/foundation.min.js'; ?>"></script>

<script>
$(document).foundation('section').foundation('orbit', {
    animation: 'fade',
    timer_speed: 5000,
	pause_on_hover: true,
	resume_on_mouseout: true,
    bullets: false,
    variable_height: false,
  });
</script>

</body>

</html>