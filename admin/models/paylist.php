<?php
defined( '_JEXEC' ) or die;
//JLoader::register('EasyPayZarinpalHelper', JPATH_ADMINISTRATOR . '/components/com_easypayzarinpal/helpers/easypayzarinpal.php');
jimport('joomla.application.component.modellist');
class EasyPayZarinpalModelPaylist extends JModelList
{
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id',
				'lastname',
				'paydate',
				'cost',
				'orderid',
				'refid',
				'msgid',
				'sattel',
				'published'
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
    	$query->from($db->quoteName('#__easypayzarinpal').' AS a');
    	
    	// Join over the categories.
    	$query->select('c.msg AS bankmsg');
    	$query->join('LEFT', '#__easypayzarinpal_bankmsg AS c ON c.code = a.msgid');
		
		$query->order($db->escape($this->getState('list.ordering', 'id')).' '.$db->escape($this->getState('list.direction', 'DESC')));
	
    	// Filter by published state
    	$published = $this->getState('filter.published');

    	if (is_numeric($published)) {
    		$query->where('a.published = '.(int) $published);
    	} elseif ($published === '') {
    		$query->where('(a.published IN (0, 1))');
    	}
    	
    	// Filter by search in title
    	$search = $this->getState('filter.search');
    	if (!empty($search)) {
    		if (stripos($search, 'id:') === 0) {
    			$query->where('a.id = '.(int) substr($search, 3));
    		} else {
    			$search = $db->Quote('%'.$db->escape($search, true).'%');
    			$query->where('(
    					a.lastname LIKE '.$search.'
    					OR a.cost LIKE '.$search.'	
    					OR a.orderid LIKE '.$search.'
    					OR a.refid LIKE '.$search.'
    			)');
    		}
    	}
    	
    	$msgid = $this->getState('filter.msgid');
    	if (is_numeric($msgid)) {
    		$query->where('a.msgid = '.(int) $msgid);
    	}
    	
    	// Column ordering
    	$orderCol = $this->getState('list.ordering');
    	$orderDirn = $this->getState('list.direction');
   /* 	if ($orderCol != '') {
    		$query->order($db->getEscaped($orderCol.' '.$orderDirn));
    	}
*/
    	return $query;
    }

	public function populateState($ordering = null, $direction=null)
	{
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$state = $this->getUserStateFromRequest($this->context.'.filter.msgid', 'filter_msgid', '', 'string');
		$this->setState('filter.msgid', $state);
		
		$published = $this->getUserStateFromRequest($this->context.'.filter.published', 'filter_published');
		$this->setState('filter.published', $published);

		parent::populateState($ordering, $direction);
	}
	
	public function getPayByID($id)
	{
		$db		= $this->getDBO();
		$query	= $db->getQuery(true);
		$query->clear();
		
		$query = "SELECT * FROM `#__easypayzarinpal` AS a WHERE `id` = '$id' LIMIT 0, 1";

		$db->setQuery( $query );
		$result = $db->loadObject();

		return $result;
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
	
	public function setSettleByID($id,$code)
	{
		$db		= $this->getDBO();
		$query	= $db->getQuery(true);
		$query->clear();
	
		$query = "UPDATE #__easypayzarinpal SET  sattel ='".$code."' WHERE id =".$id;

		$db->setQuery( $query );
		$db->query();
	}
}
?>