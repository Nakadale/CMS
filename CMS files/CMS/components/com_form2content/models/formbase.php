<?php
defined('_JEXEC') or die('Restricted acccess');

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_form2content'.DIRECTORY_SEPARATOR.'class.form2content.php');
require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_form2content'.DIRECTORY_SEPARATOR.'shared.form2content.php');
require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_form2content'.DIRECTORY_SEPARATOR.'utils.form2content.php');
require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_form2content'.DIRECTORY_SEPARATOR.'storage.form2content.php');
require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_form2content'.DIRECTORY_SEPARATOR.'validations.form2content.php');
require_once(JPATH_COMPONENT_SITE.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'form2content.php');

jimport('joomla.application.component.modeladmin');
jimport('joomla.form.form');

class Form2ContentModelFormBase extends JModelAdmin
{
	protected $text_prefix 					= 'COM_FORM2CONTENT';
	protected $event_before_save 			= 'onBeforeF2cContentSave';
	protected $event_after_save 			= 'onAfterF2cContentSave';
	protected $event_before_delete 			= 'onBeforeF2cContentDelete';
	protected $event_after_delete 			= 'onAfterF2cContentDelete';
	protected $event_before_parse 			= 'onBeforeF2cContentParse';
	protected $event_after_parse 			= 'onAfterF2cContentParse';	
	protected $f2cConfig 					= null;
	protected $parsedIntroContent 			= null;
	protected $parsedMainContent 			= null;
	public 	  $contentTypeId				= 0;
	public 	  $classicLayout				= false;
	protected $dicContentTypeTitle			= array();
	protected $dicContentTypeId				= array();
	protected $dicCatAliasPath				= array();
	protected $dicCatId						= array();
	protected $dicViewingAccessLevelTitle	= array();
	protected $dicViewingAccessLevelId		= array();
		
	/**
	 * The type alias for this content type (this type is present only to prevent errors).
	 *
	 * @var      string
	 * @since    5.4.0
	 */
	public $typeAlias = 'com_form2content.form';
	
	function __construct($config = array())
	{
		parent::__construct($config);
	
		// Load the component parameters
		$this->f2cConfig 	= F2cFactory::getConfig();
		$jinput				= JFactory::getApplication()->input;
		// try to load the contentType
		$this->contentTypeId = $jinput->getInt('projectid', $jinput->getInt('contenttypeid'));
		
		if($this->contentTypeId == 0)
		{
			if(array_key_exists('jform', $_POST))
			{
				$this->contentTypeId = (int)$_POST['jform']['projectid'];
			}
		}
	}

