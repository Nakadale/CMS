<?php
defined('_JEXEC') or die();

/**
 * Build the route for the com_form2content component
 *
 * @param	array	An array of URL arguments
 * @return	array	The URL arguments to use to assemble the subsequent URL.
 * @since	4.0.0
 */
function Form2ContentBuildRoute(&$query)
{
	$segments	= array();

	// get a menu item based on Itemid or currently active
	$app		= JFactory::getApplication();
	$menu		= $app->getMenu();

	// we need a menu item.  Either the one specified in the query, or the current active one if none specified
	if (empty($query['Itemid'])) 
	{
		$menuItem = $menu->getActive();
		$menuItemGiven = false;
	}
	else 
	{
		$menuItem = $menu->getItem($query['Itemid']);
		$menuItemGiven = true;
	}
	
	$menuView = ($menuItem) ? $menuItem->query['view'] : 'forms';
	
	$view = isset($query['view']) ? $query['view'] : $menuView;
	
	switch($view)
	{
		case 'templates':
			$segments[] = 'selecttemplate';
			unset($query['tmpl']);
			break;
			
		case 'users':
			$segments[] = 'selectuser';
			unset($query['tmpl']);
			break;
			
		// We come from the F2C Article Manager
		case 'forms':
			if(isset($query['task']))
			{
				list($controller, $task) = explode('.', $query['task']); 	
				
				switch($controller)
				{
						case 'forms':
						$segments[] = 'articlemanager';
						break;
					case 'form':
						$segments[] = 'article';
						$segments[] = $task;
						$segments[] = $query['id'];
						break;
				}
			}
			else 
			{
				$segments[] = 'articlemanager';	
			}
			break;
			
		case 'form':
			$segments[] = 'article';
			
			if(array_key_exists('editmode', $menuItem->query))
			{
				$editmode = $menuItem->query['editmode'] ? 'edit' : 'new';
			}
			else
			{
				$editmode = 'edit';
			}	
					
			if(empty($query['id']))
			{
				// new article
				$segments[] = 'new';
				$segments[] = isset($query['projectid']) ? $query['projectid'] : '';
			}
			else
			{	
				// existing article
				$segments[] = $editmode;
				$segments[] = $query['id'];
			}
			
			
			break;
	}
	
	unset($query['view']);
	unset($query['task']);
	unset($query['id']);
	unset($query['projectid']);
	unset($query['layout']);
	
	return $segments;
}

/**
 * Parse the segments of a URL.
 *
 * @param	array	The segments of the URL to parse.
 *
 * @return	array	The URL attributes to be used by the application.
 * @since	4.0.0
 */
function Form2ContentParseRoute($segments)
{
	$vars = array();
	
	//Get the active menu item.
	$app	= JFactory::getApplication();
	$menu	= $app->getMenu();
	$item	= $menu->getActive();
	
	switch($segments[0])
	{
		case 'articlemanager':
			$vars['view'] = 'forms';
			break;

		case 'selecttemplate':
			$vars['view'] = 'templates';
			$vars['layout'] = 'modal';
			$vars['task'] = 'templates.select';
			$vars['tmpl'] = 'component';
			break;
			
		case 'selectuser':
			$vars['view'] = 'users';
			$vars['layout'] = 'modal';
			$vars['task'] = 'users.display';
			$vars['tmpl'] = 'component';
			break;
			
		case 'article':
			$vars['view'] = 'form';			
			$vars['layout'] = 'edit';
			$vars['task'] = 'form.edit';
			
			if($segments[1] == 'new')
			{
				if(isset($segments[2]))
				{
					$vars['projectid'] = $segments[2];
				}
			}
			else 
			{
				$vars['id'] = $segments[2];
			}
			break;
	}

	return $vars;
}