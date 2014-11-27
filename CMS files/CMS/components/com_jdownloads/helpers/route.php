<?php
/**
 * @package jDownloads
 * @version 2.5  
 * @copyright (C) 2007 - 2013 - Arno Betz - www.jdownloads.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.txt
 * 
 * jDownloads is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */
 
defined('_JEXEC') or die('Restricted access');


jimport('joomla.application.component.helper');
jimport('joomla.application.categories');

$path = JPATH_SITE.'/components/com_jdownloads/helpers/categories.php';
if (is_file($path)) include_once $path;

/**
 * jDownloads Component Route Helper
 *
 * @static
 */
abstract class JdownloadsHelperRoute
{
	protected static $lookup;

	/**
	 * @param	int	The route of the download item
	 */
	public static function getDownloadRoute($id, $catid = 0, $language = 0)
	{
		$needles = array(
			'download'  => array((int) $id)
		);
		//Create the link
		$link = 'index.php?option=com_jdownloads&view=download&id='. $id;
		if ((int)$catid > 1)
		{
			$categories = JDCategories::getInstance('');
			$category = $categories->get((int)$catid);
			if($category)
			{
				$needles['category'] = array_reverse($category->getPath());
				$needles['categories'] = $needles['category'];
				$link .= '&catid='.$catid;
			}
		}

		if ($language && $language != "*" && JLanguageMultilang::isEnabled()) 
        {
            
			$db		= JFactory::getDBO();
			$query	= $db->getQuery(true);
			$query->select('a.sef AS sef');
			$query->select('a.lang_code AS lang_code');
			$query->from('#__languages AS a');
			//$query->where('a.lang_code = ' .$language);
			$db->setQuery($query);
			$langs = $db->loadObjectList();
			foreach ($langs as $lang) {
				if ($language == $lang->lang_code) {
					$language = $lang->sef;
					$link .= '&lang='.$language;
				}
			}
		}

		if ($item = self::_findItem($needles)) {
			$link .= '&Itemid='.$item;
		}
		elseif ($item = self::_findItem()) {
			$link .= '&Itemid='.$item;
		}

		return $link;
	}

    /**
     * @param    int    
     */
    public static function getOtherRoute($id, $catid = 0, $language = 0, $type = '', $m = '')
    {
        $needles = array(
            'download'  => array((int) $id)
        );
        //Create the link
        $link = 'index.php?option=com_jdownloads&view='.$type.'&id='. $id;
        if ((int)$catid > 1)
        {
            $categories = JDCategories::getInstance('');
            $category = $categories->get((int)$catid);
            if($category)
            {
                $needles['category'] = array_reverse($category->getPath());
                $needles['categories'] = $needles['category'];
                $link .= '&catid='.$catid;
            }
        }

        if ($language && $language != "*" && JLanguageMultilang::isEnabled()) 
        {
            
            $db        = JFactory::getDBO();
            $query    = $db->getQuery(true);
            $query->select('a.sef AS sef');
            $query->select('a.lang_code AS lang_code');
            $query->from('#__languages AS a');
            //$query->where('a.lang_code = ' .$language);
            $db->setQuery($query);
            $langs = $db->loadObjectList();
            foreach ($langs as $lang) {
                if ($language == $lang->lang_code) {
                    $language = $lang->sef;
                    $link .= '&lang='.$language;
                }
            }
        }

        // mirror
        if ($m != ''){
            $link .= '&m='.$m;
            
        }
        
        if ($item = self::_findItem($needles)) {
            $link .= '&Itemid='.$item;
        }
        elseif ($item = self::_findItem()) {
            $link .= '&Itemid='.$item;
        }

        return $link;
    }    
    
	public static function getCategoryRoute($catid)
	{
		if ($catid instanceof JCategoryNode)
		{
			$id = $catid->id;
			$category = $catid;
		}
		else
		{
			$id = (int) $catid;
			$category = JDCategories::getInstance('jdownloads')->get($id);
		}

		if($id < 1)
		{
			$link = '';
		}
		else
		{
			$needles = array(
				'category' => array($id)
			);

			if ($item = self::_findItem($needles))
			{
				$link = 'index.php?Itemid='.$item;
			}
			else
			{
				//Create the link
				$link = 'index.php?option=com_jdownloads&view=category&catid='.$id;
				if($category)
				{
					$catids = array_reverse($category->getPath());
					$needles = array(
						'category' => $catids,
						'categories' => $catids
					);
					if ($item = self::_findItem($needles)) {
						$link .= '&Itemid='.$item;
					}
					elseif ($item = self::_findItem()) {
						$link .= '&Itemid='.$item;
					}
				}
			}
		}

		return $link;
	}

	public static function getFormRoute($id)
	{
		//Create the link
		if ($id) {
			$link = 'index.php?option=com_jdownloads&task=download.edit&a_id='. $id;
		} else {
			$link = 'index.php?option=com_jdownloads&task=download.edit&a_id=0';
		}

		return $link;
	}

	protected static function _findItem($needles = null)
	{
		$app		= JFactory::getApplication();
		$menus		= $app->getMenu('site');

		// Prepare the reverse lookup array.
		if (self::$lookup === null)
		{
			self::$lookup = array();

			$component	= JComponentHelper::getComponent('com_jdownloads');
			$items		= $menus->getItems('component_id', $component->id);
			foreach ($items as $item)
			{
				if (isset($item->query) && isset($item->query['view']))
				{
					$view = $item->query['view'];
					if (!isset(self::$lookup[$view])) {
						self::$lookup[$view] = array();
					}
					if (isset($item->query['id'])) {
						self::$lookup[$view][$item->query['id']] = $item->id;
					}
				}
			}
		}

		if ($needles)
		{
			foreach ($needles as $view => $ids)
			{
				if (isset(self::$lookup[$view]))
				{
					foreach($ids as $id)
					{
						if (isset(self::$lookup[$view][(int)$id])) {
							return self::$lookup[$view][(int)$id];
						}
					}
				}
			}
		}
		else
		{
			$active = $menus->getActive();
			if ($active && $active->component == 'com_jdownloads') {
				return $active->id;
			}
		}

		return null;
	}
}
