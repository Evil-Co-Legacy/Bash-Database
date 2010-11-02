<?php
// bash imports
require_once(BASH_DIR.'lib/data/bash/BashEntry.class.php');
require_once(BASH_DIR.'lib/data/user/BASHUser.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/message/sidebar/MessageSidebarObject.class.php');

class ViewableBashEntry extends BashEntry implements MessageSidebarObject {
	protected $user;
	
	/**
	 * @see DatabaseObject::handleData()
	 */
	protected function handleData($data) {
		parent::handleData($data);
		$this->user = new BASHUser($this->authorID);
		if ($this->user->userID == 0) $this->user->username = $this->authorName;
	}
	
	// MessageSidebarObject implementation
	/**
	 * @see MessageSidebarObject::getUser()
	 */
	public function getUser() {
		return $this->user;
	}
	
	/**
	 * @see MessageSidebarObject::getMessageID()
	 */
	public function getMessageID() {
		return $this->entryID;
	}
	
	/**
	 * @see MessageSidebarObject::getMessageType()
	 */
	public function getMessageType() {
		return 'bashEntry';
	}
}
?>