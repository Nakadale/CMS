<?php
defined('_JEXEC') or die('Restricted acccess');

require_once(JPATH_COMPONENT_SITE.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'project.php');
require_once(JPATH_COMPONENT_SITE.DIRECTORY_SEPARATOR.'renderer.form2content.php');
require_once(JPATH_COMPONENT_SITE.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'form2content.php');

jimport('joomla.application.component.view');
jimport('joomla.language.helper');

class Form2ContentViewForm extends JViewLegacy
{
	protected $form;
	protected $item;
	protected $fields;
	protected $state;
	protected $jArticle;
	protected $jsScripts = array();
	protected $renderer;
	protected $nullDate;
	protected $pageTitle;
	protected $contentTypeSettings;
	protected $renderCaptcha = '';
	protected $submitForm = '';
	protected $itemId;
	protected $dateFormat = '';
	protected $params;
	protected $doc;
	private $f2cConfig;
	
	function display($tpl = null)
	{
		$app				= JFactory::getApplication();
		$model 				= $this->getModel();		
		$db					= $this->get('Dbo');
		$this->doc			= JFactory::getDocument();
		$this->nullDate		= $db->getNullDate();
		$this->f2cConfig	= F2cFactory::getConfig();
		$this->state		= $this->get('State');
		$this->dateFormat	= $this->f2cConfig->get('date_format');
		$this->params		= $app->getParams();
		$this->itemId		= $app->input->getInt('Itemid');	
		$this->menuParms	= F2cMenuHelper::getParameters($this->itemId);
		
		// Feed the model with the parameters
		$model->contentTypeId = (int)$this->menuParms->get('contenttypeid');
		
		if ((int)$this->menuParms->get('classic_layout', 0))
		{
			$this->setLayout('classic');
			$model->classicLayout = true;
		}
		
		$this->item			= $this->get('Item');		
		$this->form			= $this->get('Form');		
		$this->canDo		= Form2ContentHelper::getActions($this->state->get('filter.category_id'));
		$this->fields		= $model->loadFieldData($this->item->id, $this->item->projectid);
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			throw new Exception(500, implode("\n", $errors));
			return false;
		}

		// load com_content language file
		$lang = JFactory::getLanguage();
		$lang->load('com_content', JPATH_ADMINISTRATOR);
		
		// set the state to indicate this is a new form or an existing one
		$app->setUserState('com_form2content.edit.form.new', $this->item->id ? false : true);
		
		$modelContentType = new Form2ContentModelProject();
		$contentType = $modelContentType->getItem($this->item->projectid);
		$this->contentTypeSettings = new JRegistry();
		$this->contentTypeSettings->loadArray($contentType->settings);

		$this->doc->addStyleSheet(JURI::root(true) . '/media/com_form2content/css/f2cfields.css');
		$this->doc->addStyleSheet(JURI::root(true) . '/media/com_form2content/css/f2cfrontend.css');
		$this->doc->setTitle(HtmlHelper::getPageTitle($this->params->get('page_title', '')));
		
		$this->prepareForm($contentType);
		$this->addToolbar($contentType);

		parent::display($tpl);		
	}	
	
	protected function addToolbar($contentType)
	{
		$this->pageTitle = $this->contentTypeSettings->get('article_caption');		
	}
	
	private function prepareForm($contentType)
	{
		$db 							= JFactory::getDBO();		
		$editor 						= JEditor::getInstance(JFactory::getConfig()->get('editor'));
		$languageId 					= JLanguageHelper::detectLanguage();
		$this->jsScripts['validation']	= '';
		$this->jsScripts['fieldval']	= '';
		$this->jsScripts['editorinit']	= '';
		$this->jsScripts['editorsave']	= '';
		
		if(!$languageId)
		{
			$languageId = -1;
		}
		
		$this->form->setFieldAttribute('id', 'label', Jtext::_('COM_FORM2CONTENT_ID'));
		$this->form->setFieldAttribute('id', 'description', '');
		
		$this->overrideFieldLabel('title', $this->contentTypeSettings->get('title_caption'));
		$this->overrideFieldLabel('alias', $this->contentTypeSettings->get('title_alias_caption'));
		$this->overrideFieldLabel('tags', $this->contentTypeSettings->get('tags_caption'));
		
		$translatedDateFormat = F2cDateTimeHelper::getTranslatedDateFormat();
		
		$this->jsScripts['validation'] .= 'var arrValidation=new Array;';
				
		$validationCounter = 0;

		$this->jsScripts['editorinit'] .= 'function F2C_GetEditorText(id) { switch(id) { ';
		
		if(count($this->fields))
		{
			foreach($this->fields as $field)
			{
				if($field->frontvisible)
				{
					switch($field->fieldtypeid)
					{
						case F2C_FIELDTYPE_MULTILINEEDITOR:
							$elmEditor = 't' . $field->id; // elementname
							$this->jsScripts['editorinit'] .= "case '".$elmEditor."': return ".$editor->getContent($elmEditor)."\n";
							$this->jsScripts['editorsave'] .= $editor->save($elmEditor);
							break;
					}
				
					$fieldSettings = new JRegistry;
					$fieldSettings->loadString($field->settings);				
				}
			}
		}
						
		// Add validation scripts for the datefields
		if($this->contentTypeSettings->get('frontend_pubsel'))
		{
			$label = JText::_($this->form->getFieldAttribute('publish_up', 'label'), true);
			$this->jsScripts['fieldval'] .= F2C_Validation::createDatePickerValidation('jform_publish_up', $label, $this->dateFormat, $translatedDateFormat, false);
			
			$label = JText::_($this->form->getFieldAttribute('publish_down', 'label'), true);
			$this->jsScripts['fieldval'] .= F2C_Validation::createDatePickerValidation('jform_publish_down', $label, $this->dateFormat, $translatedDateFormat, false);
		}
		
		$this->jsScripts['editorinit'] .= '}}';

		$this->renderer = new F2C_Renderer($this->item->id, null, $contentType->settings);		
		$this->submitForm 	= 'Joomla.submitform(task, document.getElementById(\'item-form\'));';
	}
	
	private function overrideFieldLabel($field, $caption, $group = null)
	{
		// only override the field label when a value has been provided
		if($caption)
		{
			$this->form->setFieldAttribute($field, 'label', $caption, $group);
		}
	}
}
?>