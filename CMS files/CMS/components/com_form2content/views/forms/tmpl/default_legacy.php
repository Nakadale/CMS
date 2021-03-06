<?php
// No direct access 
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.framework');
JHtml::_('behavior.tooltip');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');

$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$saveOrder	= $listOrder == 'a.ordering';
$f2cConfig	= F2cFactory::getConfig();
$dateFormat = str_replace('%', '', $f2cConfig->get('date_format'));
?>
<div class="f2c-articlemanager<?php echo htmlspecialchars($this->params->get('pageclass_sfx')); ?>">
<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
<?php endif; ?>
<form action="<?php echo JRoute::_('index.php?option=com_form2content&task=forms.display&view=forms');?>" method="post" name="adminForm" id="adminForm">

	<table style="width:100%;">
	<tr>
		<td>
			<div style="float: left;">
				<?php if($this->menuParms->get('show_new_button', 0)) : ?>
				<button type="button" onclick="javascript:Joomla.submitbutton('form.add')"><?php echo JText::_('COM_FORM2CONTENT_NEW'); ?></button>
				<?php endif; ?>
				<?php if($this->menuParms->get('show_copy_button', 1)) : ?>
				<button type="button" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('<?php echo JText::sprintf(JText::_('COM_FORM2CONTENT_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST_TO'), JText::_('COM_FORM2CONTENT_COPY')); ?>');}else{  Joomla.submitbutton('forms.copy')}"><?php echo JText::_('COM_FORM2CONTENT_COPY'); ?></button>
				<?php endif; ?>
				<?php if($this->menuParms->get('show_edit_button', 1)) : ?>
				<button type="button" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('<?php echo JText::sprintf(JText::_('COM_FORM2CONTENT_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST_TO'), JText::_('COM_FORM2CONTENT_EDIT')); ?>');}else{  Joomla.submitbutton('form.edit')}"><?php echo JText::_('COM_FORM2CONTENT_EDIT'); ?></button>
				<?php endif; ?>
				<?php if($this->menuParms->get('show_publish_button', 1)) : ?>
				<button type="button" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('<?php echo JText::sprintf(JText::_('COM_FORM2CONTENT_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST_TO'), JText::_('COM_FORM2CONTENT_PUBLISH')); ?>');}else{  Joomla.submitbutton('forms.publish')}"><?php echo JText::_('COM_FORM2CONTENT_PUBLISH'); ?></button>
				<button type="button" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('<?php echo JText::sprintf(JText::_('COM_FORM2CONTENT_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST_TO'), JText::_('COM_FORM2CONTENT_UNPUBLISH')); ?>');}else{  Joomla.submitbutton('forms.unpublish')}"><?php echo JText::_('COM_FORM2CONTENT_UNPUBLISH'); ?></button>
				<?php endif; ?>
				<?php if($this->menuParms->get('show_delete_button', 1)) : ?>
				<button type="button" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('<?php echo JText::sprintf(JText::_('COM_FORM2CONTENT_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST_TO'), JText::_('COM_FORM2CONTENT_DELETE')); ?>');}else{  Joomla.submitbutton('forms.delete')}"><?php echo JText::_('COM_FORM2CONTENT_DELETE'); ?></button>
				<?php endif; ?>			
				</div>
		</td>
	</tr>
	</table>
	<fieldset id="filter-bar">	
		<div class="filter-search fltlft">
			<?php if($this->menuParms->get('show_search_filter')) : ?>
				<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
				<input type="text" name="forms_filter_search" id="forms_filter_search" value="<?php echo $this->escape($this->state->get('forms.filter.search')); ?>" title="<?php echo JText::_('COM_FORM2CONTENT_FILTER_SEARCH_DESC'); ?>" />
				<button type="submit" class="btn"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
				<button type="button" onclick="document.id('forms_filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
			<?php endif; ?>
		</div>
		<div class="filter-select fltrt">
			<?php if($this->menuParms->get('show_category_filter')) : ?>
			<select name="forms_filter_category_id" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_CATEGORY');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('category.options', 'com_content'), 'value', 'text', $this->state->get('forms.filter.category_id'));?>
			</select>
			<?php endif; ?>
		</div>
	</fieldset>
	<div class="clr"></div>	
	<table class="adminlist">
		<thead>
			<tr>
				<th width="1%" class="nowrap">
					<?php echo JHtml::_('grid.sort', 'COM_FORM2CONTENT_GRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
				</th>				
				<th width="1%">
					<input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" />
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_FORM2CONTENT_TITLE', 'a.title', $listDirn, $listOrder); ?>
				</th>
				<?php if($this->menuParms->get('show_published_column')) : ?>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_FORM2CONTENT_PUBLISHED', 'a.state', $listDirn, $listOrder); ?>
				</th>
				<?php endif; ?>
				<?php if($this->menuParms->get('show_ordering')) : ?>
				<th width="15%">
					<?php echo JHtml::_('grid.sort',  'COM_FORM2CONTENT_GRID_HEADING_ORDERING', 'a.ordering', $listDirn, $listOrder); ?>
					<?php if ($saveOrder) :?>
						<?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'forms.saveorder'); ?>
					<?php endif; ?>
				</th>
				<?php endif; ?>
				<?php if($this->menuParms->get('show_category')) : ?>
				<th width="10%">
					<?php echo JHtml::_('grid.sort', 'COM_FORM2CONTENT_CATEGORY', 'category_title', $listDirn, $listOrder); ?>
				</th>
				<?php endif; ?>
				<?php if($this->menuParms->get('show_author_column')) : ?>
				<th width="10%">
					<?php echo JHtml::_('grid.sort', 'COM_FORM2CONTENT_GRID_HEADING_CREATED_BY', 'a.created_by', $listDirn, $listOrder); ?>
				</th>
				<?php endif; ?>
				<?php if($this->menuParms->get('show_created_column')) : ?>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_FORM2CONTENT_CREATED', 'a.created', $listDirn, $listOrder); ?>
				</th>
				<?php endif; ?>
				<?php if($this->menuParms->get('show_modified_column')) : ?>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_FORM2CONTENT_MODIFIED', 'a.modified', $listDirn, $listOrder); ?>
				</th>
				<?php endif; ?>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="10">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach ($this->items as $i => $item) :
			$item->max_ordering = 0; //??
			
			$ordering	= ($listOrder == 'a.ordering');
			$canEdit	= $user->authorise('core.edit', 'com_form2content.form.'.$item->id);
			$canCheckin = true;
			$canEditOwn	= $user->authorise('core.edit.own', 'com_form2content.form.'.$item->id) && $item->created_by == $userId;
			$canChange	= $user->authorise('core.edit.state', 'com_form2content.form.'.$item->id) && $canCheckin;
			?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php echo (int) $item->id; ?>
				</td>			
				<td class="center">
					<?php echo JHtml::_('grid.id', $i, $item->id); ?>
				</td>
				<td>
					<?php if ($canEdit || $canEditOwn) : ?>
						<a href="<?php echo JRoute::_('index.php?option=com_form2content&task=form.edit&id='.$item->id);?>">
							<?php echo $this->escape($item->title); ?></a>
					<?php else : ?>
						<?php echo $this->escape($item->title); ?>
					<?php endif; ?>
				</td>
				<?php if($this->menuParms->get('show_published_column')) : ?>
				<td class="center">
					<?php echo JHtml::_('jgrid.published', $item->state, $i, 'forms.', $canChange, 'cb', $item->publish_up, $item->publish_down); ?>
				</td>
				<?php endif; ?>
				<?php if($this->menuParms->get('show_ordering')) : ?>				
				<td class="order">
					<?php if ($canChange) : ?>
						<?php if ($saveOrder) :?>
							<?php if ($listDirn == 'asc') : ?>
								<span><?php echo $this->pagination->orderUpIcon($i, ($item->catid == @$this->items[$i-1]->catid), 'forms.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
								<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, ($item->catid == @$this->items[$i+1]->catid), 'forms.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
							<?php elseif ($listDirn == 'desc') : ?>
								<span><?php echo $this->pagination->orderUpIcon($i, ($item->catid == @$this->items[$i-1]->catid), 'forms.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
								<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, ($item->catid == @$this->items[$i+1]->catid), 'forms.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
							<?php endif; ?>
						<?php endif; ?>
						<?php $disabled = $saveOrder ?  '' : 'disabled="disabled"'; ?>
						<input type="text" name="order[]" size="5" value="<?php echo $item->ordering;?>" <?php echo $disabled ?> class="text-area-order" />
					<?php else : ?>
						<?php echo $item->ordering; ?>
					<?php endif; ?>
				</td>
				<?php endif; ?>
				<?php if($this->menuParms->get('show_category')) : ?>
				<td class="center">
					<?php echo $this->escape($item->name); ?>
				</td>
				<?php endif; ?>
				<?php if($this->menuParms->get('show_author_column')) : ?>								
				<td class="center">
					<?php echo $this->escape($item->creator); ?>
				</td>
				<?php endif; ?>
				<?php if($this->menuParms->get('show_created_column')) : ?>				
				<td class="center nowrap">
					<?php echo JHTML::_('date',$item->created, $dateFormat); ?>
				</td>
				<?php endif; ?>
				<?php if($this->menuParms->get('show_modified_column')) : ?>				
				<td class="center nowrap">
					<?php
					if($item->modified && ($item->modified != $this->nullDate))
					{
						echo JHTML::_('date',$item->modified, $dateFormat);
					} 
					?>
				</td>
				<?php endif; ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>	
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>	
</form>
</div>