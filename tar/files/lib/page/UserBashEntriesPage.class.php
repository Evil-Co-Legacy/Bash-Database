<?php
// wcf imports
require_once(WCF_DIR.'lib/page/MultipleLinkPage.class.php');
require_once(WCF_DIR.'lib/data/user/UserProfileFrame.class.php');
require_once(WCF_DIR.'lib/data/message/sidebar/MessageSidebarFactory.class.php');

// bash imports
require_once(BASH_DIR.'lib/data/bash/ViewableBashEntry.class.php');

class UserBashEntriesPage extends MultipleLinkPage {
	public $templateName = 'userBashEntries';
	
	public $sidebarFactory = null;
	public $frame = null;
	
	public $entries = array();
	
	public function readData() {
		parent::readData();
		
		$sql = "SELECT
			    	`bash".BASH_N."_entry`.*
				FROM
			   		`bash".BASH_N."_entry`
			   	WHERE
			   		`bash".BASH_N."_entry`.authorID = ".$this->frame->getUserID().(!BASHCore::getUser()->getPermission('mod.bash.moderatorPermissions') ? ' AND bash'.BASH_N.'_entry.isDisabled = 0' : '')."
				ORDER BY
			    	`bash".BASH_N."_entry`.`timestamp` DESC";
		$result = WCF::getDB()->sendQuery($sql, $this->itemsPerPage, ($this->pageNo - 1) * $this->itemsPerPage);
		while ($row = WCF::getDB()->fetchArray($result)) {
		    $this->entries[] = new ViewableBashEntry(null, $row);
		}
		
		// init sidebars
		$this->sidebarFactory = new MessageSidebarFactory($this);
		foreach ($this->entries as $entry) {
			$this->sidebarFactory->create($entry);
		}
		$this->sidebarFactory->init();
	}
	
	public function readParameters() {
		parent::readParameters();
		
		// get profile frame
		$this->frame = new UserProfileFrame($this);
	}
	
	public function show() {
		// set active tab
		// set active menu item
		UserProfileMenu::getInstance()->setActiveMenuItem('wcf.user.profile.menu.link.bash.ownEntries');
		
		parent::show();
	}
	
	/**
     * @see MultipleLinkPage::countItems()
     */
    public function countItems() {
		parent::countItems();
	
		$sql = "SELECT	COUNT(*) AS count
			FROM	bash".BASH_N."_entry
			WHERE	authorID = ".$this->frame->getUserID();
		$row = WCF::getDB()->getFirstRow($sql);
		return $row['count'];
    }
	
	public function assignVariables() {
		parent::assignVariables();
		
		$this->frame->assignVariables();
		WCF::getTPL()->assign(array('entries' => $this->entries, 'sidebarFactory' => $this->sidebarFactory));
	}
}
?>