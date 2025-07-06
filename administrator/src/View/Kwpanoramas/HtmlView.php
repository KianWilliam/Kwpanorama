<?php
/**
 * @package     com_kwpanorama
 * @version     1.0.0
 * @copyright   Copyright (C) 2025. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      KWProductions Co. <webarchitect@kwproductions121.ir> - https://componentgenerator.com
 */

namespace Joomla\Component\Kwpanorama\Administrator\View\Kwpanoramas;

// No direct access
defined('_JEXEC') or die;

use JUser;
use Form;
use Exception;
use JHtmlSidebar;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\Component\Kwpanorama\Administrator\Helper\KwpanoramaHelper;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Pagination\Pagination;
use Joomla\Registry\Registry;

/**
 * Kwpanorama list view
 */
class HtmlView extends BaseHtmlView
{
	/**
	 * The Joomla user object
	 *
	 * @var JUser
	 */
	protected $user;

	/**
	 * The search tools form
	 *
	 * @var    Form
	 * @since  1.6
	 */
	public $filterForm;

	/**
	 * The active search filters
	 *
	 * @var    array
	 * @since  1.6
	 */
	public $activeFilters = [];

	/**
	 * An array of items
	 *
	 * @var    array
	 * @since  1.6
	 */
	protected $items = [];

	/**
	 * The pagination object
	 *
	 * @var    Pagination
	 * @since  1.6
	 */
	protected $pagination;

	/**
	 * The model state
	 *
	 * @var    Registry
	 * @since  1.6
	 */
	protected $state;

	/**
	 * @var bool
	 */
	protected $saveOrder;

	/**
	 * @var string
	 */
	protected $saveOrderingUrl;

	/**
	 * Display the view
	 *
	 * @throws Exception
	 */
	public function display($tpl = null)
	{
		$this->user	      = Factory::getUser();

		$model            = $this->getModel();
		$this->state      = $model->getState();
		$this->items      = $model->getItems();
		$this->filterForm = $model->getFilterForm();
		$this->pagination = $model->getPagination();

		// Check for errors
		if (count($errors = $this->get('Errors')))
		{
			throw new GenericDataException(implode("\n", $errors), 500);
		}

		KwpanoramaHelper::addSubmenu('kwpanoramas');

		$this->addToolbar();
		$this->loadTemplateHeader();

		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		$state	= $this->get('State');
		$canDo	= KwpanoramaHelper::getActions($state->get('filter.category_id'));

		$title = Text::_('COM_KWPANORAMA_TITLE_KWPANORAMAS');
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

        if ($canDo['core.create'])
		{
		    ToolbarHelper::addNew('kwpanorama.add','JTOOLBAR_NEW');
	    }

        if ($canDo['core.edit'] && isset($this->items[0]))
		{
		    ToolbarHelper::editList('kwpanorama.edit','JTOOLBAR_EDIT');
	    }

		if ($canDo['core.edit.state'])
		{
            if (isset($this->items[0]->state))
			{
			    ToolbarHelper::divider();
			    ToolbarHelper::custom('kwpanoramas.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			    ToolbarHelper::custom('kwpanoramas.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            }
			else if (isset($this->items[0]))
			{
                //If this component does not use state then show a direct delete button as we can not trash
                ToolbarHelper::deleteList('', 'kwpanoramas.delete','JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state))
			{
			    ToolbarHelper::divider();
			    ToolbarHelper::archiveList('kwpanoramas.archive','JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out))
			{
            	ToolbarHelper::custom('kwpanoramas.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
		}
        
        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state))
		{
		    if ((int)$this->items[0]->state === -2 && $canDo['core.delete'])
			{
			    ToolbarHelper::deleteList('', 'kwpanoramas.delete','JTOOLBAR_EMPTY_TRASH');
			    ToolbarHelper::divider();
		    }
			else if ($canDo['core.edit.state'])
			{
			    ToolbarHelper::trash('kwpanoramas.trash','JTOOLBAR_TRASH');
			    ToolbarHelper::divider();
		    }
        }

		if ($canDo['core.admin'])
		{
			ToolbarHelper::preferences('com_kwpanorama');
		}
		
		JHtmlSidebar::addFilter(
			Text::_('JOPTION_SELECT_PUBLISHED'),
			'filter_published',
			HTMLHelper::_('select.options', HTMLHelper::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.state'), true)
		);
	}

	/**
	 * Load the template header data to simplify the template
	 */
	protected function loadTemplateHeader() : void
	{
		HTMLHelper::_('bootstrap.tooltip');
		HTMLHelper::_('behavior.multiselect');

		$document = Factory::getDocument();
		$wa = $document->getWebAssetManager();
		$wa->registerAndUseStyle('my-style', 'components/com_kwpanorama/assets/css/kwpanorama.css');
		$wa->registerAndUseScript('my-script', 'components/com_kwpanorama/assets/js/list.js');

		$user = Factory::getUser();
		$this->listOrder = $this->escape($this->state->get('list.ordering'));
		$this->listDirn = $this->escape($this->state->get('list.direction'));
		$user->authorise('core.edit.state', 'com_kwpanorama.category');
		$saveOrder = ((string)$this->listOrder === 'a.ordering');

		if ($saveOrder)
		{
			HTMLHelper::_('draggablelist.draggable');
			$this->saveOrderingUrl = 'index.php?option=com_kwpanorama&task=kwpanoramas.saveOrderAjax&tmpl=component&' . Session::getFormToken() . '=1';
		}

		$this->saveOrder = $saveOrder;
	}
}
