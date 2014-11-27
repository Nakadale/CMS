<?php
/**
* @version $Id: mod_jdownloads_latest.php v2.0
* @package mod_jdownloads_latest
* @copyright (C) 2011 Arno Betz
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author Arno Betz http://www.jDownloads.com
*/

// this is a alternate layout without tables - it used only <div> tags

defined('_JEXEC') or die;

		echo '<div class="moduletable'.$moduleclass_sfx.'" style="padding: 5px;">';
		if ($text_before <> ''){
			echo '<div style="padding-bottom: 5px;">'.$text_before.'</div>';   
		}
		for ($i=0; $i<count($files); $i++) {
			$thumbnail = '';
            $version = $params->get('short_version', ''); 
			echo '<ul class="downloads">';
		    // add the creation date
			// jdownloads latest uses this version
            if ($view_date) {
                if ($files[$i]->date_added){
                    if ($view_date_same_line){
                        echo '<li style="padding-bottom: 3px; float:'.$date_alignment.';"><small>'.JHTML::date($files[$i]->date_added, $date_format).'</small></li>'; 
                    } else {
                        echo '<li style="padding-bottom: 3px; text-align:'.$date_alignment.';"><small>'.JHTML::date($files[$i]->date_added, $date_format).'</small></li>';
                    }
                }    
            } 
			
			
            // short the file title?
            if ($sum_char > 0){
				$gesamt = strlen($files[$i]->file_title) + strlen($files[$i]->release) + strlen($short_version) +1;
				if ($gesamt > $sum_char){
				   $files[$i]->file_title = JString::substr($files[$i]->file_title, 0, $sum_char).$short_char;
				   $files[$i]->release = '';
				}    
			} 
			
			// get for every item the menu link itemid when exists
            $database->setQuery("SELECT id from #__menu WHERE link = 'index.php?option=com_jdownloads&view=category&catid=".$files[$i]->cat_id."' and published = 1");
			$Itemid = $database->loadResult();
			if (!$Itemid){
				$Itemid = $root_itemid;
			}  

            // create the viewed category text
			if ($cat_show) {
				if ($cat_show_type == 'containing') {
					$database->setQuery('SELECT title FROM #__jdownloads_categories WHERE id = '.$files[$i]->cat_id);
					$cattitle = $database->loadResult();
					$cat_show_text2 = $cat_show_text.$cattitle;
				} else {
					$database->setQuery('SELECT cat_dir FROM #__jdownloads_categories WHERE id = '.$files[$i]->cat_id);
					$catdir = $database->loadResult();
					$cat_show_text2 = $cat_show_text.$catdir;
				}
			} else {
				$cat_show_text2 = '';
			}    
						   
			// create the link
            if ($detail_view == '1'){
				$link = JRoute::_('index.php?option='.$option.'&amp;view=download&catid='.$files[$i]->cat_id.'&id='.$files[$i]->file_id.'&amp;Itemid='.$Itemid);
			} else {    
				$link = JRoute::_('index.php?option='.$option.'&amp;view=category&catid='.$files[$i]->cat_id.'&amp;Itemid='.$Itemid);
			}    
			
            if (!$files[$i]->release) $version = '';
			
            // add mime file pic				
            $size = 0;
			$files_pic = '';
			$number = '';
			if ($view_pics){
				$size = (int)$view_pics_size;
				$files_pic = '<img src="'.JURI::base().'images/jdownloads/fileimages/'.$files[$i]->file_pic.'" align="top" width="'.$size.'" height="'.$size.'" border="0" alt="" /> '; 
			}
			if ($view_numerical_list){
				$num = $i+1;
				$number = "$num. ";
			}    
			
            // add description in tooltip
            if ($view_tooltip && $files[$i]->description){
				$link_text = '<a href="'.$link.'">'.JHTML::tooltip(strip_tags(substr($files[$i]->description,0,$view_tooltip_length)).$short_char,JText::_('MOD_JDOWNLOADS_LATEST_DESCRIPTION_TITLE'),$files[$i]->file_title.' '.$version.$files[$i]->release,$files[$i]->file_title.' '.$version.$files[$i]->release).'</a>';                
			} else {    
				$link_text = '<a href="'.$link.'">'.$files[$i]->file_title.' '.$version.$files[$i]->release.'</a>';
			}    
			echo '<div style="padding-bottom: 3px; text-align: '.$alignment.';">'.$number.$files_pic.$link_text.'</div>';

            // add the first download screenshot when exists and activated in options
            if ($view_thumbnails){
                if ($files[$i]->thumbnail){
                    $thumbnail = '<img class="img" src="'.$thumbfolder.$files[$i]->thumbnail.'" style="padding:5px;" width="'.$view_thumbnails_size.'" height="'.$view_thumbnails_size.'" border="'.$border.'" alt="'.$files[$i]->file_title.'" />';
                } else {
                    if ($view_thumbnails_dummy){
                        $thumbnail = '<img class="img" src="'.$thumbfolder.'no_pic.gif" style="padding:5px;" width="'.$view_thumbnails_size.'" height="'.$view_thumbnails_size.'" border="'.$border.'" alt="" />';
                    }    
                }
                if ($thumbnail) echo '<div style="padding-bottom: 3px;"'.$alignment.'">'.$thumbnail.'</div>';
            }
			
			
			// add category info
			if ($cat_show_text2) {
				if ($cat_show_as_link){
					echo '<li style="padding-bottom: 3px; text-align:'.$alignment.'; font-size:'.$cat_show_text_size.'; color:'.$cat_show_text_color.';"><a href="index.php?option='.$option.'&amp;view=category&catid='.$files[$i]->cat_id.'&amp;Itemid='.$Itemid.'">'.$cat_show_text2.'</a></li>';
				} else {    
					echo '<li style="padding-bottom: 3px; text-align:'.$alignment.'; font-size:'.$cat_show_text_size.'; color:'.$cat_show_text_color.';">'.$cat_show_text2.'</li>';
				}
			}

			echo '</ul>';
			
		}
		if ($text_after <> ''){
			echo '<div style="padding-top: 5px;">'.$text_after.'</div>';
		}
        echo '</div>';
        ?>