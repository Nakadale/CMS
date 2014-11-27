<?php
defined('_JEXEC') or die('Restricted acccess');

require_once(JPATH_COMPONENT_SITE.DIRECTORY_SEPARATOR.'shared.form2content.php');

class F2C_Validation
{
	static function createDatePickerValidation($fieldId, $fieldLabel, $format, $displayFormat, $userField = true)
	{
		$script = 'if(!F2C_ValDateField(\''.$fieldId.'\', \''.$format.'\'))';
		$script .= '{ ';
		$script .= 'alert(\'' . sprintf(JText::_('COM_FORM2CONTENT_ERROR_DATE_FIELD_INCORRECT_DATE', true), $fieldLabel, $displayFormat) . '\'); ';
		$script .= 'return false; }';

		return $script;
	}
	
	static function valSizeImage($field)
	{
		$f2cConfig	= F2cFactory::getConfig();
		$uploadfile = JFactory::getApplication()->input->files->get('t'.$field->id.'_fileupload');
		
		if(array_key_exists('size', $uploadfile) && $uploadfile['size'])
		{
			$maxImageUploadSize = (int)$f2cConfig->get('max_image_upload_size');
		
			if($maxImageUploadSize != 0 && (int)($uploadfile['size']/1024) > $maxImageUploadSize)
			{
				return(JText::_('COM_FORM2CONTENT_ERROR_IMAGE_UPLOAD_MAX_SIZE_F2C_CONFIG'));
			}			
		}
		else if(array_key_exists('error', $uploadfile) && $uploadfile['error'] == 1)
		{
			return JText::_('COM_FORM2CONTENT_ERROR_IMAGE_UPLOAD_MAX_SIZE');
		}
		
		return '';		
	}
}
?>
