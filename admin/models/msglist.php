<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.modellist');
class EasyPayZarinpalModelMsglist extends JModelList
{
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'code',
				'msg',
				'id'
			);
		}

		parent::__construct($config);
	}
	
    public function getListQuery()
    {
    	// Initialise variables.
    	$db		= $this->getDbo();
    	$query	= $db->getQuery(true);

    	// Select the required fields from the table.
    	$query->select($this->getState('list.select','a.* '));
    	$query->from($db->quoteName('#__easypayzarinpal_bankmsg').' AS a');

    	// Column ordering
    	$orderCol = $this->getState('list.ordering');
    	$orderDirn = $this->getState('list.direction');
    	if ($orderCol != '') {
    		$query->order($db->getEscaped($orderCol.' '.$orderDirn));
    	}

    	return $query;
    }

	public function populateState($ordering = null, $direction=null)
	{
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		parent::populateState($ordering, $direction);
	}
}
?>