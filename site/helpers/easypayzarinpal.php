<?php
// no direct access
defined('_JEXEC') or die;

jimport('joomla.filesystem.file');
class EasyPayZarinpalHelper
{
	public static function fileUpload($file)
	{
		$max 		= substr(ini_get('upload_max_filesize'),0,-1)*1024*1000;
		$max 		/= 1000000;
		$module_dir = JPATH_SITE.DS.'media'.DS.'com_easypayzarinpal'.DS.'upload';
		$date		= new DateTime();
		$prefix		= $date->getTimestamp();
		$msg = '';

		$filename = JFile::makeSafe($file['name']['attachment']);
		$filename = $prefix.'_'.$filename;
		
		$src = $file['tmp_name']['attachment'];
		$dest = $module_dir . DS . $filename;
		$file_size = $file['size']['attachment']/1000000;
		if( $file_size > $max)
		{
			$msg = JText::_('ONLY_FILES_UNDER').' '.$max.' '.JText::_('MEGA_UNIT');
			$app = JFactory::getApplication();
			$app->redirect('index.php?option=com_easypayzarinpal&amp;view=pay', $msg);
		}	
		if((strtolower(JFile::getExt($filename) ) == 'zip') && ($file_size < $max)) 
		{
			if (JFile::upload($src, $dest)) 
			{
				return $filename;
			} 
			else 
			{
				$msg = JText::_('ERROR_IN_UPLOAD');				
				$app = JFactory::getApplication();
				$app->redirect('index.php?option=com_easypayzarinpal&amp;view=pay', $msg);
			}
		} 
		else 
		{
			$msg = JText::_('FILE_TYPE_INVALID');
			$app = JFactory::getApplication();
			$app->redirect('index.php?option=com_easypayzarinpal&amp;view=pay', $msg); 
			return 0;
		}
    }
}
?>