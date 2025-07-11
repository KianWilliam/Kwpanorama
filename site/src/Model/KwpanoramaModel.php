<?php
/**
 * @package     com_kwpanorama
 * @version     1.0.0
 * @copyright   Copyright (C) 2025. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      KWProductions Co. <webarchitect@kwproductions121.ir> - https://componentgenerator.com
 */

namespace Joomla\Component\Kwpanorama\Site\Model;

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\FormModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\Component\Kwpanorama\Administrator\Helper\FormHelper;
use Joomla\Component\Kwpanorama\Site\Helper\DatetimeHelper;

/**
 * Kwpanorama detail model
 */
class KwpanoramaModel extends FormModel
{
	/**
	 * The item to hold data
	 *
	 * @return object
	 */
    protected $_item;

    /**
     * @return void
     * @throws \Exception
     */
    private function fetchItem()
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);

     //   $query->select('a.id, a.state, a.ordering');
		        $query->select('a.*');


        $query->from('#__kwpanorama as a');

        $query->select('b.name AS `created_by`');
		$query->leftJoin($this->_db->qn('#__users') . ' AS `b` ON b.id = a.created_by');

        $query->where($db->qn('a.id') . ' = ' . $db->q($this->getId()));
        $db->setQuery($query);

        try {
            $db->execute();
        } catch (\RuntimeException $e) {
            throw new \Exception($e->getMessage(), 500);
        }

        $this->_item = $db->loadObject();
    }

    /**
     * @return int
     * @throws \Exception
     */
    private function getId(): int
    {
        $app = Factory::getApplication();

        $id = $app->input->getInt('id');
        $params = $app->getParams();

        $paramId = $params->get('id');
        if ($paramId && $id === null) {
            return (int)$paramId;
        }

        return (int)$id;
    }

    /**
     * Get the data
     *
     * @param null $pk
     *
     * @return  object
     *
     * @throws \Exception
     * @since   1.6
     */
	public function getItem($pk = null)
	{
		if (isset($this->_item)) {
			return $this->_item;
		}

        $this->fetchItem();

        Form::addFormPath(JPATH_ADMINISTRATOR . '/components/com_kwpanorama/forms');
        $form = $this->loadForm('com_kwpanorama.kwpanorama', 'kwpanorama', [
            'control' => 'jform',
            'load_data' => true
        ]);
        $formHelper = new FormHelper($form);
        return $formHelper->appendFieldOptions([$this->_item])->getOne();
	}

    /**
     * Method to get the form.
     *
     * The base form is loaded from XML
     *
     * @param	array	$data		An optional array of data for the form to interogate.
     * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
     * @return	Form	A JForm object on success, false on failure
     * @throws \Exception
     * @since	1.6
     */
    public function getForm($data = [], $loadData = true)
    {
        Form::addFormPath(JPATH_ADMINISTRATOR . '/components/com_kwpanorama/forms');

        $app = Factory::getApplication();
        $id = $app->input->getInt('id');
        $params = $app->getParams();
        $paramId = $params->get('id');
        if ($paramId && !$id) {
            $id = $paramId;
        }
        if (empty($id)) {
            $loadData = false;
        }

        // Get the form
        $form = $this->loadForm('com_kwpanorama.kwpanorama', 'kwpanorama', ['control' => 'jform', 'load_data' => $loadData]);
        if (empty($form)) {
            return false;
        }

        return $form;
    }
}
