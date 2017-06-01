<?php
defined( '_JEXEC' ) or die;

class EasyPayZarinpalViewPaylist extends JViewLegacy
{
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
		EasyPayZarinpalHelper::addSubmenu('paylist');
		JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');
        //add Toolbar
        $this->addToolbar();
		$this->sidebar = JHtmlSidebar::render();		
        parent::display($tpl);
	}
    
    public function addToolbar()
    {
   		$doc	= JFactory::getDocument();
		$doc->addStyleSheet('../media/com_easypayzarinpal/css/admin.stylesheet.css');
		JToolBarHelper::title(JText::_('COM_EASYPAYZARINPAL_PAYLIST_TITLE'),'paylist.png');
        JToolBarHelper::editList('pay.edit');
        JToolBarHelper::divider();
        JToolBarHelper::publishList('paylist.publish');
        JToolBarHelper::unpublishList('paylist.unpublish');
        JToolBarHelper::archiveList('paylist.archive');
		JToolBarHelper::divider();
		JToolBarHelper::deleteList('', 'paylist.delete');
		JToolBarHelper::trash('paylist.trash');
		JToolBarHelper::divider();
		JToolBarHelper::preferences('com_easypayzarinpal');
    }
}
?>