<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.modeladmin');
class EasyPayZarinpalModelMsg extends JModelAdmin
{
    public function getTable($type = 'Msg', $prefix = 'EasyPayZarinpalTable', $config=array())
    {
        return  JTable::getInstance($type, $prefix, $config);
    }

    protected function loadFormData()
	{
		$data	=	JFactory::getApplication()->getUserState('com_easypayzarinpal.edit.msg.data',array());
		if(empty($data))
		{
			$data = $this->getItem();
		}
		return $data;
	}
	public function getForm($data = array(), $loadData = true)
    {
        $form = $this->loadForm('com_easypayzarinpal.msg', 'msg', array('control' => 'jform', 'load_data' => $loadData));
        return  $form;
    }
}
?>