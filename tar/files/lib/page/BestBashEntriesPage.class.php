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
class BestBashEntriesPage extends AbstractPage {
	
	/**
	 * @see	AbstractPage::$templateName
	 */
	public $templateName = 'bestBashEntries';
	
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
			   		`bash".BASH_N."_entry`".(BASHCore::getUser()->isModerator() ? '' :  'WHERE `isDisabled` = 0 ')."
				ORDER BY
			    	 votes DESC
			   	LIMIT
			   		10";
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
	 * @see	Page::show()
	 */
	public function show() {
		require_once(WCF_DIR.'lib/page/util/menu/PageMenu.class.php');
		if (PageMenu::getActiveMenuItem() == '') PageMenu::setActiveMenuItem('bash.header.menu.bestBashEntries');
		
		parent::show();
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