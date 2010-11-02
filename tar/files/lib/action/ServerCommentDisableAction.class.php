<?php
// wcf imports
require_once(WCF_DIR.'lib/action/AbstractAction.class.php');

// bash imports
require_once(BASH_DIR.'lib/data/server/ServerCommentEditor.class.php');

class ServerCommentDisableAction extends AbstractAction {
	public $commentID = 0;
	
	public function readParameters() {
		parent::readParameters();
		
		if (BASHCore::getUser()->userID == 0) throw new PermissionDeniedException;
		
		if (isset($_REQUEST['commentID'])) $this->commentID = intval($_REQUEST['commentID']);
	}
	
	public function execute() {
		parent::execute();
		
		$comment = new ServerCommentEditor($this->commentID);
		if ($comment->commentID == 0) throw new IllegalLinkException;
		
		if (!BASHCore::getUser()->getPermission('mod.comment.moderatorPermissions')) throw new PermissionDeniedException;
		
		$comment->isDisabled = 1;
		$comment->update();
		
		HeaderUtil::redirect(BASHCore::getSession()->lastRequestURI, false);
	}
}
?>