<?php
defined('_JEXEC') or die('Restricted acccess');

class F2C_Renderer
{
	var $config;
	var $formId;
	var $translatedFields;
	var $contentTypeSettings;
	var $classicLayout;
	
	function F2C_Renderer($formId, $translatedFields, $contentTypeSettings)
	{
		$this->config 				= F2cFactory::getConfig();
		$this->formId 				= $formId;
		$this->translatedFields		= $translatedFields;
		$this->contentTypeSettings	= $contentTypeSettings;
	}
	
	function renderField($field, $parms)
	{
		$F2C_FIELD_FUNCTION_MAPPING = array(F2C_FIELDTYPE_SINGLELINE => 'SingleLineText',
											F2C_FIELDTYPE_MULTILINETEXT => 'MultiLineText',
											F2C_FIELDTYPE_MULTILINEEDITOR => 'MultiLineEditor',
											F2C_FIELDTYPE_SINGLESELECTLIST => 'SingleSelectList', 
											F2C_FIELDTYPE_IMAGE => 'Image',
											F2C_FIELDTYPE_HYPERLINK => 'Hyperlink', 
											F2C_FIELDTYPE_INFOTEXT => 'InfoText');

		$fieldName 			= 't' . $field->id;
		$fieldDescription	= $this->_getFieldDescription($field);
		$functionName 		= '_render'.$F2C_FIELD_FUNCTION_MAPPING[$field->fieldtypeid];
				
		$fieldSettings = new JRegistry;
		$fieldSettings->loadString($field->settings);
		$field->settings = $fieldSettings;
		
		return $this->$functionName($field, $fieldName, $fieldDescription, $parms);
	}
	
	function renderHiddenField($name, $value)
	{
		return '<input type="hidden" name="'.$name.'" id="'.$name.'" value="'.F2C_Renderer::stringHTMLSafe($value).'">';
	}
		
	function _renderSingleLineText($field, $fieldName, $fieldDescription, $parms)
	{
		$html			= '';
		$value 			= $field->values['VALUE'];
		$size			= $field->settings->get('slt_size', $parms[0]);	
		$maxLength		= $field->settings->get('slt_max_length', $parms[1]);	
		$attributes		= $field->settings->get('slt_attributes');	

		$html .= '<div class="f2c_field">';			
		$html .= $this->_renderTextBox($fieldName, $value, $size, $maxLength, $attributes);
		$html .= $fieldDescription;
		$html .= $this->renderHiddenField('hid'.$fieldName, $field->internal['fieldcontentid']);
		$html .= '</div>';		

		return $html;
	}
		
	function _renderMultiLineText($field, $fieldName, $fieldDescription, $parms)
	{
		$html 					= '';
		$fieldHtml 				= '';
		$attribs				= '';
		$maxNumChars 			= (int)$field->settings->get('mlt_max_num_chars');		
		$value 					= $field->values['VALUE'];
		
		if(!$attribs)
		{
			$attribs = $parms[0];
			$attribs .= ' class="text_area"';			
		}
		
		$fieldHtml .= ' '.$attribs;
		
		if($maxNumChars)
		{
			if(function_exists('mb_substr_count') && function_exists('mb_substr') && function_exists('mb_strlen'))
			{
				$numNewLines = mb_substr_count($value, "\r\n", 'UTF-8');
				$charsRemaining = $maxNumChars + $numNewLines - mb_strlen($value, 'UTF-8');			
				$fieldValue = mb_substr($value, 0, $maxNumChars + $numNewLines, 'UTF-8');
			}
			else
			{
				$numNewLines = substr_count($value, "\r\n");
				$charsRemaining = $maxNumChars + $numNewLines - strlen($value);			
				$fieldValue = substr($value, 0, $maxNumChars + $numNewLines);
			}
			
			if($charsRemaining < 0)
			{
				$charsRemaining = 0;
			}
			
			$fieldHtml .= ' onKeyDown="F2C_limitTextArea(this.form.'.$fieldName.',this.form.'.$fieldName .'remLen,'.$maxNumChars.');" onKeyUp="F2C_limitTextArea(this.form.' . $fieldName . ',this.form.'.$fieldName .'remLen,'.$maxNumChars.');"';
		}

		$html .= '<div class="f2c_field">';	
		$html .= '<textarea name="'.$fieldName.'" id="'.$fieldName.'"'.$fieldHtml.'>'.$value.'</textarea>';
		
		if($maxNumChars)
		{
			$html .= '<br/><input readonly type="text" name="'.$fieldName .'remLen" size="6" maxlength="6" value="'.$charsRemaining.'"> '.Jtext::_('COM_FORM2CONTENT_CHARACTERS_LEFT');		
		}
		
		$html .= $fieldDescription;
		$html .= $this->renderHiddenField('hid'.$fieldName, $field->internal['fieldcontentid']);
		$html .= '</div>';
		
		return $html;
	}
	