	public function getTable($type = 'Form', $prefix = 'Form2ContentTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getItem($pk = null)
	{
		// TODO: Temporary workaround: why isn't the contentTypeId value from the constructor retained? 
		$jinput					= JFactory::getApplication()->input;
		$this->contentTypeId 	= $jinput->getInt('projectid', $jinput->getInt('contenttypeid'));
		
		if($this->contentTypeId == 0)
		{
			if(array_key_exists('jform', $_POST))
			{
				$this->contentTypeId = (int)$_POST['jform']['projectid'];
			}
		}

		if ($item = parent::getItem($pk)) 
		{
			// Convert the params field to an array.
			$registry = new JRegistry;
			$registry->loadString($item->attribs);
			$item->attribs = $registry->toArray();

			// Convert the metadata field to an array.
			$registry = new JRegistry;
			$registry->loadString($item->metadata);
			$item->metadata = $registry->toArray();
			
			// Add the category title and alias
			$query = $this->_db->getQuery(true);
			
			$query->select('title, alias');
			$query->from('`#__categories`');		
			$query->where('id = '.(int)$item->catid);
			
			$this->_db->setQuery($query->__toString());

			if($category = $this->_db->loadObject())
			{
				$item->catTitle = $category->title;
				$item->catAlias = $category->alias;
			}
			else
			{
				$item->catTitle = '';
				$item->catAlias = '';
			}
			
			// Load item tags
            if (!empty($item->id))
            {
	            $item->extended = new JRegistry($item->extended);
				$item->tags = explode(',', $item->extended->get('tags'));
            }				
		}

		if(!$item->id)
		{	
			// new Form: initialize some values	
			$date					= JFactory::getDate();
			$timestamp				= $date->toSql();
			$contentTypeId 			= $this->contentTypeId;
			$user 					= JFactory::getUser();
			$modelContentType 		= new Form2ContentModelProject();
			$contentType			= $modelContentType->getItem($contentTypeId);
			$contentTypeSettings 	= new JRegistry();
		
			$contentTypeSettings->loadArray($contentType->settings);
			
			$item->title 			= $contentTypeSettings->get('title_default') ? $contentTypeSettings->get('title_default') : '';
			$item->projectid 		= $contentTypeId; 
			$item->created_by		= $user->id;
			$item->created			= $timestamp;				
			$item->metakey 			= $contentType->metakey;
			$item->metadesc			= $contentType->metadesc;
			$item->catid			= $contentTypeSettings->get('catid') ? $contentTypeSettings->get('catid') : 0;
			$item->intro_template	= $contentTypeSettings->get('intro_template') ? $contentTypeSettings->get('intro_template') : '';
			$item->main_template	= $contentTypeSettings->get('main_template') ? $contentTypeSettings->get('main_template') : '';
			$item->publish_up		= $timestamp;
			$item->publish_down		= JFactory::getDbo()->getNullDate();
			$item->state			= $contentTypeSettings->get('state_default') ? $contentTypeSettings->get('state_default') : 0;
			$item->language			= $contentTypeSettings->get('language_default') ? $contentTypeSettings->get('language_default') : '*';
			$item->featured			= $contentTypeSettings->get('featured_default') ? $contentTypeSettings->get('featured_default') : 0;
			$item->access			= $contentTypeSettings->get('access_default') ? $contentTypeSettings->get('access_default') : 0;
			$item->attribs			= $contentType->attribs;
			$item->metadata			= $contentType->metadata;
			$item->tags 			= array();
		}		

		return $item;
	}

	public function getForm($data = array(), $loadData = true)
	{
		$app = JFactory::getApplication();
		
		// Get the form.
		$form = $this->loadForm('com_form2content.form', 'form', array('control' => 'jform', 'load_data' => $loadData));
		
		if (empty($form)) 
		{
			return false;
		}

		// Determine correct permissions to check.
		if ($id = (int)$this->getState('form.id')) 
		{
			// Existing record. Can only edit in selected categories.
			//$form->setFieldAttribute('catid', 'action', 'core.edit');
			// Existing record. Can only edit own articles in selected categories.
			//$form->setFieldAttribute('catid', 'action', 'core.edit.own');
		}
		else 
		{
			// New record. Can only create in selected categories.
			//$form->setFieldAttribute('catid', 'action', 'core.create');
		}

		$dataObject 			= new JObject();
		$dataObject->id 		= $form->getValue('id');
		$dataObject->projectid 	= $form->getValue('projectid');
		$dataObject->created_by = $form->getValue('created_by');
		
		if(empty($dataObject->id))
		{
			$dataObject->id 		= isset($data['id']) ? $data['id'] : 0;
			$dataObject->projectid 	= isset($data['projectid']) ? (int)$data['projectid'] : $app->input->getInt('projectid');
			$dataObject->created_by = isset($data['created_by']) ? (int)$data['created_by'] : -1;
		}
		
		// Modify the form based on Edit State access controls.
		if (!$this->canEditState((object)$dataObject)) 
		{
			// Disable fields for display.
			$form->setFieldAttribute('featured', 'disabled', 'true');
			$form->setFieldAttribute('ordering', 'disabled', 'true');
			$form->setFieldAttribute('publish_up', 'disabled', 'true');
			$form->setFieldAttribute('publish_down', 'disabled', 'true');
			$form->setFieldAttribute('state', 'disabled', 'true');

			/*
			// Disable fields while saving.
			// The controller has already verified this is an article you can edit.
			$form->setFieldAttribute('featured', 'filter', 'unset');
			$form->setFieldAttribute('ordering', 'filter', 'unset');
			$form->setFieldAttribute('publish_up', 'filter', 'unset');
			$form->setFieldAttribute('publish_down', 'filter', 'unset');
			$form->setFieldAttribute('state', 'filter', 'unset');
			*/
		}
		
		// Set the correct formats of the date fields
		$dateFormat = $this->f2cConfig->get('date_format');
		$form->setFieldAttribute('created', 'format', $dateFormat);
		$form->setFieldAttribute('modified', 'format', $dateFormat);
		$form->setFieldAttribute('publish_up', 'format', $dateFormat);
		$form->setFieldAttribute('publish_down', 'format', $dateFormat);

		$form->setFieldAttribute('created', 'classiclayout', $this->classicLayout);
		$form->setFieldAttribute('modified', 'classiclayout', $this->classicLayout);
		$form->setFieldAttribute('publish_up', 'classiclayout', $this->classicLayout);
		$form->setFieldAttribute('publish_down', 'classiclayout', $this->classicLayout);
		$form->setFieldAttribute('intro_template', 'classiclayout', $this->classicLayout);
		$form->setFieldAttribute('main_template', 'classiclayout', $this->classicLayout);
		$form->setFieldAttribute('created_by', 'classiclayout', $this->classicLayout);
		
		return $form;
	}

	public function save($data)
	{
		$config = JFactory::getConfig();
		$jinput	= JFactory::getApplication()->input;
		$fields = $this->loadFieldDefinitions($data['projectid']);
		$isNew	= empty($data['id']);
		$table	= $this->getTable();
		$key	= $table->getKeyName();
		$pk		= (!empty($data[$key])) ? $data[$key] : (int)$this->getState($this->getName().'.id');
		$task	= $jinput->get('task');
		$isCron = (array_key_exists('isCron', $data) && $data['isCron'] == true);
		
		if(array_key_exists('preparedFieldData', $data))
		{
			$preparedFieldData = $data['preparedFieldData'];
		}
		else 
		{
			$preparedFieldData = null;
		}
		
		if(array_key_exists('saveFormOnly', $data))
		{
			$saveFormOnly = $data['saveFormOnly'];
		}
		else 
		{
			$saveFormOnly = false;
		}
		
		// Get the current date and time
		$dateNow = JFactory::getDate('now', 'UTC');
		$dateNow->setTimezone(new DateTimeZone($config->get('offset')));
		$dateNow = $dateNow->toSql();								

		// Alter the title for save as copy
		if ($task == 'save2copy') 
		{
			list($title, $alias) = $this->generateNewTitle($data['catid'], $data['alias'], $data['title']);
			$data['title']	= $title;
			$data['alias']	= $alias;
		}
		
		if ($pk > 0) 
		{
			$table->load($pk);
		}
		
		$categoryInfo = $this->getCategoryInfo($data['catid']);
		
		if(empty($data['created']))
		{
			// no created date was provided => set to current date and time
			$data['created'] = $dateNow;
		}
		
		if(empty($data['publish_up']))
		{
			// no publish up date was provided => set to current date and time
			$data['publish_up'] = $dateNow;
		}
		
		if(empty($data['publish_down']))
		{
			// no publish down date was provided => set to null date
			$data['publish_down'] = $this->_db->getNullDate();
		}
		
		$data['modified'] = $dateNow;
		$data['reference_id'] = $table->reference_id;
		$data['catAlias'] = $categoryInfo->alias;
		$data['catTitle'] = $categoryInfo->title;
		
		if(!$saveFormOnly && !$this->validateFields($data, $fields))
		{
			return false;
		}
				
		// create new Storage object
		$storage = new F2cStorage($data['id'], JFactory::getApplication()->isAdmin(), $isCron);
		
		if($preparedFieldData)
		{
			$storage->preparedData = $preparedFieldData;
		}
		else 
		{
			$storage->prepareSubmittedData($fields);
		}
		
		unset($data['reference_id']);
		unset($data['catAlias']);
		unset($data['catTitle']);
		
		// Allow an exception to be throw.
		try
		{
			// Load the row if saving an existing record.
			/*
			if ($pk > 0) 
			{
				$table->load($pk);
			}
			*/
			
			// Bind the data.
			if (!$table->bind($data)) 
			{
				$this->setError($table->getError());
				return false;
			}

			// Prepare the row for saving
			$this->prepareTable($table);

			// Check the data.
			if (!$table->check()) 
			{
				$this->setError($table->getError());
				return false;
			}

			// Store the data.
			if (!$table->store()) 
			{
				$this->setError($table->getError());
				return false;
			}

			// Clean the cache.
			$cache = JFactory::getCache($this->option);
			$cache->clean();
		}
		catch (Exception $e)
		{
			$this->setError($e->getMessage());
			return false;
		}
		
		$pkName = $table->getKeyName();

		if (isset($table->$pkName))
		{
			$this->setState($this->getName().'.id', $table->$pkName);
		}
		
		$this->setState($this->getName().'.new', $isNew);
		
		// sync id for new forms
		$storage->formId = $this->getState('form.id');
		
		if($task == 'save2copy')
		{
			$storage->resetFieldContentIds($fields);
			
			// special case for image and file fields
			$srcFieldData = $this->loadFieldData($jinput->getInt('id'), $data['projectid']);
			
			if(count($srcFieldData))
			{
				foreach($srcFieldData as $srcField)
				{
					if($srcField->fieldtypeid == F2C_FIELDTYPE_IMAGE)
					{
						$storage->preparedData[$srcField->fieldname]->values = $srcField->values;
						$storage->preparedData[$srcField->fieldname]->internal = $srcField->internal;
						$storage->preparedData[$srcField->fieldname]->internal['method'] = 'copy';
						$storage->preparedData[$srcField->fieldname]->internal['fieldcontentid'] = 0;
						
						if($srcField->fieldtypeid == F2C_FIELDTYPE_IMAGE)
						{
							$storage->preparedData[$srcField->fieldname]->values['ALT'] = $jinput->getString('t'.$srcField->id.'_alt');
							$storage->preparedData[$srcField->fieldname]->values['TITLE'] = $jinput->getString('t'.$srcField->id.'_title');
						}
					}
				}
			}			
		}
		
		$storage->storeFields($fields);
		
		if(!$this->parse($table->state, $isNew))
		{
			return false;
		}
		
		return true;		
	}
	
	public function delete(&$pks)
	{
		// Initialise variables.
		$dispatcher		= JDispatcher::getInstance();
		$pks			= (array)$pks;
		$f2cFormTable 	= $this->getTable();
		$context 		= $this->option.'.'.$this->name;

		// Include the content plugins for the on delete events.
		JPluginHelper::importPlugin('content');
		
		// Iterate the items to delete each one.
		foreach ($pks as $i => $pk) 
		{
			if($f2cFormTable->load($pk)) 
			{
				if ($this->canDelete($f2cFormTable))
				{
					if($f2cFormTable->reference_id)
					{
						// Delete the Joomla article referenced by the F2C Article
						if(!self::deleteJoomlaArticle($f2cFormTable->reference_id))
						{
							return false;
						}
					}
					
					// Delete the article images
					Path::Remove((Path::Combine(F2C_Image::GetImagesRootPath(), 'p'.$f2cFormTable->projectid.'/f'.$pk)));
					
					// Delete the field contents	
					$query = $this->_db->getQuery(true);
					
					$query->delete();
					$query->from('#__f2c_fieldcontent');
					$query->where('formid='.(int)$pk);
					
					$this->_db->setQuery($query->__toString());
					
					if(!$this->_db->execute())
					{
						$this->setError($this->_db->getErrorMsg());
						return false;
					}
						
					// Delete the form			
					if (!$f2cFormTable->delete($pk)) 
					{
						$this->setError($f2cFormTable->getError());
						return false;
					}
				}
				else
				{
					// Prune items that you can't change.
					unset($pks[$i]);
					$error = $this->getError();
					
					if ($error) 
					{
						throw new Exception($error);
					}
					else 
					{
						throw new Exception(JText::_('JLIB_APPLICATION_ERROR_DELETE_NOT_PERMITTED'));
					}
				}			
			}
			else 
			{
				$this->setError($f2cFormTable->getError());
				return false;
			}
		}

		// Clear the component's cache
		$cache = JFactory::getCache($this->option);
		$cache->clean();

		return true;
	}
	
	private function deleteJoomlaArticle($id)
	{
		JPluginHelper::importPlugin('content');
		
		$dispatcher	= JDispatcher::getInstance();
		$table		= JTable::getInstance('Content');
		$context 	= 'com_content.article';

		if(!$table->load($id))
		{
			// no corresponding Joomla article (anymore)
			return true;
		}
		
		// Trigger the onContentBeforeDelete event.
		$result = $dispatcher->trigger('onContentBeforeDelete', array($context, $table));
		
		if (in_array(false, $result, true)) 
		{
			$this->setError($table->getError());
			return false;
		}

		if (!$table->delete($id)) 
		{
			$this->setError($table->getError());
			return false;
		}

		// Trigger the onContentAfterDelete event.
		$dispatcher->trigger('onContentAfterDelete', array($context, $table));
		
		return true;
	}
	
	public function publish(&$pks, $value = 1, $batchImportMode = false)
	{
		// Initialise variables.
		$dispatcher	= JDispatcher::getInstance();
		$user		= JFactory::getUser();
		$table		= $this->getTable();
		$pks		= (array)$pks;
		
		// Create a structure that hold the Joomla Ids for every possible state
		$stateChanges = array(F2C_STATE_PUBLISHED => array(), F2C_STATE_UNPUBLISHED => array(), F2C_STATE_TRASH => array());		
				
		// Include the content plugins for the change of state event.
		JPluginHelper::importPlugin('content');

		// Access checks.
		foreach ($pks as $i => $pk) 
		{
			$table->reset();

			if ($table->load($pk)) 
			{
				if($value == F2C_STATE_TRASH)
				{
					if($this->canTrash($table) || $batchImportMode)
					{
						if($table->reference_id)
						{
							if($value == F2C_STATE_RETAIN)
							{
								$stateChanges[$table->state][] = $table->reference_id;
							}
							else 
							{
								$stateChanges[$value][] = $table->reference_id;
							}
						}
					}
					else 
					{
						// Prune items that you can't change.
						unset($pks[$i]);
						JFactory::getApplication()->enqueueMessage(JText::_('JLIB_APPLICATION_ERROR_EDITSTATE_NOT_PERMITTED'), 'notice');
					}
				}
				else 
				{
					if ($this->canEditState($table) || $batchImportMode) 
					{
						if($table->reference_id)
						{
							if($value == F2C_STATE_RETAIN)
							{
								$stateChanges[$table->state][] = $table->reference_id;
							}
							else 
							{
								$stateChanges[$value][] = $table->reference_id;
							}
						}
					}
					else 
					{
						// Prune items that you can't change.
						unset($pks[$i]);
						JFactory::getApplication()->enqueueMessage(JText::_('JLIB_APPLICATION_ERROR_EDITSTATE_NOT_PERMITTED'), 'notice');
					}
				}				
			}
		}

		// Attempt to change the state of the records.
		foreach ($pks as $i => $pk) 
		{
			$this->setState($this->getName().'.id', $pk);
			
			if(!$this->parse($value, false))
			{
				return false;	
			}
		}
		
		// Trigger the onContentChangeState event.
		foreach($stateChanges as $state => $joomlaIds)
		{
			if(count($joomlaIds))
			{
				$result = $dispatcher->trigger('onContentChangeState', array('com_content.article', $joomlaIds, $state));
		
				if (in_array(false, $result, true)) 
				{
					$this->setError($table->getError());
					return false;
				}
			}
		}
				
		// Clear the F2C and content cache
		$cache = JFactory::getCache($this->option);
		$cache->clean();
		$cache = JFactory::getCache('com_content');
		$cache->clean();

		return true;
	}

	public function copy(&$pks, $categoryId = null)
	{
		$dispatcher = JDispatcher::getInstance();
		$dateNow 	= JFactory::getDate();
		$timestamp 	= $dateNow->toSql();
		$data 		= array();
		$newIds		= array();
		$i 			= 0;
		
		// Attempt to copy the forms.
		foreach ($pks as $i => $pk) 
		{
			$this->setState($this->getName().'.id', $pk);
			
			// load the form data
			$form 				= $this->getItem();
			$fieldDataList 		= $this->loadFieldData($form->id, $form->projectid);
			$fieldDefinitions	= $this->loadFieldDefinitions($form->projectid);

			// convert the form to a saveable structure...
			foreach($fieldDataList as $fieldData)
			{
				switch($fieldData->fieldtypeid)
				{					
					case F2C_FIELDTYPE_SINGLELINE:
					case F2C_FIELDTYPE_MULTILINETEXT:
					case F2C_FIELDTYPE_MULTILINEEDITOR:
					case F2C_FIELDTYPE_SINGLESELECTLIST:
					case F2C_FIELDTYPE_HYPERLINK:								
						$fieldData->internal['fieldcontentid'] = 0;
						break;
						
					case F2C_FIELDTYPE_IMAGE:
						$fieldData->internal['fieldcontentid'] = 0;
						$fieldData->internal['method'] = 'copy';
						break;
						
					case F2C_FIELDTYPE_INFOTEXT:
						// no action required
						break;						
				}
			}
			
			$formTable 	= $this->getTable();

			if(!$formTable->load($pk))
			{
				$this->setError($formTable->getError());
				return false;
			}
			
			if(empty($categoryId))
			{
				$categoryId = $formTable->catid;
			}
			
			$formTable->catid = $categoryId;
			
			// Add the category title and alias
			$query = $this->_db->getQuery(true);
			
			$query->select('title, alias');
			$query->from('`#__categories`');		
			$query->where('id = '.(int)$formTable->catid);
			
			$this->_db->setQuery($query->__toString());

			if($category = $this->_db->loadObject())
			{
				$formTable->catTitle = $category->title;
				$formTable->catAlias = $category->alias;
			}
			else
			{
				$formTable->catTitle = '';
				$formTable->catAlias = '';
			}
			
			// Alter the title & alias
			$titleAlias = $this->generateNewTitle($categoryId, $formTable->alias, $formTable->title);
			
			$formTable->title = $titleAlias['0'];
			$formTable->alias = $titleAlias['1'];			
			$formTable->id = 0; // force insert
			$formTable->created = $timestamp;
			$formTable->modified = null;
			$formTable->state = 0; // default unpublished
			$formTable->reference_id = null; // no article yet
			
			// Perform a check, because this will create the title alias
			if(!$formTable->check())
			{
				$this->setError($formTable->getError());
				return false;
			}
			
			// remove helper items that are nog part of the table
			unset($formTable->catTitle);
			unset($formTable->catAlias);
			
			if(!$formTable->store())
			{
				$this->setError($formTable->getError());
				return false;
			}
			
			$storage = new F2cStorage($formTable->id, true);
			$storage->preparedData = $fieldDataList;
			$storage->storeFields($fieldDefinitions);
	
			// Sync stored data with model
			$this->setState($this->getName().'.id', $formTable->id);
			
			// Add the new ID to the array
			$newIds[$i]	= $formTable->id;
			$i++;		
		}

		return $newIds;
	}
	
	protected function validateFields($data, $fields)
	{
		$validator = new F2C_Validation();
		
		// Check fields		
		foreach($fields as $field)
		{
			$fieldSettings = new JRegistry();
			$fieldSettings->loadString($field->settings);			
			
			switch($field->fieldtypeid)
			{
				case F2C_FIELDTYPE_IMAGE:
					$msg = $validator->valSizeImage($field);					
					break;
				default:
					$msg = '';
					break;
			}
			
			if($msg)
			{
				$this->setError($msg);
				return false;
			}						
		}
		
		return true;		
	} 

	public function loadFieldDefinitions($projectid)
	{
		// get all the field definitions for this form
		$query = $this->_db->getQuery(true);
		
		$query->select('f.*');
		$query->from('`#__f2c_projectfields` AS f');		
		$query->where('f.projectid = '.(int)$projectid);
		$query->order('f.ordering');		

		$this->_db->setQuery($query->__toString());

		$fields = $this->_db->loadObjectList();
		 
		if(count($fields))
		{
			foreach($fields as $field)
			{
				$settings = new JRegistry();
				$settings->loadString($field->settings);
				$field->settings = $settings;				
			}
		}
		
	  	return $fields;		
	}
		
	function loadFieldData($formId, $contentTypeId)
	{
		$fieldData 	= array();
		$fldData 	= null;
		
		// Load the fields data
		$query = $this->_db->getQuery(true);
		
		// original
		$query->select('pf.*');
		$query->from('#__f2c_projectfields pf');
		$query->where('pf.projectid = '.(int)$contentTypeId);
		$query->select('fc.attribute, fc.content, fc.id AS fieldcontentid, IFNULL(fc.formid, ' . (int)$formId . ') as formid');
		$query->join('LEFT', '#__f2c_fieldcontent fc ON fc.fieldid = pf.id AND fc.formid = '.(int)$formId);
		$query->order('pf.ordering, pf.fieldtypeid');

		$this->_db->setQuery($query);
		
		$fieldContentList = $this->_db->loadObjectList();

		if(count($fieldContentList))
		{
			$formsData = $this->createFormDataObjects($fieldContentList);
			return $formsData[(int)$formId];
		}
		else
		{
			return array();
		}
	}
	
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_form2content.edit.form.data', array());

		if (empty($data)) 
		{
			$data = $this->getItem();
		}

		return $data;
	}
	
