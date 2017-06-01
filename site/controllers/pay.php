<?php
// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');
Class EasyPayZarinpalControllerPay extends JControllerForm
{
	public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, array('ignore_request' => false));
	}
	public function submit()
	{	
	
		
		
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));		
		$session = JFactory::getSession();
		$session->set('orderID', '');
		$this->params = JComponentHelper::getParams('com_easypayzarinpal');
		$option['terminalid']	=	$this->params->get('terminalid');
		$host = 'http://'.$_SERVER["HTTP_HOST"];
		$url = '/index.php?option=com_easypayzarinpal&view=pay&task=pay.callBack';
		$option['callbackurl']	=	$host.$url;
		$option['send_email']	=	$this->params->get('send_email');
		$option['sign']			=	$this->params->get('sign');
		$app	= JFactory::getApplication();
		$model	= $this->getModel('pay');
		$data = JRequest::getVar('jform', array(), 'post', 'array');
		$file = JRequest::getVar('jform', null, 'files','array');
		if(!$file)
		{
			$file = false;
			$insert	= $model->submitPay($data,$file);
		}
		if($file)
			$insert	= $model->submitPay($data,$file);
		$option['amount']	=	$data['cost'];

		if(isset($data['mobile']) && trim($data['mobile'] != ''))
			$session->set('mobile',trim($data['mobile']));
		else
			$session->set('mobile',0);
		
		$session->set('cost',$data['cost']);

		//$insert have orderID
        if($insert){
			if($option['amount'] >= 100)
			{
				$session->set('orderID', $insert);
				$session->set('email', $data['email']);
				
				require_once 'components/com_easypayzarinpal/helpers/lib/nusoap.php';
				//$date = new DateTime();
				//$option['orderid']		=	$date->getTimestamp();
				
				
				$option['orderid']		=	'ZP_'. strtotime("now");
				$option['localDate']	=	date("Ymd");
				$option['localTime']	=	date("His");
				$option['addData']		=	'';
				$option['payerId']		=	0;
				
				
				$MerchantID = $option['terminalid'];  //Required
				$Amount = $option['amount'];
				$Description = 'پرداخت فاکتور شماره :  '.$option['orderid'];
				$Email = 'UserEmail@Mail.Com'; // Optional
				$Mobile ='09123456789'; // Optional
				$CallbackURL = $option['callbackurl'];
				
				
				// URL also Can be https://ir.zarinpal.com/pg/services/WebGate/wsdl
				$client = new nusoap_client('https://de.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl'); 
				$clientError = $client->getError();
				if($clientError)
				{
					echo '<h2>Constructor error</h2><pre>' . $clientError . '</pre>';
					die();
				}
				
				
				$client->soap_defencoding = 'UTF-8';
				$result = $client->call('PaymentRequest', array(
																array(
																		'MerchantID' 	=> $MerchantID,
																		'Amount' 		=> $Amount,
																		'Description' 	=> $Description,
																		'Email' 		=> $Email,
																		'Mobile' 		=> $Mobile,
																		'CallbackURL' 	=> $CallbackURL
																	)
																)
				);
				
				//Redirect to URL You can do it also by creating a form
				if($result['Status'] == 100)
				{
				print JText::_('SAVE_DATA_SUCCESS');
					Header('Location: https://www.zarinpal.com/pg/StartPay/'.$result['Authority']);
				} else {
					echo'ERR: '.$result['Status'];
					$model	= $this->getModel('pay');
					$msg 	= $model->getMsgByCode($result['Status']);
					$app 	= JFactory::getApplication();
					//$app->redirect('index.php?option=com_easypayzarinpal&view=pay', $msg); 
				}

				
			}
			
        }
		else
		{
			$r = '';
			$r .= '<form action="'.$_SERVER["HTTP_REFERER"].'" method="POST" >';
			$r .= '<button type="submit" >'.JText::_("BACK_TO_COM_EASYPAYZARINPAL");
			$r .= '</button></form>';
			
			print $r;
        }
		return true;
	}
	
	public function callBack()
	{
	    if(!$_SERVER['HTTP_REFERER'])
	    {
			$session = JFactory::getSession();

			$this->params = JComponentHelper::getParams('com_easypayzarinpal');
			
			require_once 'components/com_easypayzarinpal/helpers/lib/nusoap.php';	
			
			
			$MerchantID = $this->params->get('terminalid');
			$Amount = $session->get('cost');
			$Authority = $_REQUEST['Authority'];
			
			if($_REQUEST['Status'] == 'OK'){
				// URL also Can be https://ir.zarinpal.com/pg/services/WebGate/wsdl
				$client = new nusoap_client('https://de.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl'); 
				$client->soap_defencoding = 'UTF-8';
				$result = $client->call('PaymentVerification', array(
																	array(
																			'MerchantID'	 => $MerchantID,
																			'Authority' 	 => $Authority,
																			'Amount'	 	 => $Amount
																		)
																	)
				);
				
				if($result['Status'] == 100){
							$db	=	JFactory::getDBO();
							$query	= $db->getQuery(true);
							$query->clear();
							$query = "UPDATE #__easypayzarinpal SET published ='1', refid='".$_REQUEST['Authority']."', salerefid='".$result['RefId']."', msgid ='".$result['Status']."' WHERE orderid ='".$session->get('orderID')."'";
							$db->setQuery($query);
						
							$db->query();
							
							$msg = str_replace("JN_COST", $session->get('cost'), $this->params->get('email_msg'));
							$msg = str_replace("JN_ORDERID", $session->get('orderID'), $msg);
							$msg = str_replace("JN_REFID", $result['RefId'], $msg);
							$msg = str_replace("JN_EMAIL", $session->get('email'), $msg);
								
							JFactory::getApplication()->enqueueMessage($msg);
							if($this->params->get('send_email'))
							{
								$admin_email	= $this->params->get('email');
								$header_email 	= $this->params->get('header');
								$footer_email 	= $this->params->get('footer');
								
								$db	=	JFactory::getDBO();
								$query	= $db->getQuery(true);
								$query->clear();
								$query = 'SELECT email FROM #__easypayzarinpal AS a WHERE a.orderid = '.$session->get('orderID');
								$db->setQuery($query);
								$user_email = $db->loadResult();
									
								$mailer = JFactory::getMailer();
								$sender = array( $email , $name);
								$mailer->setSender($sender);
								
								$recipient = array($admin_email,$user_email);
								$mailer->addRecipient($recipient);
								$mailer->setSubject(JText::_('PAY_EMAIL_SALEORDERID').$session->get('orderID'));
								
								$body = "<html>
											<head>
												<meta http-equiv='Content-Type' content='text/html;charset=utf-8'>
											</head>
											<body>
												<table style='float:right;direction: rtl;'>
													<tr>
														<td>$msg</td>
													</tr>
												</table>";
								if($this->params->get('sign')):
									$body .= '<div style="width:100%;padding-top:20px;text-align:center;clear:both">';
									$body .= '<a style="color: gray;font-size: 1em;" title='.JText::_('YOUR_SIGN_TITLE').' href="http://www.yoursite.com" target="_blnak" >';
									$body .= JText::_('YOUR_SIGN_LINK');
									$body .= '</a></div>';
								endif;
								
								$body  .= "</body></html>";
								$mailer->isHTML(true);
								$mailer->setBody($body);
								$send = $mailer->Send();
								//$this->sendSMS($session->get('mobile'));
								
								
								$session->set('mobile',null);
								$session->set('cost',null);
							}
				
				
					echo 'Transation success. RefID:'. $result['RefID'];
				} else {
					if(isset($_REQUEST['Authority']) && isset($_REQUEST['Status']))
					{
					$db	=	JFactory::getDBO();
					$query	= $db->getQuery(true);
					$query->clear();
					$query = "UPDATE #__easypayzarinpal SET  msgid ='".$result['Status']."' WHERE orderid =".$session->get('orderID');
					$db->setQuery($query);

					$db->query();
					}
					echo 'Transation failed. Status:'. $result['Status'];
				}
			} else {
			
				echo 'Transaction canceled by user';
			}
			
		
				
			
	    }//You have returned from the bank
	    else
	    {
	    	$msg = JText::_("COM_EASYPAYZARINPAL_NO_RETURN_FROM_BANK");
			$app = JFactory::getApplication();
			$app->redirect('index.php?option=com_easypayzarinpal&amp;view=pay', $msg);
	    }
	}
	
	

}
?>