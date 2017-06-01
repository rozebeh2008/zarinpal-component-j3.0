<?php    
defined( '_JEXEC' ) or die;
jimport( 'joomla.html.html.tabs' );
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.tooltip');

$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));

?>
<form action="index.php?option=com_easypayzarinpal&amp;view=msglist" method="post" name="adminForm" id="adminForm">
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
<div id="j-main-container" class="span10">	
    <div class="filter-search fltlft">
      <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search', '')); ?>" title="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>"/>
      <button type="submit" class="btn"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
      <button type="button" onclick="document.id('filter_search').value='';this.form.submit();">
      <?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>
      </button>
    </div>
		<div class="filter-select fltrt">
			<select name="filter_msgid" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('COM_EASYPAYZARINPAL_SELECT_MSGID');?></option>
				<?php echo JHtml::_('select.options',  EasyPayZarinpalHelper::getMsgOptions(), 'value', 'text', $this->state->get('filter.msgid'), true);?>
			</select>
			<select name="filter_published" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true);?>
			</select>
		</div>

	<div class="clr"> </div>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>    <?php echo JText::_('COM_EASYPAYZARINPAL_FIELD_ROW_LABEL');   ?></th>
                <th width="1%">
                    <input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" />
                </th>
				<th><?php echo JHtml::_('grid.sort', 'COM_EASYPAYZARINPAL_FIELD_MSG_LABEL', 'msg', $listDirn, $listOrder) ?></th>
				<th><?php echo JHtml::_('grid.sort', 'COM_EASYPAYZARINPAL_FIELD_CODE_LABEL', 'code', $listDirn, $listOrder) ?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="4"><?php echo $this->pagination->getListFooter(); ?></td>
			</tr>
		</tfoot>
		<tbody>
			<?php
				$radif  =   0;
				foreach($this->items as $i => $item) :
			?>
			<tr class="row<?php echo $i % 2 ?>">
				<td class="center"> <?php $radif = $i; echo ++$radif; ?> </td>
				<td class="center">
					<?php echo JHtml::_('grid.id',   $i, $item->id)?>
				</td>
				<td class="center"><a href='index.php?option=com_easypayzarinpal&amp;task=msg.edit&amp;id=<?php print $item->id;?>'><?php echo $this->escape($item->msg)?></a></td>
				<td class="center"><?php echo $this->escape($item->code)?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	<?php echo JHtml::_('form.token'); ?>
	</div>
</form>