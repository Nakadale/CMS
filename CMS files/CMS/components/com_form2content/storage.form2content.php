<?php
defined('_JEXEC') or die('Restricted acccess');

class F2cFieldContent
{
	var $id;
	var $attribute;
	var $content;
	var $action;
	
	function F2cFieldContent($id, $attribute, $content, $action)
	{
		$this->id 			= $id;
		$this->attribute 	= $attribute;
		$this->content 		= $content;
		$this->action		= $action;
	}
}

class F2cStorage
{
	var $formId;
	var $backEnd;
	var $isCron;
	var $db;
	var $F2C_FIELD_FUNCTION_MAPPING = array();
	var $preparedData 				= null;
	var $jinput;
	
	function F2cStorage($formId, $backEnd, $isCron = false)
	{
		$this->formId 	= $formId;
		$this->backEnd 	= $backEnd;
		$this->isCron 	= $isCron;
		$this->db		= JFactory::getDBO();
		$this->jinput	= JFactory::getApplication()->input;

		$this->F2C_FIELD_FUNCTION_MAPPING = array(F2C_FIELDTYPE_SINGLELINE => 'SingleLineText',
												  F2C_FIELDTYPE_MULTILINETEXT => 'MultiLineText',
												  F2C_FIELDTYPE_MULTILINEEDITOR => 'MultiLineEditor',
												  F2C_FIELDTYPE_SINGLESELECTLIST => 'SingleSelectList', 
												  F2C_FIELDTYPE_IMAGE => 'Image',
												  F2C_FIELDTYPE_HYPERLINK => 'Hyperlink',
												  F2C_FIELDTYPE_INFOTEXT => 'InfoText');		
	}
	
	function storeFields($fields)
	{
		foreach($fields as $field)
		{
			$this->storeField($field, $this->preparedData);
		}		
	}
	
	public function resetFieldContentIds()
	{
		foreach($this->preparedData as $dataField)
		{
			$dataField->internal['fieldcontentid'] = 0;
		}
	}
	
	function storeField($field, $data)
	{
		$elementName		= 't' . $field->id;
		$functionName 		= '_store'.$this->F2C_FIELD_FUNCTION_MAPPING[$field->fieldtypeid];				
		$content 			= $this->$functionName($elementName, $field, $data[$field->fieldname]);
		
		// Process the content if a value was provided.
		// In front-end skip fields that were not shown on the form
		if(($field->frontvisible || $this->backEnd || $this->isCron) && count($content))
		{									
			foreach($content as $fieldContent)
			{
				switch($fieldContent->action)
				{
					case 'INSERT':
						$this->db->setQuery('INSERT INTO #__f2c_fieldcontent (formid, fieldid, attribute, content) VALUES ('.(int)$this->formId.','.(int)$field->id.','.$this->db->quote($fieldContent->attribute).','.$this->db->quote($fieldContent->content).')');
						$this->db->execute();
						break;
					case 'UPDATE':
						$this->db->setQuery('UPDATE #__f2c_fieldcontent set content='.$this->db->quote($fieldContent->content).' WHERE id='.(int)$fieldContent->id);
						$this->db->execute();
						break;
					case 'DELETE':
						$this->db->setQuery('DELETE FROM #__f2c_fieldcontent WHERE id='.(int)$fieldContent->id);
						$this->db->execute();							
						break;
					default: 
						// do nothing
						break;
				}														
			}
		}
	}
	
	private function _storeSingleLineText($elementName, $field, $data)
	{
		$content 	= array();
		$value 		= isset($data->values['VALUE']) ? $data->values['VALUE'] : '';
		$fieldId 	= $data->internal['fieldcontentid'];
		$action 	= ($value != '') ? (($fieldId) ? 'UPDATE' : 'INSERT') : (($fieldId) ? 'DELETE' : '');
		$content[] 	= new F2cFieldContent($fieldId, 'VALUE', $value, $action);

		return $content;		
	}
		