	protected function canDelete($record)
	{
		$user = JFactory::getUser();

		if($user->authorise('core.delete', 'com_form2content.form.'.(int)$record->id))
		{
			return true;
		}
		
		if($user->authorise('form2content.delete.own', 'com_form2content.form.'.(int)$record->id))
		{
			// Now test the owner is the user.
			$ownerId = (int)isset($record->created_by) ? $record->created_by : 0;
			
			if (empty($ownerId) && $record) 
			{
				// Need to do a lookup from the model.
				$record = $this->getModel()->getItem($record->id);

				if (empty($record)) 
				{
					return false;
				}

				$ownerId = $record->created_by;
			}

			// If the owner matches 'me' then do the test.
			if ($ownerId == $user->id) 
			{
				return true;
			}			
		}
		
		return false;
	}

	protected function canEditState($record)
	{
		$user 	= JFactory::getUser();
		$asset 	= $this->option;
		
		// Check for existing article.
		if(empty($record->id))
		{
			// this is a new article, test if the user has edit (own) state
			$asset .= '.project.' . (int)$record->projectid;
			return $user->authorise('core.edit.state', $asset) || $user->authorise('form2content.edit.state.own', $asset);
		}
		else
		{
			// existing article
			$asset .= '.form.' . (int)$record->id;
			
			if($user->authorise('core.edit.state', $asset))
			{
				return true;
			}
			
			if($user->authorise('form2content.edit.state.own', $asset))
			{
				// Now test the owner is the user.
				$ownerId	= (int)isset($record->created_by) ? $record->created_by : 0;
				if (empty($ownerId) && $record) 
				{
					// Need to do a lookup from the model.
					$record	= $this->getItem($record->id);

					if (empty($record)) 
					{
						return false;
					}
	
					$ownerId = $record->created_by;
				}
	
				// If the owner matches 'me' then do the test.
				if ($ownerId == $user->id) 
				{
					return true;
				}			
			}			
			
		}
		
		return false;
	}

