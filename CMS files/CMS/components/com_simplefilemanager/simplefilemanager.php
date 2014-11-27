<?php
/**
 * @package     Simple File Manager
 * @author			Giovanni Mansillo
 *
 * @copyright   Copyright (C) 2005 - 2014 Flow Solutions. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$document = JFactory::getDocument();
$cssFile = "./media/com_simplefilemanager/css/site.stylesheet.css";
$document->addStyleSheet($cssFile);

$controller	= JControllerLegacy::getInstance('Simplefilemanager');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();