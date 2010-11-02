<?php
// wcf imports
require_once(WCF_DIR.'lib/page/AbstractPage.class.php');

class ModerationOverviewPage extends AbstractPage {
	public $templateName = 'moderationOverview';
	
	public $outstandingModerations = array();
	
	public function readData() {
		parent::readData();
		
		// read outstanding bash moderations
		if (BASHCore::getUser()->getPermission('mod.bash.moderatorPermissions')) {
			$sql = "SELECT
						COUNT(*) AS count
					FROM
						bash".BASH_N."_entry
					WHERE
						isDisabled = 1";
			$result = WCF::getDB()->getFirstRow($sql);
			$this->outstandingModerations['entries'] = $result['count'];
		}
		
		// read outstanding comment moderations
		if (BASHCore::getUser()->getPermission('mod.comment.moderatorPermissions')) {
			$sql = "SELECT
						COUNT(*) AS count
					FROM
						bash".BASH_N."_server_comment
					WHERE
						isDisabled = 1";
			$result = WCF::getDB()->getFirstRow($sql);
			$this->outstandingModerations['comments'] = $result['count'];
		}
	}
	
	public function show() {
		// check for permissions
		if (!BASHCore::getUser()->userID) throw new PermissionDeniedException;
		if (!BASHCore::getUser()->getPermission('mod.comment.moderatorPermissions') and !BASHCore::getUser()->getPermission('mod.bash.moderatorPermissions')) {
			throw new PermissionDeniedException;
		}
		
		// activate usercpmenu
		require_once(WCF_DIR.'lib/page/util/menu/UserCPMenu.class.php');
		UserCPMenu::getInstance()->setActiveMenuItem('wcf.user.usercp.menu.link.modcp.overview');
		
		parent::show();
	}
	
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign('outstandingModerations', $this->outstandingModerations);
	}
}
?>