<?php
/**
 * @package jDownloads
 * @version 2.5  
 * @copyright (C) 2007 - 2013 - Arno Betz - www.jdownloads.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.txt
 * 
 * jDownloads is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */
 
defined('_JEXEC') or die('Restricted access');

global $jlistConfig;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.calendar');
JHtml::_('behavior.formvalidation');

jimport( 'joomla.html.html.tabs' );

// Create shortcuts
$params = $this->state->get('params');
$rules = $this->get('user_rules');
$limits = $this->get('user_limits');

    if (!is_null($this->item->file_id)){
        $new = false;  
    } else {
        $new = true;  
    }
    
    // This checks if the editor config options have ever been saved. If they haven't they will fall back to the original settings.
    $editoroptions = isset($params->show_publishing_options);
    if (!$editoroptions):
	    $params->show_urls_images_frontend = '0';
    endif;
    ?>

    <script type="text/javascript">
	    Joomla.submitbutton = function(task) {
		    if (task == 'download.cancel' || document.formvalidator.isValid(document.id('adminForm'))) {
			    Joomla.submitform(task);
		    } else {
			    alert('<?php echo $this->escape(JText::_('COM_JDOWNLOADS_VALIDATION_FORM_FAILED'));?>');
		    }
	    }
        
        // get the selected file name to view the file type pic new
        function getSelectedText( frmName, srcListName ) 
        {
            var form = eval( 'document.' + frmName );
            var srcList = eval( 'form.' + srcListName );

            i = srcList.selectedIndex;
            if (i != null && i > -1) {
                return srcList.options[i].text;
            } else {
                return null;
            }
        }
        
        function editFilename(){
             document.getElementById('jform_url_download').readOnly = false;
             document.getElementById('jform_url_download').focus();
        }

        function editFilenamePreview(){
             document.getElementById('jform_preview_filename').readOnly = false;
             document.getElementById('jform_preview_filename').focus();
        }                   
    </script>
    
<div class="edit jd-item-page<?php echo $this->pageclass_sfx; ?>">

    <?php if ($params->get('show_page_heading')) : ?>
        <h1>
	        <?php echo $this->escape($params->get('page_heading')); ?>
        </h1>
    <?php endif; ?>

    <?php 
    if ($rules->uploads_form_text){
        echo JDHelper::getOnlyLanguageSubstring($rules->uploads_form_text);
    } ?> 
    
    <form action="<?php echo JRoute::_('index.php?option=com_jdownloads&a_id='.(int) $this->item->file_id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data" accept-charset="utf-8">
            
            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo ($rules->uploads_maxfilesize_kb * 1024); ?>" />
            
        <fieldset>
                <?php echo JText::_('COM_JDOWNLOADS_BACKEND_FILESEDIT_FIELD_INFO') ?> 
                <div class="formelm-buttons">

                <button type="button" onclick="Joomla.submitbutton('download.save')">
                    <?php echo JText::_('COM_JDOWNLOADS_SAVE') ?>
                </button>

                <button type="button" onclick="Joomla.submitbutton('download.cancel')">
                    <?php echo JText::_('COM_JDOWNLOADS_CANCEL') ?>
                </button>

                <?php if (!$new && ($this->item->params->get('access-delete') == true)): ?>):?>
                    <button type="button" onclick="Joomla.submitbutton('download.delete')">
                        <?php echo JText::_('COM_JDOWNLOADS_DELETE') ?>
                    </button>
                <?php endif; ?>
                </div>
                
		    <legend>
             <?php if (!$new){ ?> 
                <?php echo JText::_('COM_JDOWNLOADS_EDIT_DOWNLOAD'); ?>
             <?php } else { ?>
                <?php echo JText::_('COM_JDOWNLOADS_ADD_NEW_DOWNLOAD'); ?>
             <?php } ?>                
             </legend>
                
			    <div class="formelm">
			        <?php echo $this->form->getLabel('file_title'); ?>
			        <?php echo $this->form->getInput('file_title'); ?>
			    </div>

            <?php if ($rules->form_alias):?>
                <?php if ($new):?>
			        <div class="formelm">
			            <?php echo $this->form->getLabel('file_alias'); ?>
			            <?php echo $this->form->getInput('file_alias'); ?>
			        </div>
		        <?php endif; ?>
            <?php endif; ?>                
            
            <?php if ($rules->form_version):?>
                <div class="formelm">
                    <?php echo $this->form->getLabel('release'); ?>
                    <?php echo $this->form->getInput('release'); ?>
                </div>
            <?php endif; ?>
                        
            <?php if ($rules->form_update_active):?>
                <div class="formelm">
                    <?php echo $this->form->getLabel('update_active'); ?>
                    <?php echo $this->form->getInput('update_active'); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($rules->form_file_language || $rules->form_file_system):?>
                <div>
                    <span style="margin:15px;"></span>
                </div>
            
                <?php if ($rules->form_file_language):?>
                    <div class="formelm">
                        <?php echo $this->form->getLabel('file_language'); ?>
                        <?php echo $this->form->getInput('file_language'); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($rules->form_file_system):?>            
                    <div class="formelm">
                        <?php echo $this->form->getLabel('system'); ?>
                        <?php echo $this->form->getInput('system'); ?>
                    </div>
                <?php endif; ?>
            <div>
                <span style="margin:15px;"></span>
            </div>            
            <?php endif; ?>
            
            <?php if ($rules->form_license):?>             
                <div class="formelm">
                    <?php echo $this->form->getLabel('license'); ?>
                    <?php echo $this->form->getInput('license'); ?>
                </div>                        
            <?php endif; ?>

            <?php if ($rules->form_confirm_license):?>                         
                <div class="formelm">
                    <?php echo $this->form->getLabel('license_agree'); ?>
                    <?php echo $this->form->getInput('license_agree'); ?>
                </div>                        
            <?php endif; ?>
                                    
       </fieldset> 

       <?php echo JHtml::_('tabs.start', 'jdlayout-sliders-'.$this->item->file_id, array('useCookie'=>1)); 
       ?>      
                        
