<?php
// wcf imports
require_once(WCF_DIR.'lib/page/MultipleLinkPage.class.php');
require_once(WCF_DIR.'lib/data/message/sidebar/MessageSidebarFactory.class.php');

// bash imports
require_once(BASH_DIR.'lib/data/news/ViewableNewsEntry.class.php');

class IndexPage extends MultipleLinkPage {
	public $templateName = 'index';
	
	public $sidebarFactory = null;
	
	public $entries = array();
	
	public function readData() {
		parent::readData();
		
		$sql = "SELECT
			    	*
				FROM
			   		`bash".BASH_N."_news`
				ORDER BY
			    	`timestamp` DESC";
		$result = WCF::getDB()->sendQuery($sql, $this->itemsPerPage, ($this->pageNo - 1) * $this->itemsPerPage);
		while ($row = WCF::getDB()->fetchArray($result)) {
		    $this->entries[] = new ViewableNewsEntry(null, $row);
		}
		
		// init sidebars
		$this->sidebarFactory = new MessageSidebarFactory($this);
		foreach ($this->entries as $entry) {
			$this->sidebarFactory->create($entry);
		}
		$this->sidebarFactory->init();
	}
	
	/**
     * @see MultipleLinkPage::countItems()
     */
    public function countItems() {
		parent::countItems();
	
		$sql = "SELECT	COUNT(*) AS count
			FROM	bash".BASH_N."_news";
		$row = WCF::getDB()->getFirstRow($sql);
		return $row['count'];
    }
	
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array('entries' => $this->entries, 'sidebarFactory' => $this->sidebarFactory));
	}
}
?>