	private function canTrash($record)
	{
		$user = JFactory::getUser();

		if($user->authorise('form2content.trash', 'com_form2content.form.'.(int) $record->id))
		{
			return true;
		}
			
		if($user->authorise('form2content.trash.own', 'com_form2content.form.'.(int) $record->id))
		{
			// Now test the owner is the user.
			$ownerId	= (int)isset($record->created_by) ? $record->created_by : 0;
			if (empty($ownerId) && $record) 
			{
				// Need to do a lookup from the model.
				$record		= $this->getModel()->getItem($record->id);

				if (empty($record)) 
				{
					return false;
				}

				$ownerId = $record->created_by;
			}

			// If the owner matches 'me' then do the test.
			if ($ownerId == $user->id) 
			{
				return true;
			}			
		}

		return false;
	}
	
	protected function prepareTable($table)
	{
		// Set the publish date to now
		if($table->state == 1 && intval($table->publish_up) == 0) 
		{
			$table->publish_up = JFactory::getDate()->toSql();
		}

		// Reorder the articles within the category so the new article is first
		if (empty($table->id)) 
		{
			$table->reorder('catid = '.(int) $table->catid.' AND state >= 0');
		}
	}
	
	protected function getReorderConditions($table = null)
	{
		$condition = array();
		$condition[] = 'catid = '.(int) $table->catid;
		return $condition;
	}
	
