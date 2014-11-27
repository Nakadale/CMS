<?php
defined('_JEXEC') or die('Restricted acccess');

require_once JPATH_COMPONENT_SITE.DIRECTORY_SEPARATOR.'const.form2content.php';
require_once JPATH_COMPONENT_SITE.DIRECTORY_SEPARATOR.'factory.form2content.php';

jimport('joomla.application.component.controller');

// Execute the task.
$controller	= JControllerLegacy::getInstance('Form2Content');
$controller->execute(JFactory::getApplication()->input->getCmd('task'));
$controller->redirect();
?>