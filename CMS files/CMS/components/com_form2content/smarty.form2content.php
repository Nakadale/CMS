<?php
defined('_JEXEC') or die('Restricted acccess');

if (!class_exists('Smarty')) 
{
	require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_form2content'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'smarty'.DIRECTORY_SEPARATOR.'Smarty.class.php');
}

class F2C_Smarty
{
	var $templates;
	var $form;
	var $error = '';
	var $smarty = null;
	
	function F2C_Smarty()
	{
		$this->smarty 				= new Smarty();
		$this->smarty->template_dir = F2cFactory::getConfig()->get('template_path');
		$this->smarty->compile_dir 	= JFactory::getConfig()->get('tmp_path');
	}

	function parseIntro()
	{
		$parsedContent = $this->smarty->fetch($this->templates[F2C_TEMPLATE_INTRO]);		
		return $parsedContent;
	}

	function parseMain()
	{
		$parsedContent = '';
		
		if(array_key_exists(F2C_TEMPLATE_MAIN, $this->templates))
		{	
			$parsedContent = $this->smarty->fetch($this->templates[F2C_TEMPLATE_MAIN]);
		}
		
		return $parsedContent;
	}
	
	function addTemplate($templateName, $templateType)
	{
		if(!JFile::exists(Path::Combine(F2cFactory::getConfig()->get('template_path'), $templateName)))
		{
			$this->error = JText::_('COM_FORM2CONTENT_ERROR_TEMPLATE_NOT_FOUND');
			return false;
		}
		
		$this->templates[$templateType] = $templateName;
		
		return true;	
	}

	function clearTemplates()
	{
		// No action necessary
	}
		
	function addVar($name, $value)
	{
		$this->smarty->assign(strtoupper($name), $value);		
	}
	
	function clearVar($name)
	{
		$this->smarty->clearAssign(strtoupper($name));
	}
	
	
	function clearAllVars()
	{
		$this->smarty->clearAllAssign();
	}
		
	function addFormVar($field)
	{
		$F2C_FIELD_FUNCTION_MAPPING = array(F2C_FIELDTYPE_SINGLELINE => 'SingleLineText',
											F2C_FIELDTYPE_MULTILINETEXT => 'MultiLineText',
											F2C_FIELDTYPE_MULTILINEEDITOR => 'MultiLineEditor',
											F2C_FIELDTYPE_SINGLESELECTLIST => 'SingleSelectList', 
											F2C_FIELDTYPE_IMAGE => 'Image',
											F2C_FIELDTYPE_HYPERLINK => 'Hyperlink', 
											F2C_FIELDTYPE_INFOTEXT => 'InfoText');

		$functionName 	= '_addVar'.$F2C_FIELD_FUNCTION_MAPPING[$field->fieldtypeid];
		$fieldData 		= count($field->values) ? $field->values : null;

		// Keep the title for backward compatibility
		$this->addVar($field->fieldname.'_TITLE', HtmlHelper::stringHTMLSafe($field->title));				
		$this->addVar($field->fieldname.'_CAPTION', HtmlHelper::stringHTMLSafe($field->title));				
		$this->addVar($field->fieldname.'_DESCRIPTION', HtmlHelper::stringHTMLSafe($field->description));				
		$this->$functionName($field, $fieldData);
	}
	
	private function _addVarSingleLineText($field, $data)
	{
		$this->addVar($field->fieldname, HtmlHelper::stringHTMLSafe($data['VALUE']));
	}
	
	private function _addVarMultiLineText($field, $data)
	{
		$this->addVar($field->fieldname, nl2br(HtmlHelper::stringHTMLSafe($data['VALUE'])));
		$this->addVar($field->fieldname .'_RAW', nl2br($data['VALUE']));
	}
		
	private function _addVarMultiLineEditor($field, $data)
	{
		$this->addVar($field->fieldname, $data['VALUE']);
	}
		
	private function _addVarSingleSelectList($field, $data)
	{
		$options 	= (array)$field->settings->get('ssl_options');
		$fieldText 	= '';					
		$fieldValue	= '';					
		
		if($data['VALUE'])
		{
			$fieldValue = $data['VALUE'];
			
			// TODO: why doesn't array_key_exists work here?
			foreach($options as $key => $value)
			{
				if($key == $fieldValue)
				{
					$fieldText = $value;
					break;
				}
			}
		}
			
		$this->addVar($field->fieldname, $fieldValue);
		$this->addVar($field->fieldname.'_TEXT', $fieldText);
	}

