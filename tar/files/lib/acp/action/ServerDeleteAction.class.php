<?php
// wcf imports
require_once(WCF_DIR.'lib/action/AbstractAction.class.php');

// bash imports
require_once(BASH_DIR.'lib/data/server/ServerEditor.class.php');

class ServerDeleteAction extends AbstractAction {
	public $serverID = 0;
	
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['serverID'])) $this->serverID = intval($_REQUEST['serverID']);
	}
	
	public function execute() {
		parent::execute();
		
		$server = new ServerEditor($this->serverID);
		if ($server->serverID == 0) throw new IllegalLinkException;
		
		if (!WCF::getUser()->getPermission('admin.bash.canDeleteServers')) throw new PermissionDeniedException;
		
		ServerEditor::remove($server->serverID);
		ServerEditor::clearCache();
		
		HeaderUtil::redirect('index.php?page=ServerList&packageID='.PACKAGE_ID.SID_ARG_2ND_NOT_ENCODED);
	}
}
?>