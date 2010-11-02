<?php
// wcf imports
require_once(WCF_DIR.'lib/action/AbstractAction.class.php');

// bash imports
require_once(BASH_DIR.'lib/data/bash/BashEntryEditor.class.php');

class BashEntryEnableAction extends AbstractAction {
	public $entryID = 0;
	
	public function readParameters() {
		parent::readParameters();
		
		if (BASHCore::getUser()->userID == 0) throw new PermissionDeniedException;
		
		if (isset($_REQUEST['entryID'])) $this->entryID = intval($_REQUEST['entryID']);
	}
	
	public function execute() {
		parent::execute();
		
		$entry = new BashEntryEditor($this->entryID);
		if ($entry->entryID == 0) throw new IllegalLinkException;
		
		if (!BASHCore::getUser()->getPermission('mod.bash.moderatorPermissions')) throw new PermissionDeniedException;
		
		$entry->isDisabled = 0;
		$entry->update();
		
		HeaderUtil::redirect(BASHCore::getSession()->lastRequestURI, false);
	}
}
?>