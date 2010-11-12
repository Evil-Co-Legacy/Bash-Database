<?php
// wcf imports
require_once(WCF_DIR.'lib/page/MultipleLinkPage.class.php');
require_once(WCF_DIR.'lib/data/message/sidebar/MessageSidebarFactory.class.php');

// bash imports
require_once(BASH_DIR.'lib/data/bash/ViewableBashEntry.class.php');

/**
 * Implements a page that lists all available bash entries
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.bash
 */
class BashListPage extends MultipleLinkPage {
	
	/**
	 * @see	AbstractPage::$templateName
	 */
	public $templateName = 'bashList';
	
	/**
	 * Contains the sidebar factory
	 * @var	MessageSidebarFactory
	 */
	public $sidebarFactory = null;
	
	/**
	 * Contains all bash entries
	 * @var	array<ViewableBashEntry>
	 */
	public $entries = array();
	
	/**
	 * @see	Page::readData()
	 */
	public function readData() {
		parent::readData();
		
		$sql = "SELECT
			    	*
				FROM
			   		`bash".BASH_N."_entry`".(!BASHCore::getUser()->isModerator() ? ' WHERE `isDisabled` = 0 ' : '')."
				ORDER BY
			    	timestamp DESC";
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
	
	/**
	 * @see	Page::show()
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
	
		$sql = "SELECT	COUNT(*) AS count
				FROM	bash".BASH_N."_entry";
		$row = WCF::getDB()->getFirstRow($sql);
		
		return $row['count'];
    }
	
    /**
     * @see	Page::assignVariables()
     */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array('entries' => $this->entries, 'sidebarFactory' => $this->sidebarFactory));
	}
}
?>