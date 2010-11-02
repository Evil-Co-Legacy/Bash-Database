<?php
require_once(WCF_DIR.'lib/data/DatabaseObject.class.php');
require_once(WCF_DIR.'lib/data/message/sidebar/MessageSidebarFactory.class.php');

/**
 * This class represents a server
 * @author Akkarin
 */
class Server extends DatabaseObject {
	protected $sqlJoins = '';
	protected $sqlSelects = '';
	protected $sqlGroupBy = '';
	
	protected $sidebarFactory = null;
	
	/**
	 * Gets the main data of the server
	 *
	 * @param 	string 		$entryID
	 * @param 	array 		$row
	 */
	public function __construct($serverID, $row = null) {
		$this->sqlSelects .= "`bash1_1_server`.*"; 
		
		// execute sql statement
		$sqlCondition = '';
		if ($serverID !== null) {
			$sqlCondition = "`bash1_1_server`.`serverID` = ".$serverID;
		}
		
		if (!empty($sqlCondition)) {
			$sql = "SELECT ".$this->sqlSelects."
					FROM `bash1_1_server`
					WHERE ".$sqlCondition;
			$row = WCF::getDB()->getFirstRow($sql);
		}
		
		// handle result set
		parent::__construct($row);
	}
	
	/**
	 * @see DatabaseObject::handleData()
	 */
	protected function handleData($data) {
		parent::handleData($data);
		if (!$this->serverID) $this->data['serverID'] = 0;
	}
	
	/**
	 * alias of the getUsername() function
	 * @see User::getUsername()
	 */
	public function __toString() {
		return $this->address;
	}
	
	/**
	 * Returns a BashEntryEditor object to edit this bash entry.
	 * 
	 * @return	BashEntryEditor
	 */
	public function getEditor() {
		require_once(BASH_DIR.'lib/data/server/ServerEditor.class.php');
		return new ServerEditor($this->entryID);
	}
	
	/**
	 * Returnes the html version of the bash content
	 * @return	 string
	 */
	public function getFormatedText() {
		require_once(WCF_DIR.'lib/data/message/bbcode/SimpleMessageParser.class.php');
		$parser = SimpleMessageParser::getInstance();
		return $parser->parse($this->description);
	}
	
	/**
	 * Returnes all comments
	 */
	public function getComments($onlyActivated = false) {
		require_once(BASH_DIR.'lib/data/server/ViewableServerComment.class.php');
		
		$sql = "SELECT
					*
				FROM
					bash".BASH_N."_server_comment
				WHERE
					serverID = ".$this->serverID;
		if ($onlyActivated) $sql .= " AND isDisabled = 0";
		$sql .= " ORDER BY `timestamp` DESC";
		$result = WCF::getDB()->sendQuery($sql);
		
		// init sidebars
		$this->sidebarFactory = new MessageSidebarFactory($this);
		
		
		$comments = array();
		while ($row = WCF::getDB()->fetchArray($result)) {
			$temp = new ViewableServerComment(null, $row);
			$this->sidebarFactory->create($temp);
			$comments[] = $temp;
			unset($temp);
		}
		$this->sidebarFactory->init();
		
		return $comments;
	}
	
	/**
	 * Returnes the sidebar factory
	 */
	public function getSidebarFacotry() {
		return $this->sidebarFactory;
	}
	
	/**
	 * Returnes the complete server list
	 */
	public static function getServerList() {
		WCF::getCache()->addResource('serverList', BASH_DIR.'cache/cache.serverList.php', BASH_DIR.'lib/system/cache/CacheBuilderServerList.class.php');
		return WCF::getCache()->get('serverList');
	}
	
	/**
	 * Clears the server list cache
	 */
	public static function clearCache() {
		WCF::getCache()->clear(BASH_DIR.'cache/', 'cache.serverList.php');
	}
}
?>