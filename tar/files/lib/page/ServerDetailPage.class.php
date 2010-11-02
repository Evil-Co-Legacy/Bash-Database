<?php
// wcf imports
require_once(WCF_DIR.'lib/page/AbstractPage.class.php');

// bash imports
require_once(BASH_DIR.'lib/data/server/Server.class.php');

class ServerDetailPage extends AbstractPage {
	public $templateName = 'serverDetail';
	
	public $serverID = 0;
	public $server = null;
	
	/**
	 * @see Page::readData()
	 */
	public function readData() {
		parent::readData();
		
		$this->server = new Server($this->serverID);
		if ($this->server->serverID == 0) throw new IllegalLinkException;
	}
	
	/**
	 * @see Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['serverID'])) $this->serverID = intval($_REQUEST['serverID']);
	}
	
	/**
	 * @see Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign('server', $this->server);
	}
}
?>