	function _renderMultiLineEditor($field, $fieldName, $fieldDescription, $parms)
	{
		$editor	= JEditor::getInstance(JFactory::getConfig()->get('editor'));
		$value 	= $field->values['VALUE'];
		$html	= '';
		$width	= $parms[0];
		$height = $parms[1];
		$col	= $parms[2];
		$row	= $parms[3];
		
		$html .= '<div class="f2c_field" style="width:'.$width.'px;">';		
		$html .= $editor->display($fieldName, htmlspecialchars($value, ENT_COMPAT, 'UTF-8'), $width, $height, $col, $row);
		$html .= $fieldDescription;
		$html .= $this->renderHiddenField('hid'.$fieldName, $field->internal['fieldcontentid']);
		$html .= '</div>';
				
		return $html;
	}
	
	function _renderSingleSelectList($field, $fieldName, $fieldDescription, $parms)
	{
		$html			= '';
		$fieldValue		= $field->values['VALUE'];		
		$listOptions 	= null;

		$html .= '<div class="f2c_field">';				

		if($field->settings->get('ssl_show_empty_choice_text'))
		{
			$listOptions[] = JHTML::_('select.option', '', $field->settings->get('ssl_empty_choice_text'));
		}
			      				
		if(count((array)$field->settings->get('ssl_options')))
		{					
			foreach((array)$field->settings->get('ssl_options') as $key=>$value)
			{
				$listOptions[] = JHTML::_('select.option', $key, $value);  	
			}			
		}
		
		if((int)$field->settings->get('ssl_display_mode') == 0)
		{
			$html .= JHTMLSelect::genericlist($listOptions, $fieldName, '', 'value', 'text', $fieldValue);
		}
		else
		{  
			$html .= JHTMLSelect::radioList($listOptions, $fieldName, '', 'value', 'text', $fieldValue);
		}
		
		$html .= $fieldDescription;
		$html .= $this->renderHiddenField('hid'.$fieldName, $field->internal['fieldcontentid']);
		$html .= '</div>';
		
		return $html;
	}

	function _renderImage($field, $fieldName, $fieldDescription, $parms)
	{
		$html				= '';
		$imageHelper		= new F2C_Image();
		$uploadAttribs 		= 'class="inputbox"';
		$deleteAttribs 		= 'class="inputbox"';		
		$widthAltText		= $parms[0];
		$maxLengthAltText	= $parms[1];
		$widthTitle			= $parms[0];
		$maxLengthTitle		= $parms[1];

		$html .= '<div class="f2c_field">';		
		$html .= '<table><tr><td>&nbsp;</td><td>';
		$html .= '<input type="file" id="'.$fieldName.'_fileupload" name="'.$fieldName.'_fileupload" '.$uploadAttribs.'>&nbsp;';
		$html .= '<input type="button" class="btn" onclick="clearUpload(\''.$fieldName.'_fileupload\');return false;" value="'.Jtext::_('COM_FORM2CONTENT_CLEAR_FIELD').'" />&nbsp;';
		$html .= '<input type="checkbox" id="'.$fieldName.'_del" name="'.$fieldName.'_del" '.$deleteAttribs.'>&nbsp;'.Jtext::_('COM_FORM2CONTENT_DELETE_IMAGE');
		
		$html .= F2C_Renderer::renderHiddenField($fieldName . '_filename', $field->values['FILENAME']);
		$html .= $fieldDescription;
					
		$html .= '</td></tr>';
		
		$html .= '<tr><td>'.Jtext::_('COM_FORM2CONTENT_ALT_TEXT').':</td>';
		$html .= '<td>'.$this->_renderTextBox($fieldName.'_alt', $field->values['ALT'], $widthAltText, $maxLengthAltText, $field->settings->get('img_attributes_alt_text')).'</td></tr>';

		$html .= '<tr><td>'.Jtext::_('COM_FORM2CONTENT_TITLE').':</td>';
		$html .= '<td>'.$this->_renderTextBox($fieldName.'_title', $field->values['TITLE'], $widthTitle, $maxLengthTitle, $field->settings->get('img_attributes_title')).'</td></tr>';

		$html .= '<tr><td valign="top">'.Jtext::_('COM_FORM2CONTENT_PREVIEW').':</td><td>';

		if($field->values['FILENAME'])
		{
			$thumbSrc = Path::Combine(F2C_Image::GetThumbnailsUrl($field->projectid, $this->formId), $imageHelper->CreateThumbnailImageName($field->values['FILENAME'], $field->id));
			$html .= '<img id="'.$fieldName.'_preview" src="' . $thumbSrc . '" style="border: 1px solid #000000;">';
		}

		$html .= '</td></tr></table>';
		$html .= $this->renderHiddenField('hid'.$fieldName, $field->internal['fieldcontentid']);
		$html .= '</div>';
				
		return $html;		
	}
	