	private function _addVarImage($field, $data)
	{
		if($data['FILENAME'])
		{
			if($field->settings->get('img_output_mode') == 0)
			{				
				$this->addVar($field->fieldname, F2C_Image::GetImagesUrl($this->form->projectid, $this->form->id) . $data['FILENAME']);						
			}
			else
			{
				$tagWidth = ($data['WIDTH'] > 0) ? ' width="'.$data['WIDTH'].'"' : '';
				$tagHeight = ($data['HEIGHT'] > 0) ? ' height="'.$data['HEIGHT'].'"' : '';
				$this->addVar($field->fieldname, '<img src="' . F2C_Image::GetImagesUrl($this->form->projectid, $this->form->id) . $data['FILENAME'] . '" alt="' . $data['ALT'] . '" title="' . $data['TITLE'] . '"' . $tagWidth . $tagHeight . '/>');
			}

			// add image urls
			$this->addVar($field->fieldname.'_PATH_ABSOLUTE', Path::Combine(F2C_Image::GetImagesPath($this->form->projectid, $this->form->id, false), $data['FILENAME']));
			$this->addVar($field->fieldname.'_PATH_RELATIVE', Path::Combine(F2C_Image::GetImagesPath($this->form->projectid, $this->form->id, true), $data['FILENAME']));
			
			// add thumbnail urls
			$this->addVar($field->fieldname.'_THUMB_URL_ABSOLUTE', Path::Combine(F2C_Image::GetThumbnailsUrl($this->form->projectid, $this->form->id), $data['FILENAME']));
			$this->addVar($field->fieldname.'_THUMB_URL_RELATIVE', Path::Combine(F2C_Image::GetThumbnailsUrl($this->form->projectid, $this->form->id, true), $data['FILENAME']));			
		}
		else
		{
			// no image was specified
			$this->addVar($field->fieldname, '');
			$this->addVar($field->fieldname.'_PATH_ABSOLUTE', '');
			$this->addVar($field->fieldname.'_PATH_RELATIVE', '');
			$this->addVar($field->fieldname.'_THUMB_URL_ABSOLUTE', '');
			$this->addVar($field->fieldname.'_THUMB_URL_RELATIVE', '');
		}

		$this->addVar($field->fieldname.'_ALT', HtmlHelper::stringHTMLSafe($data['ALT']));					
		$this->addVar($field->fieldname.'_TITLE', HtmlHelper::stringHTMLSafe($data['TITLE']));					
	}
	
	private function _addVarHyperlink($field, $data)
	{
		$linkTitle = '';
		$linkTarget = '';
		$linkDisplay = '';
		$linkUrl = '';
		
		if($data['URL'])
		{
			$display = $data['DISPLAY_AS'] ? $data['DISPLAY_AS'] : $data['URL'];
			$linkTitle 		= $data['TITLE'];
			$linkTarget 	= $data['TARGET'];
			$linkDisplay 	= $data['DISPLAY_AS'];
			$linkUrl 		= $data['URL'];
			
			if($field->settings->get('lnk_add_http_prefix', 0))
			{
				if(!strstr($linkUrl, '://'))
				{
					$linkUrl = 'http://' . $linkUrl;
				}
			}
			
			if($field->settings->get('lnk_output_mode') == 0)
			{
				$linkTag = $linkUrl;
			}
			else
			{
				$linkTag = '<a href="' . $linkUrl . '" target="' . $data['TARGET'] . '" title="' . $data['TITLE'] . '">' . $display . '</a>';					
			}
			
			$this->addVar($field->fieldname, $linkTag);
		}
		else
		{
			$this->addVar($field->fieldname, '');
		}
		
		$this->addVar($field->fieldname.'_URL', $linkUrl);		
		$this->addVar($field->fieldname.'_TITLE', $linkTitle);		
		$this->addVar($field->fieldname.'_TARGET', $linkTarget);		
		$this->addVar($field->fieldname.'_DISPLAY', $linkDisplay);					
	}
	
	private function _addVarInfoText($field, $data)
	{
		// Nothing to parse		
		$this->addVar($field->fieldname, '');		
	}
	
	function getTemplateVars($formVars, &$usedVars)
	{
		foreach($this->templates as $templateName)
		{
			$this->_getTemplateVars($templateName, $formVars, $usedVars);
		}
	}
	
	function _getTemplateVars($templateName, $formVars, &$usedVars)
	{
		$contents = file_get_contents(Path::Combine(F2cFactory::getConfig()->get('template_path'), $templateName));

		// check which vars are used within the template
		foreach($formVars as $formVarAlias => $formVarName)
		{
			if(strpos($contents, '{$'.$formVarAlias.'}') !== false)
			{
				$usedVars[] = strtoupper($formVarName);
			}

			if(strpos($contents, '{$'.$formVarAlias.'|') !== false)
			{
				$usedVars[] = strtoupper($formVarName);
			}
		}		
	} 	
}
?>