<?php
// wcf imports
require_once(WCF_DIR.'lib/page/MultipleLinkPage.class.php');
require_once(WCF_DIR.'lib/data/message/sidebar/MessageSidebarFactory.class.php');

// bash imports
require_once(BASH_DIR.'lib/data/bash/ViewableBashEntry.class.php');

class ModerationDisabledEntriesPage extends MultipleLinkPage {
	public $templateName = 'moderationDisabledEntries';
	
	public $sidebarFactory = null;
	
	public $entries = array();
	
	public function readData() {
		parent::readData();
		
		$sql = "SELECT
			    	*
				FROM
			   		`bash".BASH_N."_entry`
			   	WHERE
			   		isDisabled = 1
				ORDER BY
			    	`timestamp` DESC
			    LIMIT 10";
		$result = WCF::getDB()->sendQuery($sql);
		while ($row = WCF::getDB()->fetchArray($result)) {
			$temp = new ViewableBashEntry(null, $row);
			// placeholder for additional buttons
		    $this->entries[] = $temp;
		    unset($temp);
		}
		
		// init sidebars
		$this->sidebarFactory = new MessageSidebarFactory($this);
		foreach ($this->entries as $entry) {
			$this->sidebarFactory->create($entry);
		}
		$this->sidebarFactory->init();
	}
	
	/**
	 * 
	 */
	public function show() {
		// check for permissions
		if (!BASHCore::getUser()->userID) throw new PermissionDeniedException;
		if (!BASHCore::getUser()->getPermission('mod.bash.moderatorPermissions')) {
			throw new PermissionDeniedException;
		}
		
		// activate usercpmenu
		require_once(WCF_DIR.'lib/page/util/menu/UserCPMenu.class.php');
		UserCPMenu::getInstance()->setActiveMenuItem('wcf.user.usercp.menu.link.modcp.disabledEntries');
		
		parent::show();
	}
	
	/**
     * @see MultipleLinkPage::countItems()
     */
    public function countItems() {
		parent::countItems();
	
		$sql = "SELECT COUNT(*) AS count
				FROM bash".BASH_N."_entry
				WHERE isDisabled = 1";
		$count = WCF::getDB()->getFirstRow($sql);
		
		return $count['count'];
    }
	
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array('entries' => $this->entries, 'sidebarFactory' => $this->sidebarFactory));
	}
}
?>