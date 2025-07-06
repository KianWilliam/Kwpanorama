<?php
/**
 * @package     com_kwpanorama
 * @version     1.0.0
 * @copyright   Copyright (C) 2025. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      KWProductions Co. <webarchitect@kwproductions121.ir> - https://componentgenerator.com
 */

namespace Joomla\Component\Kwpanorama\Administrator\View\Browse;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\Component\Kwpanorama\Administrator\Helper\KwpbrowseHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\Component\Kwpanorama\Administrator\Helper\KwpframeworkHelper;

//use Kwpanorama\Helper\KwpBrowse;

use Joomla\Component\Kwpanorama\Administrator\Controller\Browse;

// No direct access
defined('_JEXEC') or die;

/**
 * Kwpanorama list view
 */
class HtmlView extends BaseHtmlView
{
	protected $items;
	public function display($tpl = null)
	{
	   $input = Factory::getApplication()->input;
	   $user = Factory::getUser();
	   
	   	$authorised = ($user->authorise('core.edit', 'com_kwpanorama') || (count($user->getAuthorisedCategories('com_kwpanorama', 'core.create'))));

		if ($authorised !== true)
		{
			throw new Exception(Text::_('JERROR_ALERTNOAUTHOR'), 403);
			return false;
		}
//var_dump("haaaaaaaaaaaaaaaaaaaaaaaaaaaamid");
//exit();
		// load the items
	//	require_once JPATH_ADMINISTRATOR . '/components/com_kwpanorama/src/Helper/KwpBrowse.php';
				// load the items
	//	require_once Uri::Base() . 'components/com_kwpanorama/src/Helper/KwpBrowse.php';
		//var_dump(Uri::Base(). 'components/com_kwpanorama/src/Helper/KwpBrowse.php');

		$this->items = KwpbrowseHelper::getItemsList();
		HTMLHelper::_('jquery.framework');
//KwpframeworkHelper::loadCss();

$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
//$wa->registerAndUseStyle('kwpframework',  Uri::Base(true).'/components/com_kwpanorama/assets/css/kwpframework.css' );

//$wa->registerAndUseStyle('kwpbrowser', Uri::Base(true).'/components/com_kwpanorama/assets/css/kwpbrowse.css');
$wa->registerAndUseScript('kwpbrowsejs', Uri::Base(true).'/components/com_kwpanorama/assets/js/kwpbrowse.js?ver=2.1.0');

	//	var_dump($tpl);
//exit();
		parent::display($tpl);
//				parent::display('edit');

	}

}
