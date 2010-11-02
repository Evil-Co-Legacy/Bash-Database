<?php
require_once(WCF_DIR.'lib/data/DatabaseObject.class.php');

/**
 * This class represents a news entry
 * @author Akkarin
 */
class NewsEntry extends DatabaseObject {
	protected $sqlJoins = '';
	protected $sqlSelects = '';
	protected $sqlGroupBy = '';
	
	public $additionalButtons = '';
	
	/**
	 * Gets the main data of the news entry
	 *
	 * @param 	string 		$entryID
	 * @param 	array 		$row
	 */
	public function __construct($entryID, $row = null) {
		$this->sqlSelects .= 'news.*'; 
		
		// execute sql statement
		$sqlCondition = '';
		if ($entryID !== null) {
			$sqlCondition = "news.entryID = ".$entryID;
		}
		
		if (!empty($sqlCondition)) {
			$sql = "SELECT 	".$this->sqlSelects."
				FROM 	bash".BASH_N."_news news
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
		return $this->subject;
	}
	
	/**
	 * Returns a BashEntryEditor object to edit this bash entry.
	 * 
	 * @return	BashEntryEditor
	 */
	public function getEditor() {
		require_once(BASH_DIR.'lib/data/news/NewsEntryEditor.class.php');
		return new NewsEntryEditor($this->entryID);
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
			FROM 		bash".BASH_N."_news
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
			FROM		bash".BASH_N."_news
			WHERE		entryID IN (".$entryIDs.")
			ORDER BY	`timestamp` DESC";
		$result = WCF::getDB()->sendQuery($sql);
		while ($row = WCF::getDB()->fetchArray($result)) {
			$entries[] = new NewsEntry(null, $row);
		}
		
		return $entries;
	}
}
?>