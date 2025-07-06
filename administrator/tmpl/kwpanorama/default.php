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

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\HTML\HTMLHelper;

//require Formhelper.php in Helper and with constructor add $this->form to its param
//then call the field which prints all field. echo $this->blah

/** @var \Joomla\Component\Kwpanorama\Administrator\View\Kwpanorama\HtmlView $this */

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->getRegistry()->addExtensionRegistryFile('com_contenthistory');
$wa->useScript('keepalive')
   ->useScript('form.validate')
   ->useScript('com_contenthistory.admin-history-versions');
   var_dump("Hamid:".$this->form->getFieldSets('params'));
?>
<form action="<?php echo Route::_('index.php?option=com_kwpanorama&layout=edit&id=' . $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="adminForm" class="form-validate">
	<div class="row-fluid">
		<div class="span10 form-horizontal">
            <fieldset class="adminform">
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('id'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('id'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('title'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('title'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('alias'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('alias'); ?>
					</div>
				</div>
            	<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('created_by'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('created_by'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('state'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('state'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('slides'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('slides'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('lib'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('lib'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('cube_left'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('cube_left'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('cube_top'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('cube_top'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('image_width'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('image_width'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('image_height'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('image_height'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('cubespeed'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('cubespeed'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('cubebackgroundcolor'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('cubebackgroundcolor'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('dimensionbackgroundcolor'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('dimensionbackgroundcolor'); ?>
					</div>
				</div>
            </fieldset>
    	</div>
        <input type="hidden" name="task" value="" />
        <?php echo HTMLHelper::_('form.token'); ?>
    </div>
	<div id="validation-form-failed" data-backend-detail="kwpanorama" data-message="<?php echo $this->escape(Text::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>">
	</div>
</form>
