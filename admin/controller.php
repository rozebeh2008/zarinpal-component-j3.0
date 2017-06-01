<?php
defined( '_JEXEC' ) or die;
//JLoader::register('EasyPayZarinpalHelper', JPATH_ADMINISTRATOR . '/components/com_easypayzarinpal/helpers/easypayzarinpal.php');

//jimport('joomla.application.component.controller');
class EasyPayZarinpalController extends JControllerLegacy
{
    public function display($cachable = false, $urlparams = false)
    {
        JRequest::setVar('view', JRequest::getCmd('view', 'paylist'));
        parent::display($cachable, $urlparams);
    }
}
?>