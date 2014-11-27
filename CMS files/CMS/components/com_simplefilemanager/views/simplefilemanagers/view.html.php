<?php
/**
 * @package     Simple File Manager
 * @author			Giovanni Mansillo
 *
 * @copyright   Copyright (C) 2005 - 2014 Flow Solutions. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class SimplefilemanagerViewSimplefilemanagers extends JViewLegacy
{
	protected $items;

	public function display($tpl = null)
	{
		$this->items = $this->get('Items');

		$app = JFactory::getApplication();
		$params	= $app->getParams();
		$doc = JFactory::getDocument();

		$this->assignRef('params', $params);

		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		
		echo '<h2>'.$doc->getTitle().'</h2>';
		
		$catID = $app->input->get('catid',0,"int");
		if($catID>0):
			$db = JFactory::getDBO();
			$db->setQuery("SELECT description FROM #__categories WHERE id = ".$catID." LIMIT 1;");
			echo '<div class="catdesc">'.$db->loadResult().'</div>';
		endif;
		
		parent::display($tpl);
		echo JText::_("COM_SIMPLEFILEMANAGER_CREDITS");
	}
}