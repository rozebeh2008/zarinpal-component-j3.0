<?php
defined( '_JEXEC' ) or die;

//jimport( 'joomla.application.component.view');
class EasyPayZarinpalViewPay extends JViewLegacy
{
	protected $item;
	protected $form;
	protected $bankmsg;
	public function display($tpl = null)
	{
		$this->item	=	$this->get('Item');
		$this->form	=	$this->get('Form');
		$this->bankmsg  =	$this->get('BankMsg');
        
		$errors = $this->get('Errors');
        if(count($errors))
        {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
		$this->addToolbar();
		parent::display($tpl);
	}
	
	public function addToolbar()
	{
		
		JRequest::setVar('hidemainmenu', true);
		
		$doc	= JFactory::getDocument();
		$doc->addStyleSheet('../media/com_easypayzarinpal/css/admin.stylesheet.css');
		if($this->item->id)
		{
			JToolBarHelper::title(JText::_('COM_EASYPAYZARINPAL_EDIT_PAYLIST_TITLE'),'paylist.png');
		}
		else
		{
			ToolBarHelper::title(JText::_('COM_EASYPAYZARINPAL_ADD_PAYLIST_TITLE'),'paylist.png');
		}
		JToolBarHelper::apply('pay.apply','JTOOLBAR_APPLY');
		JToolBarHelper::save('pay.save','JTOOLBAR_SAVE');
		JToolBarHelper::cancel('pay.cancel');		
	}
}
?>