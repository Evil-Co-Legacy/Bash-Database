<?php
require_once(BASH_DIR.'lib/data/user/AbstractBASHUserSession.class.php');

class BASHUserSession extends AbstractBASHUserSession {
	
	public function hasFavorites() {
		return true;
	}
	
	public function isModerator() {
		if (BASHCore::getUser()->getPermission('mod.bash.moderatorPermissions') or BASHCore::getUser()->getPermission('mod.comment.moderatorPermissions')) return true;
		return false;
	}
	
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