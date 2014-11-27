<?php
/**
 * @package     Simple File Manager
 * @author			Giovanni Mansillo
 *
 * @copyright   Copyright (C) 2005 - 2014 Flow Solutions. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

class SimplefilemanagerModelSimplefilemanagers extends JModelList
{
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				'title', 'a.title',
				'state', 'a.state',
				'description', 'a.description',
				'ordering', 'a.ordering',
				'reserved_user', 'a.reserved_user',
				'file_created', 'a.file_created'
			);
		}

		parent::__construct($config);
	}

	protected function populateState($ordering = null, $direction = null)
	{
		$catid = JRequest::getInt('catid');
		$this->setState('catid', $catid);
	}

	protected function getListQuery()
	{
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		$user = JFactory::getUser();

		$query->select(
			$this->getState(
				'list.select',
				'a.id, a.title,' .
				'a.state, a.ordering,' .
				'a.description, a.reserved_user,'.
				'a.file_created, a.file_size, a.icon, a.featured'
			)
		);
		
		$query->from($db->quoteName('#__simplefilemanager').' AS a');
		$query->where('(a.state = 1)');
		$query->where('((a.reserved_user = 0) OR (a.reserved_user='.$user->id.'))');
		
		$orderBy = JFactory::getApplication()->input->get('orderBy','a.ordering');
		$order = JFactory::getApplication()->input->get('order','DESC');
		
		$query->order($db->quoteName($orderBy).' '.$order);
		
		
		if ($categoryId = $this->getState('catid'))
		{
			$query->where('a.catid = '.(int) $categoryId);
		}

		return $query;
	}
}