<!-- Description TAB -->      
      
      <?php 
        if ($rules->form_short_desc || $rules->form_long_desc){
            echo JHtml::_('tabs.panel', JText::_('COM_JDOWNLOADS_FORM_LABEL_DESCRIPTIONS'),'descriptions');
      ?> 
        <fieldset>
            <legend><?php echo JText::_('COM_JDOWNLOADS_FORM_LABEL_DESCRIPTIONS'); ?></legend>

            <?php if ($rules->form_short_desc):?>
                <label><?php echo '<b>'.$this->form->getLabel('description').'</b>'; ?></label>
                <?php echo $this->form->getInput('description'); ?>
                <div style="clear:both"></div>
                <br />
            <?php endif; ?>
            
            <?php if ($rules->form_long_desc):?>
                <label><?php echo '<b>'.$this->form->getLabel('description_long').'</b>'; ?></label>
                <?php echo $this->form->getInput('description_long'); ?>
            <?php endif; ?>
      </fieldset>      
      <?php
           }
           echo JHtml::_('tabs.panel', JText::_('COM_JDOWNLOADS_FORM_LABEL_TAB_PUBLISHING'),'publishing');
      ?>

<!-- Publishing TAB -->                        
        
        <fieldset>
            <legend><?php echo JText::_('COM_JDOWNLOADS_FORM_LABEL_PUBLISHING'); ?></legend>

                <div class="formelm">
                    <?php echo $this->form->getLabel('cat_id'); ?>
                    <span class="category">
                    <?php echo $this->form->getInput('cat_id'); ?>
                    </span>
                </div>
           
            <?php if ($this->item->params->get('access-change') || $this->item->params->get('access-create') || $this->item->params->get('access-edit')): ?>
                <?php if ($rules->form_access):?>
                    <div class="formelm">
                        <?php echo $this->form->getLabel('access'); ?>
                        <?php echo $this->form->getInput('access'); ?>
                    </div>
            <?php endif; ?>

            <?php if ($rules->form_language):?>                        
                <div class="formelm">
                    <?php echo $this->form->getLabel('language'); ?>
                    <?php echo $this->form->getInput('language'); ?>
                </div>
                <div>
                    <span style="margin:15px;"></span>
                </div> 
            <?php endif; ?>            
        <?php endif; ?>            
            
        <?php if ($this->item->params->get('access-change') || $this->item->params->get('access-create') || $this->item->params->get('access-edit')): ?>
            <?php if ($rules->form_published):?>
                <div class="formelm">
                    <?php echo $this->form->getLabel('published'); ?>
                    <?php echo $this->form->getInput('published'); ?>
                </div>
            <?php endif; ?>            
        <?php endif; ?>            
            
            <?php if ($rules->form_creation_date):?>
                <div class="formelm">
                    <?php echo $this->form->getLabel('date_added'); ?>
                    <?php echo $this->form->getInput('date_added'); ?>
                </div>
            <?php endif; ?>            

            <?php if ($rules->form_modified_date):?>
                <div class="formelm">
                    <?php echo $this->form->getLabel('modified_date'); ?>
                    <?php echo $this->form->getInput('modified_date'); ?>
                </div>
                <div>
                    <span style="margin:15px;"></span>
                </div>             
            <?php endif; ?>            
            
        <?php if ($this->item->params->get('access-change') || $this->item->params->get('access-create') || $this->item->params->get('access-edit')): ?>
                    
            <?php if ($rules->form_timeframe):?>
                <div class="formelm">
                    <?php echo $this->form->getLabel('use_timeframe'); ?>
                    <?php echo $this->form->getInput('use_timeframe'); ?>
                </div>

                <div class="formelm">
                    <?php echo $this->form->getLabel('publish_from'); ?>
                    <?php echo $this->form->getInput('publish_from'); ?>
                </div>
                
                <div class="formelm">
                    <?php echo $this->form->getLabel('publish_to'); ?>
                    <?php echo $this->form->getInput('publish_to'); ?>
                </div>
                <div>
                    <span style="margin:15px;"></span>
                </div> 
            <?php endif; ?>            

            <?php if ($rules->form_views):?>                
                <div class="formelm">
                    <?php echo $this->form->getLabel('views'); ?>
                    <?php echo $this->form->getInput('views'); ?>
                </div>
            <?php endif; ?>            

            <?php if ($rules->form_downloaded):?>            
                <div class="formelm">
                    <?php echo $this->form->getLabel('downloads'); ?>
                    <?php echo $this->form->getInput('downloads'); ?>
                </div>
            <?php endif; ?>            
                                    
        <?php endif; ?>

            <?php if ($rules->form_ordering):?> 
                <?php if ($new){?>
                    <div class="form-note">
                          <p><?php echo JText::_('COM_JDOWNLOADS_FORM_ORDERING'); ?></p>
                    </div>
                <?php } else { ?>
                    <div class="formelm">
                        <?php echo $this->form->getLabel('ordering'); ?>
                        <?php echo $this->form->getInput('ordering'); ?>
                    </div>
                <?php } ?>
            <?php endif; ?>

        </fieldset>      
      
