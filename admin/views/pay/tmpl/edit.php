<?php defined( '_JEXEC' ) or die; 

$action =  JRoute::_('index.php?option=com_easypayzarinpal&amp;view=pay&amp;&layout=edit&amp;id='.(int)$this->item->id);
$doc	= JFactory::getDocument();
$doc->addStyleSheet('../media/com_easypayzarinpal/css/admin.stylesheet.css');
?>
<form action="<?php echo $action; ?>" 	method="post" name="adminForm" class="form-validate" id="register-form">
	<div class="width-50 fltlft">
		<fieldset class="adminform">
			<ul class="adminformlist">
				<?php foreach ($this->form->getFieldset('pay_table') as $field): ?>
				<li><?php echo $field->label; echo $field->input; ?></li>
				<?php endforeach ?>
				<li>
				<?php echo $this->form->getLabel('msgid'); ?>
				<input id="jform_msgid" class="readonly" type="text" readonly="readonly" value="<?php echo $this->bankmsg; ?>" name="jform[msgid]" size="68" />
				</li>
			</ul>
		</fieldset>
	</div>
	<div class="width-50 fltlft">
		<fieldset class="adminform">
			<ul class="adminformlist">
				<li>
				<?php 
					echo $this->form->getLabel('attachment');
					if($this->form->getValue("attachment")!='NO_UPLOAD')
					{
					$upload=true;?>								
					<a style="color: green;position: relative;right: -85px;top: 22px;font-weight:bold" href="<?php print JURI::root().'media/com_easypayzarinpal/upload/'.$this->form->getValue("attachment"); ?> " target="_blank" >Download</a>
					<?php
					}else{$upload=false;}
					$upload ? print "" : print "<span style='color: red;position: relative;right: -85px;top: 22px;font-weight:bold'>No Upload</span>";
				?>
				</li>
				<li>
				<?php echo $this->form->getLabel('description'); ?>
				<div class="clr"></div>
				<?php echo $this->form->getInput('description'); ?>
				</li>
			</ul>
		</fieldset>
	</div>
	<input type="hidden" name="task" value="pay.edit" />
	<?php echo JHtml::_('form.token'); ?>
</form>