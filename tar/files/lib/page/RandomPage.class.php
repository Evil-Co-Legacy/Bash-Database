<?php
// wcf imports
require_once(WCF_DIR.'lib/page/MultipleLinkPage.class.php');
require_once(WCF_DIR.'lib/data/message/sidebar/MessageSidebarFactory.class.php');

// bash imports
require_once(BASH_DIR.'lib/data/bash/ViewableBashEntry.class.php');

class RandomPage extends MultipleLinkPage {
	public $templateName = 'random';
	
	public $sidebarFactory = null;
	
	public $entries = array();
	
	public function readData() {
		parent::readData();
		
		$sql = "SELECT
			    	*
				FROM
			   		`bash".BASH_N."_entry`".((BASHCore::getUser()->userID == 0 or (!BASHCore::getUser()->isModerator())) ? ' WHERE `isDisabled` = 0 ' : '')."
				ORDER BY
			    	RAND()
			    LIMIT 10";
		$result = WCF::getDB()->sendQuery($sql);
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
	
	/**
	 * 
	 */
	public function show() {
		require_once(WCF_DIR.'lib/page/util/menu/PageMenu.class.php');
		if (PageMenu::getActiveMenuItem() == '') PageMenu::setActiveMenuItem('bash.header.menu.random');
		
		parent::show();
	}
	
	/**
     * @see MultipleLinkPage::countItems()
     */
    public function countItems() {
		parent::countItems();
	
		return 10;
    }
	
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array('entries' => $this->entries, 'sidebarFactory' => $this->sidebarFactory));
	}
}
?>