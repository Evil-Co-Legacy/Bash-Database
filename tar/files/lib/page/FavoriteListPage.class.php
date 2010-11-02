<?php
// wcf imports
require_once(WCF_DIR.'lib/page/MultipleLinkPage.class.php');
require_once(WCF_DIR.'lib/data/message/sidebar/MessageSidebarFactory.class.php');

// bash imports
require_once(BASH_DIR.'lib/data/bash/ViewableBashEntry.class.php');

class FavoriteListPage extends MultipleLinkPage {
	public $templateName = 'favoriteList';
	
	public $sidebarFactory = null;
	
	public $entries = array();
	
	public function readData() {
		parent::readData();
		
		$sql = "SELECT
			    	`bash".BASH_N."_entry`.*
				FROM
			   		`bash".BASH_N."_favorite`
			   	JOIN
			   		`bash".BASH_N."_entry`
			   	ON
			   		`bash".BASH_N."_favorite`.entryID = `bash".BASH_N."_entry`.entryID
			   	WHERE
			   		`bash".BASH_N."_favorite`.userID = ".BASHCore::getUser()->userID.(!BASHCore::getUser()->getPermission('mod.bash.moderatorPermissions') ? ' AND bash'.BASH_N.'_entry.isDisabled = 0' : '')."
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
	
	public function show() {
		if (!BASHCore::getUser()->userID) throw new PermissionDeniedException;
		
		// set active tab
		require_once(WCF_DIR.'lib/page/util/menu/UserCPMenu.class.php');
		UserCPMenu::getInstance()->setActiveMenuItem('wcf.user.usercp.menu.link.management.favorites');
		
		parent::show();
	}
	
	/**
     * @see MultipleLinkPage::countItems()
     */
    public function countItems() {
		parent::countItems();
	
		$sql = "SELECT	COUNT(*) AS count
			FROM	bash".BASH_N."_favorite
			WHERE	userID = ".BASHCore::getUser()->userID;
		$row = WCF::getDB()->getFirstRow($sql);
		return $row['count'];
    }
	
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array('entries' => $this->entries, 'sidebarFactory' => $this->sidebarFactory));
	}
}
?>