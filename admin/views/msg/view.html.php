<?php
defined( '_JEXEC' ) or die;

//jimport( 'joomla.application.component.view');
class EasyPayZarinpalViewMsg extends JViewLegacy
{
	protected $item;
	protected $form;
	
	public function display($tpl = null)
	{
		$this->item	=	$this->get('Item');
		$this->form	=	$this->get('Form');        
		
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
			JToolBarHelper::title(JText::_('COM_EASYPAYZARINPAL_EDIT_MSGLIST_TITLE'),'msglist.png');
		}
		else
		{
			JToolBarHelper::title(JText::_('COM_EASYPAYZARINPAL_ADD_MSGLIST_TITLE'),'msglist.png');
		}
		JToolBarHelper::apply('msg.apply','JTOOLBAR_APPLY');
		JToolBarHelper::save('msg.save','JTOOLBAR_SAVE');
		JToolBarHelper::save2new('msg.save2new','JTOOLBAR_SAVE_AND_NEW');
		JToolbarHelper::cancel('banner.cancel');
	}
}
?>