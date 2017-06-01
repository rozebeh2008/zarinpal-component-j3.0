<?php
defined( '_JEXEC' ) or die; 

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.tooltip');

$params = JComponentHelper::getParams('com_easypayzarinpal');
?>
<fieldset>
	<legend><?php echo JText::_('COM_EASYPAYZARINPAL_LEGEND_PAYMENT');?></legend>
	<form id="pay" name="pay" class="form-validate" action="<?php echo JRoute::_('index.php'); ?>" method="post" <?php ($params->get('attachment')) ? print 'enctype="multipart/form-data"' : print null; ?>>
		<table style="width:100%">
			<tr>
				<td><?php echo $this->form->getLabel('firstname'); ?></td>
				<td><?php echo $this->form->getInput('firstname'); ?></td>
			</tr>
			<tr>
				<td><?php echo $this->form->getLabel('lastname'); ?></td>
				<td><?php echo $this->form->getInput('lastname'); ?></td>
			</tr>
			<tr>
				<td><?php echo $this->form->getLabel('email'); ?></td>
				<td><?php echo $this->form->getInput('email'); ?></td>
			</tr>
			<?php if($params->get('phone')):?>
			<tr>
				<td><?php echo $this->form->getLabel('phone'); ?></td>
				<td><?php echo $this->form->getInput('phone'); ?></td>
			</tr>
			<?php endif;?>
			<tr>
				<td><?php echo $this->form->getLabel('mobile'); ?></td>
				<td><?php echo $this->form->getInput('mobile'); ?></td>
			</tr>
			<?php if($params->get('mellicode')):?>
			<tr>
				<td><?php echo $this->form->getLabel('mellicode'); ?></td>
				<td><?php echo $this->form->getInput('mellicode'); ?></td>
			</tr>
			<?php endif;?>
			<?php if($params->get('state')):?>
			<tr>
				<td><?php echo $this->form->getLabel('state'); ?></td>
				<td><?php echo $this->form->getInput('state'); ?></td>
			</tr>
			<?php endif;?>
			<?php if($params->get('city')):?>
			<tr>
				<td><?php echo $this->form->getLabel('city'); ?></td>
				<td><?php echo $this->form->getInput('city'); ?></td>
			</tr>
			<?php endif;?>
			<?php if($params->get('address')):?>
			<tr>
				<td><?php echo $this->form->getLabel('address'); ?></td>
				<td><?php echo $this->form->getInput('address'); ?></td>
			</tr>
			<?php endif;?>
			<?php if($params->get('postcode')):?>
			<tr>
				<td><?php echo $this->form->getLabel('postcode'); ?></td>
				<td><?php echo $this->form->getInput('postcode'); ?></td>
			</tr>
			<?php endif;?>
			<?php if($params->get('attachment')):?>
			<tr>
				<td><?php echo $this->form->getLabel('attachment'); ?></td>
				<td><?php echo $this->form->getInput('attachment'); ?></td>
			</tr>
			<?php endif;?>
			<tr>
				<td><?php echo $this->form->getLabel('cost'); ?></td>
				<td><input type="text" name="jform[cost]" id="jform_cost" value="<?php print JRequest::getInt('cost','20000'); ?>" class="inputbox required" size="50"/></td>
			</tr>
			<?php if($params->get('description')):?>
			<tr>
				<td><?php echo $this->form->getLabel('description'); ?></td>
				<td><?php echo $this->form->getInput('description'); ?></td>
			</tr>
			<?php endif;?>
			<tr>
				<td colspan="2">
					<input type="hidden" name="option" value="com_easypayzarinpal" />
					<input type="hidden" name="task" value="pay.submit" />
				</td>
			</tr>
			<tr>
				<td><label><?php print JText::_("COM_EASYPAYZARINPAL_FIELD_PAYMENT_LABEL"); ?></label></td>
				<td>
					<input type="submit" name="payment" value="<?php print JText::_("COM_EASYPAYZARINPAL_FIELD_PAYMENT_SUBMIT_LABEL"); ?>" />
					<?php echo JHtml::_('form.token'); ?>
				</td>
			</tr>
		</table>
	</form>
</fieldset>
<?php if($params->get('sign')):?>
<div style="width:100%;padding:5px;text-align:center"><a style="color: gray;font-size: 1em;" title="<?php print JText::_('YOUR_SIGN_TITLE'); ?>" href="http://www.yoursite.com" target="_blank"><?php print JText::_('YOUR_SIGN_LINK'); ?></a></div>
<?php endif; ?>