	public function getContentTypeSelectList($publishedOnly = true, $authorizedOnly = true)
	{
		$db 	= JFactory::getDBO();
		$query 	= $db->getQuery(true);
		$user 	= JFactory::getUser();
		
		$query->select('id AS value, title AS text');
		$query->from('`#__f2c_project`');				
		if($publishedOnly) $query->where('published = 1');
		$query->order('title'); 
		$db->setQuery($query->__toString());
		
		$contentTypeList = $db->loadObjectList();
		
		foreach($contentTypeList as $i => $contentType)
		{
			if ($user->authorise('core.create', 'com_form2content.project.'.$contentType->value) != true ) 
			{
				unset($contentTypeList[$i]);
			}
		}
		
		return $contentTypeList;			
	}
	
	public function parse($publishState, $isNew = false)
	{
		JPluginHelper::importPlugin('form2content');
		
		$dispatcher 		= JDispatcher::getInstance();
		$context			= $this->option.'.'.$this->name;	
		$form 				= $this->getItem();
		$formData 			= $this->loadFieldData($form->id, $form->projectid);			
		$performParse 		= true;
		
		if($performParse)
		{	
			// Resync data
			$form = $this->getItem();
			$formData = $this->loadFieldData($form->id, $form->projectid);	
		
			if(!$this->parseSingleForm($form, $formData, $publishState))
			{
				return false;
			}
		}
				
		return true;
	}
	