	private function _storeMultiLineText($elementName, $field, $data)
	{
		$content 	= array();				
		$value 		= $data->values['VALUE'];
		$fieldId 	= $data->internal['fieldcontentid'];
		$action 	= ($value) ? (($fieldId) ? 'UPDATE' : 'INSERT') : (($fieldId) ? 'DELETE' : '');
		
		$settings = new JRegistry();
		$settings->loadString($field->settings);
		
		if((int)$settings->get('mlt_max_num_chars'))
		{
			if(function_exists('mb_substr_count') && function_exists('mb_substr'))
			{
				$numNewLines = mb_substr_count ($value, "\r\n", 'UTF-8');
				$value = mb_substr($value, 0, (int)$settings->get('mlt_max_num_chars') + $numNewLines, 'UTF-8');
			}
			else
			{
				$numNewLines = substr_count ($value, "\r\n");
				$value = substr($value, 0, (int)$settings->get('mlt_max_num_chars') + $numNewLines);
			}
		}
							
		$content[] 	= new F2cFieldContent($fieldId, 'VALUE', $value, $action);
		
		return $content;		
	}
		
	private function _storeMultiLineEditor($elementName, $field, $data)
	{
		$content 	= array();					
		$fieldId 	= $data->internal['fieldcontentid'];
		$value 		= $data->values['VALUE'];		
		$action 	= ($value) ? (($fieldId) ? 'UPDATE' : 'INSERT') : (($fieldId) ? 'DELETE' : '');
		$content[] 	= new F2cFieldContent($fieldId, 'VALUE', $value, $action);
		
		return $content;		
	}
		
	private function _storeSingleSelectList($elementName, $field, $data)
	{
		$content 	= array();					
		$value 		= $data->values['VALUE'];
		$fieldId 	= $data->internal['fieldcontentid'];
		$action 	= ($value) ? (($fieldId) ? 'UPDATE' : 'INSERT') : (($fieldId) ? 'DELETE' : '');
		$content[] 	= new F2cFieldContent($fieldId, 'VALUE', $value, $action);
		
		return $content;		
	}
		
