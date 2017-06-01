<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
class EasyPayZarinpalController extends JControllerLegacy
{	public function display($cachable = false, $urlparams = false)
	{
	
		$request_view = JRequest::setVar('view', JRequest::getCmd('view', 'pay'));
		if(JRequest::getVar('view')!="pay")
			JRequest::setVar('view', JRequest::getCmd('view', 'pay'));
		
		return parent::display($cachable, $urlparams);
	}
}
?>
