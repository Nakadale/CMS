<?php
/**
 * @package     Simple File Manager
 * @author			Giovanni Mansillo
 *
 * @copyright   Copyright (C) 2005 - 2014 Flow Solutions. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

$app = JFactory::getApplication();
?>

<div class="simplefilemanager sfm-list">
	<table class="table table-hover">
		<thead>
			<tr>
				<th><?php echo JText::_('COM_SIMPLEFILEMANAGER_HEADING_TITLE'); ?></th>
				<?php if ($app->input->get('showDate',1,"int")): ?>
					<th><?php echo JText::_('COM_SIMPLEFILEMANAGER_HEADING_CREATED'); ?></th>
				<?php endif; ?>
				<th><?php echo JText::_('COM_SIMPLEFILEMANAGER_HEADING_FILE'); ?></th>
			</tr>
		</thead>
		<tbody>
		
		<?php foreach ($this->items as $item) : ?>
              
			<tr class="sfm-item">
				<td class="sfm-title">
					<strong><?php echo $item->title; ?></strong>
					<?php 
						$time = strtotime($item->file_created);
						$one_week_ago = strtotime('-1 week');
						if( $time > $one_week_ago and  $app->input->get('showNew',1,"int")):
					?>
						<span class="label label-important"><?php echo JText::_('COM_SIMPLEFILEMANAGER_NEW'); ?></span>
						<?php if($item->featured==1): ?>
							<span class="label label-warning"><?php echo JText::_('COM_SIMPLEFILEMANAGER_HOT'); ?></span>
						<?php endif; ?>
					<?php endif; ?>
					<p><?php echo $item->description; ?></p>
				</td>
				
				<?php if ($app->input->get('showDate',1,"int")): ?>
					<td>
						<?php echo JHTML::_('date', $item->file_created, JText::_('DATE_FORMAT_LC1')); ?></div>
					</td>
				<?php endif; ?>
				
				<?php if($item->icon=='') $item->icon="./media/com_simplefilemanager/images/download.png" ?>
				<td>
					<?php if ($app->input->get('showSize',1,"int")): ?><?php echo round($item->file_size * .0009765625, 2); ?> Kb<br><?php endif; ?>
					<a href="<?php echo JRoute::_('index.php?option=com_simplefilemanager&task=download&id='.(int)$item->id); ?>">
						<img alt="<?php echo $item->title; ?>" src="<?php echo $item->icon; ?>" class="sfm-icon">
					</a>
				</td>
			</tr>
			
		<?php endforeach; ?>
		</tbody>
  </table>
</div>