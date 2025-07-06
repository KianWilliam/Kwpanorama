<?php
/**
 * @package     com_kwpanorama
 * @version     1.0.0
 * @copyright   Copyright (C) 2025. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      KWProductions Co. <webarchitect@kwproductions121.ir> - https://componentgenerator.com
 */

namespace Joomla\Component\Kwpanorama\Administrator\View\Browser;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

// No direct access
defined('_JEXEC') or die;

/**
 * Kwpanorama list view
 */
class HtmlView extends BaseHtmlView
{
	
	public function display($tpl = 'default')
	{
	   $input = Factory::getApplication()->input;
	   $user = Factory::getUser();
	   
	   	$authorised = ($user->authorise('core.edit', 'com_kwpanorama') || (count($user->getAuthorisedCategories('com_kwpanorama', 'core.create'))));

		if ($authorised !== true)
		{
			throw new Exception(Text::_('JERROR_ALERTNOAUTHOR'), 403);
			return false;
		}

		// load the items
		require_once JPATH_ADMINISTRATOR . '/components/com_kwpanorama/helper/KwpBrowse.php';
		$this->items = KWPBrowse::getItemsList();

		parent::display($tpl);
	}

}
