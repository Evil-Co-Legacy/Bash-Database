<?php
require_once(BASH_DIR.'lib/data/news/NewsEntry.class.php');

/**
 * The bash entry editor
 * @author		Akkarin
 * @copyright	2010 Punksoft
 */
class NewsEntryEditor extends NewsEntry {
	
	/**
	 * Creates a new news entry
	 * @param	integer	$authorID
	 * @param	string	$authorName
	 * @param	integer	$serverID
	 * @param	string	$serverName
	 * @param	string	$text
	 */
	public static function create($authorID, $authorName, $subject, $text, $timestamp, $enableSmilies = true, $enableHTML = false, $enableBBCodes = true) {
		$sql = "INSERT INTO bash".BASH_N."_news
					(`authorID`, 
					 `authorName`, 
					 `subject`,
					 `text`,
					 `timestamp`,
					 `enableSmilies`,
					 `enableHTML`,
					 `enableBBCodes`)
				VALUES (".$authorID.",
						'".escapeString($authorName)."',
						'".escapeString($subject)."',
						'".escapeString($text)."',
						".$timestamp.",
						".($enableSmilies ? 1 : 0).",
						".($enableHTML ? 1 : 0).",
						".($enableBBCodes ? 1 : 0).");";
		WCF::getDB()->sendQuery($sql);
		
		$entry = new NewsEntry(WCF::getDB()->getInsertID());
		
		return $entry;
	}
	
	/**
	 * Removes a entry row
	 * @param	integer	$entryID
	 */
	public static function remove($entryID) {
		$sql = "DELETE FROM bash".BASH_N."_news
				WHERE
					entryID = ".$entryID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Updates the data in our database table
	 */
	public function update() {
		$updateSQL = '';
		
		if (!empty($this->authorID)) {
			if (!empty($updateSQL)) $updateSQL .= ',';
			$updateSQL .= '`authorID` = '.$this->authorID;
		}
		
		if (!empty($this->authorName)) {
			if (!empty($updateSQL)) $updateSQL .= ',';
			$updateSQL .= '`authorName` = \''.escapeString($this->authorName).'\'';
		}
		
		if (!empty($this->subject)) {
			if (!empty($updateSQL)) $updateSQL .= ',';
			$updateSQL .= '`subject` = \''.escapeString($this->subject).'\'';
		}
		
		if (!empty($this->text)) {
			if (!empty($updateSQL)) $updateSQL .= ',';
			$updateSQL .= '`text` = \''.escapeString($this->text).'\'';
		}
		
		if (!empty($updateSQL)) $updateSQL .= ',';
		$updateSQL .= "`enableSmilies` = ".($this->enableSmilies ? 1 : 0);
		
		$updateSQL .= ",`enableHTML` = ".($this->enableHTML ? 1 : 0);
		
		$updateSQL .= ",`enableBBCodes` = ".($this->enableBBCodes ? 1 : 0);
		
		$sql = "UPDATE bash".BASH_N."_news
				SET
					".$updateSQL."
				WHERE
					entryID = ".$this->entryID;
		WCF::getDB()->sendQuery($sql);
	}
}
?>