<!-- Additional TAB --> 


<!-- Files TAB -->

      <?php 
       echo JHtml::_('tabs.panel', JText::_('COM_JDOWNLOADS_FORM_LABEL_TAB_FILES'),'files');
      ?>        

        <fieldset>
           <legend><?php echo JText::_('COM_JDOWNLOADS_FORM_LABEL_FILES'); ?></legend>
        
           <?php
           if ($rules->form_select_main_file){
                if ($this->item->url_download != ''){ ?> 
                <div class="formelm">
                    <?php echo $this->form->getLabel('url_download'); ?>
                    <?php echo $this->form->getInput('url_download'); ?>
                    <span>
                        &nbsp;<input type="button" value="" class="button_rename" title="<?php echo JText::_('COM_JDOWNLOADS_FORM_RENAME_FILE_LABEL'); ?>" name="activateFileNameField" onClick="editFilename();" >&nbsp;
                        <?php echo ' <a href="index.php?option=com_jdownloads&amp;task=download.deletefile&amp;id='.$this->item->file_id.'"><img src="'.JURI::root().'administrator/components/com_jdownloads/assets/images/'.'delete.png'.'" width="18px" height="18px" border="0" style="vertical-align:middle;" alt="'.JText::_('COM_JDOWNLOADS_FORM_DELETE_FILE_LABEL').'" title="'.JText::_('COM_JDOWNLOADS_FORM_DELETE_FILE_LABEL').'" /></a>'; ?>
                    </span>
                </div>        
           <?php }                               
           } ?>
           
           <?php if ($rules->form_select_main_file):?> 
                <div class="formelm">
                    <?php echo $this->form->getLabel('file_upload'); ?>
                    <?php echo $this->form->getInput('file_upload'); ?>
                </div>
                <div class="formelm">
                <label></label>
                    <?php echo '<small>'.JText::_('COM_JDOWNLOADS_BACKEND_FILESEDIT_ALLOWED_FILETYPE').' '.str_replace(',', ', ', $rules->uploads_allowed_types).'</small><br />'; ?>
                <label></label>
                    <?php echo '<small>'.JText::_('COM_JDOWNLOADS_BACKEND_FILESEDIT_ALLOWED_MAX_SIZE').' '.$rules->uploads_maxfilesize_kb.' KB</small>'; ?>
                </div>
                <div>
                    <span style="margin:15px;"></span>
                </div>              
            <?php endif; ?>
            
           <?php if ($rules->form_file_size):?>             
                <div class="formelm">
                    <?php echo $this->form->getLabel('size'); ?>
                    <?php echo $this->form->getInput('size'); ?>
                </div>
            <?php endif; ?>
                        
           <?php if ($rules->form_file_date):?> 
                <div class="formelm">
                    <?php echo $this->form->getLabel('file_date'); ?>
                    <?php echo $this->form->getInput('file_date'); ?>
                </div>              
                <div>
                    <span style="margin:15px;"></span>
                </div>              
            <?php endif; ?>

            
            <?php if ($rules->form_select_preview_file && $this->item->preview_filename != ''):?>
                <div class="formelm">
                    <?php echo $this->form->getLabel('preview_filename'); ?>
                    <?php echo $this->form->getInput('preview_filename'); ?>
                    <span>
                        &nbsp;<input type="button" value="" class="button_rename" title="<?php echo JText::_('COM_JDOWNLOADS_FORM_RENAME_FILE_LABEL'); ?>" name="activateFilePrevNameField" onClick="editFilenamePreview();" >&nbsp;
                        <?php echo ' <a href="index.php?option=com_jdownloads&amp;task=download.deletefile&amp;id='.$this->item->file_id.'&amp;type=prev"><img src="'.JURI::root().'administrator/components/com_jdownloads/assets/images/'.'delete.png'.'" width="18px" height="18px" border="0" style="vertical-align:middle;" alt="'.JText::_('COM_JDOWNLOADS_FORM_DELETE_FILE_LABEL').'" title="'.JText::_('COM_JDOWNLOADS_FORM_DELETE_FILE_LABEL').'" /></a>'; ?>
                    </span>                    
                </div>        
            <?php endif;?>            
            
            <?php if ($rules->form_select_preview_file):?>            
                <div class="formelm">
                    <?php echo $this->form->getLabel('preview_file_upload'); ?>
                    <?php echo $this->form->getInput('preview_file_upload'); ?>
                </div>
                <div class="formelm">
                <label></label>
                    <?php echo  '<small>'.JText::_('COM_JDOWNLOADS_BACKEND_FILESEDIT_ALLOWED_FILETYPE').' '.str_replace(',', ', ', $rules->uploads_allowed_preview_types).'</small><br />'; ?>
                <label></label>
                    <?php echo  '<small>'.JText::_('COM_JDOWNLOADS_BACKEND_FILESEDIT_ALLOWED_MAX_SIZE').' '.$rules->uploads_maxfilesize_kb.' KB</small>'; ?>
                </div>        
                <div>
                    <span style="margin:15px;"></span>
                </div>             
            <?php endif;?>                                        
        </fieldset>

        <?php if ($rules->form_external_file):?>
            <fieldset>
               <legend><?php echo JText::_('COM_JDOWNLOADS_FORM_LABEL_EXTERNAL'); ?></legend>        
            
                <div class="formelm">
                    <?php echo $this->form->getLabel('extern_file'); ?>
                    <?php echo $this->form->getInput('extern_file'); ?>
                </div>          
            
                <div class="formelm">
                    <?php echo $this->form->getLabel('extern_site'); ?>
                    <?php echo $this->form->getInput('extern_site'); ?>
                </div>          
            </fieldset>        
        <?php endif; ?>        
        
        <?php if ($rules->form_mirror_1):?>
                <fieldset>
                   <legend><?php echo JText::_('COM_JDOWNLOADS_FORM_LABEL_MIRRORS_1'); ?></legend>             
                
                    <div class="formelm">
                        <?php echo $this->form->getLabel('mirror_1'); ?>
                        <?php echo $this->form->getInput('mirror_1'); ?>
                    </div>          
                
                    <div class="formelm">
                        <?php echo $this->form->getLabel('extern_site_mirror_1'); ?>
                        <?php echo $this->form->getInput('extern_site_mirror_1'); ?>
                    </div>         
                    <div>
                        <span style="margin:15px;"></span>
                    </div>  
                
                </fieldset>
        <?php endif; ?>                    

        <?php if ($rules->form_mirror_2):?>
                <fieldset>
                   <legend><?php echo JText::_('COM_JDOWNLOADS_FORM_LABEL_MIRRORS_2'); ?></legend>             
                
                    <div class="formelm">
                        <?php echo $this->form->getLabel('mirror_2'); ?>
                        <?php echo $this->form->getInput('mirror_2'); ?>
                    </div>          
                
                    <div class="formelm">
                        <?php echo $this->form->getLabel('extern_site_mirror_2'); ?>
                        <?php echo $this->form->getInput('extern_site_mirror_2'); ?>
                    </div>         
                
                    <div>
                        <span style="margin:15px;"></span>
                    </div>  
                </fieldset> 
        <?php endif; ?> 
        
