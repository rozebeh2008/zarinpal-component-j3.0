<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.modeladmin');
class EasyPayZarinpalModelPay extends JModelAdmin
{
    public function getTable($type = 'Easypayzarinpal', $prefix = 'EasyPayZarinpalTable', $config=array())
    {
        return  JTable::getInstance($type, $prefix, $config);
    }

    protected function loadFormData()
	{
		$data	=	JFactory::getApplication()->getUserState('com_easypayzarinpal.edit.pay.data',array());
		if(empty($data))
		{
			$data = $this->getItem();
		}
		return $data;
	}
	
	public function getForm($data = array(), $loadData = true)
    {
        $form = $this->loadForm('com_easypayzarinpal.pay', 'pay', array('control' => 'jform', 'load_data' => $loadData));
        return  $form;
    }
    
	public function getBankMsg()
    {
    	$id = JRequest::getInt('id',0);
    	
    	$db	=	JFactory::getDBO();
		$query	= $db->getQuery(true);
		$query->clear();
		$query = "SELECT msgid FROM #__easypayzarinpal WHERE id = $id LIMIT 0,1";
		$db->setQuery($query);
		$msgid = $db->loadResult();
		
		//$db	=	JFactory::getDBO();
		$query	= $db->getQuery(true);
		$query->clear();
		$query = "SELECT msg FROM #__easypayzarinpal_bankmsg WHERE code= $msgid LIMIT 0,1";
		$db->setQuery($query);
		$bankmsg= $db->loadResult();
	
		return $bankmsg;
    }
}
?>