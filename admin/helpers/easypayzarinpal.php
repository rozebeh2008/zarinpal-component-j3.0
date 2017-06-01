<?php
// No direct access to this file
defined('_JEXEC') or die;

class EasyPayZarinpalHelper
{
	public static function addSubmenu($vname) 
	{
		JHtmlSidebar::addEntry(JText::_('COM_EASYPAYZARINPAL_SUBMENU_PAYLIST'),
		                         'index.php?option=com_easypayzarinpal', $vname == 'paylist');
		JHtmlSidebar::addEntry(JText::_('COM_EASYPAYZARINPAL_SUBMENU_MSGLIST'),
		                         'index.php?option=com_easypayzarinpal&amp;view=msglist', $vname == 'msglist');
	}

	public static function getMsgOptions()
	{
		// Initialize variables.
		$options = array();
	
		$db     = JFactory::getDbo();
		$query  = $db->getQuery(true);
	
		$query->select('code As value, code As text');
		$query->from('#__easypayzarinpal_bankmsg AS a');
		$query->order('a.code');
	
		// Get the options.
		$db->setQuery($query);
		$options = $db->loadObjectList();
	
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
	
		return $options;
	}
}
?>