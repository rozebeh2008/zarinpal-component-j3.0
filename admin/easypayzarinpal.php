<?php
defined( '_JEXEC' ) or die;

JLoader::register('EasyPayZarinpalHelper', dirname(__FILE__) . '/helpers/easypayzarinpal.php');
$controller = JControllerLegacy::getInstance('EasyPayZarinpal');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
?>