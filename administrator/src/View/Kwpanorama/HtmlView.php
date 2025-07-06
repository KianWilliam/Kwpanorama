<?php
/**
 * @package     com_kwpanorama
 * @version     1.0.0
 * @copyright   Copyright (C) 2025. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      KWProductions Co. <webarchitect@kwproductions121.ir> - https://componentgenerator.com
 */

namespace Joomla\Component\Kwpanorama\Administrator\View\Kwpanorama;

// No direct access
defined('_JEXEC') or die;

//use Exception;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Language\Text;
use Joomla\Component\Kwpanorama\Administrator\Helper\KwpanoramaHelper;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Component\ComponentHelper;


/**
 * Kwpanorama detail view
 */
class HtmlView extends BaseHtmlView
{
	/**
	 * The Form object
	 *
	 * @var    Form
	 * @since  1.5
	 */
	protected $form;

	/**
	 * The active item
	 *
	 * @var    object
	 * @since  1.5
	 */
	protected $item;

	/**
	 * The model state
	 *
	 * @var    object
	 * @since  1.5
	 */
	protected $state;

	/**
	 * Display the view
	 *
	 * @throws Exception
	 */
	public function display($tpl = null)
	{
	/*	$model       = $this->getModel();
		$this->form  = $model->getForm();
		$this->item  = $model->getItem();
		$this->state = $model->getState();*/
		
		
			$this->form  = $this->get("Form");
		$this->item  = $this->get("Item");
		$this->state = $this->get("State");
		
	//$params = ComponentHelper::getParams('com_kwpanorama');
//var_dump($params);
//exit();
		if (count($errors = $this->get('Errors')))
		{
            throw new Exception(implode("\n", $errors));
		}

        $document = Factory::getDocument();
		$wa = $document->getWebAssetManager();
		
//$wa->registerAndUseStyle('kwpframework','components/com_kwpanorama/assets/css/kwpframework.css' );
//$wa->registerAndUseStyle('kwpbrowse', 'components/com_kwpanorama/assets/css/kwpbrowse.css');
$wa->registerAndUseStyle('mystyle', 'components/com_kwpanorama/assets/css/kwpanorama.css');
		//$wa->registerAndUseScript('my-script', 'components/com_kwpanorama/assets/js/detail.js');
		$this->addToolbar();

		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 */
	protected function addToolbar()
	{
		Factory::getApplication()->input->set('hidemainmenu', true);

		$user		= Factory::getUser();
		$isNew		= ($this->item->id == 0);

        if (isset($this->item->checked_out))
		{
		    $checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
        }
		else
		{
            $checkedOut = false;
        }

		$canDo = KwpanoramaHelper::getActions();

		$title = Text::_('COM_KWPANORAMA_TITLE_KWPANORAMA');
		$icon = 'fa fa-file-alt';

		$layout = new FileLayout('joomla.toolbar.title');
		$html = $layout->render([
			'title' => $title,
			'icon' => $icon
		]);

		$app = Factory::getApplication();
		$app->JComponentTitle = str_replace('icon-', '', $html);
		$title = strip_tags($title) . ' - ' . $app->get('sitename') . ' - ' . Text::_('JADMINISTRATION');
		Factory::getDocument()->setTitle($title);

		// If not checked out, can save the item.
		if (!$checkedOut && ($canDo['core.edit'] || ($canDo['core.create'])))
		{
			ToolbarHelper::apply('kwpanorama.apply', 'JTOOLBAR_APPLY');
			ToolbarHelper::save('kwpanorama.save', 'JTOOLBAR_SAVE');
		}

		if (!$checkedOut && ($canDo['core.create']))
		{
			ToolbarHelper::custom('kwpanorama.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
		}

		// If an existing item, can save to a copy.
		if (!$isNew && $canDo['core.create'])
		{
			ToolbarHelper::custom('kwpanorama.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
		}

		if (empty($this->item->id))
		{
			ToolbarHelper::cancel('kwpanorama.cancel', 'JTOOLBAR_CANCEL');
		}
		else
		{
			ToolbarHelper::cancel('kwpanorama.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}