	private function _storeImage($elementName, $field, $data)
	{
		$content 				= array();
		$f2cConfig				= F2cFactory::getConfig();		
		$fieldId 				= $data->internal['fieldcontentid'];
		$imageContent 			= new JRegistry();
		$imageHelper			= new F2C_Image();
		$saveImage				= false;
		$imagePath 				= Path::Combine(Path::Combine(F2C_Image::GetImagesRootPath(), 'p'.$field->projectid), 'f'.$this->formId);				
		$thumbsPath				= Path::Combine($imagePath, 'thumbs');
		$maxImageWidth 			= $field->settings->get('img_max_width', 10000);
		$maxImageHeight 		= $field->settings->get('img_max_height', 10000);
		$defaultThumbnailWidth 	= $f2cConfig->get('default_thumbnail_width', F2C_DEFAULT_THUMBNAIL_WIDTH);
		$defaultThumbnailHeight = $f2cConfig->get('default_thumbnail_height', F2C_DEFAULT_THUMBNAIL_HEIGHT);
		$thumbnailWidth 		= $field->settings->get('img_thumb_width', $defaultThumbnailWidth);
		$thumbnailHeight 		= $field->settings->get('img_thumb_height', $defaultThumbnailHeight);

		// Check if the image is selected for deletion
		if($data->internal['delete'])
		{
			if(array_key_exists('currentfilename', $data->internal)) 
			{
				$imageHelper->delete($field->projectid, $this->formId, $data->internal['currentfilename']);
			}
			else
			{
				// Load the image field
				$query = $this->db->getQuery(true);
				$query->select('content');
				$query->from('#__f2c_fieldcontent');
				$query->where('id = ' . (int)$data->internal['fieldcontentid']);
				$this->db->setQuery($query);
				$result = $this->db->loadResult();
				
				if($result)
				{
					$imageContent->loadString($result);
					$imageHelper->delete($field->projectid, $this->formId, $imageContent->get('filename'));
				}
			}
			
			$content[] 	= new F2cFieldContent($fieldId, '', '', 'DELETE');
			return $content;	
		}
		
		switch($data->internal['method'])
		{
			case 'upload':				
				if($data->internal['imagelocation'])
				{						
					// delete current image, if there is one
					$imageHelper->delete($field->projectid, $this->formId, $data->internal['currentfilename']);							
							
					// Store the uploaded image
					$uploadFileName 		= $data->values['FILENAME'];
					$imageFileName 			= F2C_Image::CreateFullImageName($uploadFileName, $field->id);
					$imageFileLocation 		= Path::Combine($imagePath, $imageFileName);
					$imageFileLocationTmp 	= Path::Combine($imagePath, '~'.$imageFileName);
					$thumbnailLocation 		= Path::Combine($thumbsPath, F2C_Image::CreateThumbnailImageName($uploadFileName, $field->id));						
	
					if(!JFolder::exists($thumbsPath)) JFolder::create($thumbsPath);
					
					if(JFile::upload($data->internal['imagelocation'], $imageFileLocationTmp))
					{			
						$imageContent->set('filename', $imageFileName);
						
						// resize image
						if(!ImageHelper::ResizeImage($imageFileLocationTmp, $imageFileLocation, $maxImageWidth, $maxImageHeight, $f2cConfig->get('jpeg_quality', 75)))
						{
							JError::raiseError(401,JText::_('COM_FORM2CONTENT_ERROR_IMAGE_RESIZE_FAILED'));
							return false;
						}
						
						$imageContent->set('width', $maxImageWidth);
						$imageContent->set('height', $maxImageHeight);
												
						// create thumbnail image
						if(!ImageHelper::ResizeImage($imageFileLocationTmp, $thumbnailLocation, $thumbnailWidth, $thumbnailHeight, $f2cConfig->get('jpeg_quality', 75)))
						{
							JError::raiseError(401,JText::_('COM_FORM2CONTENT_ERROR_IMAGE_RESIZE_FAILED'));
							return false;
						}
						
						$imageContent->set('widthThumbnail', $thumbnailWidth);
						$imageContent->set('heightThumbnail', $thumbnailHeight);
						
						JFile::delete($imageFileLocationTmp);
						
						// Save the image info to the F2C table
						$saveImage = true;								
					}				
				}
				else 
				{
					// no image was uploaded, but the alt and title tags could be modified
					if($data->internal['fieldcontentid'])
					{
						// Load the image field
						$query = $this->db->getQuery(true);
						$query->select('content');
						$query->from('#__f2c_fieldcontent');
						$query->where('id = ' . (int)$data->internal['fieldcontentid']);
						$this->db->setQuery($query);
						$result = $this->db->loadResult();
						
						if($result)
						{
							$imageContent->loadString($result);
							
							if($imageContent->get('alt') != $data->values['ALT'])
							{
								$imageContent->set('alt', $data->values['ALT']);
								$saveImage = true;
							}

							if($imageContent->get('title') != $data->values['TITLE'])
							{
								$imageContent->set('title', $data->values['TITLE']);
								$saveImage = true;
							}
						}
					}
				}
				break;
				
			case 'copy':				
				if($data->internal['imagelocation'])
				{
					$srcImage 				= $data->internal['imagelocation'];
					$srcThumb 				= $data->internal['thumblocation'];
					$filename				= $data->values['FILENAME'];						
					$imageFileName 			= F2C_Image::CreateFullImageName($filename, $field->id);
					$imageFileLocation 		= Path::Combine($imagePath, $imageFileName);
					$thumbnailLocation 		= Path::Combine($thumbsPath, F2C_Image::CreateThumbnailImageName($filename, $field->id));
					
					JFolder::create($thumbsPath);				
					JFile::copy($srcImage, $imageFileLocation);
					JFile::copy($srcThumb, $thumbnailLocation);
					
					list($width, $height, $type, $attr) = getimagesize($imageFileLocation);
					list($widthThumb, $heightThumb, $typeThumb, $attrThumb) = getimagesize($thumbnailLocation);
					
					$imageContent->set('filename', $filename);
					$imageContent->set('width', $width);
					$imageContent->set('height', $height);
					$imageContent->set('widthThumbnail', $widthThumb);
					$imageContent->set('heightThumbnail', $heightThumb);
				}
								
				// Save the image info to the F2C table
				$saveImage = true;													
				break;
				
			case 'remote':
				if($data->internal['imagelocation'])
				{
					$srcImage 				= $data->internal['imagelocation'];
					$srcThumb 				= $data->internal['thumblocation'];
					$filename				= $data->values['FILENAME'];						
					$imageFileName 			= F2C_Image::CreateFullImageName($filename, $field->id);
					$thumbFileName			= F2C_Image::CreateThumbnailImageName($filename, $field->id);
					$imageFileLocation 		= Path::Combine($imagePath, $imageFileName);
					$thumbnailLocation 		= Path::Combine($thumbsPath, $thumbFileName);
					$tmpImage				= Path::Combine($imagePath, '~'.$imageFileName);
					$tmpThumb				= Path::Combine($thumbsPath, '~'.$thumbFileName);;
					
					JFolder::create($thumbsPath);

					if(!$this->downloadFile($srcImage, $tmpImage))
					{
						echo 'Download failed for: ' . $srcImage . ' form id: ' . $this->formId . '<br/>';
						return $content;
					}
										
					if($srcThumb)
					{
						$this->downloadFile($srcThumb, $tmpThumb);
					}
					
					// resize image
					if(!ImageHelper::ResizeImage($tmpImage, $imageFileLocation, $maxImageWidth, $maxImageHeight, $f2cConfig->get('jpeg_quality', 75)))
					{
						JError::raiseError(401,JText::_('COM_FORM2CONTENT_ERROR_IMAGE_RESIZE_FAILED'));
						return false;
					}
					
					// Check if we need to generate a thumbnail image
					if($srcThumb)
					{
						// copy the thumbnail image
						JFile::copy($tmpThumb, $thumbnailLocation);
						// determine the size
						list($thumbnailWidth, $thumbnailHeight, $typeThumb, $attrThumb) = getimagesize($thumbnailLocation);
					}
					else 
					{
						// create thumbnail image
						if(!ImageHelper::ResizeImage($tmpImage, $thumbnailLocation, $thumbnailWidth, $thumbnailHeight, $f2cConfig->get('jpeg_quality', 75)))
						{
							JError::raiseError(401,JText::_('COM_FORM2CONTENT_ERROR_IMAGE_RESIZE_FAILED'));
							return false;
						}
					}
					
					$imageContent->set('filename', $field->id . '.' . JFile::getExt($tmpImage));
					$imageContent->set('width', $maxImageWidth);
					$imageContent->set('height', $maxImageHeight);
					$imageContent->set('widthThumbnail', $thumbnailWidth);
					$imageContent->set('heightThumbnail', $thumbnailHeight);
					
					JFile::delete($tmpImage);
					
					if($srcThumb)
					{
						JFile::delete($tmpThumb);
					}
				}
								
				// Save the image info to the F2C table
				$saveImage = true;													
				break;
		}
		
		$imageContent->set('alt', $data->values['ALT']);
		$imageContent->set('title', $data->values['TITLE']);
		
		if($saveImage)								
		{
			$value 		= $imageContent->toString();
			$action 	= ($value) ? (($fieldId) ? 'UPDATE' : 'INSERT') : (($fieldId) ? 'DELETE' : '');				
			$content[] 	= new F2cFieldContent($fieldId, 'VALUE', $value, $action);
		}
				
		return $content;	
	}
	
