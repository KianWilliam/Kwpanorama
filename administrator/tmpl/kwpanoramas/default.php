<?php
/**
 * @package     com_kwpanorama
 * @version     1.0.0
 * @copyright   Copyright (C) 2025. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      KWProductions Co. <webarchitect@kwproductions121.ir> - https://componentgenerator.com
 */

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\Component\Kwpanorama\Administrator\Helper\KwpanoramaHelper;
?>
<?php $listOrder = $this->listOrder; ?>
<?php $listDirn = $this->listDirn;
$saveOrder = $listOrder;
if ($listOrder && !empty($this->items))
{
	$this->saveOrderingUrl = 'index.php?option=com_kwpanorama&task=kwpanoramas.saveOrderAjax&tmpl=component&' . Session::getFormToken() . '=1';
	HTMLHelper::_('draggablelist.draggable');
}
?>
<form action="<?php echo Route::_('index.php?option=com_kwpanorama&view=kwpanoramas'); ?>" method="post" name="adminForm" id="adminForm" data-list-order="<?php echo $listOrder; ?>">
	<?php if(!empty($this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
		<?php else : ?>
		<?php echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>
		<div id="j-main-container">
			<?php endif;?>
			<table class="table table-striped" id="kwpanoramaList">
				<thead>
					<tr>
						<?php if (isset($this->items[0]->ordering)): ?>
							<th width="1%" class="nowrap center hidden-phone">
								<?php echo HTMLHelper::_('grid.sort', '<i class="icon-menu-2"></i>', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
							</th>
						<?php endif; ?>
						<th width="1%" class="nowrap center">
							<?php echo HTMLHelper::_('grid.checkall'); ?>
						</th>
						<th class="left">
							<?php echo HTMLHelper::_('grid.sort',  'COM_KWPANORAMA_HEADING_BACKEND_LIST_KWPANORAMAS_CREATED_BY', 'a.created_by', $listDirn, $listOrder); ?>
						</th>
						<th class="left">
							<?php echo HTMLHelper::_('grid.sort',  'COM_KWPANORAMA_HEADING_BACKEND_LIST_KWPANORAMAS_STATE', 'a.state', $listDirn, $listOrder); ?>
						</th>
						<th width="1%" class="nowrap">
							<?php echo HTMLHelper::_('grid.sort', 'COM_KWPANORAMA_HEADING_BACKEND_LIST_KWPANORAMAS_ID', 'a.id', $listDirn, $listOrder); ?>
						</th>
					</tr>
				</thead>
				<tbody <?php if ($saveOrder) :?> class="js-draggable" data-url="<?php echo $this->saveOrderingUrl; ?>" data-direction="<?php echo strtolower($listDirn); ?>" data-nested="true"<?php endif; ?>>
				<?php
				foreach ($this->items as $i => $item) :
					$ordering   = ($listOrder == 'a.ordering');
					$canCreate	= $this->user->authorise('core.create',		'com_kwpanorama');
					$canEdit	= $this->user->authorise('core.edit',		'com_kwpanorama');
					$canCheckin	= $this->user->authorise('core.manage',		'com_kwpanorama');
					$canChange	= $this->user->authorise('core.edit.state',	'com_kwpanorama');
					?>
					<tr class="row<?php echo $i % 2; ?>" data-draggable-group="1">
						<td class="order nowrap center hidden-phone">
							<?php
							$iconClass = '';
							if (!$canChange)
							{
								$iconClass = ' inactive';
							}
							elseif (!$this->saveOrder)
							{
								$iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::tooltipText('JORDERINGDISABLED');
							}
							?>
							<span class="sortable-handler<?php echo $iconClass; ?>">
								<span class="icon-ellipsis-v"></span>
							</span>
							<?php if ($canChange && $this->saveOrder) : ?>
								<input type="text" style="display:none" name="order[]" size="5"
									   value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />
							<?php endif; ?>
						</td>
						<td class="center">
							<?php echo HTMLHelper::_('grid.id', $i, $item->id); ?>
						</td>
						<td>
							<?php echo $item->created_by; ?>
						</td>
						<td>
							<?php echo HTMLHelper::_('jgrid.published', $item->state, $i, 'kwpanoramas.', $canChange, 'cb'); ?>
						</td>
						<td>
							<a href="<?php echo Route::_('index.php?option=com_kwpanorama&task=kwpanorama.edit&id=' . $item->id); ?>">
								<?php echo $item->id; ?>
							</a>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<div class="pagination center">
				<?php echo $this->pagination->getListFooter(); ?>
			</div>
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="boxchecked" value="0" />
			<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
			<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
			<?php echo HTMLHelper::_('form.token'); ?>
		</div>
	</div>
</form>
