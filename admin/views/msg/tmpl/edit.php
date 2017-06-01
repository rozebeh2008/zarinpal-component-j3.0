<?php 
defined( '_JEXEC' ) or die; 

$action =  JRoute::_('index.php?option=com_easypayzarinpal&amp;view=msg&amp;&layout=edit&amp;id='.(int)$this->item->id);
$doc	= JFactory::getDocument();
$doc->addStyleSheet('../media/com_easypayzarinpal/css/admin.stylesheet.css');
?>
<form action="<?php echo $action; ?>" 	method="post" name="adminForm" class="form-validate" id="register-form">
	<div class="width-50 fltlft">
		<fieldset class="adminform">
			<ul class="adminformlist">
			
				<?php foreach ($this->form->getFieldset('msg_table') as $field): ?>
					<li><?php echo $field->label; ?>
					<?php echo $field->input; ?></li>
				<?php endforeach ?>
			</ul>

		</fieldset>
	</div>
	<input type="hidden" name="task" value="msg.edit" />
	<?php echo JHtml::_('form.token'); ?>
</form>