	/*
	function _storeImage($elementName, $field, $data)
	{
		$content 		= array();
		$f2cConfig		= F2cFactory::getConfig();		
		$fieldId 		= $data[$elementName.'_fieldid'];						
		$imageContent 	= new JRegistry();
		$imageHelper	= new F2C_Image();
		$imageCurrent	= new JRegistry();
		$value			= '';

		// initialize with empty values
		$imageCurrent->set('filename', '');
		$imageCurrent->set('width', '');
		$imageCurrent->set('height', '');
		$imageCurrent->set('widthThumbnail', '');
		$imageCurrent->set('heightThumbnail', '');
		
		if($fieldId)
		{
			$this->db->setQuery('SELECT * FROM #__f2c_fieldcontent WHERE id='.(int)$fieldId);
			$fieldContent = $this->db->loadObject();
	
			if($fieldContent->content)
			{
				$imageCurrent->loadString($fieldContent->content);
			}
		}
	
		if($data[$elementName.'_del'])
		{
			$imageHelper->delete($field->projectid, $this->formId, $data[$elementName.'_filename']);	
		}
		else
		{			
			switch($data[$elementName.'_method'])
			{
				case 'upload':				
					$uploadfile = $data[$elementName.'_fileupload'];

					if($uploadfile['size'])
					{						
						// delete current image, if there is one
						$imageHelper->delete($field->projectid, $this->formId, $imageCurrent->get('filename'));							
								
						// Store the uploaded image
						$settings 		= new JRegistry();						
						
						$settings->loadString($field->settings);
						
						$maxImageWidth			= 10000;
						$maxImageHeight			= 10000;
						$uploadFileName 		= $uploadfile['name'];
						$imagePath 				= Path::Combine(F2C_Image::GetImagesRootPath(), 'p'.$field->projectid);				
						$imagePath 				= Path::Combine($imagePath, 'f'.$this->formId);				
						$thumbsPath 			= Path::Combine($imagePath, 'thumbs');
						$imageFileName 			= F2C_Image::CreateFullImageName($uploadFileName, $field->id);
						$imageFileLocation 		= Path::Combine($imagePath, $imageFileName);
						$imageFileLocationTmp 	= Path::Combine($imagePath, '~'.$imageFileName);
						$thumbnailLocation 		= Path::Combine($thumbsPath, F2C_Image::CreateThumbnailImageName($uploadFileName, $field->id));						
						$maxImageWidth 			= $settings->get('img_max_width', 10000);
						$maxImageHeight 		= $settings->get('img_max_height', 10000);
						
						if(!JFolder::exists($thumbsPath)) JFolder::create($thumbsPath);
						
						if(JFile::upload($uploadfile['tmp_name'], $imageFileLocationTmp))
						{			
							$imageContent->set('filename', $imageFileName);
							
							// resize image
							if(!ImageHelper::ResizeImage($imageFileLocationTmp, $imageFileLocation, $maxImageWidth, $maxImageHeight, $f2cConfig->get('jpeg_quality', 75)))
							{
								JError::raiseError(401,JText::_('ERROR_IMAGE_RESIZE_FAILED'));
								return false;
							}
							
							$imageContent->set('width', $maxImageWidth);
							$imageContent->set('height', $maxImageHeight);
							
							$defaultThumbnailWidth 	= $f2cConfig->get('default_thumbnail_width', F2C_DEFAULT_THUMBNAIL_WIDTH);
							$defaultThumbnailHeight = $f2cConfig->get('default_thumbnail_height', F2C_DEFAULT_THUMBNAIL_HEIGHT);
							$thumbnailWidth 		= $settings->get('img_thumb_width', $defaultThumbnailWidth);
							$thumbnailHeight 		= $settings->get('img_thumb_height', $defaultThumbnailHeight);
							
							// create thumbnail image
							if(!ImageHelper::ResizeImage($imageFileLocationTmp, $thumbnailLocation, $thumbnailWidth, $thumbnailHeight, $f2cConfig->get('jpeg_quality', 75)))
							{
								JError::raiseError(401,JText::_('ERROR_IMAGE_RESIZE_FAILED'));
								return false;
							}
							
							$imageContent->set('widthThumbnail', $thumbnailWidth);
							$imageContent->set('heightThumbnail', $thumbnailHeight);
							
							JFile::delete($imageFileLocationTmp);								
						}				
					}
					else
					{
						// no file was uploaded, check if there was a previous file
						$imageContent = $imageCurrent; 
					}				
					break;
					
				case 'copy':
					$srcImage 				= $data[$elementName.'_location'];
					$srcThumb 				= $data[$elementName.'_thumblocation'];
					$filename				= $data[$elementName.'_filename'];						
					$imagePath 				= Path::Combine(F2C_Image::GetImagesRootPath(), 'p'.$field->projectid);				
					$imagePath 				= Path::Combine($imagePath, 'f'.$this->formId);				
					$thumbsPath 			= Path::Combine($imagePath, 'thumbs');
					$imageFileName 			= F2C_Image::CreateFullImageName($filename, $field->id);
					$imageFileLocation 		= Path::Combine($imagePath, $imageFileName);
					$thumbnailLocation 		= Path::Combine($thumbsPath, F2C_Image::CreateThumbnailImageName($filename, $field->id));
					
					JFolder::create($thumbsPath);				
					JFile::copy($srcImage, $imageFileLocation);
					JFile::copy($srcThumb, $thumbnailLocation);
					
					list($width, $height, $type, $attr) = getimagesize($imageFileLocation);
					list($widthThumb, $heightThumb, $typeThumb, $attrThumb) = getimagesize($thumbnailLocation);
					
					$imageContent->set('filename', $filename);
					$imageContent->set('width', $width);
					$imageContent->set('height', $height);
					$imageContent->set('widthThumbnail', $widthThumb);
					$imageContent->set('heightThumbnail', $heightThumb);
					break;
			}
			
			$imageContent->set('alt', $data[$elementName.'_alt']);
			$imageContent->set('title', $data[$elementName.'_title']);
		}				
		
		$value 		= $imageContent->__toString();
		$action 	= ($value) ? (($fieldId) ? 'UPDATE' : 'INSERT') : (($fieldId) ? 'DELETE' : '');				
		$content[] 	= new F2C_FieldContent($fieldId, 'VALUE', $value, $action);
		
		return $content;	
	}
	*/
	
