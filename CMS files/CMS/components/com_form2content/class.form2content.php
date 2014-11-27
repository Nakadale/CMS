<?php
defined('_JEXEC') or die('Restricted acccess');

class F2C_Image
{
	function F2C_Image()
	{
	}
	
	static function GetImagesUrl($projectId, $formId, $relative = false)
	{
		if($relative)
		{
			return "com_form2content/p$projectId/f$formId/" ;
		}
		else
		{
			return F2cUri::GetClientRoot()."images/stories/com_form2content/p$projectId/f$formId/" ;
		}
	}
	
	static function GetThumbnailsUrl($projectId, $formId, $relative = false)
	{
		return Path::Combine(F2C_Image::GetImagesUrl($projectId, $formId, $relative), 'thumbs');	
	}

	static function GetImagesRootPath($relative = false)
	{
		if($relative)
		{
			return 'com_form2content/';
		}
		else
		{
			return JPATH_SITE.DIRECTORY_SEPARATOR.'images/stories/com_form2content/';
		}				
	}
	
	static function GetImagesPath($projectId, $formId, $relative = false)
	{
		return Path::Combine(F2C_Image::GetImagesRootPath($relative), 'p'.$projectId.'/'.'f'.$formId);
	}

	static function GetThumbnailsPath($projectId, $formId, $relative = false)
	{
		return Path::Combine(F2C_Image::GetImagesPath($projectId, $formId, $relative), 'thumbs');	
	}

	static function CreateFullImageName($uploadFilename, $fieldId)
	{
		if(!$uploadFilename)
		{
			return '';
		}	
		
		return $fieldId . '.' . JFile::getExt($uploadFilename);
	}
	
	static function CreateThumbnailImageName($uploadFilename, $fieldId)
	{
		if(!$uploadFilename)
		{
			return '';
		}	
		
		return $fieldId . '.' . JFile::getExt($uploadFilename);		
	}	

	static function Delete($projectId, $formId, $filename)
	{
		// delete thumbnail
		$img = Path::Combine(self::GetThumbnailsPath($projectId, $formId), $filename);
	
		if(JFile::exists($img))
		{
			JFile::delete($img);
		}

		// delete image
		$img = Path::Combine(self::GetImagesPath($projectId, $formId), $filename);
	
		if(JFile::exists($img))
		{
			JFile::delete($img);
		}
	}

	static function deleteContentTypeFieldImages($ContentTypeFieldId)
	{
		$db = JFactory::getDBO(); 
	
		$sql =	"SELECT pfl.projectid, fct.formid, fct.content " .
				"FROM #__f2c_projectfields pfl " .
				"INNER JOIN #__f2c_fieldcontent fct ON pfl.id = fct.fieldid " .
				"WHERE pfl.fieldtypeid = " . F2C_FIELDTYPE_IMAGE . " AND pfl.id = $ContentTypeFieldId";

		$db->setQuery($sql);
		$rows = $db->loadObjectList();
		
		for ($i=0, $n=count($rows); $i < $n; $i++) 
		{
	  		$row =& $rows[$i];
			  		
	  		if($row->content)
	  		{
	  			$imageData = new JRegistry();
	  			$imageData->loadString($row->content);
	  		
	  			$imageFile = Path::Combine(F2C_Image::GetImagesPath($row->projectid, $row->formid), $imageData->get('filename'));
	  			$thumbNailFile = Path::Combine(F2C_Image::GetThumbnailsPath($row->projectid, $row->formid), $imageData->get('filename'));
	  		
	  			if(JFile::exists($imageFile)) JFile::delete($imageFile);
	  			if(JFile::exists($thumbNailFile)) JFile::delete($thumbNailFile);
	  		}
		}					
	}
}

class F2cFieldData
{
	var $id;
	var $fieldname;
	var $title;
	var $fieldtypeid;
	var $settings;
	var $description;
	var $projectid;
	var $ordering;
	var $frontvisible;
	var $values = array();
	var $internal = array();
}

class F2C_SaveEventArgs
{
	var $isNew = false;
	var $formOld = null;
	var $fieldsOld = null;
	var $formNew = null;
	var $fieldsNew = null;
}

class F2C_EventArgs
{
	var $action = null;
	var $isNew = false;
	var $form = null;
	var $fields = null;
	
	function F2C_EventArgs($action)
	{
		$this->action = $action;
	}
}
?>