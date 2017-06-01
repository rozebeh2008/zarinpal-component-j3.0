<?php
defined( '_JEXEC' ) or die;
class EasyPayZarinpalTableEasypayzarinpal extends	JTable
{
	public function __construct(&$db)
	{
		parent::__construct('#__easypayzarinpal','id',$db);
	}
}
?>