	private function _storeHyperlink($elementName, $field, $data)
	{
		$content 		= array();					
		$link 			= new JRegistry();
		$fieldId 		= $data->internal['fieldcontentid'];
				
		$link->set('url', $data->values['URL']);
		$link->set('display', $data->values['DISPLAY_AS']);
		$link->set('title', $data->values['TITLE']);
		$link->set('target', $data->values['TARGET']);
		
		$value 			= $link->toString();
		$action 		= ($value) ? (($fieldId) ? 'UPDATE' : 'INSERT') : (($fieldId) ? 'DELETE' : '');
		$content[] 		= new F2cFieldContent($fieldId, 'VALUE', $value, $action);
		
		return $content;		
	}
	
	private function _storeInfoText($elementName, $field, $data)
	{
		$content = array();
		return $content;
	}
		
	public function prepareSubmittedData($fields)
	{
		$this->preparedData = array();
		
		foreach($fields as $field)
		{
			// add the field definition to the data
			$fldData 				= new F2cFieldData();
			$fldData->id 			= $field->id;
			$fldData->fieldtypeid 	= $field->fieldtypeid;
			$fldData->title 		= $field->title;
			$fldData->fieldname 	= $field->fieldname;
			$fldData->ordering 		= $field->ordering;
			$fldData->frontvisible 	= $field->frontvisible;				
			$fldData->settings 		= $field->settings;
			$fldData->projectid		= $field->projectid;
			
			$functionName = '_prepare'.$this->F2C_FIELD_FUNCTION_MAPPING[$field->fieldtypeid];
			$this->$functionName('t' . $field->id, $fldData);
					
			$this->preparedData[$field->fieldname] = $fldData;
		}
	}
	
