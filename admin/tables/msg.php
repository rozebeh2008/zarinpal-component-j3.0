<?php
defined( '_JEXEC' ) or die;
class EasyPayZarinpalTableMsg extends	JTable
{
	public function __construct(&$db)
	{
		parent::__construct('#__easypayzarinpal_bankmsg','id',$db);
	}
}
?>