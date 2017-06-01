<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.controlleradmin');
class EasyPayZarinpalControllerPaylist extends JControllerAdmin
{
    public function getModel($name = 'Pay', $prefix = 'EasyPayZarinpalModel', $config = array('ignore_request' => true))
    {
        $model = parent::getModel($name, $prefix, $config);
        return $model;
    }
    
    public function __construct($config = array())
    {
    	parent::__construct($config);
    }
	
    public function settle()
    {
		$model	= $this->getModel('paylist');
		
		$id = JRequest::getInt('id', 0);
		$result = $model->getPayByID($id);
		$this->params = JComponentHelper::getParams('com_easypayzarinpal');
		
		$option['terminalid']	=	$this->params->get('terminalid');
		$option['username']	=	$this->params->get('username');
		$option['password']	=	$this->params->get('password');
		$option['orderid']	=	$result->orderid;
		$option['saleorderid']	=	$result->orderid;
		$option['salerefid']	=	$result->salerefid;

		$nusoap = substr(dirname(dirname(__FILE__)),0,-46)."/components/com_easypayzarinpal/helpers/lib/nusoap.php";
		require_once($nusoap);

		$client = new nusoap_client($this->params->get('web_service'));
		$namespace='http://interfaces.core.sw.bps.com/';
		
		// Check for an error
		$err = $client->getError();
		if ($err) {
			echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
			die();
		}
		
		$parameters = array(
			'terminalId' => $option['terminalid'],
			'userName' => $option['username'],
			'userPassword' => $option['password'],
			'orderId' => $option['orderid'],
			'saleOrderId' => $option['saleorderid'],
			'saleReferenceId' => $option['salerefid']);


		$result = $client->call('bpSettleRequest', $parameters, $namespace);

		// Check for a fault
		if ($client->fault) {
			echo '<h2>Fault</h2><pre>';
			print_r($result);
			echo '</pre>';
			die();
		}
		else
		{
			$code = $result;
			$err = $client->getError();
			if ($err) {
				echo '<h2>Error</h2><pre>' . $err . '</pre>';
				die();
			} 
			else
			{
				$model->setSettleByID($id,$code);
				$msg = $model->getMsgByCode($code);
				$app = JFactory::getApplication();
				$app->redirect('index.php?option=com_easypayzarinpal&amp;view=paylist', $msg); 
			}
		}
    }
}
?>