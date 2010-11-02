<?php
// wcf imports
require_once(WCF_DIR.'lib/form/MessageForm.class.php');

// bash imports
require_once(BASH_DIR.'lib/data/server/ServerCommentEditor.class.php');
require_once(BASH_DIR.'lib/data/server/Server.class.php');

class ServerCommentAddForm extends MessageForm {
	public $templateName = 'serverCommentAdd';
	public $useCaptcha = true;
	public $showSmilies = true;
	public $showSettings = true;
	public $showAttachments = false;
	public $showPoll = false;
	public $showSignatureSetting = false;
	public $neededPermissions = 'user.comment.canAddComment';
	
	public $serverID = 0;
	public $server = null;
	
	public $subject = 'ThisIsAnEasteregg';
	public $username = '';
	
	public function readData() {
		parent::readData();
		
		if ($this->server == null) $this->server = new Server($this->serverID);
		
		if (!$this->server->serverID) throw new IllegalLinkException;
	}
	
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['serverID'])) $this->serverID = intval($_REQUEST['serverID']);
	}
	
	/**
	 * @see Form::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (isset($_POST['username'])) 		$this->username 	= StringUtil::trim($_POST['username']);
	}
	
	public function validate() {
		parent::validate();
		
	// only for guests
		if (WCF::getUser()->userID == 0) {
			// username
			if (empty($this->username)) {
				throw new UserInputException('username');
			}
			if (!UserUtil::isValidUsername($this->username)) {
				throw new UserInputException('username', 'notValid');
			}
			if (!UserUtil::isAvailableUsername($this->username)) {
				throw new UserInputException('username', 'notAvailable');
			}
			
			WCF::getSession()->setUsername($this->username);
		}
		else {
			$this->username = WCF::getUser()->username;
		}
	}
	
	public function save() {
		parent::save();
		
		if ($this->server == null) $this->server = new Server($this->serverID);
		
		$comment = ServerCommentEditor::create($this->server->serverID, BASHCore::getUser()->userID, $this->username, $this->text, TIME_NOW, $this->enableSmilies, $this->enableHtml, $this->enableBBCodes, (BASHCore::getUser()->userID > 0 ? false : true));
		
		if (MODULE_USER_RANK and BASHCore::getUser()->userID > 0) {
			require_once(WCF_DIR.'lib/data/user/rank/UserRank.class.php');
			UserRank::updateActivityPoints(SERVER_COMMENT_USER_ACTIVITY_POINTS);
		}
		
		HeaderUtil::redirect('index.php?page=ServerDetail&serverID='.$comment->serverID.SID_ARG_2ND_NOT_ENCODED.'#comment'.$comment->commentID);
	}
	
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array('server' => $this->server, 'username' => $this->username));
	}
}
?>