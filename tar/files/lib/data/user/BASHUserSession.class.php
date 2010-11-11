<?php
require_once(BASH_DIR.'lib/data/user/AbstractBASHUserSession.class.php');

/**
 * Represents a bash user session
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.bash
 */
class BASHUserSession extends AbstractBASHUserSession {
	
	/**
	 * Returnes true if the current user has favorites
	 */
	public function hasFavorites() {
		return true;
	}
	
	/**
	 * Returnes true if the user has moderator access
	 */
	public function isModerator() {
		if (BASHCore::getUser()->getPermission('mod.bash.moderatorPermissions') or BASHCore::getUser()->getPermission('mod.comment.moderatorPermissions')) return true;
		return false;
	}
	
	/**
	 * Returnes a count of all outstanding moderations
	 */
	public function getOutstandingModerations() {
		$count = 0;
		
		if (BASHCore::getUser()->getPermission('mod.bash.moderatorPermissions')) {
			$sql = "SELECT
						COUNT(*) AS count
					FROM
						bash".BASH_N."_entry
					WHERE
						isDisabled = 1";
			$result = WCF::getDB()->getFirstRow($sql);
			$count = ($count + intval($result['count']));
		}
		
		if (BASHCore::getUser()->getPermission('mod.comment.moderatorPermissions')) {
			$sql = "SELECT
						COUNT(*) AS count
					FROM
						bash".BASH_N."_server_comment
					WHERE
						isDisabled = 1";
			$result = WCF::getDB()->getFirstRow($sql);
			$count = ($count + intval($result['count']));
		}
		
		return $count;
	}
}
?>