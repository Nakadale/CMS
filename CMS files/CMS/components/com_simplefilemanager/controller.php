<?php
/**
 * @package     Simple File Manager
 * @author			Giovanni Mansillo
 *
 * @copyright   Copyright (C) 2005 - 2014 Flow Solutions. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class simplefilemanagerController extends JControllerLegacy
{
	function download()
  {
		$jinput = JFactory::getApplication()->input;
		$user = JFactory::getUser();
		
		$id = $jinput->get->get('id',0, 'INTEGER');
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('file_name, reserved_user, state');
		$query->from($db->quoteName('#__simplefilemanager'));
		$query->where($db->quoteName('id') . ' = '.$id);
		$db->setQuery($query);
		$row = $db->loadRow();
		
		if(!$row) die("No input file");
		if(!file_exists ($row['0'])) die("File not found");
    if($row['2']!='1') die("No access");
		
    if($row['1']!='0' and $row['1']!=$user->id) die("No access");

		$db1 = JFactory::getDbo();
		$query1 = $db1->getQuery(true);
		$db1->setQuery("UPDATE #__simplefilemanager SET download_counter = download_counter + 1, download_last = NOW() WHERE id = ".$id);
		$db1->execute();
		
		header("Content-Transfer-Encoding: binary");
		header("Content-type: application/octet-stream");
		header('Content-Disposition: attachment; filename="'.basename($row['0']).'"');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Cache-Control: private');
		ob_clean();  flush();
		readfile($row['0']);
		exit;
  }
}