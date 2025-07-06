<?php
/**
 * @package     com_kwpanorama
 * @version     1.0.0
 * @copyright   Copyright (C) 2025. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      KWProductions Co. <webarchitect@kwproductions121.ir> - https://componentgenerator.com
 */

namespace Joomla\Component\Kwpanorama\Administrator\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Router\Route;
use Joomla\Component\Kwpanorama\Administrator\Helper\KwpbrowseHelper;
use Joomla\Component\Kwpanorama\Administrator\Helper\KwpfofHelper;



//require_once JPATH_SITE . '/administrator/components/com_kwpanorama/src/helper/KwpFramework.php';
//require_once JPATH_SITE . '/administrator/components/com_kwpanorama/src/helper/KwpModel.php';
//require_once JPATH_SITE . '/administrator/components/com_kwpanorama/src/helper/KwpFof.php';




/**
 * Base controller class
 *
 * @since  2.5
 */
class DisplayController extends BaseController
{
	/**
	 * The default view.
	 *
	 * @var    string
	 * @since  2.5
	 */
	protected $default_view = 'kwpanoramas';
	//	protected $default_view = 'browse';


    /**
     * Method to display a view.
     *
     * @param boolean $cachable If true, the view output will be cached
     * @param array $urlparams An array of safe URL parameters and their variable types, for valid values see {@link \JFilterInput::clean()}.
     *
     * @return bool|\JControllerLegacy|BaseController A Controller object to support chaining.
     *
     * @throws \Exception
     * @since    2.5
     */
	public function display($cachable = false, $urlparams = array())
	{
		$view   = $this->input->get('view', $this->default_view);
		$layout = $this->input->get('layout', 'default');
		$id     = $this->input->getInt('id');
		//var_dump("shaman is damn stupid, haha");
	//	$this->setRedirect(Route::_('index.php?option=com_kwpanorama&task=browse.getFiles', false));

		// Check for edit form.
		if ((string)$view === 'kwpanorama' && (string)$layout === 'edit' && !$this->checkEditId('com_kwpanorama.edit.kwpanorama', $id))
		{
			// Somehow the person just went to the form - we don't allow that.
			$this->setMessage(Text::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id), 'error');
			$this->setRedirect(Route::_('index.php?option=com_kwpanorama&view=kwpanoramas', false));

			return false;
		}

		return parent::display();
	}
	public function ajaxAddPicture() {
		//require_once CAROUSELCK_PATH . '/helpers/ckbrowse.php';
		KwpbrowseHelper::ajaxAddPicture();
	}
		
	public function ajaxCreateFolder() {
	
		// security check
	if (! KwpfofHelper::checkAjaxToken()) {
			exit();
		}
		
		//	var_dump("Apres");
		//exit();

		if (KwpfofHelper::userCan('create', 'com_media')) {
			$input = KwpfofHelper::getInput();
			$path = $input->get('path', '', 'string');
			$name = $input->get('name', '', 'string');

			//require_once CAROUSELCK_PATH . '/helpers/ckbrowse.php';
			if ($result = KwpbrowseHelper::createFolder($path, $name)) {
				$msg = Text::_('KWP_FOLDER_CREATED_SUCCESS');
			} else {
				$msg = Text::_('KWP_FOLDER_CREATED_ERROR');
			}

			echo '{"status" : "' . ($result == false ? '0' : '1') . '", "message" : "' . $msg . '"}';
		} else {
			echo '{"status" : "2", "message" : "' . Text::_('KWP_ERROR_USER_NO_AUTH') . '"}';
		}
		exit;
	}
}
