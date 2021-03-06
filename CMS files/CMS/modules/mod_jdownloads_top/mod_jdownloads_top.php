<?php
/**
* @version $Id: mod_jdownloads_top.php v3.2
* @package mod_jdownloads_top
* @copyright (C) 2014 Arno Betz
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author Arno Betz http://www.jDownloads.com
*
* This modul shows you the most recent downloads from the jDownloads component. 
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

require_once __DIR__ . '/helper.php';

    $database = JFactory::getDBO();
    JHtml::_('behavior.tooltip');
    $current_itemid = $app->input->get('Itemid');
    
    // get published root menu link
    $database->setQuery("SELECT id from #__menu WHERE link = 'index.php?option=com_jdownloads&view=categories' and published = 1");
    $root_itemid = $database->loadResult();

    $before                = trim($params->get( 'text_before' ) );
    $text_before           = modJdownloadsTopHelper::getOnlyLanguageSubstring($before);
    $after                 = trim($params->get( 'text_after' ) );
    $text_after            = modJdownloadsTopHelper::getOnlyLanguageSubstring($after);
    $cat_id                = trim($params->get( 'cat_id' ) );
    $sum_view              = intval(($params->get( 'sum_view' ) ));
    $sum_char              = intval(($params->get( 'sum_char' ) ));
    $short_char            = $params->get( 'short_char' ) ; 
    $short_version         = $params->get( 'short_version' );
    $detail_view           = $params->get( 'detail_view' ) ; 
    $view_hits             = $params->get( 'view_hits' ) ;
    $view_hits_same_line   = $params->get( 'view_hits_same_line' );
    $hits_label            = $params->get( 'hits_label' );
    $hits_alignment        = $params->get( 'hits_alignment' );
    $view_pics             = $params->get( 'view_pics' ) ;
    $view_pics_size        = $params->get( 'view_pics_size' ) ;
    $view_numerical_list   = $params->get( 'view_numerical_list' );
    $view_thumbnails       = $params->get( 'view_thumbnails' );
    $view_thumbnails_size  = $params->get( 'view_thumbnails_size' );
    $view_thumbnails_dummy = $params->get( 'view_thumbnails_dummy' );
    $hits_alignment        = $params->get( 'hits_alignment' ); 
    $cat_show              = $params->get( 'cat_show' );
    $cat_show_type         = $params->get( 'cat_show_type' );
    $cat_show_text         = $params->get( 'cat_show_text' );
    $cat_show_text         = modJdownloadsTopHelper::getOnlyLanguageSubstring($cat_show_text);
    $cat_show_text_color   = $params->get( 'cat_show_text_color' );
    $cat_show_text_size    = $params->get( 'cat_show_text_size' );
    $cat_show_as_link      = $params->get( 'cat_show_as_link' ); 
    $view_tooltip          = $params->get( 'view_tooltip' ); 
    $view_tooltip_length   = intval($params->get( 'view_tooltip_length' ) ); 
    $alignment             = $params->get( 'alignment' );
    
    $thumbfolder = JUri::base().'images/jdownloads/screenshots/thumbnails/';
    $thumbnail = '';
    $border = ''; 
    
    $cat_show_text = trim($cat_show_text);
    if ($cat_show_text) $cat_show_text = ' '.$cat_show_text.' ';

    if ($sum_view == 0) $sum_view = 5;
    $option = 'com_jdownloads';
        
    $files = modJdownloadsTopHelper::getList($params);

    if (!count($files)) {
	    return;
    }

    $moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

    require JModuleHelper::getLayoutPath('mod_jdownloads_top',$params->get('layout', 'default'));
?>