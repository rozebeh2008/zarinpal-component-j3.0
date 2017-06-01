<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.controlleradmin');
class EasyPayZarinpalControllerMsglist extends JControllerAdmin
{
    public function getModel($name = 'Msg', $prefix = 'EasyPayZarinpalModel', $config = array('ignore_request' => true))
    {
        $model = parent::getModel($name, $prefix, $config);
        return $model;
    }
	public function __construct($config = array())
	{
		parent::__construct($config);
	}
}
?>