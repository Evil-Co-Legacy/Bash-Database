<?php
// wcf imports
require_once(WCF_DIR.'lib/page/MultipleLinkPage.class.php');
require_once(WCF_DIR.'lib/data/message/sidebar/MessageSidebarFactory.class.php');

// bash imports
require_once(BASH_DIR.'lib/data/server/ViewableServerComment.class.php');

class ModerationDisabledCommentsPage extends MultipleLinkPage {
	public $templateName = 'moderationDisabledComments';
	
	public $sidebarFactory = null;
	protected $scriptingCompiler = null;
	
	public $comments = array();
	
	public function readData() {
		parent::readData();
		
		$sql = "SELECT
			    	*
				FROM
			   		`bash".BASH_N."_server_comment`
			   	WHERE
			   		isDisabled = 1
			   	ORDER BY
			   		`timestamp` DESC
			    LIMIT 10";
		$result = WCF::getDB()->sendQuery($sql);
		while ($row = WCF::getDB()->fetchArray($result)) {
			$temp = new ViewableServerComment(null, $row);
			WCF::getTPL()->assign('comment', $temp);
			$temp->additionalButtons .= WCF::getTPL()->fetchString($this->getScriptingCompiler()->compileString('comment'.$temp->commentID.'AdditionalButton', '<li><a id="server{@$comment->commentID}" href="index.php?page=ServerDetail&amp;serverID={@$comment->serverID}{@SID_ARG_2ND}" title="'.WCF::getLanguage()->get('bash.moderation.disabledComments.serverButton').'"><img src="{icon}serverS.png{/icon}" alt="" /> <span>'.WCF::getLanguage()->get('bash.moderation.disabledComments.serverButton').'</span></a></li>'));
		    $this->comments[] = $temp;
		    unset($temp);
		}
		
		// init sidebars
		$this->sidebarFactory = new MessageSidebarFactory($this);
		foreach ($this->comments as $comment) {
			$this->sidebarFactory->create($comment);
		}
		$this->sidebarFactory->init();
	}
	
	/**
	 * 
	 */
	public function show() {
		// check for permissions
		if (!BASHCore::getUser()->userID) throw new PermissionDeniedException;
		if (!BASHCore::getUser()->getPermission('mod.comment.moderatorPermissions')) {
			throw new PermissionDeniedException;
		}
		
		// activate usercpmenu
		require_once(WCF_DIR.'lib/page/util/menu/UserCPMenu.class.php');
		UserCPMenu::getInstance()->setActiveMenuItem('wcf.user.usercp.menu.link.modcp.disabledComments');
		
		parent::show();
	}
	
	/**
     * @see MultipleLinkPage::countItems()
     */
    public function countItems() {
		parent::countItems();
	
		$sql = "SELECT COUNT(*) AS count
				FROM bash".BASH_N."_server_comment
				WHERE isDisabled = 1";
		$count = WCF::getDB()->getFirstRow($sql);
		
		return $count['count'];
    }
	
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array('comments' => $this->comments, 'sidebarFactory' => $this->sidebarFactory));
	}
	
	/**
	 * Returns the active scripting compiler object.
	 * 
	 * @return	TemplateScriptingCompiler
	 */
	public function getScriptingCompiler() {
		if ($this->scriptingCompiler === null) {
			if (!defined('NO_IMPORTS')) require_once(WCF_DIR.'lib/system/template/TemplateScriptingCompiler.class.php');
			$this->scriptingCompiler = new TemplateScriptingCompiler(WCF::getTPL());
		}
		
		return $this->scriptingCompiler;
	}
	
}
?>