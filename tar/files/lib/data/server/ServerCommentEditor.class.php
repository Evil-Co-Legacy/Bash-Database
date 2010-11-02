<?php
require_once(BASH_DIR.'lib/data/server/ServerComment.class.php');

/**
 * The bash entry editor
 * @author		Akkarin
 * @copyright	2010 Punksoft
 */
class ServerCommentEditor extends ServerComment {
	
	/**
	 * Creates a new server comment
	 * @param	integer	$serverID
	 * @param	integer	$authorID
	 * @param	integer	$authorName
	 * @param	string	$serverName
	 * @param	string	$text
	 */
	public static function create($serverID, $authorID, $authorName, $message, $timestamp = TIME_NOW, $enableSmilies = true, $enableHtml = false, $enableBBCodes = true, $isDisabled = true) {
		$sql = "INSERT INTO bash".BASH_N."_server_comment
					(`serverID`, 
					 `authorID`,
					 `authorName`,
					 `message`,
					 `timestamp`,
					 `enableSmilies`,
					 `enableHtml`,
					 `enableBBCodes`,
					 `isDisabled`)
				VALUES (".$serverID.",
						".$authorID.",
						'".escapeString($authorName)."',
						'".escapeString($message)."',
						".$timestamp.",
						".($enableSmilies ? '1' : '0').",
						".($enableHtml ? '1' : '0').",
						".($enableBBCodes ? '1' : '0').",
						".($isDisabled ? '1' : '0').");";
		WCF::getDB()->sendQuery($sql);
		
		$serverComment = new ServerComment(WCF::getDB()->getInsertID());
		
		return $serverComment;
	}
	
	/**
	 * Removes the comment
	 * @param unknown_type $commentID
	 */
	public static function remove($commentID) {
		$sql = "DELETE FROM bash".BASH_N."_server_comment
				WHERE
					commentID = ".$commentID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Updates the data in our database table
	 */
	public function update() {
		$updateSQL = '';
		
		if (!empty($this->serverID)) {
			if (!empty($updateSQL)) $updateSQL .= ',';
			$updateSQL .= '`serverID` = '.$this->serverID;
		}
		
		if (!empty($updateSQL)) $updateSQL .= ',';
		$updateSQL .= '`authorID` = '.$this->authorID;
		
		if (!empty($this->authorName)) {
			if (!empty($updateSQL)) $updateSQL .= ',';
			$updateSQL .= '`authorName` = \''.escapeString($this->authorName).'\'';
		}
		
		$updateSQL .= ',`message` = \''.escapeString($this->message).'\'';
		
		$updateSQL .= ",`timestamp` = ".$this->timestamp;
		
		$updateSQL .= ',`enableSmilies` = '.($this->enableSmilies ? '1' : '0');

		$updateSQL .= ',`enableHtml` = '.($this->enableHtml ? '1' : '0');
		
		$updateSQL .= ',`enableBBCodes` = '.($this->enableBBCodes ? '1' : '0');
		
		$updateSQL .= ",`isDisabled` = ".$this->isDisabled;
		
		$sql = "UPDATE bash".BASH_N."_server_comment
				SET
					".$updateSQL."
				WHERE
					commentID = ".$this->commentID;
		WCF::getDB()->sendQuery($sql);
	}
}
?>