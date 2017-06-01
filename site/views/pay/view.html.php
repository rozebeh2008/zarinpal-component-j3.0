<?php
defined( '_JEXEC' ) or die;

class EasyPayZarinpalViewPay extends JViewLegacy
{
	protected $form;

	public function display($tpl = null)
	{
		$this->form	= $this->get('Form');
		parent::display($tpl);
	}
}
?>