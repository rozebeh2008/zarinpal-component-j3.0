<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.controllerform');
class EasyPayZarinpalControllerPay extends JControllerForm
{	
	protected $view_list	=	'paylist';	

	function __construct($config = array()) 
	{		
		parent::__construct($config);	
	}
}
?>