<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.modelform');
class EasyPayZarinpalModelPay extends JModelForm
{	
	public function getForm($data = array(), $loadData = true)
	{
		$app = JFactory::getApplication('site');

		// Get the form.
		$form = $this->loadForm('com_easypayzarinpal.pay', 'pay', array('control' => 'jform', 'load_data' => true));
		if (empty($form)) {
			return false;
		}

		return $form;
	}

	public function submitPay($data,$file)
	{
		$db		= $this->getDBO();
		$query = $db->getQuery(true);
		$query->clear();
		$orderID =  date_timestamp_get(date_create());
		date_default_timezone_set('UTC');
		$now = date("Y-m-d G:i:s");
		if($file)
		{
			require_once 'components'.DS.'com_easypayzarinpal'.DS.'helpers'.DS.'easypayzarinpal.php';
			$filename = EasyPayZarinpalHelper::fileUpload($file);
			$query = "	INSERT INTO #__easypayzarinpal
			(`id`, `firstname`, `lastname`, `email`, `phone`, 
			`mobile`, `mellicode`, `state`, `city`, `address`, 
			`postcode`, `description`, `attachment`, `cost`, 
			`orderid`, `salerefid`, `refid`, `paydate`, `msgid`, `sattel`, `published`) 
			VALUES (NULL, '" . $data['firstname'] . "', '". $data['lastname'] ."', '". $data['email'] ."', '". $data['phone'] ."', 
			'". $data['mobile'] ."', '". $data['mellicode'] ."', '". $data['state'] ."', '". $data['city'] ."', '". $data['address'] ."', 
			'". $data['postcode'] ."', '". $data['description'] ."', '". $filename ."', '". $data['cost'] ."', 
			'". $orderID ."', '0', '0', '". $now."', '500', '500', '0'); ";
		}
		else
		{
			$query = "	INSERT INTO #__easypayzarinpal
			(`id`, `firstname`, `lastname`, `email`, `phone`,
			`mobile`, `mellicode`, `state`, `city`, `address`,
			`postcode`, `description`, `attachment`, `cost`,
			`orderid`, `salerefid`, `refid`, `paydate`, `msgid`, `sattel`, `published`)
			VALUES (NULL, '" . $data['firstname'] . "', '". $data['lastname'] ."', '". $data['email'] ."', '". $data['phone'] ."',
			'". $data['mobile'] ."', '". $data['mellicode'] ."', '". $data['state'] ."', '". $data['city'] ."', '". $data['address'] ."',
			'". $data['postcode'] ."', '". $data['description'] ."', '". JText::_('NO_UPLOAD') ."', '". $data['cost'] ."',
			'". $orderID ."', '0', '0', '". $now ."', '500', '500', '0'); ";
		}
		
		$db->setQuery((string)$query);
		if (!$db->query() || !is_numeric($data['cost'])) 
		{
			JError::raiseNotice( 100,JText::_('SAVE_DATA_ERROR'));
			return false;

		} else {
			return $orderID;
		}
	}
	public function getMsgByCode($code)
	{
		$db		= $this->getDBO();
		$query	= $db->getQuery(true);
		$query->clear();
		
		$query = "SELECT msg FROM #__easypayzarinpal_bankmsg WHERE code = '$code' LIMIT 0, 1";

		$db->setQuery( $query );
		$result = $db->loadResult();
		return $result;
	}
	
	public function getPayByOrderID($orderID)
	{
		$db		= $this->getDBO();
		$query	= $db->getQuery(true);
		$query->clear();

		$query = "SELECT salerefid, orderid FROM #__easypayzarinpal WHERE orderid = ". $orderID ." LIMIT 0, 1";
		$db->setQuery( $query );
		$result = $db->loadObject();
		return $result;
	}	
}
?>