	public function parseSingleForm($form, $formData, $publishState)
	{
		$user 			= JFactory::getUser();
		$nullDate 		= $this->_db->getNullDate();
		$datenow 		= JFactory::getDate();
		$dispatcher 	= JDispatcher::getInstance();
		$row			= null;
		$errorMsgPrefix	= JText::_('COM_FORM2CONTENT_FORM_ID') . ' ' . $form->id . ': ';
		$parseResult	= new JObject();
		
		JPluginHelper::importPlugin('content');
		
		$parser = new F2cParser();

		if(!$parser->addTemplate($form->intro_template, F2C_TEMPLATE_INTRO))
		{
			$parseResult->message = $parser->getError();
			return false;				
		}

		if($form->main_template)
		{
			if(!$parser->addTemplate($form->main_template, F2C_TEMPLATE_MAIN))
			{
				$parseResult->message = $parser->getError();
				return false;				
			}
		}

		$categoryAlias	= $form->catAlias; // for use in re-parsing
		$joomlaId 		= $form->reference_id;
		$usrTmp 		= JFactory::getUser($form->created_by);
		$form->fields 	= $formData;
		
		$parser->addVars($form);
		
		$row = $this->getTable('content');
		$row->load((int)$joomlaId);
		$isNew = false;
		
		$query = $this->_db->getQuery(true);

		$query->select('count(*)');
		$query->from('`#__content`');				
		$query->where('id=' . (int)$joomlaId);
		$this->_db->setQuery($query);
		
		if($this->_db->loadResult())
		{
			$isNew = false;			
			// fail if checked out not by 'me'
			if ($row->checked_out && $row->checked_out != $user->id) 
			{
				$this->setError($errorMsgPrefix . JText::_('COM_FORM2CONTENT_ERROR_FORM_CHECKED_OUT'));
				return false;
			}
			
			$row->modified 		= $datenow->toSql();
			$row->modified_by 	= $user->get('id');			
		}
		else
		{
			// deleted / archived
			$isNew = true;
			$joomlaId 			= null;
			$form->reference_id = null;
		}
		
		if($isNew)
		{
			// init new content item
			$row = $this->getTable('content');
			$row->load(0);
			// if $publishState is not set, set item to form publish state
			$row->state		= ($publishState == F2C_STATE_RETAIN) ? F2C_STATE_PUBLISHED : $form->state;
			$row->state		= $form->state;
			$row->modified 	= $nullDate;
		}
		
		$row->created_by 	= $usrTmp->id;
		$row->created 		= $form->created;
		
		if($form->publish_up == $nullDate)
		{	
			$row->publish_up = $datenow->format('Y-m-d') . ' 00:00:00';
		}	
		else
		{
			$row->publish_up = $form->publish_up;
		}
		
		$row->publish_down = $form->publish_down;
			
		if($this->f2cConfig->get('autosync_article_order'))
		{
			$row->ordering = $form->ordering;
		}
	
		$this->parsedIntroContent = $parser->parseIntro();
		
		if($parser->getError())
		{
			$this->setError($errorMsgPrefix . $parser->getError());
			return false;
		}
		
		$this->parsedMainContent = $parser->parseMain();
		
		if($parser->getError())
		{
			$this->setError($errorMsgPrefix . $parser->getError());
			return false;
		}
	
		$attribs = new JRegistry();
		$attribs->loadArray($form->attribs);
		
		$metadata = new JRegistry();
		$metadata->loadArray($form->metadata);
		
		// Handle the images and links
		$modelContentType 		= new Form2ContentModelProject();
		$contentType			= $modelContentType->getItem($form->projectid);
		$imageSettings 			= new JRegistry($contentType->images);
		$urlSettings 			= new JRegistry($contentType->urls);
		$images 				= new JRegistry();
		$urls 					= new JRegistry();

		$this->handleArticleImage($imageSettings->get('image_intro'), $form, $formData, 'intro', $images, $imageSettings);
		$this->handleArticleImage($imageSettings->get('image_fulltext'), $form, $formData, 'fulltext', $images, $imageSettings);
		$this->handleArticleUrl($urlSettings->get('urla'), $formData, 'a', $urls, $urlSettings);
		$this->handleArticleUrl($urlSettings->get('urlb'), $formData, 'b', $urls, $urlSettings);
		$this->handleArticleUrl($urlSettings->get('urlc'), $formData, 'c', $urls, $urlSettings);
		
		$row->introtext 		= $this->parsedIntroContent;	
		$row->fulltext 			= $this->parsedMainContent;
		$row->title 			= $form->title;
		$row->alias 			= $form->alias;
		$row->metadesc 			= $form->metadesc;
		$row->metakey			= $form->metakey;
		$row->catid 			= $form->catid;
		$row->state 			= ($publishState == F2C_STATE_RETAIN) ? $form->state : $publishState;
		$row->featured			= $form->featured;
		$row->created_by_alias 	= $form->created_by_alias;
		$row->access			= $form->access;
		$row->attribs			= $attribs->toString();
		$row->metadata			= $metadata->toString();
		$row->language			= $form->language;
		$row->images			= $images->toString();
		$row->urls	 			= $urls->toString();
		
		if(isset($form->tags) && is_array($form->tags) && !empty($form->tags[0]))
		{
			// Add the tags
			$row->newTags = $form->tags;
		}
		
		// Make sure the data is valid
		if (!$row->check()) 
		{
			$this->setError($errorMsgPrefix . $row->getError());
			return false;
		}

		// Increment the content version number
		$row->version++;

		// Trigger the onContentBeforeSave event.
		$result = $dispatcher->trigger('onContentBeforeSave', array('com_content.article', &$row, $isNew));
		
		if (in_array(false, $result, true)) 
		{
			$this->setError($errorMsgPrefix . $row->getError());
			return false;
		}
			
		// Store the content to the database
		if (!$row->store()) 
		{
			$this->setError($errorMsgPrefix . $row->getError());
			return false;
		}
	
		if($isNew || $joomlaId != $row->id || !$form->alias)
		{
			// reparse to get the correct Article Id and/or title alias
			$joomlaId 	= $row->id;			
			$slug 		= ($row->alias) ? $joomlaId.':'.$row->alias : $joomlaId;
			$catslug 	= ($categoryAlias) ? $form->catid.':'.$categoryAlias : $form->catid;
			$seflink 	= 'index.php?option=com_content&view=article&id='. $slug . '&catid=' . $catslug;
						
			$parser->clearVar('JOOMLA_ID');
			$parser->addVar('JOOMLA_ID', $row->id);
			$parser->clearVar('JOOMLA_TITLE_ALIAS');
			$parser->addVar('JOOMLA_TITLE_ALIAS', $row->alias);
			$parser->clearVar('JOOMLA_ARTICLE_LINK');		
			$parser->addVar('JOOMLA_ARTICLE_LINK', $seflink);
			$parser->clearVar('JOOMLA_ARTICLE_LINK_SEF');
			$parser->addVar('JOOMLA_ARTICLE_LINK_SEF', '{plgContentF2cSef}'.$slug.','.$catslug.'{/plgContentF2cSef}');	 		
			$parser->clearTemplates();
	
			$this->parsedIntroContent = $parser->parseIntro();
			
			if($parser->getError())
			{
				$this->setError($errorMsgPrefix . $parser->getError());
				return false;
			}
		
			$this->parsedMainContent = $parser->parseMain();
			
			if($parser->getError())
			{
				$this->setError($errorMsgPrefix . $parser->getError());
				return false;
			}
	
			$row->introtext	= $this->parsedIntroContent;
			$row->fulltext 	= $this->parsedMainContent;
				
			// Make sure the data is valid
			if (!$row->check()) 
			{
				$this->setError($errorMsgPrefix . $row->getError());
				return false;
			}
	
			// Store the content to the database
			if (!$row->store()) 
			{
				$this->setError($errorMsgPrefix . $row->getError());
				return false;
			}
		}
	
		$row->checkin();
		
		if($this->f2cConfig->get('autosync_article_order'))
		{
			F2cContentHelper::syncArticleOrder($row->catid);	
		}
		
		// Set the featured option of the Joomla article
		$this->featured($joomlaId, $form->featured);
				
		// Clean the cache.
		$cache = JFactory::getCache($this->option);
		$cache->clean();

		// Trigger the onContentAfterSave event.
		$result = $dispatcher->trigger('onContentAfterSave', array('com_content.article', &$row, $isNew));
		
		if (in_array(false, $result, true)) 
		{
			$this->setError($errorMsgPrefix . $row->getError());
			return false;
		}
				
	 	// Sync F2C Article with data from Joomla Article
	 	$rowForm = $this->getTable('form');
	 	$rowForm->load($form->id);
	 	$rowForm->alias = $row->alias;
	 	$rowForm->state = $row->state;
		$rowForm->reference_id = $row->id;
		
		// Sync tags
		$tagsHelper = new JHelperTags;
		$tagsHelper->getTagIds($row->id, 'com_content.article');
		$extended = new JRegistry();
		$extended->set('tags', $tagsHelper->tags);
		$rowForm->extended = $extended->toString();
		
		if (!$rowForm->store()) 
		{
			$this->setError($errorMsgPrefix . $rowForm->getError());
			return false;
		}
		
		$parseResult->success = true;
		return $parseResult;
	}
	
