<?php
/**
 * @package     com_kwpanorama
 * @version     1.0.0
 * @copyright   Copyright (C) 2025. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      KWProductions Co. <webarchitect@kwproductions121.ir> - https://componentgenerator.com
 */

namespace Joomla\Component\Kwpanorama\Site\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;

/**
 * Kwpanorama list controller
 */
class KwpanoramasController extends BaseController
{
	/**
	 * Proxy for getModel.
	 * @since    1.6
	 *
	 * @param string $name
	 * @param string $prefix
	 *
	 * @return mixed
	 */
	public function &getModel($name = 'kwpanorama', $prefix = 'Administrator')
	{
		return parent::getModel($name, $prefix, ['ignore_request' => true]);
	}
}
