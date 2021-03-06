<?php
// wcf imports
require_once(WCF_DIR.'lib/action/AbstractAction.class.php');

// bash imports
require_once(BASH_DIR.'lib/data/news/NewsEntryEditor.class.php');

class NewsDeleteAction extends AbstractAction {
	public $entryID = 0;
	
	public function readParameters() {
		parent::readParameters();
		
		if (BASHCore::getUser()->userID == 0) throw new PermissionDeniedException;
		
		if (isset($_REQUEST['entryID'])) $this->entryID = intval($_REQUEST['entryID']);
	}
	
	public function execute() {
		parent::execute();
		
		$entry = new NewsEntryEditor($this->entryID);
		if ($entry->entryID == 0) throw new IllegalLinkException;
		
		if (!BASHCore::getUser()->getPermission('mod.bash.canDeleteNewsEntries') and BASHCore::getUser()->userID != $entry->authorID) throw new PermissionDeniedException;
		
		NewsEntryEditor::remove($entry->entryID);
		
		HeaderUtil::redirect('index.php?page=Index'.SID_ARG_2ND_NOT_ENCODED);
	}
}
?>