	/*
	 * Toggle the featured option of a Joomla Article
	 */
	public function featured($pk, $value = 0)
	{
		JTable::addIncludePath(JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_content'.DIRECTORY_SEPARATOR.'tables');
		
		$table = $this->getTable('Featured', 'ContentTable');

		try 
		{
			$db = $this->getDbo();

			// Adjust the mapping table.
			// Clear the existing features settings.
			$query = $db->getQuery(true);
			$query->delete('#__content_frontpage');
			$query->where('content_id = ' . (int)$pk);
					
			$db->setQuery($query);

			if (!$db->execute()) 
			{
				throw new Exception($db->getErrorMsg());
			}

			if($value == 1) 
			{
				// Featuring.
				$query = $db->getQuery(true);
				$query->insert('#__content_frontpage');
				$query->set('content_id='.(int)$pk);
				$query->set('ordering=1');
				
				$db->setQuery($query);

				if (!$db->execute()) 
				{
					$this->setError($db->getErrorMsg());
					return false;
				}
			}
		} 
		catch (Exception $e) 
		{
			$this->setError($e->getMessage());
			return false;
		}

		$table->reorder();

		$cache = JFactory::getCache('com_content');
		$cache->clean();

		return true;
	}
	
	public function featuredList($pks, $value)
	{
		// Initialise variables.
		$dispatcher	= JDispatcher::getInstance();
		$user		= JFactory::getUser();
		$table		= $this->getTable();
		$pks		= (array)$pks;
		
		JArrayHelper::toInteger($pks);

		if (empty($pks)) 
		{
			$this->setError(JText::_('COM_CONTENT_NO_ITEM_SELECTED'));
			return false;
		}

		// Include the content plugins for the change of state event.
		JPluginHelper::importPlugin('content');

		// Access checks.
		foreach ($pks as $i => $pk) 
		{
			$table->reset();

			if ($table->load($pk)) 
			{
				if (!$this->canEditState($table)) 
				{
					// Prune items that you can't change.
					unset($pks[$i]);
					JFactory::getApplication()->enqueueMessage(JText::_('JLIB_APPLICATION_ERROR_EDITSTATE_NOT_PERMITTED'), 'notice');
				}
				
				$table->featured = $value;
				
				if(!$table->store())
				{
					$this->setError($table->getError());
					return false;
				}
				
				// Set the correct PK for the model
				$this->setState($this->getName().'.id', $pk);
				
				if(!$this->parse($table->state, false))
				{
					return false;	
				}				
			}
		}
		
		// Clear the F2C and content cache
		$cache = JFactory::getCache($this->option);
		$cache->clean();
		$cache = JFactory::getCache('com_content');
		$cache->clean();

		return true;
	}
	
	public function reorder($pks, $delta = 0)
	{
		// reorder the f2c_form table
		if(parent::reorder($pks, $delta))
		{
			if($this->f2cConfig->get('autosync_article_order'))
			{
				$categories = $this->getCategories($pks);
				
				foreach($categories as $catid)
				{
					F2cContentHelper::syncArticleOrder($catid);						
				}				
			}			
		}
		else
		{
			return false;
		}	
	}
	
	public function saveorder($pks = null, $order = null)
	{
		// reorder the f2c_form table
		if(parent::saveorder($pks, $order))
		{
			if($this->f2cConfig->get('autosync_article_order'))
			{
				$categories = $this->getCategories($pks);
				
				foreach($categories as $catid)
				{
					F2cContentHelper::syncArticleOrder($catid);						
				}
			}			
		}
		else
		{
			return false;
		}
		
		return true;
	}
	
	/*
	 * Load a list of unique category Id's for a set of F2C Articles
	 */
	private function getCategories($pks)
	{
		$db = $this->getDbo();
	
		$query = $db->getQuery(true);
		$query->select('DISTINCT catid');
		$query->from('#__f2c_form');
		$query->where('id IN ('. implode(',', $pks) . ')');

		$db->setQuery($query);
		return $db->loadColumn();		
	}
	
	/**
	 * Method to validate the form data.
	 *
	 * @param	object		$form		The form to validate against.
	 * @param	array		$data		The data to validate.
	 * @return	mixed		Array of filtered data if valid, false otherwise.
	 * @since	4.0.0
	 */
	function validate($form, $data, $group = null)
	{
		$validData = parent::validate($form, $data, $group);
		
		$item = $this->getItem($data['id']);

		if(!$this->canEditState($item))
		{
			// retain the current state values
			$validData['featured'] 		= $item->featured;
			$validData['ordering'] 		= $item->ordering;
			$validData['publish_up'] 	= $item->publish_up;
			$validData['publish_down'] 	= $item->publish_down != JFactory::getDbo()->getNullDate() ? $item->publish_down : '';
			$validData['state'] 		= $item->state;			
		}

		return $validData;
	}
	
	private function getCategoryInfo($catId)
	{
		$query = $this->_db->getQuery(true);
		
		$query->select('title, alias');
		$query->from('`#__categories`');		
		$query->where('id = '.(int)$catId);
		
		$this->_db->setQuery($query);

		return $this->_db->loadObject();		
	}
	
	public function createFormDataObjects($fieldContentList)
	{
		$formData  = null;
		$fldData 	= null;
		$forms		= array();

		if(count($fieldContentList))
		{
			foreach($fieldContentList as $fieldContent)
			{
				if(!array_key_exists($fieldContent->formid, $forms))
				{
					$forms[$fieldContent->formid] = array();
				}
				
				$formData =& $forms[$fieldContent->formid];

				if(!array_key_exists($fieldContent->fieldname, $formData))
				{	
					$settings = new JRegistry();
					$settings->loadString($fieldContent->settings);
					
					$fldData 				= new F2cFieldData();
					$fldData->id 			= $fieldContent->id;
					$fldData->fieldtypeid 	= $fieldContent->fieldtypeid;
					$fldData->title 		= $fieldContent->title;
					$fldData->fieldname 	= $fieldContent->fieldname;
					$fldData->description	= $fieldContent->description;
					$fldData->projectid		= $fieldContent->projectid;
					$fldData->ordering		= $fieldContent->ordering;
					$fldData->frontvisible	= $fieldContent->frontvisible;								
					$fldData->settings 		= $settings;
					
					// provide default values
					switch ($fldData->fieldtypeid)
					{
						case F2C_FIELDTYPE_SINGLELINE:
						case F2C_FIELDTYPE_MULTILINETEXT:
						case F2C_FIELDTYPE_MULTILINEEDITOR:
						case F2C_FIELDTYPE_SINGLESELECTLIST:
							$fldData->values['VALUE']				= '';
							$fldData->internal['fieldcontentid']	= 0;
							break;
							
						case F2C_FIELDTYPE_IMAGE:
							$fldData->values['FILENAME'] 			= '';
							$fldData->values['ALT'] 				= '';
							$fldData->values['TITLE'] 				= '';
							$fldData->values['WIDTH'] 				= null;
							$fldData->values['HEIGHT'] 				= null;
							$fldData->values['WIDTH_THUMBNAIL'] 	= null;
							$fldData->values['HEIGHT_THUMBNAIL'] 	= null;
							$fldData->internal['method'] 			= '';
							$fldData->internal['delete'] 			= '';
							$fldData->internal['currentfilename']	= '';
							$fldData->internal['imagelocation']		= '';
							$fldData->internal['thumblocation']		= '';
							$fldData->internal['fieldcontentid']	= 0;
							break;
	
						case F2C_FIELDTYPE_HYPERLINK:
							$fldData->values['URL'] 				= '';
							$fldData->values['DISPLAY_AS'] 			= '';
							$fldData->values['TITLE'] 				= '';
							$fldData->values['TARGET'] 				= '';
							$fldData->internal['fieldcontentid']	= 0;
							break;							
					}
					
					$formData[$fieldContent->fieldname] = $fldData;
				}
				
				switch ($fldData->fieldtypeid)
				{
					case F2C_FIELDTYPE_SINGLELINE:
					case F2C_FIELDTYPE_MULTILINETEXT:
					case F2C_FIELDTYPE_MULTILINEEDITOR:
					case F2C_FIELDTYPE_SINGLESELECTLIST:
					//case F2C_FIELDTYPE_INFOTEXT:
						if($fieldContent->attribute)
						{
							$fldData->values[$fieldContent->attribute] 	= $fieldContent->content;
							$fldData->internal['fieldcontentid'] 		= $fieldContent->fieldcontentid;
						}
						break;
						
					case F2C_FIELDTYPE_IMAGE:					
						$fldData->internal['fieldcontentid']	= $fieldContent->fieldcontentid;
						$values 								= new JRegistry($fieldContent->content);
						$fldData->values['FILENAME'] 			= $values->get('filename');
						$fldData->values['ALT'] 				= $values->get('alt');
						$fldData->values['TITLE'] 				= $values->get('title');					
						$fldData->values['WIDTH'] 				= ($values->get('width') != -1) ? $values->get('width') : null;
						$fldData->values['HEIGHT'] 				= ($values->get('height') != -1) ? $values->get('height') : null;
						$fldData->values['WIDTH_THUMBNAIL'] 	= ($values->get('widthThumbnail') != -1) ? $values->get('widthThumbnail') : null;
						$fldData->values['HEIGHT_THUMBNAIL'] 	= ($values->get('heightThumbnail') != -1) ? $values->get('heightThumbnail') : null;						
						$fldData->internal['method'] 			= '';
						$fldData->internal['delete'] 			= '';
						$fldData->internal['currentfilename']	= $values->get('filename');
						
						if($values->get('filename'))
						{
							$fldData->internal['imagelocation']		= Path::Combine(F2C_Image::GetImagesPath($fieldContent->projectid, $fieldContent->formid, false), $values->get('filename'));
							$fldData->internal['thumblocation']		= Path::Combine(F2C_Image::GetThumbnailsPath($fieldContent->projectid, $fieldContent->formid), $values->get('filename'));
						}										
						break;
						
					case F2C_FIELDTYPE_HYPERLINK:					
						$fldData->internal['fieldcontentid']	= $fieldContent->fieldcontentid;
						$values 								= new JRegistry($fieldContent->content);
						$fldData->values['URL'] 				= $values->get('url');
						$fldData->values['DISPLAY_AS'] 			= $values->get('display');
						$fldData->values['TITLE'] 				= $values->get('title');
						$fldData->values['TARGET'] 				= $values->get('target');
						break;											
				}			
			}
		}

		return $forms;		
	}
	
	private function handleArticleImage($imageId, $form, $formData, $tag, $images, $imageSettings)
	{		
		// find the image
		if (count($formData))
		{
			foreach ($formData as $formField)
			{ 
				
				if($formField->id == $imageId && $formField->values['FILENAME'])
				{
					if($imageSettings->get('imagetype_'.$tag) == 'full')
					{
						$images->set('image_'.$tag, 'images/stories/' . Path::Combine(F2C_Image::GetImagesUrl($form->projectid, $form->id, true), $formField->values['FILENAME']));
					}
					else
					{
						$images->set('image_'.$tag, 'images/stories/' . Path::Combine(F2C_Image::GetThumbnailsUrl($form->projectid, $form->id, true), $formField->values['FILENAME']));
					}
					
					$images->set('float_'.$tag, $imageSettings->get('float_intro'));
					$images->set('image_'.$tag.'_alt', $formField->values['ALT'] ? $formField->values['ALT'] : $imageSettings->get('image_'.$tag.'_alt'));
					$images->set('image_'.$tag.'_caption', $formField->values['TITLE'] ? $formField->values['TITLE'] : $imageSettings->get('image_'.$tag.'_caption'));
					return true;
				}
			}
			
			// No image present
			$images->set('image_'.$tag, '');
			$images->set('float_'.$tag, '');
			$images->set('image_'.$tag.'_alt', '');
			$images->set('image_'.$tag.'_caption', '');
		}
	}
	
	private function handleArticleUrl($urlId, $formData, $tag, $urls, $urlSettings)
	{
		// find the image
		if (count($formData))
		{
			foreach ($formData as $formField)
			{
				if($formField->id == $urlId) //&& $formField->values['URL'])
				{
					$urls->set('url'.$tag, $formField->values['URL']);
					$urls->set('url'.$tag.'text', $formField->values['TITLE'] ? $formField->values['TITLE'] : $urlSettings->get('url'.$tag.'text'));
					
					$target = $formField->values['TARGET'] ? $formField->values['TARGET'] : $urlSettings->get('target'.$tag);
					
					switch($target)
					{
						case '_top':
							$target = 0;
							break;
						case '_blank':
							$target = 1;
							break;
					}
					
					$urls->set('target'.$tag, $target);
					return true;
				}
			}
			
			// No url present
			$urls->set('url'.$tag, '');
			$urls->set('url'.$tag.'text', '');
			$urls->set('target'.$tag, '');
		}
	}
	
	/**
	 * Method to allow derived classes to preprocess the form.
	 *
	 * @param   JForm   $form   A JForm object.
	 * @param   mixed   $data   The data expected for the form.
	 * @param   string  $group  The name of the plugin group to import (defaults to "content").
	 *
	 * @return  void
	 *
	 * @see     JFormField
	 * @since   5.2.0
	 * @throws  Exception if there is an error in the form event.
	 */
	protected function preprocessForm(JForm $form, $data, $group = 'content')
	{
		if(empty($this->contentTypeId))
		{
			$contentTypeId = (int)$data->projectid;
		}
		else 
		{
			$contentTypeId = $this->contentTypeId;
		}
		
		$contentType	= F2cFactory::getContentType($contentTypeId);
		$settings 		= $contentType->settings;
		$ajaxMode 		= (array_key_exists('tag_field_ajax_mode', $settings) && $settings['tag_field_ajax_mode'] != 1) ? 'nested' : 'ajax';
		$customTags		= (array_key_exists('tags_allow_custom', $settings) && $settings['tags_allow_custom'] != 1) ? 'deny' : 'allow';
		
		$form->setFieldAttribute('tags', 'mode', $ajaxMode, 'metadata');
		$form->setFieldAttribute('tags', 'custom', $customTags, 'metadata');
		
		parent::preprocessForm($form, $data, $group);
	}
}
?>