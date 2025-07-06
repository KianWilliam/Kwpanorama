<?php
/**
 * @package     com_kwpanorama
 * @version     1.0.0
 * @copyright   Copyright (C) 2025. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      KWProductions Co. <webarchitect@kwproductions121.ir> - https://componentgenerator.com
 */

namespace Joomla\Component\Kwpanorama\Administrator\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\Component\Kwpanorama\Administrator\Helper\FormHelper;
use Joomla\Component\Kwpanorama\Administrator\Helper\KwpanoramaHelper;
use Joomla\CMS\Form\Form;


/**
 * Kwpanorama model
 */
class KwpanoramasModel extends ListModel
{
	/**
	 * @var		array		An array with the filtering columns
	 */
	protected $filter_fields;
	
    /**
     * Constructor
     *
     * @param    array    		An optional associative array of configuration settings
	 *
     * @see      JController
     * @since    1.6
     */
    public function __construct($config = array())
    {
        if (empty($config['filter_fields']))
        {
            $config['filter_fields'] = array(
				'id', 'a.id',
				'created_by', 'a.created_by',
				'state', 'a.state',
				'ordering', 'a.ordering',
				'title','a.title',
				'alias','a.alias',
				'visual','a.visual',
				'description','a.description',
				'checked_out','a.check_out',
				'checked_out_time','a.checked_out_time',
				'params','a.params',
				);
				
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state
     *
     * Note. Calling getState in this method will result in recursion
     *
     * @param null $ordering
     * @param null $direction
     * @throws Exception
     */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables
		$app = Factory::getApplication('administrator');

		// Load the filter state
		$search = $app->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $app->getUserStateFromRequest($this->context.'.filter.state', 'filter_published', '', 'int');
		$this->setState('filter.state', $published);

		// List state information
		$value = $app->input->get('limit', $app->get('list_limit', 20), 'uint');
		$this->setState('list.limit', $value);

		$value = $app->input->get('limitstart', 0, 'uint');
		$this->setState('list.start', $value);

		// Load the parameters
		$params = ComponentHelper::getParams('com_kwpanorama');
		$this->setState('params', $params);

		// List state information
		parent::populateState('a.title', 'asc');
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	DatabaseQuery
	 * @since	1.6
	 */
	protected function getListQuery()
	{
		$query	= $this->_db->getQuery(true);

		$query->select('a.id, a.state, a.ordering, a.created_by');

		$query->from('`#__kwpanorama` AS a');

	//	$query->select('b.name AS `created_by`');
		//$query->leftJoin($this->_db->qn('#__users') . ' AS `b` ON b.id = a.created_by');

		// Filter by published state
		$state = $this->getState('filter.published');

		if (is_numeric($state))
		{
			$query->where('a.state = ' . (int)$state);
		}
		elseif ($state !== '*')
		{
			$query->where('(a.state IN (0, 1))');
		}

		// Search for this word
		$searchPhrase = $this->getState('filter.search');

		// Search in these columns
		$searchColumns = array(
            'a.title',
        );

		if (!empty($searchPhrase))
		{
			if (stripos($searchPhrase, 'id:') === 0)
			{
				// Build the ID search
				$idPart = (int) substr($searchPhrase, 3);
				$query->where($this->_db->qn('a.id') . ' = ' . $this->_db->q($idPart));
			}
			else
			{
				// Build the search query from the search word and search columns
				$query = KwpanoramaHelper::buildSearchQuery($searchPhrase, $searchColumns, $query);
			}
		}

        $query->group($this->_db->qn('a.id'));

		// Add the list ordering clause
        $orderCol	= $this->state->get('list.ordering');
        $orderDirn	= $this->state->get('list.direction');

        if ($orderCol && $orderDirn)
        {
	        $query->order($this->_db->escape($orderCol.' '.$orderDirn));
        }

		return $query;
	}

    /**
     * Method to get an array of data items
     *
     * @return  mixed An array of data on success, false on failure.
     
    public function getItems()
    {
        Form::addFormPath(JPATH_ADMINISTRATOR . '/components/com_kwpanorama/forms');
        $form = $this->loadForm('com_kwpanorama.kwpanorama', 'kwpanorama', [
            'control' => 'jform',
            'load_data' => true
        ]);
        $formHelper = new FormHelper($form);
        return $formHelper->appendFieldOptions(parent::getItems())->getAll();
    }*/
}