<!-- Images TAB -->      

       <?php if ($rules->form_images){ 
                echo JHtml::_('tabs.panel', JText::_('COM_JDOWNLOADS_FORM_LABEL_TAB_IMAGES'),'images');
       ?>   

                <fieldset>
                   <legend><?php echo JText::_('COM_JDOWNLOADS_FORM_LABEL_TAB_IMAGES'); ?></legend>
                
                    <?php $image_id = 0; ?>
                    <?php if ($this->item->images){ ?>    
                        <table class="admintable" width="100%" border="0" cellpadding="0" cellspacing="10">
                        <tr><td><?php if ($this->item->images) echo JText::_('COM_JDOWNLOADS_THUMBNAIL_LIST_INFO'); ?></td></tr>
                        <tr>
                        <td valign="top">
                        <?php 
                        // display the selected images
                        
                        if ($this->item->images){
                            $images = array();
                            $images = explode("|", $this->item->images);
                            echo '<ul style="list-style-type: none; margin: 0px 0 0 0; padding: 0; width: 350px; overflow: visible;" id="displayimages">';
                            foreach ($images as $image){
                                 $image_id ++;
                                 echo '<li id="'.$image.'">';
                                 echo '<input style="position:relative;
                                        left: 7px;
                                        top: 15px;
                                        vertical-align: top;
                                        z-index: 1;
                                        margin: 0;
                                        padding: 0;" type="checkbox" name="keep_image['.$image_id.']" value="'.$image.'" checked />';
                                 echo '<a href="'.JURI::root().'images/jdownloads/screenshots/'.$image.'" target="_blank">';
                                 
                                 echo '<img border="0" style="position:relative;border:1px solid black; max-width:100px; max-height:100px;" align="middle" src="'.JURI::root().'images/jdownloads/screenshots/thumbnails/'.$image.'" alt="'.$image.'" title="'.$image.'" />';
                                 echo '</a>';
                                 echo '</li>';                         
                            }
                            echo '</ul>'; 
                        }
                        ?>
                        </td>
                        </tr>
                        </table>                
                    <?php } ?>
                         
                    <?php 
                    if ($image_id < (int)$rules->uploads_max_amount_images){ ?>
                             <br />
                             <label>
                             <?php  echo JHtml::_('tooltip', JText::_('COM_JDOWNLOADS_FORM_IMAGE_UPLOAD_DESC'), JText::_('COM_JDOWNLOADS_FORM_IMAGE_UPLOAD_LABEL').'<br />'.JText::sprintf('COM_JDOWNLOADS_LIMIT_IMAGES_MSG', $rules->uploads_max_amount_images), '', JText::_('COM_JDOWNLOADS_FORM_IMAGE_UPLOAD_LABEL').'<br />'.JText::sprintf('COM_JDOWNLOADS_LIMIT_IMAGES_MSG', $rules->uploads_max_amount_images) ); ?>
                             </label>
                            <table id="files_table" class="admintable" border="0" cellpadding="0" cellspacing="10">
                            <tr id="new_file_row">
                            <td class=""><input type="file" name="file_upload_thumb[0]" id="file_upload_thumb[0]" size="40" readonly="readonly" accept="image/gif,image/jpeg,image/jpg,image/png" onchange="add_new_image_file(this)" />
                            </td>
                            </tr>
                            </table> 
                     <?php
                     } else { 
                            // limit is reached - display a info message 
                            echo '<p>'.JText::_('COM_JDOWNLOADS_LIMIT_IMAGES_REACHED_MSG').'</p>'; 
                     }?>        
                </fieldset>      
              
      <?php } else {
               $image_id = 0;
            } ?>
            
