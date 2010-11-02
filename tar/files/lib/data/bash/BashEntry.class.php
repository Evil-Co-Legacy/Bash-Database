<?php
require_once(WCF_DIR.'lib/data/DatabaseObject.class.php');

/**
 * This class represents a bash entry
 * @author Akkarin
 */
class BashEntry extends DatabaseObject {
	protected $sqlJoins = '';
	protected $sqlSelects = '';
	protected $sqlGroupBy = '';
	
	/**
	 * Gets the main data of the bash entry
	 *
	 * @param 	string 		$entryID
	 * @param 	array 		$row
	 */
	public function __construct($entryID, $row = null) {
		$this->sqlSelects .= '`bash'.BASH_N.'_entry`.*'; 
		
		// execute sql statement
		$sqlCondition = '';
		if ($entryID !== null) {
			$sqlCondition = "`bash".BASH_N."_entry`.entryID = ".$entryID;
		}
		
		if (!empty($sqlCondition)) {
			$sql = "SELECT 	".$this->sqlSelects."
				FROM 	`bash".BASH_N."_entry`
					".$this->sqlJoins."
				WHERE 	".$sqlCondition.
					$this->sqlGroupBy;
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
		if (!$this->entryID) $this->data['entryID'] = 0;
	}
	
	/**
	 * alias of the getUsername() function
	 * @see User::getUsername()
	 */
	public function __toString() {
		return $this->text;
	}
	
	/**
	 * Returns a BashEntryEditor object to edit this bash entry.
	 * 
	 * @return	BashEntryEditor
	 */
	public function getEditor() {
		require_once(BASH_DIR.'lib/data/bash/BashEntryEditor.class.php');
		return new BashEntryEditor($this->entryID);
	}
	
	/**
	 * Returnes the html version of the bash content
	 * @return	 string
	 */
	public function getFormatedText() {
		require_once(WCF_DIR.'lib/data/message/bbcode/SimpleMessageParser.class.php');
		$parser = SimpleMessageParser::getInstance();
		return $parser->parse($this->text);
	}
	
	/**
	 * 
	 */
	public function getAuthorProfile() {
		require_once(WCF_DIR.'lib/data/user/UserProfile.class.php');
		return new UserProfile($this->authorID);
	}
	
	/**
	 * Gets the entry with the highest timestamp
	 * @return 	 BashEntry
	 */
	public static function getNewest() {
		$sql = "SELECT 		*
			FROM 		bash".BASH_N."_entry
			ORDER BY 	timestamp DESC";
		$result = WCF::getDB()->getFirstRow($sql);
		return new BashEntry(null, $result);
	}
	
	/**
	 * Returns a list of entrys.
	 * @param 	string		$entryIDs
	 * @return 	array		entries
	 */
	public static function getEntries($entryIDs) {
		$entires = array();
		$sql = "SELECT		*
			FROM		bash".BASH_N."_entry
			WHERE		entryID IN (".$entryIDs.")
			ORDER BY	`timestamp` DESC";
		$result = WCF::getDB()->sendQuery($sql);
		while ($row = WCF::getDB()->fetchArray($result)) {
			$entries[] = new BashEntry(null, $row);
		}
		
		return $entries;
	}
	
	/**
	 * Returnes true if this bash entry is favorisized
	 * @param	integer	$userID
	 */
	public function isFavorite($userID = null) {
		if ($userID == null) $userID = BASHCore::getUser()->userID;
		
		$sql = "SELECT
					COUNT(*) AS count
				FROM
					bash".BASH_N."_favorite
				WHERE
					entryID = ".$this->entryID."
				AND
					userID = ".$userID;
		$count = WCF::getDB()->getFirstRow($sql);
		
		if ($count['count'] != 0) return true;
		return false;
	}
	
	/**
	 * If the user has already voted for this entry this should return true
	 * @param	integer	$userID
	 */
	public function hasVoted($userID = null) {
		if ($userID == null) $userID = BASHCore::getUser()->userID;
		
		$sql = "SELECT
					COUNT(*) AS count
				FROM
					bash".BASH_N."_vote
				WHERE
					entryID = ".$this->entryID."
				AND
					userID = ".$userID;
		$count = WCF::getDB()->getFirstRow($sql);
		
		if ($count['count'] != 0) return true;
		return false;
	}
}
?>