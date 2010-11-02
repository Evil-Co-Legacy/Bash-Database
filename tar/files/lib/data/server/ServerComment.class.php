<?php
require_once(WCF_DIR.'lib/data/DatabaseObject.class.php');

/**
 * This class represents a server comment entry
 * @author Akkarin
 */
class ServerComment extends DatabaseObject {
	protected $sqlJoins = '';
	protected $sqlSelects = '';
	protected $sqlGroupBy = '';
	
	public $additionalButtons = '';
	
	/**
	 * Gets the main data of the server comment
	 *
	 * @param 	string 		$entryID
	 * @param 	array 		$row
	 */
	public function __construct($commentID, $row = null) {
		$this->sqlSelects .= 'bash'.BASH_N.'_server_comment.*'; 
		
		// execute sql statement
		$sqlCondition = '';
		if ($commentID !== null) {
			$sqlCondition = "bash".BASH_N."_server_comment.commentID = ".$commentID;
		}
		
		if (!empty($sqlCondition)) {
			$sql = "SELECT 	".$this->sqlSelects."
				FROM 	bash".BASH_N."_server_comment
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
		if (!$this->commentID) $this->data['commentID'] = 0;
		$this->enableSmilies = ($this->enableSmilies == 1 ? true : false);
		$this->enableHtml = ($this->enableHtml == 1 ? true : false);
		$this->enableBBCodes = ($this->enableBBCodes == 1 ? true : false);
	}
	
	/**
	 * alias of the getUsername() function
	 * @see User::getUsername()
	 */
	public function __toString() {
		return $this->subject;
	}
	
	/**
	 * Returns a BashEntryEditor object to edit this news comment.
	 * 
	 * @return	BashEntryEditor
	 */
	public function getEditor() {
		require_once(BASH_DIR.'lib/data/news/ServerCommentEditor.class.php');
		return new ServerCommentEditor($this->commentID);
	}
	
	/**
	 * Returnes the html version of the comment content
	 * @return	 string
	 */
	public function getFormatedText() {
		require_once(WCF_DIR.'lib/data/message/bbcode/MessageParser.class.php');
		$parser = MessageParser::getInstance();
		return $parser->parse($this->message, $this->enableSmilies, $this->enableHtml, $this->enableBBCodes);
	}
	
	/**
	 * 
	 */
	public function getAuthorProfile() {
		require_once(WCF_DIR.'lib/data/user/UserProfile.class.php');
		return new UserProfile($this->authorID);
	}
}
?>