	function _renderHyperlink($field, $fieldName, $fieldDescription, $parms)
	{
		$html 			= '';
		$listTarget[] 	= JHTML::_('select.option', '_top', 'Parent window');
		$listTarget[] 	= JHTML::_('select.option', '_blank','New window');	

		$html .= '<div class="f2c_field">';		
		$html .= '<table><tr><td>'.Jtext::_('COM_FORM2CONTENT_URL').':</td><td>';
		$html .= $this->_renderTextBox($fieldName, $field->values['URL'], 40, 300, $field->settings->get('lnk_attributes_url')); 
		$html .= $fieldDescription;
		$html .= '</td></tr>';
		$html .= '<tr>';
		$html .= '<td>'.Jtext::_('COM_FORM2CONTENT_DISPLAY_AS').':</td>';
		$html .= '<td>'.$this->_renderTextBox($fieldName.'_display', $field->values['DISPLAY_AS'], 40, 100, $field->settings->get('lnk_attributes_display_as')).'</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>'.Jtext::_('COM_FORM2CONTENT_TITLE').':</td>';
		$html .= '<td>'.$this->_renderTextBox($fieldName.'_title', $field->values['TITLE'], 40, 100, $field->settings->get('lnk_attributes_title')).'</td>';		      							
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>'.Jtext::_('COM_FORM2CONTENT_TARGET').':</td>';	      							
		$html .= '<td>'.JHTMLSelect::genericlist($listTarget, $fieldName . '_target',$field->settings->get('lnk_attributes_target') ,'value', 'text', $field->values['TARGET']).'</td>';
		$html .= '</tr>';
		$html .= '</table>';
		$html .= $this->renderHiddenField('hid'.$fieldName, $field->internal['fieldcontentid']);
		$html .= '</div>';

		return $html;
	}
	
	function _renderInfoText($field, $fieldName, $fieldDescription, $parms)
	{
		$html = '';
	
		$html .= '<div class="f2c_field">';		
		$html .= $field->settings->get('inf_text') . $fieldDescription;		
		$html .= '</div>';
		
		return $html;
	}

	function _renderTextBox($name, $value = '', $size = '', $maxlength = '', $tags = '')
	{
		$html 	= '';
		$class 	= ($tags) ? '' : 'class="inputbox"';
		
		$html .= '<input type="text" '.$class.' name="'.$name.'" id="'.$name.'"';
		$html .= ($value != '') ? ' value= "' . F2C_Renderer::stringHTMLSafe($value) . '"' : '';
		$html .= $size ? ' size= "' . $size . '"' : '';
		$html .= $maxlength ? ' maxlength= "' . $maxlength . '"' : '';
		$html .= $tags . '/>';
		
		return $html;
	}
	
	function _detectUTF8($string)
	{
	    return preg_match('%(?:
	        [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
	        |\xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
	        |[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} # straight 3-byte
	        |\xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
	        |\xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
	        |[\xF1-\xF3][\x80-\xBF]{3}         # planes 4-15
	        |\xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
	        )+%xs', 
	    $string);
	}

	function stringHTMLSafe($string)
	{
		if(F2C_Renderer::_detectUTF8($string))
		{
			$safeString = htmlentities($string, ENT_COMPAT, 'UTF-8');
		}
		else
		{
			$safeString = htmlentities($string, ENT_COMPAT);
		}
		
		return $safeString;
	}
	
	function _getFieldDescription($field)
	{
		$fieldLabel = $field->title;
		$fieldDescription = $field->description;				
		
		if($fieldDescription)
		{
			$fieldDescription = '&nbsp;' . JHTML::tooltip($fieldDescription, $fieldLabel);				
		}
		
		return $fieldDescription;		
	}
	
	function renderFieldLabel($field)
	{
		$label = '';
		
		if($field->fieldtypeid != F2C_FIELDTYPE_INFOTEXT)
		{ 
			$labelText = $field->title; 
			$label = '<label for="t'.$field->id.'">'.$labelText.'</label>';
		}
		
		return $label; 
	}
}
?>