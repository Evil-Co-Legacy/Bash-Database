<?php
// wcf imports
require_once(WCF_DIR.'lib/action/AbstractAction.class.php');

// bash imports
require_once(BASH_DIR.'lib/data/bash/BashEntryEditor.class.php');

/**
 * Implements an action that removes bash entry rows
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.bash
 */
class BashEntryDeleteAction extends AbstractAction {
	
	/**
	 * Contains the entryID of the row that should removed
	 * @var	integer
	 */
	public $entryID = 0;
	
	/**
	 * @see	Action::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (BASHCore::getUser()->userID == 0) throw new PermissionDeniedException;
		
		if (isset($_REQUEST['entryID'])) $this->entryID = intval($_REQUEST['entryID']);
	}
	
	/**
	 * @see	Action::execute()
	 */
	public function execute() {
		parent::execute();
		
		$entry = new BashEntryEditor($this->entryID);
		if ($entry->entryID == 0) throw new IllegalLinkException;
		
		if (!BASHCore::getUser()->getPermission('mod.bash.moderatorPermissions') and BASHCore::getUser()->userID != $entry->authorID) throw new PermissionDeniedException;
		
		BashEntryEditor::remove($entry->entryID);
		
		if (!isset($_REQUEST['ajax'])) HeaderUtil::redirect(BASHCore::getSession()->lastRequestURI, false);
	}
}
?>