	private function _prepareSingleLineText($elementName, &$fieldData)
	{
		$fieldData->internal['fieldcontentid'] = $this->jinput->getInt('hid'.$elementName);
		$fieldData->values['VALUE'] = $this->jinput->get($elementName, '', 'RAW');
	}
	
	private function _prepareMultiLineText($elementName, &$fieldData)
	{
		$fieldData->internal['fieldcontentid'] = $this->jinput->getInt('hid'.$elementName);
		$fieldData->values['VALUE'] = $this->jinput->get($elementName, '', 'RAW');
	}
	
	private function _prepareMultiLineEditor($elementName, &$fieldData)
	{
		$fieldData->internal['fieldcontentid'] = $this->jinput->getInt('hid'.$elementName);
		$fieldData->values['VALUE'] = $this->jinput->get($elementName, '', 'RAW');
	}
	
	private function _prepareSingleSelectList($elementName, &$fieldData)
	{
		$fieldData->internal['fieldcontentid'] = $this->jinput->getInt('hid'.$elementName);
		$fieldData->values['VALUE'] = $this->jinput->get($elementName, '', 'RAW');
	}
	
	private function _prepareImage($elementName, &$fieldData)
	{
		$upload									= $this->jinput->files->get($elementName . '_fileupload');
		$fieldData->internal['fieldcontentid'] 	= $this->jinput->getInt('hid'.$elementName);
		$fieldData->internal['method'] 			= 'upload';
		$fieldData->internal['delete'] 			= $this->jinput->get($elementName . '_del');
		$fieldData->internal['currentfilename']	= $this->jinput->getString($elementName . '_filename');
		$fieldData->internal['imagelocation']	= ($upload['size']) ? $upload['tmp_name'] : '';
		$fieldData->internal['thumblocation']	= '';					
		$fieldData->values['FILENAME']			= basename($upload['name']);
		$fieldData->values['ALT']				= $this->jinput->getString($elementName . '_alt');
		$fieldData->values['TITLE']				= $this->jinput->getString($elementName . '_title');		
	}
	
	private function _prepareHyperlink($elementName, &$fieldData)
	{
		$fieldData->internal['fieldcontentid'] = $this->jinput->getInt('hid'.$elementName);
		
		$fieldData->values['URL'] 			= $this->jinput->getString($elementName);
		$fieldData->values['DISPLAY_AS'] 	= $this->jinput->getString($elementName . '_display');
		$fieldData->values['TITLE'] 		= $this->jinput->getString($elementName . '_title');
		$fieldData->values['TARGET'] 		= $this->jinput->getString($elementName . '_target');
	}
	
	private function _prepareInfoText($elementName, &$fieldData)
	{
	}
}
?>
