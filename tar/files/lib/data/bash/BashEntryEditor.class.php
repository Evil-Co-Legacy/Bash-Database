<?php
require_once(BASH_DIR.'lib/data/bash/BashEntry.class.php');

/**
 * The bash entry editor
 * @author		Akkarin
 * @copyright	2010 Punksoft
 */
class BashEntryEditor extends BashEntry {
	
	/**
	 * Creates a new bash entry
	 * @param	integer	$authorID
	 * @param	string	$authorName
	 * @param	integer	$serverID
	 * @param	string	$serverName
	 * @param	string	$text
	 */
	public static function create($authorID, $authorName, $serverID, $serverName, $text, $timestamp) {
		$sql = "INSERT INTO bash".BASH_N."_entry
					(`authorID`, 
					 `authorName`, 
					 `serverID`, 
					 `serverName`, 
					 `text`,
					 `timestamp`)
				VALUES (".$authorID.",
						'".escapeString($authorName)."',
						".$serverID.",
						'".escapeString($serverName)."',
						'".escapeString($text)."',
						".$timestamp.");";
		WCF::getDB()->sendQuery($sql);
		
		$entry = new BashEntry(WCF::getDB()->getInsertID());
		
		return $entry;
	}
	
	public static function remove($entryID) {
		$sql = "DELETE FROM bash".BASH_N."_entry
				WHERE
					entryID = ".$entryID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Updates the data in our database table
	 */
	public function update() {
		$updateSQL = '';
		
		$updateSQL .= '`authorID` = '.$this->authorID;
		
		if (!empty($this->authorName)) {
			if (!empty($updateSQL)) $updateSQL .= ',';
			$updateSQL .= '`authorName` = \''.escapeString($this->authorName).'\'';
		}
		
		if (!empty($updateSQL)) $updateSQL .= ',';
		$updateSQL .= '`serverID` = '.$this->serverID.'';
		
		if (!empty($this->serverName)) {
			if (!empty($updateSQL)) $updateSQL .= ',';
			$updateSQL .= '`serverName` = \''.escapeString($this->serverID).'\'';
		}
		
		if (!empty($this->text)) {
			if (!empty($updateSQL)) $updateSQL .= ',';
			$updateSQL .= '`text` = \''.escapeString($this->text).'\'';
		}
		
		$updateSQL .= ',`votes` = '.$this->votes;
		
		$updateSQL .= ',`isDisabled` = '.$this->isDisabled;
		
		$sql = "UPDATE bash".BASH_N."_entry
				SET
					".$updateSQL."
				WHERE
					entryID = ".$this->entryID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Favorites the bash entry
	 * @param	integer	$userID
	 */
	public function favorite($userID = null) {
		if ($userID == null) $userID = BASHCore::getUser()->userID;
		
		$sql = "INSERT INTO
					bash".BASH_N."_favorite (`entryID`, `userID`)
				VALUES (".$this->entryID.", ".$userID.");";
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Deletes the bash entry from users favorite list
	 * @param	integer	$userID
	 */
	public function unfavorite($userID = null) {
		if ($userID == null) $userID = BASHCore::getUser()->userID;
		
		$sql = "DELETE FROM
					bash".BASH_N."_favorite
				WHERE
					entryID = ".$this->entryID."
				AND
					userID = ".$userID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Votes for the entry (true for positive and false for negative)
	 * @param	boolean	$type
	 * @param	integer	$userID
	 */
	public function vote($type = true, $userID = null) {
		if ($userID == null) $userID = BashCore::getUser()->userID;
		
		$sql = "INSERT INTO
					bash".BASH_N."_vote (`entryID`, `userID`)
				VALUES (".$this->entryID.", ".$userID.")";
		WCF::getDB()->sendQuery($sql);
		
		$this->votes = ($this->votes + ($type ? 1 : -1));
		
		$this->update();
	}
}
?>