<?php
defined('_JEXEC') or die('Restricted acccess');

jimport('joomla.application.component.controller');

class Form2ContentControllerTemplates extends JControllerLegacy
{
	function display()
	{
		$this->input->set('view', 'templates');
		parent::display();
	}
}
?>