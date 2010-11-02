<?php
// wcf imports
require_once(WCF_DIR.'lib/page/AbstractPage.class.php');
require_once(WCF_DIR.'lib/data/message/sidebar/MessageSidebarFactory.class.php');

// bash imports
require_once(BASH_DIR.'lib/data/bash/ViewableBashEntry.class.php');

class BashEntryPage extends AbstractPage {
	public $templateName = 'bash';
	
	public $sidebarFactory = null;
	
	public $entryID = 0;
	public $entry = null;
	
	public function readData() {
		parent::readData();
		
		$this->entry = new ViewableBashEntry($this->entryID);
		
		// check for the entry 
		if (!$this->entry->entryID) throw new IllegalLinkException;
			
		// check for permissions
		$throwPermissionDeniedException = false;
		if ($this->entry->isDisabled) {
			// guest
			if (!WCF::getUser()->userID) $throwPermissionDeniedException = true;
			
			// check for author (the author of the entry can see this entry)
			if (!$throwPermissionDeniedException and WCF::getUser()->userID != $this->entry->authorID) $throwPermissionDeniedException = true;
			
			// check for a moderator (a moderator can see this entry)
			if (!$throwPermissionDeniedException and WCF::getUser()->userID != $this->entry->authorID and !WCF::getUser()->getPermission('mod.bash.moderatorPermissions')) $throwPermissionDeniedException = true;
		}
		// throw a permission denied exception
		if ($throwPermissionDeniedException) throw new PermissionDeniedException;
		
		// init sidebars
		$this->sidebarFactory = new MessageSidebarFactory($this);
		$this->sidebarFactory->create($this->entry);
		$this->sidebarFactory->init();
	}
	
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['entryID'])) $this->entryID = intval($_REQUEST['entryID']);
	}
	
	/**
	 * 
	 */
	public function show() {
		parent::show();
	}
	
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array('entry' => $this->entry, 'sidebarFactory' => $this->sidebarFactory));
	}
}
?>