<?php
require_once(BASH_DIR.'lib/data/server/Server.class.php');

/**
 * The bash entry editor
 * @author		Akkarin
 * @copyright	2010 Punksoft
 */
class ServerEditor extends Server {
	
	/**
	 * Creates a new news entry
	 * @param	integer	$authorID
	 * @param	string	$authorName
	 * @param	integer	$serverID
	 * @param	string	$serverName
	 * @param	string	$text
	 */
	public static function create($serverAddress, $port, $description) {
		$sql = "INSERT INTO bash".BASH_N."_server
					(`serverAddress`, 
					 `port`,
					 `description`)
				VALUES ('".escapeString($serverAddress)."',
						".$port.",
						'".escapeString($description)."');";
		WCF::getDB()->sendQuery($sql);
		
		$server = new Server(WCF::getDB()->getInsertID());
		
		return $server;
	}
	
	public static function remove($entryID) {
		$sql = "DELETE FROM bash".BASH_N."_server
				WHERE
					serverID = ".$entryID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Updates the data in our database table
	 */
	public static function update() {
		$updateSQL = '';
		
		if (!empty($this->authorName)) {
			if (!empty($updateSQL)) $updateSQL .= ',';
			$updateSQL .= '`serverAddress` = \''.escapeString($this->serverAddress).'\'';
		}
		
		if (!empty($this->subject)) {
			if (!empty($updateSQL)) $updateSQL .= ',';
			$updateSQL = '`port` = '.$this->port;
		}
		
		if (!empty($this->text)) {
			if (!empty($updateSQL)) $updateSQL .= ',';
			$updateSQL = '`description` = \''.escapeString($this->description).'\'';
		}
		
		$sql = "UPDATE bash".BASH_N."_server
				SET
					".$updateSQL."
				WHERE
					serverID = ".$this->entryID;
		WCF::getDB()->sendQuery($sql);
	}
}
?>