<!-- Metadata TAB -->      

       <?php
             if ($rules->form_meta_desc || $rules->form_meta_key || $rules->form_robots){ 
                 echo JHtml::_('tabs.panel', JText::_('COM_JDOWNLOADS_FORM_LABEL_TAB_META_DATA'),'meta');                 
       ?>   
	            <fieldset>
		            <legend><?php echo JText::_('COM_JDOWNLOADS_FORM_LABEL_META_DATA'); ?></legend>
		            
                    <?php if ($rules->form_meta_desc):?>
                        <div class="formelm-area">
		                    <?php echo $this->form->getLabel('metadesc'); ?>
		                    <?php echo $this->form->getInput('metadesc'); ?>
		                </div>
                    <?php endif; ?>
		            
                    <?php if ($rules->form_meta_key):?>
                        <div class="formelm-area">
		                    <?php echo $this->form->getLabel('metakey'); ?>
		                    <?php echo $this->form->getInput('metakey'); ?>
		                </div>
                    <?php endif; ?>

                    <?php if ($rules->form_robots):?>
                        <div class="formelm-area">
                            <?php echo $this->form->getLabel('robots'); ?>
                            <?php echo $this->form->getInput('robots'); ?>
                        </div>
                    <?php endif; ?>            
	            </fieldset>
       <?php }
                echo JHtml::_('tabs.end'); ?>

        <input type="hidden" name="task" value="" />
        <input type="hidden" name="view" value="form" />
        <input type="hidden" name="image_file_count" id="image_file_count" value="0" />         
        <input type="hidden" name="cat_dir_org" value="<?php echo $this->item->cat_id; ?>" />
        <input type="hidden" name="sum_listed_images" id="sum_listed_images" value="<?php echo (int)$image_id; ?>" />
        <input type="hidden" name="max_sum_images" id="max_sum_images" value="<?php echo (int)$rules->uploads_max_amount_images; ?>" /> 
        <input type="hidden" name="filename" value="<?php echo $this->item->url_download; ?>" />        
        <input type="hidden" name="modified_date_old" value="<?php echo $this->item->modified_date; ?>" />
        <input type="hidden" name="submitted_by" value="<?php echo $this->item->submitted_by; ?>" />
        <input type="hidden" name="set_aup_points" value="<?php echo $this->item->set_aup_points; ?>" />
        <input type="hidden" name="filename_org" value="<?php echo $this->item->url_download; ?>" />          
        <input type="hidden" name="preview_filename_org" value="<?php echo $this->item->preview_filename; ?>" />
        <input type="hidden" name="return" value="<?php echo $this->return_page;?>" /> 

        <?php echo JHtml::_('form.token'); ?>
    </form>
</div>