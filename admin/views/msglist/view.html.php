<?php
defined( '_JEXEC' ) or die;

class EasyPayZarinpalViewMsglist extends JViewLegacy
{
	protected $sidebar = '';	
    protected $items;
	protected $pagination;
	protected $state;

	public function display($tpl = null)
	{
        $this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}		
		EasyPayZarinpalHelper::addSubmenu('msglist');
        $this->sidebar = JHtmlSidebar::render();
		
        //add Toolbar
        $this->addToolbar();
        parent::display($tpl);
	}
    
    public function addToolbar()
    {
   		$doc	= JFactory::getDocument();
	//	$doc->addStyleSheet('../media/com_easypayzarinpal/css/admin.stylesheet.css');
		JToolBarHelper::title(JText::_('COM_EASYPAYZARINPAL_MSGLIST_TITLE'),'msglist.png');
		JToolBarHelper::addNew('msg.add');
		JToolBarHelper::editList('msg.edit');
		JToolBarHelper::deleteList('', 'msglist.delete');
    }
}
?>