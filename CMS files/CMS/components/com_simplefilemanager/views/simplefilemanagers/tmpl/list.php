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
	<?php foreach ($this->items as $item) : ?>
		<div class="sfm-item">
			<?php if($item->icon=='') $item->icon="./media/com_simplefilemanager/images/download.png" ?>
			<div class="float icon" style="width:18%">
				<a href="<?php echo JRoute::_('index.php?option=com_simplefilemanager&task=download&id='.(int)$item->id); ?>">
					<img alt="<?php echo $item->title; ?>" src="<?php echo $item->icon; ?>" class="sfm-icon">
				</a>
			</div>
			<div class="float" style="width:80%">
				<h4 class="sfm-title">
					<a href="<?php echo JRoute::_('index.php?option=com_simplefilemanager&task=download&id='.(int)$item->id); ?>">
						<?php echo $item->title; ?>
					</a>
					<?php 
						$time = strtotime($item->file_created);
						$one_week_ago = strtotime('-1 week');
						if( $time > $one_week_ago and  $app->input->get('showNew',1,"int")):
					?>
						<span class="label label-important"><?php echo JText::_('COM_SIMPLEFILEMANAGER_NEW'); ?></span>
					<?php endif; ?>
					<?php if($item->featured==1): ?>
						<span class="label label-warning"><?php echo JText::_('COM_SIMPLEFILEMANAGER_HOT'); ?></span>
					<?php endif; ?>					
				</h4>
				
				<?php if ($app->input->get('showSize',1,"int")): ?>
					<div class="sfm-element"><?php echo round($item->file_size * .0009765625, 2); ?> Kb</div>
				<?php endif; ?>
				
				<?php if ($app->input->get('showDate',1,"int")): ?>
				<div class="sfm-element"><?php echo JHTML::_('date', $item->file_created, JText::_('DATE_FORMAT_LC1')); ?></div>
				<?php endif; ?>
				
				<div class="sfm-element"><?php echo $item->description; ?></div>
			</div>
		</div>
	<?php endforeach; ?>
</div>